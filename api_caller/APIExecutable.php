<?php

namespace APICaller;

/**
 * @author Tran Van Hoang <hoangtv2101@gmail.com>
 */
interface APIExecutable {

    /**
     */
    public function get($url, $args = null): array;

    /**
     */
    public function post($url, $args = []): array;

    /**
     */
    public function put($url, $args = []): array;

    /**
     */
    public function delete($url, $args = []): array;

    /**
     */
    public function patch($url, $args = []): array;
}
