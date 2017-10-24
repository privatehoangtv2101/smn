<?php

namespace APIService\Users\Activity;

class Login {
    
    private $userRepository;
    private $loginContraint;
    
    public function __construct(UserRepository $userRepository, LoginConstraint $loginContraint) {
        $this->userRepository = $userRepository;
        $this->loginContraint = $loginContraint;
    }

    public function run($email, $password) {
        $user = $this->userRepository->getUser([
            'email' => $email,
            'password' => $password
        ]);
        
        $this->loginContraint->checkUserCanLogin($user);
    }

}
