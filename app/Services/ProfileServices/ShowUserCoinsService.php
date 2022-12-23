<?php

namespace App\Services\ProfileServices;

use App\Models\Collections\UserCoinValueCollection;
use App\Models\UserCoinValue;

class ShowUserCoinsService extends ProfileService
{
    public function execute($userId): UserCoinValueCollection
    {
        $userCoins=$this->usersRepository->getUserCoins($userId)->getUserCoinCollection();
        $usersCoinValues=[];
        foreach ($userCoins as $userCoin){
            $symbol=$userCoin->getSymbol();
            $cryptoCurrency=$this->cryptocurrencyRepository->getCryptocurrency($symbol);
            $usersCoinValues[]=new UserCoinValue($userCoin,$cryptoCurrency);
        }
        return new UserCoinValueCollection($usersCoinValues);
    }
}
