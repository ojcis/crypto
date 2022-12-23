<?php

namespace App\Services\TransactionServices;

class CloseShortService extends TransactionService
{
    public function execute(int $shortId, int $amount): string
    {
        $coinSymbol=$this->usersRepository->getShortSymbol($shortId);
        $price=$this->cryptocurrencyRepository->getCryptocurrency($coinSymbol)->getPrice();
        $price*=$amount;
        $this->usersRepository->withdrawMoney($price);
        $this->usersRepository->updateUserShort($shortId, $amount);
        return $coinSymbol;
    }
}
