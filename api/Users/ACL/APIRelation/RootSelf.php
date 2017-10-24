<?php

namespace API\Users\ACL\APIRelation;
use API\Common\ACL\APIRelation;
use API\HTTPCode;
use API\APIQL;

class RootSelf implements APIRelation{
    
    public function run(APIQL $apiQL) {
        return [
            'status' => true,
            'status_code' => HTTPCode::OK,
            'resources' => $apiQL->getFilterArgs()
        ];
    }

}