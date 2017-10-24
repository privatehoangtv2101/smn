<?php


namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class removeAuthArgTest extends TestCase {
    
    /**
     * @test
     */
    public function RemoveAuthArgHydrateData_ArgWillBeRemoved(){
        //TODO: hydrate data
        $chaosArgs = [
            '_token'=>'data token',
            '_service_token'=>'data service token'
        ];
        
        $apiQL = new APIQL($chaosArgs);
        $apiQL->removeAuthArg('_token');
        
        $this->assertEquals(['_service_token'=>'data service token'], $apiQL->getAuthArgs());
    }
}