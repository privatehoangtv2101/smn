<?php

namespace API;

use API\Common\Exceptions\DomainException;
use API\Common\Exceptions\BadRequestException;
use API\Common\Exceptions\UnauthorizedException;
use API\Common\Exceptions\ResourceNotFoundException;
use API\Common\Exceptions\AccessForbiddenException;
use API\Common\Exceptions\InternalServerErrorException;

trait ErrorInfo {

    public function error($errorCode, $errorDesc = null, $errorDetail = null) {
        $error = [
            'status' => false,
            'status_code' => $errorCode,
            'error' => []
        ];

        if ($errorDesc != null) {
            $error['error']['err_desc'] = $errorDesc;
        }

        if ($errorDetail != null) {
            $error['error']['err_detail'] = $errorDetail;
        }

        return $error;
    }

    public function handleException(\Exception $e, $debug = false) {
        //enable debug for only one service
        if ($debug && env('APP_DEBUG')) {
            throw $e;
        }

        //enable debug for all services
        if (env('APP_DEBUG') && env('APP_DEBUG_ONE_SERVICE', false) == false) {
            throw $e;
        }

        if (!$e instanceof DomainException) {
            return $this->error(500, 'Hệ thống xảy ra lỗi - chưa thể xác định nguyên nhân');
        }

        return $this->error($e->getErrorCode(), $e->getName(), $e->getErrorDetail());
    }

    private $availableException = [
        400 => BadRequestException::class,
        401 => UnauthorizedException::class,
        404 => ResourceNotFoundException::class,
        503 => AccessForbiddenException::class,
        500 => InternalServerErrorException::class
    ];

    public function handleErrorResponse($response) {
        if (isset($this->availableException[$response['status_code']])) {
            /* @var $exception \API\Common\Exceptions\DomainException */
            $exceptionClassName = $this->availableException[$response['status_code']];
            $exception = new $exceptionClassName;

            if (isset($response['error']['err_desc'])) {
                $exception->setErrorName($response['error']['err_desc']);
            }
            if (isset($response['error']['err_detail'])) {
                $exception->setErrorDetail($response['error']['err_detail']);
            }

            throw $exception;
        }

        throw new \Exception;
    }

}
