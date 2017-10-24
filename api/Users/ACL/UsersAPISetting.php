<?php

namespace API\Users\ACL;

class UsersAPISetting extends \API\Common\ACL\APISetting {

    
    public function __construct() {
        $this->rootURI = url('/api/users');
    }
    
    public function getAggregateLinks() {
        return [
            'create_order' => ['href' => $this->rootURI.'/create-order', 'method' => 'GET'],
            'self' => ['href' => $this->rootURI, 'method' => 'GET']
        ];
    }
    
    public function getItemLinks() {
        return [
            'delete_receipt' => ['href' => $this->rootURI . '/{id}/order-receipts', 'method' => 'GET'],
            'update_order' => ['href' => $this->rootURI . '/{id}/update-order', 'method' => 'GET'],
            'self' => ['href' => $this->rootURI . '/{id}', 'method' => 'GET']
        ];
    }

    public function getItem($itemData) {
        return [
            'id' => null,
            'code' => null,
            'description' => null,
            'start_date' => null,
            'end_date' => null,
            'total_value' => null,
            'total_tax' => null,
            'total_paid' => null,
            'status' => null,
            'create_at' => null,
            'branch' => null,
            'creator' => null,
            'customer' => null,
            'order_items' => null,
            'order_receipts' => null
        ];
    }

    public function subItem_order_receipts($order) {
        return [
            'href' => url("api/receipts?order_item={$order['id']}")
        ];
    }
    
    public function subItem_order_items($order) {
        return [
            'href' => url("api/orders/{$order['id']}/order-items")
        ];
    }

    /**
     * ***************************************************** */
    public function subItem_creator($order) {
        $staffUrl = url('api/staffs/' . $order['create_by']);
        return [
            'id' => $order['create_by'],
            'href' => $staffUrl
        ];
    }

    /**
     * ***************************************************** */
    public function subItem_branch($order) {
        $branchUrl = url('api/branchs/' . $order['branch_id']);
        return [
            'id' => $order['branch_id'],
            'href' => $branchUrl
        ];
    }

    /**
     * ***************************************************** */
    public function subItem_customer($order) {
        $customerUrl = url('api/customers/' . $order['customer_id']);
        return [
            'id' => $order['customer_id'],
            'href' => $customerUrl
        ];
    }

}
