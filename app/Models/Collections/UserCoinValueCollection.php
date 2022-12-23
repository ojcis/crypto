<?php

namespace App\Models\Collections;

class UserCoinValueCollection
{
    private array $userCoinValueCollection;

    public function __construct(array $userCoinValueCollection)
    {
        $this->userCoinValueCollection = $userCoinValueCollection;
    }

    public function getUserCoinValueCollection(): array
    {
        return $this->userCoinValueCollection;
    }
}