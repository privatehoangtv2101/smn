<?php

declare(strict_types = 1);

namespace API;

/**
 * API Query Language
 * @author Tran Van Hoang <hoangtv2101@gmail.com>
 */
class APIQL {

    use APIQLTemplate;

    /**
     * @var array
     */
    private $args = [], $authArgs = [], $sqlLikeArgs = [], $presentationArgs = [], $otherArgs = [], $filterArgs = [];

    /**
     * @param array $args
     */
    public function __construct(array $args = []) {
        $this->args = $args;
        $this->hydrate();
    }

    /**
     * @param array $args
     * @return \API\APIQL
     */
    public function setArgs(array $args) {
        $this->args = $args;
        $this->hydrate();
    }

    private function hydrate() {
        $args = $this->args;

        //TODO: find out auth args
        foreach ($this->authArgTemplate as $key => $value) {
            if (array_key_exists($key, $args)) {
                $this->authArgs[$key] = $args[$key];
                unset($args[$key]);
            }
        }

        //TODO: find out sql args
        foreach ($this->sqlLikeArgTemplate as $key => $value) {
            if (array_key_exists($key, $args)) {
                $this->sqlLikeArgs[$key] = $args[$key];
                unset($args[$key]);
            }
        }

        //TODO: find out presentation args
        foreach ($this->presentationArgTemplate as $key => $value) {
            if (array_key_exists($key, $args)) {
                $this->presentationArgs[$key] = $args[$key];
                unset($args[$key]);
            }
        }

        //TODO: find out other args
        foreach ($this->otherArgTemplate as $key => $value) {
            if (array_key_exists($key, $args)) {
                $this->otherArgs[$key] = $args[$key];
                unset($args[$key]);
            }
        }

        //TODO: All other thing are filter arguments
        $this->filterArgs = array_merge($this->filterArgs, $args);
    }

    /* ---------------------------------------------------------------------- */

    /**
     * @return array
     */
    public function getFilterArgs(): array {
        return $this->filterArgs;
    }

    /**
     * @param string $key
     * @return boolean|string
     */
    public function getFilterArg(string $key) {
        if (!isset($this->filterArgs[$key])) {
            return false;
        }

        return $this->filterArgs[$key];
    }

    public function removeFilterArg(string $key) {
        unset($this->filterArgs[$key]);
    }

    /* ---------------------------------------------------------------------- */

    /**
     * @return array
     */
    public function getAuthArgs(): array {
        return $this->authArgs;
    }

    /**
     * @param string $key
     * @return boolean|string
     */
    public function getAuthArg(string $key) {
        if (!isset($this->authArgs[$key])) {
            return false;
        }

        return $this->authArgs[$key];
    }

    /**
     * @param string $key
     */
    public function removeAuthArg(string $key) {
        unset($this->authArgs[$key]);
    }

    /* ---------------------------------------------------------------------- */

    /**
     * @return array
     */
    public function getSQLLikeArgs(): array {
        return $this->sqlLikeArgs;
    }

    /**
     * @param string $key
     */
    public function getSQLLikeArg(string $key) {
        if (!isset($this->sqlLikeArgs[$key])) {
            return false;
        }

        return $this->sqlLikeArgs[$key];
    }

    /**
     * @param string $key
     */
    public function removeSQLLikeArg(string $key) {
        unset($this->sqlLikeArgs[$key]);
    }

    /* ---------------------------------------------------------------------- */

    /**
     * @return array
     */
    public function getOtherArgs(): array {
        return $this->otherArgs;
    }

    /**
     * @param string $key
     */
    public function getOtherArg(string $key) {
        if (!isset($this->otherArgs[$key])) {
            return false;
        }

        return $this->otherArgs[$key];
    }

    /**
     * @param string $key
     */
    public function removeOtherArg(string $key) {
        unset($this->otherArgs[$key]);
    }

    /* ---------------------------------------------------------------------- */

    /**
     * @return array
     */
    public function getPresentationArgs(): array {
        return $this->presentationArgs;
    }
    
    /**
     * @param string $key
     */
    public function getPresentationArg(string $key) {
        if (!isset($this->presentationArgs[$key])) {
            return false;
        }

        return $this->presentationArgs[$key];
    }

    /**
     * 
     * @param string $key
     */
    public function removePresentationArg(string $key) {
        unset($this->presentationArgs[$key]);
    }

}
