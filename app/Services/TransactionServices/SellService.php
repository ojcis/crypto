<?php

namespace App\Services\TransactionServices;

use App\Models\Transaction;

class SellService extends TransactionService
{
    public function execute(int $coinId, int $amount): string
    {
        $coinSymbol=$this->usersRepository->getCoinSymbol($coinId);
        $price=$this->cryptocurrencyRepository->getCryptocurrency($coinSymbol)->getPrice();
        $price*=$amount;
        $this->usersRepository->addMoney($price);
        $this->usersRepository->updateUserCoin($coinId,$amount);
        $transaction=new Transaction($_SESSION['userId'],'sell',$price,$coinSymbol,$amount);
        $this->usersRepository->addTransaction($transaction);
        return $coinSymbol;
    }
}
