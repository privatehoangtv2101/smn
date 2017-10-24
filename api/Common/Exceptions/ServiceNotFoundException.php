<?php

namespace API\Common\Exceptions;

use API\Common\Exceptions\ResourceNotFoundException;

class ServiceNotFoundException extends ResourceNotFoundException {

    protected $errorName = 'Không tìm thấy dịch vụ';

}
