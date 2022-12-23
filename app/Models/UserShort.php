<?php

namespace App\Models;

class UserShort
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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
