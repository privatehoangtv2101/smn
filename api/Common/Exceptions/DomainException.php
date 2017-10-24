<?php

namespace API\Common\Exceptions;

class DomainException extends \Exception {

    private $errorDetail = null;
    protected $errorName = null;

    public function setErrorDetail($errorDetail) {
        $this->errorDetail = $errorDetail;
    }
    
    public function setErrorName($errorName) {
        $this->errorName = $errorName;
    }

    public function getErrorDetail() {
        return $this->errorDetail;
    }

    public function getName(){
        return $this->errorName;
    }

    public function getErrorCode(){}
}
