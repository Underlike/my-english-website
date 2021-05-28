<?php

namespace App\Service;

use App\Repository\UserRepository;

class ValidationApiToken
{
    /**
     * Construct function
     */
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Verify if user token exist and is valid
     */
    public function isValidate($token)
    {
        if ($token) {
            $user = $this->userRepository->findOneBy([
                'apiToken' => $token
            ]);

            if ($user) {
                return $user;
            }
        }
        return null;
    }
}