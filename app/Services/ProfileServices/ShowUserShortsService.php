<?php

namespace App\Services\ProfileServices;

use App\Models\Collections\UserShortValueCollection;
use App\Models\UsersShortValue;

class ShowUserShortsService extends ProfileService
{
    public function execute($userId): UserShortValueCollection
    {
        $userShorts=$this->usersRepository->getUserShorts($userId)->getUserShortCollection();
        $userShortsValues=[];
        foreach ($userShorts as $userShort){
            $symbol=$userShort->getSymbol();
            $cryptoCurrency=$this->cryptocurrencyRepository->getCryptocurrency($symbol);
            $userShortsValues[]=new UsersShortValue($userShort, $cryptoCurrency);
        }
        return new UserShortValueCollection($userShortsValues);
    }
}
