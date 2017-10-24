<?php

namespace API\Users\ACL;

class UsersAPIPolicy extends \API\Common\ACL\APIPolicy {

    /**
     * @var array 
     */
    protected $rootPolicies = [
        'create_order' => ['auth' => true],
        'self' => ['auth' => true]
    ];

    /**
     * @var array 
     */
    protected $itemPolicies = [
        'delete_receipt' => ['auth' => true],
        'create_receipt' => ['auth' => true],
        'update_order' => ['auth' => true],
        'update_order_item' => ['auth' => true],
        'delete_order_item' => ['auth' => true],
        'add_order_item' => ['auth' => true],
        'delete_order' => ['auth' => true],
        'self' => ['auth' => true]
    ];

}
