<?php

namespace App;

use App\Repositories\Users\UsersRepository;

class Validation
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function getId($email): int
    {
        return $this->usersRepository->getUserID($email);
    }

    public function validatePassword($id, $password): bool
    {
        $user=$this->usersRepository->getUser($id);
        return password_verify($password, $user->getPassword());
    }
}
