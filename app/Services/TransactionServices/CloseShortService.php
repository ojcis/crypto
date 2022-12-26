<?php

namespace App\Services\TransactionServices;

use App\Models\Transaction;

class CloseShortService extends TransactionService
{
    public function execute(int $shortId, int $amount): string
    {
        $coinSymbol=$this->usersRepository->getShortSymbol($shortId);
        $price=$this->cryptocurrencyRepository->getCryptocurrency($coinSymbol)->getPrice();
        $price*=$amount;
        $this->usersRepository->withdrawMoney($price);
        $this->usersRepository->updateUserShort($shortId, $amount);
        $transaction=new Transaction($_SESSION['userId'],'close short',($price*(-1)),$coinSymbol,$amount);
        $this->usersRepository->addTransaction($transaction);
        return $coinSymbol;
    }
}
