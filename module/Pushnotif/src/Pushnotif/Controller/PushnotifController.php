<?php

namespace Pushnotif\Controller;

use Pushnotif\Notification\Push;
use Pushnotif\Model\PushDao;
use Pushnotif\Model\PushObj;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ExtLib\Utils;

class PushnotifController extends AbstractActionController {

    protected $PushDao;

    /**
     * Envoi d'un nouveau push
     */
    public function indexAction() {

        return new ViewModel(array(
            //'test'=>'testOK'
        ));
    }
    
    public function addAction() {

        return new ViewModel(array(
            //'test'=>'testOK'
        ));
    }

    public function newAction() {

        $request = $this->getRequest();
        if (!$request->isPost())
            die('pas de demande');

        // Connexion a la base
        $Push = new Push();

        // Connexion a la base
        $this->PushDao = new PushDao();

        $this->PushDao->setEnvironement('TEST');
        if ($_POST['cible'] == 'Prod')
            $this->PushDao->setEnvironement('PROD');

        $confPush = $this->PushDao->getPushConfiguration();
        
        // Creation de l'objet Push.
        $pushObj = new PushObj();
        $pushObj->hydrate($_POST);

        // Recuperation de Device Android
        $devicesToken = $this->PushDao->getAndroidDeviceToken();
        //"<pre>".var_dump($devicesToken)."<pre>";
        // Creation du body du message Android
        $androidBody = $pushObj->getAndroidMsg($devicesToken);
        //"<pre>".var_dump($androidBody)."<pre>";
        // Recuperation de Device iOS
        $devicesToken = $this->PushDao->getIOSDeviceToken();
       //"<pre>".var_dump($devicesToken)."<pre>";
        // Creation du body du message iOS
        $iOSBody = $pushObj->getiOSMsg();
        //"<pre>".var_dump($iOSBody)."<pre>";
        
        // Enregistrement du push en etat 0
        $pushId = $this->PushDao->newPush($pushObj);
        
        // Envoi des push Android
        $reponseAndroid = $Push->sendPushAndroid($androidBody, $confPush['pushapp_androidkey']);
        //"<pre>".var_dump($confPush)."<pre>";
       // "<pre>".var_dump($reponseAndroid)."<pre>";
        
        // Modification de l'enregistrement du push en etat Envoye
        //$this->PushDao->updateStatusPush($pushId, 'Envoy&#233;', $reponseAndroid, "Not tested");
        //exit;
        
        // Envoi des push iOS
        $reponseiOS = $Push->sendPushIOS($iOSBody, $devicesToken, $confPush['pushapp_ioslocate'], $confPush['pushapp_passphrase']);

        // Modification de l'enregistrement du push en etat Envoye
        $this->PushDao->updateStatusPush($pushId, 'Envoy&#233;', $reponseAndroid, $reponseiOS);

        //die('<pre>'.print_r(array($reponseAndroid, $reponseiOS), true).'</pre>');
        
        return $this->redirect()->toRoute(
                'pushnotif', 
                array(
                    'action' => 'history'
                )
        );
         
    }

    /**
     * Affichage de l'historique des push
     */
    public function historyAction() {
        $this->PushDao = new PushDao();

        return new ViewModel(array(
            'pushs' => $this->PushDao->getAll()
        ));
    }

}
