<?php

namespace App\Services\ProfileServices;

class AddMoneyService extends ProfileService
{
    public function execute($amount): void
    {
        $this->usersRepository->addMoney($amount);
    }
}
