<?php

namespace API\Common\ACL;

use API\Common\ACL\APIPolicy;
use API\APIQL;

class APISetting{
    
    protected $rootURI;

//    protected $rootPath, $rootURI, $apiPolicy, $argumentService;
//
//    /**
//     * ***************************************************** */
//    public function __construct($rootPath, $rootURI, APIPolicy $apiPolicy, ArgumentService $argumentService) {
//        $this->rootPath = $rootPath;
//        $this->rootURI = $rootURI;
//        $this->apiPolicy = $apiPolicy;
//        $this->argumentService = $argumentService;
//    }
//
//    /**
//     * @deprecated since version number
//     */
//    private function returnCount($data){
//        return [
//            'status' =>true,
//            'count' => $data['count']
//        ];
//    }
    /**
     * ***************************************************** */
    public function generateAggregate($data, $paging = null, $apiQL) {
        $return = $apiQL->getOtherArg('_return');
        if($return != null){
            $methodName = 'return'.ucfirst($return);
            if(method_exists($this, $methodName)){
                return $this->$methodName($data);
            }
        }
        
        if (isset($data['status']) && $data['status'] == false) {
            return $data;
        }
        $aggregate = $this->getAggregate();
        if ($apiQL->getOtherArg('_hide_root_links') === null) {
            $aggregate = $this->bindAggregateLinks(
                    $aggregate, $this->getAggregateLinks()
            );
        }


        foreach ($data as $itemData) {
            $item = $this->bindItem($itemData);
            $aggregate['resources'][] = $item;
        }

        $aggregate['_paging'] = $paging;
        return $aggregate;
    }

    private function bindAggregateLinks($aggregate, $aggregateLinks) {
        $aggregate['_links'] = null;
        $rootAPIPolicies = $this->apiPolicy->getRootPolicies();
        foreach ($rootAPIPolicies as $policyName => $policySetting) {
            if (isset($policySetting['caller']) || isset($policySetting['outside'])) {
                continue;
            }

            $aggregate['_links'][$policyName] = $aggregateLinks[$policyName];
        }

        return $aggregate;
    }

    /**
     * ***************************************************** */
    public function generateItem($data) {
        $bound = [
            'status' => true
        ];
        $item = $this->bindItem($data);
        $bound['resources'] = $item;
        return $bound;
    }

    /**
     * ***************************************************** */
    public function bindItem($itemData) {
        $item = $this->getItem($itemData);
        foreach ($item as $key => $itemValue) {
            if (array_key_exists($key, $itemData)) {
                $item[$key] = $itemData[$key];
            } elseif ($this->isInFieldsList($key) && method_exists($this, 'subItem_' . $key)) {
                $itemMethod = 'subItem_' . $key;
                $subItem = $this->$itemMethod($itemData);
                if (!$subItem) {
                    unset($item[$key]);
                    continue;
                }
                $item[$key] = $subItem;
            } else {
                unset($item[$key]);
            }
        }
        if ($apiQL->getOtherArg('_hide_item_links') === null) {
            $itemLinks = $this->getItemLinks();
            foreach ($itemLinks as $key => $link) {
                $itemLinks[$key]['href'] = str_replace('{id}', $itemData['id'], $itemLinks[$key]['href']);
            }
            $item['_links'] = $itemLinks;
        }

        return $item;
    }

    private function isInFieldsList($key) {
        $fieldsList = $apiQL->getSQLArg('_fields');
        if ($fieldsList === null) {
            return true;
        }

        $fieldsListArr = explode('.', $fieldsList);
        if (!array_search($key, $fieldsListArr)) {
            return false;
        }

        return true;
    }

    /**
     * ***************************************************** */
    public function getAggregate() {
        return [
            'status' => true,
            'resources' => null,
            '_paging' => null
        ];
    }

    public function getRootURI(){
        return $this->rootURI;
    }

}
