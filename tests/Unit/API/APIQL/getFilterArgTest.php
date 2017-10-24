<?php

namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class getFilterArgTest extends TestCase {
  
    /**
     * @test
     */
    public function getFilterArgByExistKey_ReturnValueExactly(){
        //TODO: set up
        $chaosArgs = [
            'name'=>'John Doe',
            'email'=>'doe69@gmail.com',
            '_include' => 'data include'
        ];
        $apiQL = new APIQL($chaosArgs);
        $actualResult = $apiQL->getFilterArg('name');
        
        //TODO: assert
        $this->assertEquals('John Doe', $actualResult);
    }
    
    /**
     * @test
     */
    public function getFilterArgByNonExistKey_ReturnFalse(){
        //TODO:
        $chaosArgs = [
            'name'=>'John Doe',
            'email'=>'doe69@gmail.com',
            '_include' => 'data include'
        ];
        $apiQL = new APIQL($chaosArgs);
        
        //TODO:
        $this->assertFalse($apiQL->getFilterArg('foo'));
    }
    
    
}