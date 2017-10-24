<?php

namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class getAuthArgTest extends TestCase {
  
    /**
     * @test
     */
    public function getAuthArgByExistKey_ReturnValueExactly(){
        //TODO: set up
        $chaosArgs = [
            'name'=>'John Doe',
            'email'=>'doe69@gmail.com',
            '_token' => 'data token'
        ];
        $apiQL = new APIQL($chaosArgs);
        $actualResult = $apiQL->getAuthArg('_token');
        
        //TODO: assert
        $this->assertEquals('data token', $actualResult);
    }
    
    /**
     * @test
     */
    public function getAuthArgByNonExistKey_ReturnFalse(){
        //TODO:
        $chaosArgs = [
            'name'=>'John Doe',
            'email'=>'doe69@gmail.com'
        ];
        $apiQL = new APIQL($chaosArgs);
        
        //TODO:
        $this->assertFalse($apiQL->getAuthArg('_token'));
    }
    
    
}