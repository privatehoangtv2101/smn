<?php

namespace API\Users\ACL;

/**
 * @author Tran Van Hoang <hoangtv2101@gmail.com>
 */
class UsersAPIGate extends \API\Common\ACL\APIGate {

    protected function getAPIRelationNameSpacePrefix(): string {
        return '\\API\\Users\\ACL\\APIRelation\\';
    }
    
    protected function getAPISetting() {
        return new \API\Users\ACL\UsersAPISetting;
    }

    protected function getAPIPolicy(): \API\Common\ACL\APIPolicy {
        return new \API\Users\ACL\UsersAPIPolicy;
    }

    protected function getMiddleware(): \API\Common\ACL\APIPolicy {
        return new \API\Users\ACL\UsersAPIPolicy;
    }

}
