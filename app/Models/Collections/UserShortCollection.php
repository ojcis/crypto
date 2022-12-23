<?php

namespace App\Models\Collections;

class UserShortCollection
{
    private array $userShortCollection;

    public function __construct(array $userShortCollection)
    {
        $this->userShortCollection = $userShortCollection;
    }

    public function getUserShortCollection(): array
    {
        return $this->userShortCollection;
    }
}
