<?php

namespace App\Models\Collections;

class UserShortValueCollection
{
    private array $userShortValueCollection;

    public function __construct(array $userShortValueCollection)
    {
        $this->userShortValueCollection = $userShortValueCollection;
    }

    public function getUserShortValueCollection(): array
    {
        return $this->userShortValueCollection;
    }
}
