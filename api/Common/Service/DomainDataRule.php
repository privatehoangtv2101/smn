<?php

namespace API\Common\Service;

use Validator;
use API\Common\Exceptions\BadRequestException;

/**
 * Dependency: laravel validator
 */
abstract class DomainDataRule {

    public function validate($data = null) {
        $dataValidate = ($this->getDataValidate()!== null)? $this->getDataValidate():$data;
        $validator = Validator::make($dataValidate, $this->rules(), $this->messages());
        if ($validator->fails()) {
            $badRequestException = new BadRequestException();
            $errorMsg = $this->handleLaravelErrorMsg($validator->errors()->toArray());
            $badRequestException->setErrorDetail($errorMsg);

            throw $badRequestException;
        }
    }
    
    protected function getDataValidate(){
        return null;
    }

    
    private function rules() {
        $validateFields = $this->validateFields();
        $allDataRules = $this->getAllDataRules();
        $usingRules = [];
        foreach($validateFields as $value){
            $usingRules[$value] = $allDataRules[$value];
        }
        
        return $usingRules;
    }
    
    private function handleLaravelErrorMsg($laravelErrorMsg) {
        $errorMsg = [];
        foreach ($laravelErrorMsg as $key => $value) {
            $errorMsg[$key] = $value[0];
        }

        return $errorMsg;
    }

    abstract protected function getAllDataRules();
    abstract protected function messages();
    abstract protected function validateFields();
}
