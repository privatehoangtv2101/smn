<?php

namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class getSQLLikeArgTest extends TestCase {
  
    /**
     * @test
     */
    public function getSQLLikeArgByExistKey_ReturnValueExactly(){
        //TODO: set up
        $expectedResult = 32;
        $chaosArgs = [
            'name'=>'John Doe',
            'email'=>'doe69@gmail.com',
            '_offset' => $expectedResult
        ];
        $apiQL = new APIQL($chaosArgs);
        $actualResult = $apiQL->getSQLLikeArg('_offset');
        
        //TODO: assert
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    /**
     * @test
     */
    public function getSQLLikeArgByNonExistKey_ReturnFalse(){
        //TODO:
        $chaosArgs = [
            'name'=>'John Doe',
            'email'=>'doe69@gmail.com'
        ];
        $apiQL = new APIQL($chaosArgs);
        
        //TODO:
        $this->assertFalse($apiQL->getSQLLikeArg('_offset'));
    }
    
    
}