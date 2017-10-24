<?php

namespace API\Common\Exceptions;

use API\Common\Exceptions\DomainException;
use API\HTTPCode;

class UnauthorizedException extends DomainException {

    protected $errorName = 'Không thể xác thực danh tính người dùng';

    public function getErrorCode() {
        return HTTPCode::UNAUTHORIZED;
    }

}
