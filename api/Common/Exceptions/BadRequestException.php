<?php

namespace API\Common\Exceptions;

use API\Common\Exceptions\DomainException;
use API\HTTPCode;

class BadRequestException extends DomainException {

    protected $errorName = 'Yêu cầu không thể thực hiện';

    public function getErrorCode() {
        return HTTPCode::BAD_REQUEST;
    }

}
