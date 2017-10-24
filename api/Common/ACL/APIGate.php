<?php

namespace API\Common\ACL;

use API\ErrorInfo;
use API\Common\Exceptions\UnauthorizedException;
use API\Common\Exceptions\ServiceNotFoundException;
use API\APIQL;

abstract class APIGate {

    use ErrorInfo;

    private $method;
    private $uri;
    private $args;
    private $apiSetting;

    public function get($uri, $args) {
        $this->method = 'GET';
        $this->uri = $uri;
        $this->args = $args;

        return $this->runService();
    }

    public function post($uri, $args) {
        $this->method = 'POST';
        $this->uri = $uri;
        $this->args = $args;

        return $this->runService();
    }

    public function put($uri, $args) {
        $this->method = 'PUT';
        $this->uri = $uri;
        $this->args = $args;

        return $this->runService();
    }

    public function patch($uri, $args) {
        $this->method = 'PATCH';
        $this->uri = $uri;
        $this->args = $args;

        return $this->runService();
    }

    public function delete($uri, $args) {
        $this->method = 'DELETE';
        $this->uri = $uri;
        $this->args = $args;

        return $this->runService();
    }

    /* ---------------------------------------------------------------------- */

    private function runService(): array {
        try {
            $this->apiSetting = $this->getAPISetting();
            $isMapToRoot = true;
            $service = $this->findRootService();
            if ($service === false) {
                $isMapToRoot = false;
                $service = $this->findItemService();
            }

            if($service === false){
                throw new ServiceNotFoundException();
            }

            $actionClassPrefix = $this->getAPIRelationNameSpacePrefix();
            if ($isMapToRoot) {
                $actionClass = $actionClassPrefix.'Root' . $this->parseMethodName($service);
            } else {
                $actionClass = $actionClassPrefix.'Item' . $this->parseMethodName($service);
            }

//            if (!$this->serviceAuth($isMapToRoot, $service)) {
//                throw new UnauthorizedException();
//            }
//            $this->applyMiddleware();
            
            

            $apiQL = new APIQL($this->args);
            
            $action = new $actionClass;
            return $action->run($apiQL);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * ***************************************************** */
    private function findRootService() {
        $links = $this->apiSetting->getAggregateLinks();
        foreach ($links as $key => $value) {
            if (!isset($value['method'])) {
                $value['method'] = 'GET';
            }

            if ($value['method'] != $this->method) {
                continue;
            }

            if ($this->uri === $value['href']) {
                return $key;
            }
        }

        return false;
    }

    private function findItemService() {
        $links = $this->apiSetting->getItemLinks();
        foreach ($links as $key => $value) {
            if (!isset($value['method'])) {
                $value['method'] = 'GET';
            }

            if ($value['method'] != $this->method) {
                continue;
            }

            $url = $this->uri;
            $href = $value['href'];


            $url = trim(str_replace($this->apiSetting->getRootURI(), '', $url), '/');
            $href = trim(str_replace($this->apiSetting->getRootURI(), '', $href), '/');

            $urlArr = explode('/', $url);
            $hrefArr = explode('/', $href);

            if (!isset($urlArr[1]) && !isset($hrefArr[1])) {
                $this->args['id'] = $urlArr[0];
                return $key;
            }

            if (isset($urlArr[1]) && isset($hrefArr[1]) && ($urlArr[1] == $hrefArr[1])) {
                $this->args['id'] = $urlArr[0];
                return $key;
            }
        }
        return false;
    }

    /**
     * ***************************************************** */
    private function parseMethodName($raw) {
        $rawArr = explode('_', $raw);
        $rawArr = array_map(function($word) {
            return ucfirst($word);
        }, $rawArr);
        return implode('', $rawArr);
    }

    /**
     * ***************************************************** */
    private function serviceAuth($isMapToRoot, $action) {
        $authArgs = $this->argumentService->getAuthArgs();

        $APIPolicy = $this->getAPIPolicy();
        $checkPolicyResult = $APIPolicy->checkPolicy($isMapToRoot, $action, $authArgs);
        if (!$checkPolicyResult) {
            return false;
        }

        if ($authArgs['_service_token'] !== null) {
            return $this->setSignerData($authArgs['_service_token']);
        }

        return true;
    }

//
//    /**
//     * ***************************************************** */
//    private function setSignerData($serviceToken) {
//        $serviceTokenArr = explode('.', $serviceToken);
//        if (!isset($serviceTokenArr[1])) {
//            return false;
//        }
//
//        $payload = $serviceTokenArr[0];
//        $signature = $serviceTokenArr[1];
//        if ($this->generateSignature($payload) !== $signature) {
//            return false;
//        }
//
//        $claims = json_decode(base64_decode($payload), true);
//
//        $signer = $this->getSigner();
//        $signer::setSignerData($claims);
//        $signer::setServiceToken($serviceToken);
//
//        return true;
//    }
//
//    /**
//     * ***************************************************** */
//    private function generateSignature($payload) {
//        return md5(base64_encode(sha1($payload . 'let it be')));
//    }
    
    /**
     * ***************************************************** */
    abstract protected function getAPIRelationNameSpacePrefix(): string;

    /**
     * ***************************************************** */
    abstract protected function getAPISetting();

//    /**
//     * ***************************************************** */
//    abstract protected function getSigner();
//
    /**
     * @return \API\Common\ACL\APIPolicy
     */
    abstract protected function getAPIPolicy(): \API\Common\ACL\APIPolicy;
}
