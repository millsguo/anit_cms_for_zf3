;
 height: 85px;
 -ms-grid-rows: 40px 1fr
 }
 .inPlaceDetailsItemName
 {
 -ms-grid-row: 1;
 -ms-grid-column: 1
 }
 .musicPage .win-vertical .inPlaceDetailsItemName, .collectionVideoGallery .inPlaceDetailsItemName
 {
 margin-top: 15px;
 padding-right: 10px
 }
 .inPlaceDetailsItemDurationStatus
 {
 -ms-grid-row: 1;
 -ms-grid-column: 2;
 display: -ms-grid
 }
 .musicPage .win-vertical .inPlaceDetailsItemDurationStatus, .collectionVideoGallery .inPlaceDetailsItemDurationStatus
 {
 margin-top: 15px
 }
 .inPlaceDetailsItemStatus
 {
 -ms-grid-row: 1;
 -ms-grid-column: 1
 }
 .inPlaceDetailsItemDuration
 {
 -ms-grid-row: 1;
 -ms-grid-column: 2
 }
 .inPlaceDetailsHorizontalRule
 {
 -ms-grid-row: 1;
 -ms-grid-column-span: 2;
 border-top: 1px solid
 }
 .inPlaceDetailsItemInfo
 {
 -ms-grid-row: 2;
 -ms-grid-column-span: 2
 }
 .inPlaceDetailsItemActions
 {
 -ms-grid-row: 2;
 -ms-grid-column-span: 2;
 clear: left
 }
 .inPlaceDetailsItemActions>div .win-template
 {
 -ms-flex: 1 auto
 }
 .inPlaceDetailsItemActionButton
 {
 float: left;
 width: 208px;
 height: 50px;
 padding: 10px 10px 10px 10px;
 margin: 1px 1px 1px 1px;
 text-align: left;
 border: 0 solid;
 cursor: pointer;
 white-space: normal
 }
 .musicPage .win-vertical .inPlaceDetailsItemActionButton, .collectionVideoGallery .inPlaceDetailsItemActionButton
 {
 width: calc( 50% - 1px );
 margin-top: 0;
 margin-right: 1px;
 margin-bottom: 0;
 margin-left: 0;
 padding-left: 15px
 }
 .inlineDetailsExtrasList .win-listview, .inlineDetailsExtrasList .win-surface
 {
 width: 100%;
 margin: 0;
 height: auto;
 padding: 0;
 position: relative;
 overflow: visible
 }
 .inlineDetailsExtrasList .win-item
 {
 margin: 0;
 padding-bottom: 10px;
 width: 100%;
 height: 50px
 }
 .inlineDetailsGameExtra
 {
 height: 100%;
 width: 100%;
 padding-top: 10px
 }
 .inlineDetailsGameExtraMetadataLine
 {
 clear: left;
 width: 100%;
 text-overflow: ellipsis;
 white-space: nowrap;
 overflow: hidden
 }
 .inlineDetailsGameExtraTitle
 {
 position: relative;
 left: 4px;
 height: 50px
 }
 .inlineStreamingStatusArea
 {
 display: -ms-grid;
 -ms-grid-rows: 1fr;
 -ms-grid-columns: auto 1fr;
 padding-bottom: 10px
 }
 .inlineStreamingText
 {
 -ms-grid-row: 1;
 -ms-grid-column: 2
 }
 .gameInlineDetailsPanelFragmentContainer.panelFragmentContainer, .movieInlineDetailsPanelFragmentContainer.panelFragmentContainer, .musicInlineDetailsPanelFragmentContainer.panelFragmentContainer, .tvInlineDetailsPanelFragmentContainer.panelFragmentContainer
 {
 width: calc(100% - 35px);
 height: calc(100% - 30px);
 top: 5px;
 left: 15px;
 margin-left: 0
 }
 .gameInlineDetailsPanelFragmentContainer.panelFragmentContainer.panelFragmentLoading, .movieInlineDetailsPanelFragmentContainer.panelFragmentContainer.panelFragmentLoading, .musicInlineDetailsPanelFragmentContainer.panelFragmentContainer.panelFragmentLoading, .tvInlineDetailsPanelFragmentContainer.panelFragmentContainer.panelFragmentLoading
 {
 width: 100%;
 height: 100%;
 top: 0;
 left: 0
 }
 .contentNotificationListWrapper
 {
 margin-left: -5px
 }
 .contentNotificationListWrapper .label
 {
 margin-left: 12px
 }
 .popOver
 {
 display: -ms-grid;
 width: 730px;
 height: 530px;
 -ms-grid-columns: 255px 475px;
 -ms-grid-rows: 1fr
 }
 @media screen and (min-height: 1080px){
 .dashboardPanel.socialMiniProfile .popOver.friend
 {
 height: 675px
 }
 }
 .popOver.tv
 {
 overflow: hidden
 }
 .popOver .leftColumn
 {
 display: -ms-grid;
 -ms-grid-columns: 20px 1fr 20px;
 -ms-grid-rows: 20px auto 4px 1fr 20px
 }
 .album .leftColumn
 {
 -ms-grid-rows: 20px auto 4px 1fr auto 20px
 }
 .popOver .rightColumn
 {
 display: -ms-grid;
 -ms-grid-columns: 30px 1fr 50px;
 -ms-grid-column: 2;
 -ms-grid-rows: 20px auto auto 16px 1fr 22px
 }
 .popOver .rightColumnBackground
 {
 -ms-grid-column: 2
 }
 .popOver.friend .rightColumn
 {
 -ms-grid-columns: 25px 1fr 50px;
 -ms-grid-rows: 20px auto auto 16px 1fr 22px
 }
 .popOver.playlist .rightColumn
 {
 -ms-grid-rows: 20px auto auto 10px 1fr 22px
 }
 .popOver.album .rightColumn
 {
 -ms-grid-rows: 20px auto 10px auto auto 12px 1fr 30px
 }
 .popOver.artist .rightColumn
 {
 -ms-grid-rows: 20px auto 10px auto auto 10px auto 0 1fr 30px
 }
 .popOver .actions
 {
 -ms-grid-column: 2;
 -ms-grid-row: 4;
 overflow-x: visible;
 overflow-y: auto;
 -ms-grid-column-span: 2;
 display: -ms-grid;
 -ms-grid-columns: 1fr 20px;
 -ms-grid-row-span: 2;
 margin: 0 -2px
 }
 .musicSubscriptionLink
 {
 -ms-grid-column: 2;
 -ms-grid-row: 5
 }
 .musicSubscriptionLink>button
 {
 width: 100%
 }
 .musicSubscriptionLink .actionLinkLabel
 {
 width: 100%
 }
 html[dir=ltr] .musicSubscriptionLink .actionLinkLabel
 {
 text-align: left
 }
 html[dir=rtl] .musicSubscriptionLink .actionLinkLabel
 {
 text-align: right
 }
 .popOverContainer .overlayContent>div
 {
 display: -ms-grid;
 -ms-grid-columns: 1fr;
 -ms-grid-rows: 1fr
 }
 .popOver .titleContainer
 {
 -ms-grid-row: 2;
 -ms-grid-column: 2;
 margin: 0 2px
 }
 .popOver .titleContainer .secondaryText
 {
 margin: 4px 0
 }
 .popOver .activityTitleContainer
 {
 display: -ms-grid;
 -ms-grid-columns: 46px 354px;
 -ms-grid-rows: 1fr
 }
 .popOver .activityTitleContainer .activityBackButton button.iconButton.win-command
 {
 -ms-grid-rows: 0 1fr 0
 }
 .popOver .activityTitleContainer .activityBackButton
 {
 -ms-grid-column: 1;
 -ms-grid-row: 1
 }
 .popOver .activityTitleContainer .metaData1
 {
 -ms-grid-column: 2;
 -ms-grid-row: 1
 }
 .popOver .activityTitleContainer .metaData2
 {
 -ms-grid-column: 2;
 -ms-grid-row: 2
 }
 .popOver .activityTitleContainer .metaData3
 {
 -ms-grid-column: 2;
 -ms-grid-row: 3
 }
 .popOver .episodeTitleContainer
 {
 display: -ms-grid;
 -ms-grid-columns: 46px 354px;
 -ms-grid-rows: 1fr
 }
 .popOver .episodeTitleContainer .episodeBackButton
 {
 -ms-grid-column: 1;
 -ms-grid-row: 1
 }
 .popOver .episodeTitleContainer .episodeBackButton button.iconButton.win-command
 {
 -ms-grid-rows: 0 1fr 0
 }
 .popOver .episodeTitleContainer .metadata1
 {
 -ms-grid-column: 2;
 -ms-grid-row: 1
 }
 .popOver .episodeTitleContainer .metadata2
 {
 -ms-grid-column: 2;
 -ms-grid-row: 2
 }
 .popOver .episodeTitleContainer .metadata3
 {
 -ms-grid-column: 2;
 -ms-grid-row: 3
 }
 .popOver .episodeTitl