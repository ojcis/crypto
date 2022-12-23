<?php

namespace App\Models;

class UserCoin
{
    private int $id;
    private string $symbol;
    private float $price;
    private int $amount;

    public function __construct(int $id, string $symbol, float $price, int $amount)
    {
        $this->id = $id;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->amount = $amount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}