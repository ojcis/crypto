<?php

namespace App\Services\ProfileServices;

class ChangePasswordService extends ProfileService
{
    public function execute($password): void
    {
        $this->usersRepository->changePassword($password);
    }
}