<?php

namespace Pushnotif\Notification;

class Push {

    private $apiUrl_Androide = 'https://android.googleapis.com/gcm/send';
    private $apiUrl_iOS = 'ssl://gateway.push.apple.com:2195';
    private $ioscertFolder = "public/ioscert/";
    /**
     * Environnement
     * DEV : Developpement
     * Prod ; Production
     */
    private $env = 'DEV';

    //private
    public function sendPushAndroid($body, $apiKey) {
        // Entete du CURL
        $curl_headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );

        // Connexion Curl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl_Androide);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $curl_headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

        $result = curl_exec($curl);
        if (curl_exec($curl) === FALSE) {
            die('Envoi Push Android échoué <!-- ' . curl_error($curl) . ' -->');
        }

        curl_close($curl);
        return $result;
    }

    //private
    public function sendPushIOS($body, $devicesToken, $apiKey_iOS, $passphrase) {
        if (empty($devicesToken)) {
            return true;
            die('Il n`\'y a pas de devices iOS enregistré');
        }

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->ioscertFolder.$apiKey_iOS);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        foreach ($devicesToken as $t) {
            $fp = stream_socket_client($this->apiUrl_iOS, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
            if (!$fp)
                exit("Connexion échouée: $err $errstr" . PHP_EOL);

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $t) . pack('n', strlen($body)) . $body;

            $iosresult = fwrite($fp, $msg, strlen($msg));
            fclose($fp);
        }

        return $iosresult . $body;
        return true;
    }

    public function sendPush($PushObj) {
        
    }

}
