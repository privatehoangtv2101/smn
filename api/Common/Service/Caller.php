<?php

namespace API\Common\Service;

class Caller {

    public static function hash($key) {
        return substr(md5($key . env('APP_KEY')), 3, 10);
    }

}
