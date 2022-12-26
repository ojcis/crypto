<?php

namespace App\Services\TransactionServices;

use App\Models\Transaction;

class OpenShortService extends TransactionService
{
    public function execute(string $symbol, int $amount): void
    {
        $cryptocurrency=$this->cryptocurrencyRepository->getCryptocurrency($symbol);
        $this->usersRepository->addMoney($cryptocurrency->getPrice()*$amount);
        $this->usersRepository->addShort($cryptocurrency, $amount);
        $moneyAmount=$cryptocurrency->getPrice()*$amount;
        $transaction=new Transaction($_SESSION['userId'],'open short',$moneyAmount,$symbol,$amount);
        $this->usersRepository->addTransaction($transaction);
    }
}
