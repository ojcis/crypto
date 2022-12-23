<?php

namespace App\Services\ProfileServices;

class WithdrawMoneyService extends ProfileService
{
    public function execute($amount): void
    {
        $this->usersRepository->withdrawMoney($amount);
    }
}
