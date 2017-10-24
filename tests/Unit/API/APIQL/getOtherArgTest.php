<?php

namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class getOtherArgTest extends TestCase {
  
    /**
     * @test
     */
    public function getOtherArgByExistKey_ReturnValueExactly(){
        //TODO: set up
        $expectedResult = 'data include';
        $chaosArgs = [
            'name'=>'John Doe',
            '_include' => $expectedResult
        ];
        $apiQL = new APIQL($chaosArgs);
        $actualResult = $apiQL->getOtherArg('_include');
        
        //TODO: assert
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    /**
     * @test
     */
    public function getOtherArgByNonExistKey_ReturnFalse(){
        //TODO:
        $chaosArgs = [
            'name'=>'John Doe'
        ];
        $apiQL = new APIQL($chaosArgs);
        
        //TODO:
        $this->assertFalse($apiQL->getOtherArg('_include'));
    }
    
    
}