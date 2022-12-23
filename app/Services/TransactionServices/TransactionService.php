<?php

namespace App\Services\TransactionServices;

use App\Repositories\Cryptocurrencies\CryptocurrencyRepository;
use App\Repositories\Users\UsersRepository;

class TransactionService
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
