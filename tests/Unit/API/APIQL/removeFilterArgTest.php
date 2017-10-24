<?php


namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class removeFilterArgTest extends TestCase {
    /**
     * @test
     */
    public function RemoveFilterArgHydrateData_ArgWillBeRemoved(){
        //TODO: hydrate data
        $chaosArgs = [
            'name'=>'John Doe',
            'email'=>'john69@gmail.com'
        ];
        
        $apiQL = new APIQL($chaosArgs);
        $apiQL->removeFilterArg('name');
        
        $this->assertEquals(['email'=>'john69@gmail.com'], $apiQL->getFilterArgs());
    }
}