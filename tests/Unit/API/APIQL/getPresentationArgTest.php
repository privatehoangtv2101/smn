<?php

namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class getPresentationArgTest extends TestCase {
  
    /**
     * @test
     */
    public function getPresentationArgByExistKey_ReturnValueExactly(){
        //TODO: set up
        $expectedResult = 'data';
        $chaosArgs = [
            'name'=>'John Doe',
            '_return' => $expectedResult
        ];
        $apiQL = new APIQL($chaosArgs);
        $actualResult = $apiQL->getPresentationArg('_return');
        
        //TODO: assert
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    /**
     * @test
     */
    public function getPresentationArgByNonExistKey_ReturnFalse(){
        //TODO:
        $chaosArgs = [
            'name'=>'John Doe',
            'email'=>'doe69@gmail.com'
        ];
        $apiQL = new APIQL($chaosArgs);
        
        //TODO:
        $this->assertFalse($apiQL->getAuthArg('_return'));
    }
    
    
}