<?php

namespace Tests\Unit\APICaller;

use Tests\TestCase;
use APICaller\APIFactory;
use APICaller\APIExecutable;
use APICaller\Adapter\LocalAPI;
use APICaller\Adapter\RemoteAPI;

class APIFactoryTest extends TestCase {

    /**
     * @test
     */
    public function getAPI_WithValidAPIType_ReturnAnInstanceOfAPIExecutable() {
        $object1 = APIFactory::getAPI(LocalAPI::class);
        $object2 = APIFactory::getAPI(RemoteAPI::class);

        $valid = $object1 instanceof APIExecutable
                 &&
                 $object2 instanceof APIExecutable;

        $this->assertTrue($valid);
    }

    /**
     * @test
     */
    public function getAPI_WithoutPassingAPIType_ReturnLocalAPIByDefault() {
        $object = APIFactory::getAPI();

        $this->assertTrue($object instanceof LocalAPI);
    }
    
    /**
     * @test
     */
    public function getAPI_RunManyTimeWithSameType_ReturnExactTheSameInstance(){
        $object1 = APIFactory::getAPI(LocalAPI::class);
        $object2 = APIFactory::getAPI(LocalAPI::class);
        $object3 = APIFactory::getAPI(LocalAPI::class);

        $this->assertTrue($object1 === $object2);
        $this->assertTrue($object2 === $object3);
    }

}
