<?php

namespace APIService\Users\Bussiness\Activity;

class DisableAccount {
    
    private $userRepository;
    public function __construct(UserRepository $user) {
        $this->userRepository = $user;
    }

    public function run($userID) {
        $user = $this->userRepository->getUserByID($userID);
        $signer->canDisableAccountOf($user);
        
        $this->userRepository->disableAccountOf($user);
    }

}
