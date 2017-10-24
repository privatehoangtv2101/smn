<?php

namespace API\Users\DataAccess\ORM;

use API\Common\Repository\RepositoryEloquent;

class UserEloquent extends RepositoryEloquent{
    
     /**
     * The table associated with the data model.
     *
     * @var string
     */
    protected $table = 'user';
}