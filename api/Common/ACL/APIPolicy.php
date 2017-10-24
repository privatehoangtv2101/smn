<?php

namespace API\Common\ACL;

use API\Common\Service\Caller;

abstract class APIPolicy {

    /**
     * @var array 
     */
    protected $rootPolicies;

    /**
     * @var array 
     */
    protected $itemPolicies;

    public function getRootPolicies() {
        return $this->rootPolicies;
    }

    public function getItemPolicies() {
        return $this->itemPolicies;
    }

    public function checkPolicy($isCheckRoot = true, $actionKey, $authArgs) {

        if ($isCheckRoot) {
            if (!isset($this->rootPolicies[$actionKey])) {
                return false;
            }
            $policySetting = $this->rootPolicies[$actionKey];
        } else {
            if (!isset($this->itemPolicies[$actionKey])) {
                return false;
            }
            $policySetting = $this->itemPolicies[$actionKey];
        }

        foreach ($policySetting as $policyType => $value) {
            $result = $this->runCheckPolicy($policyType, $value, $authArgs);
            if ($result === false) {
                return $result;
            }
        }

        return true;
    }

    private function runCheckPolicy($policyType, $value, $authArgs) {
        $policyMethod = "{$policyType}Policy";
        if (method_exists($this, $policyMethod)) {
            return $this->$policyMethod($value, $authArgs);
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    private function authPolicy($auth, $authArgs) {
        $serviceToken = $authArgs['_service_token'];
        if ($auth == false) {
            return true;
        }

        if ($serviceToken === null) {
            return false;
        }

        return true;
    }

    private function callerPolicy($caller, $authArgs) {
        if (Caller::hash($caller) !== $authArgs['_caller']) {
            return false;
        }

        return true;
    }

    private function outsidePolicy($outside, $authArgs) {
        if ($outside !== $authArgs['_outside']) {
            return false;
        }

        return true;
    }

}
