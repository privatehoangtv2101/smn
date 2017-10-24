<?php

namespace API\Users\DataAccess;

use API\Users\DataAccess\ORM\UserEloquent;

class UserRepositoryImp implements UserRepository{
    
    /**
     * @var UserEloquent 
     */
    private $handler;
    
    public function __construct($handler) {
        $this->handler = $handler;
    }
    
    public function createAccount($name, $email, $password) {
        $this->handler->save([
            
        ]);
    }

}