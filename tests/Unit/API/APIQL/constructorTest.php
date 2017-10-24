<?php

namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class constructorTest extends TestCase {
  
    /**
     * @test
     */
    public function instantiateObjectWithArgument_ArgumentWillBeHydratedAutomactically(){
        //TODO:
        $chaosArgs = [
            'name'=>'John Doe',
            'email'=>'fizzbuzz@gmail.com',
            '_include' => 'data include'
        ];
        $apiQL = new APIQL($chaosArgs);
        
        //TODO:
        $this->assertEquals([
            'name'=>'John Doe',
            'email'=>'fizzbuzz@gmail.com',
        ], $apiQL->getFilterArgs());
        
        $this->assertEquals([
            '_include' => 'data include'
        ], $apiQL->getOtherArgs());
    }
    
    /**
     * @test
     */
    public function passNothingWhenInstantiateNewObject_CodeRunWithoutError(){
        $apiQL = new APIQL();
        $this->assertTrue(true);
    }
    
    
}