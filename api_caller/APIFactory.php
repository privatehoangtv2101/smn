<?php

namespace APICaller;

use APICaller\APIExecutable;
use APICaller\Adapter\LocalAPI;

class APIFactory {

    /**
     * Array of APIExecutable implementation objects
     * @var array 
     */
    private static $container = [];
    
    /**
     * @param string $type
     * @return APIExecutable
     */
    public static function getAPI(string $type = LocalAPI::class): APIExecutable {
        if(isset(self::$container[$type])){
            return self::$container[$type];
        }
        
        self::$container[$type] = new $type();
        return self::$container[$type];
    }

}
