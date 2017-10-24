<?php

namespace API\Common\ACL;
use API\APIQL;

interface APIRelation {

    public function run(APIQL $apiQL);
}
