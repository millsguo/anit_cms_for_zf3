<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\Validator\HttpUserAgent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        // get the cache listener service
        // $e->getApplication()->getServiceManager()->get('CacheDataListener');
        
        //force ssl
        //$eventManager->attach('route', array($this, 'doHttpsRedirect'));
        /*
        $translator=$e->getApplication()->getServiceManager()->get('translator');
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator); */
        
        $this->initSession(array(
            'remember_me_seconds' => 10800,
            'use_cookies' => true,
            'cookie_httponly' => true,
            'cache_expire' => 180,
            'cookie_lifetime' => 10800
        ));
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }
/*
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
*/
    public function initSession($config) {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->getValidatorChain()
          ->attach(
            'session.validate',
            array(new HttpUserAgent(), 'isValid')
          );
        /*
          $sessionManager->getValidatorChain()
          ->attach(
            'session.validate',
              array(new RemoteAddr(), 'isValid')
          );*/
        $sessionManager->start();
        /**
         * Optional: If you later want to use namespaces, you can already store the 
         * Manager in the shared (static) Container (=namespace) field
         */
        Container::setDefaultManager($sessionManager);
    }

    /*
     * 
    //source -> http://stackoverflow.com/questions/18141140/zf2-and-force-https-for-specific-routes
    public function doHttpsRedirect(MvcEvent $e){
        $sm = $e->getApplication()->getServiceManager();
        $uri = $e->getRequest()->getUri();
        $scheme = $uri->getScheme();
        if ($scheme != 'https'){
            $uri->setScheme('https');
            $response=$e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $uri);
            $response->setStatusCode(302);
            $response->sendHeaders();
            return $response;
        }
    }
     * 
     */
    
}
