<?php

namespace App\Services\TransactionServices;

use App\Models\Transaction;

class BuyService extends TransactionService
{
    public function execute(string $symbol, int $amount): Void
    {
        $cryptocurrency=$this->cryptocurrencyRepository->getCryptocurrency($symbol);
        $this->usersRepository->buyCoins($cryptocurrency,$amount);
        $moneyAmount=$amount*$cryptocurrency->getPrice()*(-1);
        $transaction=new Transaction($_SESSION['userId'],'buy',$moneyAmount,$symbol,$amount);
        $this->usersRepository->addTransaction($transaction);
    }
}
