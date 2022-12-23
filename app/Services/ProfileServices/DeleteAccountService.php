<?php

namespace App\Services\ProfileServices;

class DeleteAccountService extends ProfileService
{
    public function execute(): void
    {
        $this->usersRepository->deleteAccount();
    }
}
