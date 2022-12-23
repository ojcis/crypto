<?php

namespace App\Services;

use App\Models\Collections\UserShortCollection;
use App\Repositories\Users\UsersRepository;

class GetUserShortsService
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function execute(int $id, string $symbol): UserShortCollection
    {
        return $this->usersRepository->getUserShortsBySymbol($id, $symbol);
    }
}
