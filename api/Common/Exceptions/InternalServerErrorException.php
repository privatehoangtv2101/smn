<?php

namespace API\Common\Exceptions;

use API\Common\Exceptions\DomainException;
use API\HTTPCode;

class InternalServerErrorException extends DomainException {

    protected $errorName = 'Hệ thống lỗi';

    public function getErrorCode() {
        return HTTPCode::INTERNAL_SERVER_ERROR;
    }

}
