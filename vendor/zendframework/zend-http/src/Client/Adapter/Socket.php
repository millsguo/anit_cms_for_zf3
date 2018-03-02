<?php
/**
 * @see       https://github.com/zendframework/zend-http for the canonical source repository
 * @copyright Copyright (c) 2005-2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-http/blob/master/LICENSE.md New BSD License
 */

namespace Zend\Http\Client\Adapter;

use Traversable;
use Zend\Http\Client\Adapter\AdapterInterface as HttpAdapter;
use Zend\Http\Client\Adapter\Exception as AdapterException;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\ErrorHandler;

/**
 * A sockets based (stream\socket\client) adapter class for Zend\Http\Client. Can be used
 * on almost every PHP environment, and does not require any special extensions.
 */
class Socket implements HttpAdapter, StreamInterface
{
    /**
     * Map SSL transport wrappers to stream crypto method constants
     *
     * @var array
     */
    protected static $sslCryptoTypes = [
        'ssl'   => STREAM_CRYPTO_METHOD_SSLv23_CLIENT,
        'sslv2' => STREAM_CRYPTO_METHOD_SSLv2_CLIENT,
        'sslv3' => STREAM_CRYPTO_METHOD_SSLv3_CLIENT,
        'tls'   => STREAM_CRYPTO_METHOD_TLS_CLIENT,
    ];

    /**
     * The socket for server connection
     *
     * @var resource|null
     */
    protected $socket;

    /**
     * What host/port are we connected to?
     *
     * @var array
     */
    protected $connectedTo = [null, null];

    /**
     * Stream for storing output
     *
     * @var resource
     */
    protected $outStream;

    /**
     * Parameters array
     *
     * @var array
     */
    protected $config = [
        'persistent'            => false,
        'ssltransport'          => 'ssl',
        'sslcert'               => null,
        'sslpassphrase'         => null,
        'sslverifypeer'         => true,
        'sslcafile'             => null,
        'sslcapath'             => null,
        'sslallowselfsigned'    => false,
        'sslusecontext'         => false,
        'sslverifypeername'     => true,
    ];

    /**
     * Request method - will be set by write() and might be used by read()
     *
     * @var string
     */
    protected $method;

    /**
     * Stream context
     *
     * @var resource
     */
    protected $context;

    /**
     * Adapter constructor, currently empty. Config is set using setOptions()
     *
     */
    public function __construct()
    {
    }

    /**
     * Set the configuration array for the adapter
     *
     * @param  array|Traversable $options
     * @throws AdapterException\InvalidArgumentException
     */
    public function setOptions($options = [])
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }
        if (! is_array($options)) {
            throw new AdapterException\InvalidArgumentException(
                'Array or Zend\Config object expected, got ' . gettype($options)
            );
        }

        foreach ($options as $k => $v) {
            $this->config[strtolower($k)] = $v;
        }
    }

    /**
     * Retrieve the array of all configuration options
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the stream context for the TCP connection to the server
     *
     * Can accept either a pre-existing stream context resource, or an array
     * of stream options, similar to the options array passed to the
     * stream_context_create() PHP function. In such case a new stream context
     * will be created using the passed options.
     *
     * @since  Zend Framework 1.9
     *
     * @param  mixed $context Stream context or array of context options
     * @throws Exception\InvalidArgumentException
     * @return Socket
     */
    public function setStreamContext($context)
    {
        if (is_resource($context) && get_resource_type($context) == 'stream-context') {
            $this->context = $context;
        } elseif (is_array($context)) {
            $this->context = stream_context_create($context);
        } else {
            // Invalid parameter
            throw new AdapterException\InvalidArgumentException(sprintf(
                'Expecting either a stream context resource or array, got %s',
                gettype($context)
            ));
        }

        return $this;
    }

    /**
     * Get the stream context for the TCP connection to the server.
     *
     * If no stream context is set, will create a default one.
     *
     * @return resource
     */
    public function getStreamContext()
    {
        if (! $this->context) {
            $this->context = stream_context_create();
        }

        return $this->context;
    }

    /**
     * Connect to the remote server
     *
     * @param string  $host
     * @param int     $port
     * @param  bool $secure
     * @throws AdapterException\RuntimeException
     */
    public function connect($host, $port = 80, $secure = false)
    {
        // If we are connected to the wrong host, disconnect first
        $connectedHost = (strpos($this->connectedTo[0], '://'))
            ? substr($this->connectedTo[0], (strpos($this->connectedTo[0], '://') + 3), strlen($this->connectedTo[0]))
            : $this->connectedTo[0];

        if ($connectedHost != $host || $this->connectedTo[1] != $port) {
            if (is_resource($this->socket)) {
                $this->close();
            }
        }

        // Now, if we are not connected, connect
        if (! is_resource($this->socket) || ! $this->config['keepalive']) {
            $context = $this->getStreamContext();

            if ($secure || $this->config['sslusecontext']) {
                if ($this->config['sslverifypeer'] !== null) {
                    if (! stream_context_set_option($context, 'ssl', 'verify_peer', $this->config['sslverifypeer'])) {
                        throw new AdapterException\RuntimeException('Unable to set sslverifypeer option');
                    }
                }

                if ($this->config['sslcafile']) {
                    if (! stream_context_set_option($context, 'ssl', 'cafile', $this->config['sslcafile'])) {
                        throw new AdapterException\RuntimeException('Unable to set sslcafile option');
                    }
                }

                if ($this->config['sslcapath']) {
                    if (! stream_context_set_option($context, 'ssl', 'capath', $this->config['sslcapath'])) {
                        throw new AdapterException\RuntimeException('Unable to set sslcapath option');
                    }
                }

                if ($this->config['sslallowselfsigned'] !== null) {
                    if (! stream_context_set_option(
                        $context,
                        'ssl',
                        'allow_self_signed',
                        $this->config['sslallowselfsigned']
                    )) {
                        throw new AdapterException\RuntimeException('Unable to set sslallowselfsigned option');
                    }
                }

                if ($this->config['sslcert'] !== null) {
                    if (! stream_context_set_option($context, 'ssl', 'local_cert', $this->config['sslcert'])) {
                        throw new AdapterException\RuntimeException('Unable to set sslcert option');
                    }
                }

                if ($this->config['sslpassphrase'] !== null) {
                    if (! stream_context_set_option($context, 'ssl', 'passphrase', $this->config['sslpassphrase'])) {
                        throw new AdapterException\RuntimeException('Unable to set sslpassphrase option');
                    }
                }

                if ($this->config['sslverifypeername'] !== null) {
                    if (! stream_context_set_option(
                        $context,
                        'ssl',
     ﻿/* Copyright (C) Microsoft Corporation. All rights reserved. */
scriptValidator("/Components/Playback/Playbackhelpers.js","/Framework/data/queries/marketplacequeries.js","/Framework/querywatcher.js","/Framework/stringids.js","/Framework/utilities.js","/ViewModels/QueryViewModel.js");
(function()
{
    "use strict";
    MS.Entertainment.UI.Debug.defineAssert("MS.Entertainment.ViewModels");
    WinJS.Namespace.define("MS.Entertainment.ViewModels",{Music: WinJS.Class.derive(MS.Entertainment.ViewModels.QueryViewModel,function(view)
        {
            this._queryWatcherString = "music-marketplace-";
            this._loadingDoneString = "music", MS.Entertainment.ViewModels.QueryViewModel.prototype.constructor.apply(this,arguments)
        },{createTrackQuery: function()
            {
                var query;
                var QueryType;
                var options;
                var view = this.getViewDefinition(this.view);
                var pivot = this._workingPivotsSelectionManager.selectedItem;
                var modifier = this._workingModifierSelectionManager.selectedItem;
                pivot = pivot || {value: {}};
                modifier = modifier || {value: {}};
                if(view.trackQuery)
                    QueryType = view.trackQuery;
                else if(modifier.value.trackQuery)
                    QueryType = modifier.value.trackQuery;
                else if(pivot.value.trackQuery)
                    QueryType = pivot.value.trackQuery;
                if(QueryType)
                {
                    query = new QueryType;
                    options = MS.Entertainment.Utilities.uniteObjects(WinJS.Binding.unwrap(pivot.value.trackQueryOptions),WinJS.Binding.unwrap(modifier.value.trackQueryOptions));
                    options = MS.Entertainment.Utilities.uniteObjects(options,WinJS.Binding.unwrap(view.trackQueryOptions));
                    MS.Entertainment.Utilities.BindingAgnostic.setProperties(query,options)
                }
                if(!query)
                {
                    if(view.query)
                        QueryType = view.query;
                    else if(modifier.value.query)
                        QueryType = modifier.value.query;
                    else if(pivot.value.query)
                        QueryType = pivot.value.query;
                    if(QueryType)
                    {
                        query = new QueryType;
                        options = MS.Entertainment.Utilities.uniteObjects(WinJS.Binding.unwrap(pivot.value.queryOptions),WinJS.Binding.unwrap(modifier.value.queryOptions));
                        options = MS.Entertainment.Utilities.uniteObjects(options,WinJS.Binding.unwrap(view.queryOptions));
                        MS.Entertainment.Utilities.BindingAgnostic.setProperties(query,options)
                    }
                }
                MS.Entertainment.ViewModels.assert(query,"No track query was created, when we expected one");
                return query
            }})});
    WinJS.Namespace.define("MS.Entertainment.ViewModels",{
        PlayQueryAction: MS.Entertainment.derive(MS.Entertainment.Platform.PlayAction,function(queryFactory)
        {
            this.base();
            this.queryFactory = queryFactory;
            this.title = String.load(String.id.IDS_PLAY_ALL_LABEL)
        },{
            _queryFactory: null,
            _disposed: false,
            isEnabled: false,
            dispose: function()
            {
                this._queryFactory = null;
                this.requeryCanExecute();
                this._disposed = true
            },
            queryFactory: {
                get: function()
                {
                    return this._queryFactory
                },
                set: function(value)
                {
                    if(!this._disposed)
                        this._queryFactory = value
                }
            },
            executedPlay: function(param)
            {
                var query = this.queryFactory();
                MS.Entertainment.ViewModels.assert(query,"QueryFactory returned a null query");
                if(query)
                {
                    query.isLive = false;
                    MS.Entertainment.Platform.PlaybackHelpers.playMedia2(query,{
                        sessionId: MS.Entertainment.Platform.Playback.WellKnownPlaybackSessionId.nowPlaying,
                        autoPlay: true,
                        showImmersive: false,
                        showAppBar: true
                    })
                }
                return!!query
            },
            canExecutePlay: function(param)
            {
                return!!this.queryFactory
            }
        }),
        PlayArtistAction: MS.Entertainment.derive(MS.Entertainment.Platform.PlayAction,function()
        {
            this.base()
        },{
            executedPlay: function(param)
            {
                var query,
                    id;
                var navigationService = MS.Entertainment.ServiceLocator.getService(MS.Entertainment.Services.navigation);
                var isImmersive = navigationService.checkUserLocation(MS.Entertainment.UI.Monikers.immersiveDetails);
                MS.Entertainment.ViewModels.assert(param.mediaItem.mediaType === Microsoft.Entertainment.Queries.ObjectType.person && param.mediaItem.personType === Microsoft.Entertainment.Queries.PersonType.artist,"Invalid media type. Was expecting an artist media object");
                if(param.playCollectionItemsOnly)
                {
                    id = MS.Entertainment.Utilities.isValidLibraryId(param.mediaItem.libraryId) ? param.mediaItem.libraryId : param.libraryId;
                    query = new MS.Entertainment.Data.Query.libraryTracks;
                    query.artistId = param.mediaItem.libraryId;
                    if(param.librarySort)
                        query.sort = param.librarySort
                }
                else
                {
                    id = !MS.Entertainment.Utilities.isEmptyGuid(param.mediaItem.canonicalId) ? param.mediaItem.canonicalId : param.serviceId;
                    query = new MS.Entertainment.Data.Query.Music.ArtistTopSongs;
                    query.id = param.mediaItem.canonicalId;
                    query.impressionGuid = param.mediaItem.impressionGuid
                }
                if(MS.Entertainment.Utilities.Telemetry.isCurrentPageSearchPage())
                    MS.Entertainment.Utilities.Telemetry.logSearchExit(param.mediaItem,false,"Play");
                MS.Entertainment.Platform.PlaybackHelpers.playMedia2(query,{
                    sessionId: MS.Entertainment.Platform.Playback.WellKnownPlaybackSessionId.nowPlaying,
                    autoPlay: true,
                    startPositionMsec: param.startPositionMS,
                    showImmersive: !!param.showImmersive,
                    showAppBar: !!param.showAppBar && !isImmersive,
                    automationId: param.automationId,
                    immersiveOptions: {
                        sessionId: MS.Entertainment.Platform.Playback.WellKnownPlaybackSessionId.nowPlaying,
                        startFullScreen: !param.showDetails,
                        overridePageChange: param.overridePageChange
                    }
                });
                return true
            },
            canExecutePlay: function(param)
            {
                return param && param.mediaItem && (param.playCollectionItemsOnly && (MS.Entertainment.Utilities.isValidLibraryId(param.mediaItem.libraryId) || MS.Entertainment.Utilities.isValidLibraryId(param.libraryId)) || !param.playCollectionItemsOnly && (!MS.Entertainment.Utilities.isEmptyGuid(param.mediaItem.serviceId) || !MS.Entertainment.Utilities.isEmptyGuid(param.serviceId)))
            }
        }),
        PlaySmartDJAction: MS.Entertainment.derive(MS.Entertainment.Platform.PlayAction,function()
        {
            this.base()
        },{
            _addSmartDJTimeout: 5e3,
            _uiStateService: MS.Entertainment.ServiceLocator.getService(MS.Entertainment.Services.uiState),
            _numberOfFeaturedArtistNamesToFind: 2,
            _numberOfArtistNamesToCheck: 8,
            _appendArtistName: function(item, mediaNameLowercase, featuredArtists)
            {
                var newArtistNameLowerCase = featuredArtists.length < this._numberOfFeaturedArtistNamesToFind && item && item.data.artist && item.data.artist.name.toLowerCase();
                if(newArtistNameLowerCase !== mediaNameLowercase)
                {
                    var matchFound = false;
                    for(var i = 0; i < featuredArtists.length; i++)
                        if(newArtistNameLowerCase === featuredArtists[i].toLowerCase())
                            matchFound = true;
                    if(!matchFound)
                        featuredArtists.push(item.data.artist.name)
                }
                return WinJS.Promise.wrap(item)
            },
            _addSmartDJ: function(mediaItem)
            {
                var promise;
                var sessionMgr = MS.Entertainment.ServiceLocator.getService(MS.Entertainment.Services.sessionManager);
                var playbackSession = sessionMgr.nowPlayingSession;
                var playbackError = playbackSession.playerState === MS.Entertainment.Platform.Playback.PlayerState.error;
                if(playbackError)
                    promise = WinJS.Promise.wrapError(new Error("Playback failed"));
                else if(playbackSession.smartDJSeed !== mediaItem)
                    promise = WinJS.Promise.wrap();
                else if(playbackSession.mediaCollection)
                {
                    var featuredArtists = [];
                    var mediaNameLowercase = mediaItem.name.toLowerCase();
                    var appendArtistName = function(item)
                        {
                            return this._appendArtistName(item,mediaNameLowercase,featuredArtists)
                        }.bind(this);
                    promise = MS.Entertainment.Platform.Playback.Playlist.PlaylistCore.forEachItemSequentially(playbackSession.mediaCollection,appendArtistName,this._numberOfArtistNamesToCheck).then(function()
                    {
                        var smartDJAddQuery = new MS.Entertainment.Data.Query.Music.SmartDJAdd(mediaItem,featuredArtists);
                        return smartDJAddQuery.execute()
                    }).then(function()
                    {
                        MS.Entertainment.ServiceLocator.getService(MS.Entertainment.Services.smartDJList).refresh()
                    })
                }
                else
                {
                    var smartDJAddQuery = new MS.Entertainment.Data.Query.Music.SmartDJAdd(mediaItem);
                    return smartDJAddQuery.execute().then(function()
                        {
                            MS.Entertainment.ServiceLocator.getService(MS.Entertainment.Services.smartDJList).refresh()
                        })
                }
                return promise.then(null,function(error)
                    {
                        MS.Entertainment.ViewModels.assert(error && error.message === "Canceled","SmartDJ add failed. Error: " + error)
                    })
            },
            _addSmartDJAfterPlayback: function(mediaItem)
            {
                var bindings;
                var completed;
                var playbackSession = MS.Entertainment.ServiceLocator.getService(MS.Entertainment.Services.sessionManager).nowPlayingSession;
                function onPlaybackChanged()
                {
                    if(!bindings)
                        return;
                    var playbackError = playbackSession.playerState === MS.Entertainment.Platform.Playback.PlayerState.error;
                    if(playbackError)
                        completed();
                    else if(playbackSession.smartDJSeed === mediaItem && playbackSession.currentTransportState === MS.Entertainment.Platform.Playback.TransportState.playing && playbackSession.mediaCollection)
                        playbackSession.mediaCollection.getCount().then(function(count)
                        {
                            if(bindings && count > 1)
                                completed()
                        },function()
                        {
                            completed()
                        })
                }
                var promise = new WinJS.Promise(function(c)
                    {
                        completed = c;
                        bindings = WinJS.Binding.bind(playbackSession,{
                            currentTransportState: onPlaybackChanged,
                            playerState: onPlaybackChanged
                        })
                    },function(){});
                promise.then(this._addSmartDJCallback(mediaItem),function(){}).done(function()
                {
                    if(bindings)
                    {
                        bindings.cancel();
                        bindings = null
                    }
                });
                return promise
            },
            _addSmartDJCallback: function(mediaItem)
            {
                return function()
                    {
                        this._addSmartDJ(mediaItem)
                    }.bind(this)
            },
            _defaultPlaybackOptions: function(param)
            {
                return{
                        sessionId: MS.Entertainment.Platform.Playback.WellKnownPlaybackSessionId.nowPlaying,
                        autoPlay: true,
                        showImmersive: !!param.showImmersive,
                        showAppBar: !!param.showAppBar && !this._uiStateService.nowPlayingVisible,
                        shuffle: false,
                        automationId: param.automationId,
                        immersiveOptions: {
                            sessionId: MS.Entertainment.Platform.Playback.WellKnownPlaybackSessionId.nowPlaying,
                            startFullScreen: !param.showDetails,
                            overridePageChange: param.overridePageChange
                        }
                    }
            },
            executedPlay: function(param)
            {
                var primaryStringId;
                var secondaryStringId;
                var error = false;
                var networkStatus = MS.Entertainment.ServiceLocator.getService(MS.Entertainment.Services.uiState).networkStatus;
                if(networkStatus === MS.Entertainment.UI.NetworkStatusService.NetworkStatus.localOnly || networkStatus === MS.Entertainment.UI.NetworkStatusService.NetworkStatus.none)
                {
                    error = true;
                    primaryStringId = String.id.IDS_SMARTDJ_OFFINE_ERROR_TITLE;
                    secondaryStringId = String.id.IDS_SMARTDJ_OFFINE_ERROR_DESC
                }
                var sessionManager = MS.Entertainment.ServiceLocator.getService(MS.Entertainment.Services.sessionManager);
                if(sessionManager.primarySession && sessionManager.primarySession.isRemoteSession && sessionManager.primarySession.isRemoteSession())
                {
                    error = 