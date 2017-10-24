<?php

namespace API\Common\Exceptions;

use API\Common\Exceptions\DomainException;
use API\HTTPCode;

class ResourceNotFoundException extends DomainException {

    protected $errorName = 'Không tìm thấy dữ liệu';

    public function getErrorCode() {
        return HTTPCode::NOT_FOUND;
    }

}
