<?php

namespace API\Common\Exceptions;

use API\Common\Exceptions\DomainException;
use API\HTTPCode;

class AccessForbiddenException extends DomainException {

    protected $errorName = 'Hạn chế truy cập';

    public function getErrorCode() {
        return HTTPCode::FORBIDDEN;
    }

}
