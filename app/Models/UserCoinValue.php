<?php

namespace App\Models;

class UserCoinValue
{
    private int $id;
    private string $symbol;
    private float $price;
    private int $amount;
    private float $priceNow;
    private float $profit;
    private float $value;

    public function __construct(UserCoin $userCoins, Cryptocurrency $cryptocurrency)
    {
        $this->id=$userCoins->getId();
        $this->symbol=$userCoins->getSymbol();
        $this->price=$userCoins->getPrice();
        $this->amount=$userCoins->getAmount();
        $this->priceNow=$cryptocurrency->getPrice();
        $this->profit=$cryptocurrency->getPrice()-$userCoins->getPrice();
        $this->value=$userCoins->getAmount()*$cryptocurrency->getPrice();
    }

    public function getProfit(): float
    {
        return $this->profit;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPriceNow(): float
    {
        return $this->priceNow;
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
