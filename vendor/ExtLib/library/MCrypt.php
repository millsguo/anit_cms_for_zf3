<?php

namespace ExtLib;

use ExtLib\MCryptConst;

class MCrypt {

    function __construct() {
        
    }

    public function encrypt($str) {

        $td = mcrypt_module_open('rijndael-128', '', 'cbc', MCryptConst::$iv);

        mcrypt_generic_init($td, MCryptConst::$key, MCryptConst::$iv);
        $encrypted = mcrypt_generic($td, $str);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return bin2hex($encrypted);
    }

    public function decrypt($code) {
        //$key = $this->hex2bin(MCryptConst::$key);
        $code = $this->hex2bin($code);
        
        $td = mcrypt_module_open('rijndael-128', '', 'cbc', MCryptConst::$iv);

        mcrypt_generic_init($td, MCryptConst::$key, MCryptConst::$iv);
        $decrypted = mdecrypt_generic($td, $code);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return utf8_encode(trim($decrypted));
    }

    private function hex2bin($hexdata) {
        $bindata = '';

        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }

        return $bindata;
    }

}

// see http://androidsnippets.com/encrypt-decrypt-between-android-and-php