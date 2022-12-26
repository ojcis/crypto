<?php

namespace App\Services;

use App\Controllers\TransactionsController;
use App\Models\Collections\TransactionsCollection;
use App\Repositories\Users\UsersRepository;

class GetTransactionsService
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function execute($userId): TransactionsCollection
    {
        return $this->usersRepository->getTransactionHistory($userId);
    }
}
