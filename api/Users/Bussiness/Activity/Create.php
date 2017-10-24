<?php

namespace APIService\Users\Activity;

class Create {
    
    private $userRepository;
    
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function run($name, $email, $password) {
        $user = $this->userRepository->save([
            'email' => $email,
            'password' => $password
        ]);
    }

}
