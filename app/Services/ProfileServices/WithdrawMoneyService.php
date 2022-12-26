<?php

namespace App\Services\ProfileServices;

use App\Models\Transaction;

class WithdrawMoneyService extends ProfileService
{
    public function execute($amount): void
    {

        $this->usersRepository->withdrawMoney($amount);
        $transaction=new Transaction($_SESSION['userId'],'withdraw money', ($amount*(-1)));
        $this->usersRepository->addTransaction($transaction);
    }
}
