<?php

namespace API\Users\DataAccess;

interface UserRepository{
    
    function createAccount($name, $email, $password);
    
}