<?php

namespace Tests\Unit\API\APIQL;

use Tests\TestCase;
use API\APIQL;

/**
 * to make sure APIQLTemplate correctly
 */
class APITemplateTest extends TestCase {

    use \API\APIQLTemplate;

    public function test() {
        $authArgs = $this->authArgTemplate;
        $authArgs['_token'] = 'data';
        $authArgs['_service_token'] = 'data';
        $authArgs['_auth_token'] = 'data';
        $authArgs['_caller'] = 'data';
        $authArgs['_outside'] = 'data';


        $sqlLikeArgs = $this->sqlLikeArgTemplate;
        $sqlLikeArgs['_offset'] = 'data';
        $sqlLikeArgs['_limit'] = 'data';
        $sqlLikeArgs['_sort'] = 'data';
        $sqlLikeArgs['_fields'] = 'data';
        $sqlLikeArgs['_order'] = 'data';


        $otherArgs = $this->otherArgTemplate;
        $otherArgs['_include'] = 'data';
        $otherArgs['_page'] = 'data';
        $otherArgs['_paging'] = 'data';
        $otherArgs['_method'] = 'data';
        $otherArgs['_hide_item_links'] = 'data';
        $otherArgs['_hide_root_links'] = 'data';


        $presentationArgs = $this->presentationArgTemplate;
        $presentationArgs['_return'] = 'data';

        $filterArgs = [
            'foo' => 'bar'
        ];

        $chaosArgs = array_merge($authArgs, $sqlLikeArgs, $otherArgs, $presentationArgs, $filterArgs);
        $apiQL = new APIQL($chaosArgs);
        
        $this->assertEquals($authArgs, $apiQL->getAuthArgs());
        $this->assertEquals($sqlLikeArgs, $apiQL->getSQLLikeArgs());
        $this->assertEquals($otherArgs, $apiQL->getOtherArgs());
        $this->assertEquals($presentationArgs, $apiQL->getPresentationArgs());
        $this->assertEquals($filterArgs, $apiQL->getFilterArgs());
    }

}
