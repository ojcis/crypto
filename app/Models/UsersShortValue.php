<?php

namespace App\Models;

class UsersShortValue
{
    private int $id;
    private string $symbol;
    private float $price;
    private int $amount;
    private float $priceNow;
    private float $profit;
    private float $value;

    public function __construct(UserShort $userShort, Cryptocurrency $cryptocurrency)
    {
        $this->id=$userShort->getId();
        $this->symbol=$userShort->getSymbol();
        $this->price=$userShort->getPrice();
        $this->amount=$userShort->getAmount();
        $this->priceNow=$cryptocurrency->getPrice();
        $this->profit=$cryptocurrency->getPrice()-$userShort->getPrice();
        $this->value=$cryptocurrency->getPrice()*$userShort->getAmount();
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

    public function getPriceNow(): float
    {
        return $this->priceNow;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getProfit(): float
    {
        return $this->profit;
    }
}
