<?php

namespace App\Application\User;

use App\Domain\Entity\User as UserDomain;
use App\Infrastructure\Persistence\Repository\UserRepository;

class CreateUserUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private UserDomain $userDomain
    ){
    }

    public function create(CreateUserInputData $inputData)
    {
        $this->userDomain->setProperties($inputData);
        $this->userRepository->create($this->userDomain);
    }
}
