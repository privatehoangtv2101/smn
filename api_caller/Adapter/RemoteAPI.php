<?php

namespace APICaller\Adapter;

use APICaller\APIExecutable;

/**
 * @author Tran Van Hoang <hoangtv2101@gmail.com>
 */
class RemoteAPI implements APIExecutable {

    public function get($url, $args = null): array {
        if (is_array($args)) {
            $url .= '?' . http_build_query($args);
        }

        $curl = curl_init();

        //TODO: Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $curl
        ));

        //TODO:
        $response = curl_exec($curl);

        //TODO:
        curl_close($curl);

        return json_decode($response, true);
    }

    public function post($url, $args = []): array {
        //TODO:
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_POST => true
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($args));
        //TODO:
        $response = curl_exec($curl);

        //TODO:
        curl_close($curl);
        return json_decode($response, true);
    }

    public function put($url, $args = []): array {
        return $this->call("PUT", $url, $args);
    }

    public function delete($url, $args = []): array {
        return $this->call("DELETE", $url, $args);
    }

    public function patch($url, $args = []): array {
        return $this->call("PATCH", $url, $args);
    }
    
    private function call($type, $url, $args): array {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
        
        $response = curl_exec($ch);

        //TODO:
        curl_close($curl);
        return json_decode($response, true);
    }

}
