<?php

namespace API\Common;

trait Signer {

    private static $data;
    private static $serviceToken;

    public static function setServiceToken($serviceToekn) {
        self::$serviceToken = $serviceToekn;
    }

    public static function getServiceToken() {
        return self::$serviceToken;
    }

    public static function setSignerData($data) {
        self::$data = $data;
    }

    public static function getSignerData() {
        return self::$data;
    }
    
    public static function isCEO(){
        $signerData = self::getSignerData();
        $signerRoles = explode('.', $signerData['role']);
        
        return in_array(Role::CEO, $signerRoles);
    }

}
