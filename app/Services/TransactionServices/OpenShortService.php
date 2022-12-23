<?php

namespace App\Services\TransactionServices;

class OpenShortService extends TransactionService
{
    public function execute(string $symbol, int $amount): void
    {
        $cryptocurrency=$this->cryptocurrencyRepository->getCryptocurrency($symbol);
        $this->usersRepository->addMoney($cryptocurrency->getPrice()*$amount);
        $this->usersRepository->addShort($cryptocurrency, $amount);
    }
}
