<?php


namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class removePresentationArgTest extends TestCase {
    /**
     * @test
     */
    public function RemovePresentationArgHydrateData_ArgWillBeRemoved(){
        //TODO: hydrate data
        $chaosArgs = [
            '_return'=>'count'
        ];
        
        $apiQL = new APIQL($chaosArgs);
        $apiQL->removePresentationArg('_return');
        
        $this->assertEquals([], $apiQL->getPresentationArgs());
    }
}