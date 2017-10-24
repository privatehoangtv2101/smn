<?php

namespace API;

trait APIQLTemplate {

    /**
     * @var array
     */
    public $authArgTemplate = [
        '_token' => null, // it is a jwt, be used between application and api
        '_service_token' => null, // it actually is stateless jwt, be used among internal services
        '_auth_token' => null, //_auth_token is exactly _token but it is only used to verify
        '_caller' => null, // it is a key which will be hashed to use among internal services
        '_outside' => null// it is a key which will not be hash, it's used to call from external services,applications
    ];

    /**
     * @var array
     */
    public $sqlLikeArgTemplate = [
        '_offset' => null, // ex: offset=1
        '_limit' => null, // ex: limit=2
        '_sort' => null, //deprecated
        '_fields' => null, //ex: fields:name.status.gender
        '_in' => null, // deprecated
        '_order' => null//ex: order=id.desc
    ];

    /**
     * @var array
     */
    public $otherArgTemplate = [
        '_include' => null, //ex: include=project.department
        '_page' => null, //ex: _page=2
        '_paging' => null, //enable pagination, ex: _paging=true
        '_method' => null, //HTTP method: post, get, delete, put,...
        '_hide_item_links' => null, // ex: _hide_item_links=true
        '_hide_root_links' => null, // ex: _hide_root_links=true
    ];

    /**
     * @var array
     */
    public $presentationArgTemplate = [
        '_return' => null, //optional: count,...
    ];

}
