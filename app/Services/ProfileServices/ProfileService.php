<?php

namespace App\Services\ProfileServices;

use App\Repositories\Cryptocurrencies\CryptocurrencyRepository;
use App\Repositories\Users\UsersRepository;

class ProfileService
{
    protected UsersRepository $usersRepository;
    protected CryptocurrencyRepository $cryptocurrencyRepository;

    public function __construct(
        UsersRepository $usersRepository,
        CryptocurrencyRepository $cryptocurrencyRepository
    )
    {
        $this->usersRepository = $usersRepository;
        $this->cryptocurrencyRepository = $cryptocurrencyRepository;
    }
}
