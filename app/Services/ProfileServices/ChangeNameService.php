<?php

namespace App\Services\ProfileServices;

use App\Repositories\Users\UsersRepository;

class ChangeNameService extends ProfileService
{
    public function execute(string $newName): void
    {
        $this->usersRepository->changeName($newName);
    }
}
