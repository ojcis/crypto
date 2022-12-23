<?php

namespace App\Services\TransactionServices;

class SellService extends TransactionService
{
    public function execute(int $coinId, int $amount): string
    {
        $coinSymbol=$this->usersRepository->getCoinSymbol($coinId);
        $price=$this->cryptocurrencyRepository->getCryptocurrency($coinSymbol)->getPrice();
        $price*=$amount;
        $this->usersRepository->addMoney($price);
        $this->usersRepository->updateUserCoin($coinId,$amount);
        return $coinSymbol;
    }
}
