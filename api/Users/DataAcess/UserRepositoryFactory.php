<?php

namespace API\Users\DataAccess;

use API\Users\DataAccess\UserRepositoryImp;
use API\Users\DataAccess\ORM\UserEloquent;

class RepositoryFactory {
    
    public function getRepository(): UserRepository{
        return new UserRepositoryImp(new UserEloquent());
    }
}