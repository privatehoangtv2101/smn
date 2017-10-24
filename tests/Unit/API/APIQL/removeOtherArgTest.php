<?php


namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

class removeOtherArgTest extends TestCase {
    
    /**
     * @test
     */
    public function RemoveOtherArgHydrateData_ArgWillBeRemoved(){
        //TODO: hydrate data
        $chaosArgs = [
            '_paging'=>true,
            '_page'=>2
        ];
        
        $apiQL = new APIQL($chaosArgs);
        $apiQL->removeOtherArg('_paging');
        
        $this->assertEquals(['_page'=>2], $apiQL->getOtherArgs());
    }
}