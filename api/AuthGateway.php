<?php

namespace API;

use API\APIQL;
use APICaller\APIFactory;

/**
 * @deprecated
 */
class AuthGateway {

    private static $serviceToken = null;

    /**
     * @var APIQL 
     */
    private $args;

    public function mofifyArgs($args) {
        $this->args = new APIQL($args);
        $this->setServiceToken();
        $this->args->removeArg('_token');
        return $this->args->getAllArgs();
    }

    private function setServiceToken() {
        $authArgs = $this->args->getAuthArgs();
        if (!isset($authArgs['_token']) || isset($authArgs['_service_token'])) {
            return;
        }

        if (self::$serviceToken === null) {
            self::$serviceToken = $this->findServiceToken($authArgs['_token']);
        }

        if (self::$serviceToken === null) {
            return;
        }

        $this->args->setArg('_service_token', self::$serviceToken);
    }

    private function findServiceToken($statefull_jwt) {
        $api = APIFactory::getAPI();
        $response = $api->get(url('api/staffs/verify-token'), [
            '_outside' => 'auth',
            '_auth_token' => $statefull_jwt,
            '_hide_item_links' => true
        ]);

        //TODO:
        if(!isset($response['status'])){
            return null;
        }
        if ($response['status'] == false) {
            return null;
        }

        return $this->generateServiceToken($response['resources']);
    }

    private function generateServiceToken($signerData) {
        $claims = [
            'id' => $signerData['id'],
            'role' => $signerData['permission'],
            'branch_id' => $signerData['branch']['id']
        ];

        $payload = base64_encode(json_encode($claims));
        $serviceToken = $payload . '.' . $this->generateSignature($payload);
        
        //service token mean stateless jwt, used to auth among services
        return $serviceToken;
    }

    private function generateSignature($payload) {
        return md5(base64_encode(sha1($payload . 'let it be')));
    }

}
