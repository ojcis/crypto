<?php

namespace App\Services;

use App\Models\Collections\UserCoinCollection;
use App\Repositories\Users\UsersRepository;

class GetUserCryptocurrencyService
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function execute(int $id, string $symbol): UserCoinCollection
    {
        return $this->usersRepository->getUserCoinsBySymbol($id, $symbol);
    }
}