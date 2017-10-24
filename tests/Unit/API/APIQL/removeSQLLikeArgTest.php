<?php


namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class removeSQLLikeArgTest extends TestCase {
    
    /**
     * @test
     */
    public function RemoveSQLLikeArgHydrateData_ArgWillBeRemoved(){
        //TODO: hydrate data
        $chaosArgs = [
            '_fields'=>'name.avatar.email.address',
            '_service_token'=>'data service token'
        ];
        
        $apiQL = new APIQL($chaosArgs);
        $apiQL->removeSQLLikeArg('_fields');
        
        $this->assertEquals([], $apiQL->getSQLLikeArgs());
    }
    
}