<?php

use Illuminate\Http\Request;
use APICaller\APIFactory;

$supportedHTTPMethod = [
    'GET' => 'get',
    'POST' => 'post',
    'PUT' => 'put',
    'PATCH' => 'patch',
    'DELETE' => 'delete'
];

Route::any('{path}', function ($path = null, Request $request) use($supportedHTTPMethod) {

    $method = $request->method();

    if (!isset($supportedHTTPMethod[$method])) {
        return [
            'status' => false,
            'status_code' => 400,
            'error' => [
                'err_desc' => 'HTTP method is not valid'
            ]
        ];
    }
    $methodName = $supportedHTTPMethod[$method];

    $fullUrl = $request->fullUrl();
    $api = APIFactory::getAPI();

    if ($method === 'GET') {
        $response = $api->get($fullUrl,  filter_input_array(INPUT_GET));
    }else{
        $response = $api->$methodName($fullUrl,  filter_input_array(INPUT_POST));
    }
    
    return \Response::json($response,$response['status_code']);
})->where(['path' => '.*']);
