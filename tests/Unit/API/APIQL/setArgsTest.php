<?php

namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class setArgsTest extends TestCase {
    
    /**
     * @test
     */
    public function runSetArg_ArgumentWillBeHydratedAutomactically(){
        //TODO:
        $chaosArgs = [
            'name'=>'John Doe',
            'email'=>'fizzbuzz@gmail.com',
            '_include' => 'data include'
        ];
        $apiQL = new APIQL();
        $apiQL->setArgs($chaosArgs);
        
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
    public function RunSetArgManyTimes_ArgumentBeforeWillBeOverride(){
        //TODO:
        $chaosArgs1 = [
            'name'=>'John Doe',
            'email'=>'fizzbuzz@gmail.com'
        ];
        $apiQL = new APIQL($chaosArgs1);
        
        //TODO:
        $chaosArgs2 = [
            'email'=>'john69@gmail.com'
        ];
        $apiQL->setArgs($chaosArgs2);
        
        
        //TODO:
        $chaosArgs3 = [
            'name'=>'Doe',
            'first_name'=>'John'
        ];
        $apiQL->setArgs($chaosArgs3);
        
        //TODO:
        $this->assertNotEquals($chaosArgs1, $apiQL->getFilterArgs());
        $this->assertEquals([
            'name'=>'Doe',
            'email'=>'john69@gmail.com',
            'first_name'=>'John'
        ], $apiQL->getFilterArgs());
        
    }
    
    
}