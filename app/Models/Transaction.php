<?php

namespace App\Models;

use Carbon\Carbon;

class Transaction
{
    private int $userId;
    private string $transaction;
    private float $moneyAmount;
    private string $date;
    private ?string $coinSymbol;
    private ?int $coinAmount;


    public function __construct(
        int $userId,
        string $transaction,
        float $moneyAmount,
        ?string $coinSymbol=null,
        ?int $coinAmount=null,
        ?string $date=null
    )
    {
        $this->userId = $userId;
        $this->transaction = $transaction;
        $this->moneyAmount = $moneyAmount;
        $this->coinSymbol = $coinSymbol;
        $this->coinAmount = $coinAmount;
        if ($date){
            $this->date=$date;
        }else {
            $this->date = Carbon::now();
        }
    }

    public function getCoinAmount(): ?int
    {
        return $this->coinAmount;
    }

    public function getCoinSymbol(): ?string
    {
        return $this->coinSymbol;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getMoneyAmount(): float
    {
        return $this->moneyAmount;
    }

    public function getTransaction(): string
    {
        return $this->transaction;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
