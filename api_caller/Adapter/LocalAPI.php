<?php

namespace APICaller\Adapter;

use APICaller\APIExecutable;

/**
 * @author Tran Van Hoang <hoangtv2101@gmail.com>
 */
class LocalAPI implements APIExecutable {

    private static $endpointClass = 'API\{ep}\ACL\{ep}APIGate';
    private static $endpointPlaceholder = '{ep}';
    private static $apiBase = '/api/';
    
    /**
     * connect mean autoload
     * @param string $uri
     * @return \API\Common\ACL\APIGate|array
     */
    private function connectTo($uri) {
        $urlPath = parse_url($uri, PHP_URL_PATH);
        $pathWithoutAPIBase = str_replace(self::$apiBase, '', $urlPath);
        $pathArr = explode('/', $pathWithoutAPIBase);

        $endpoint = $this->parseEndpoint($pathArr[0]);
        $endpointClass = str_replace(self::$endpointPlaceholder, $endpoint, self::$endpointClass);

        if (!class_exists($endpointClass)) {
            return [
                'status' => false,
                'error' => [
                    'err_code' => 404,
                    'err_desc' => 'Gate: Resource not found'
                ]
            ];
        }

        return new $endpointClass;
    }

    /**
     * ex: parse "lorem-ispum" into "LoremIspum"
     * @param string $raw
     * @return string
     */
    private function parseEndpoint($raw) {
        $rawArr = array_map(function($word) {
            return ucfirst($word);
        }, explode('-', $raw));

        return implode('', $rawArr);
    }

    /* ---------------------------------------------------------------------- */

    /**
     * @param string $uri
     * @param array $args
     * @return array
     */
    public function get($uri, $args = []): array {
        if (sizeof($args) === 0) {
            $query = parse_url($uri, PHP_URL_QUERY);
            parse_str($query, $args);
        }
        $uri = strtok($uri, '?');
        
        $instance = $this->connectTo($uri);
        if (!is_object($instance)) {
            return $instance;
        }

        return $instance->get($uri, $args);
    }

    /**
     * @param string $uri
     * @param array $args
     * @return array
     */
    public function post($uri, $args = []): array {
        $instance = $this->connectTo($uri);
        if (!is_object($instance)) {
            return $instance;
        }

        return $instance->post($uri, $args);
    }

    /**
     * @param string $uri
     * @param array $args
     * @return array
     */
    public function put($uri, $args = []): array {
        $instance = $this->connectTo($uri);
        if (!is_object($instance)) {
            return $instance;
        }

        return $instance->put($uri, $args);
    }

    /**
     * @param string $uri
     * @param array $args
     * @return array
     */
    public function patch($uri, $args = []): array {
        $instance = $this->connectTo($uri);
        if (!is_object($instance)) {
            return $instance;
        }

        return $instance->patch($uri, $args);
    }

    /**
     * @param string $uri
     * @param array $args
     * @return array
     */
    public function delete($uri, $args = []): array {
        $instance = $this->connectTo($uri);
        if (!is_object($instance)) {
            return $instance;
        }

        return $instance->delete($uri, $args);
    }

}
