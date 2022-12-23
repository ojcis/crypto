<?php

namespace App\Services;

use App\Models\NewUser;
use App\Repositories\Users\UsersRepository;

class RegisterService
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function execute(NewUser $newUser): void
    {
        $this->usersRepository->addUser($newUser);
    }
}