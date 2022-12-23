<?php

namespace App\Models\Collections;

class UserCoinCollection
{
    private array $userCoinCollection;

    public function __construct(array $userCoinCollection)
    {
        $this->userCoinCollection = $userCoinCollection;
    }

    public function getUserCoinCollection(): array
    {
        return $this->userCoinCollection;
    }
}
