<?php

namespace App\Services\ProfileServices;

use App\Models\Transaction;

class AddMoneyService extends ProfileService
{
    public function execute($amount): void
    {
        $transaction=new Transaction($_SESSION['userId'],'add money',$amount);
        $this->usersRepository->addMoney($amount);
        $this->usersRepository->addTransaction($transaction);
    }
}
