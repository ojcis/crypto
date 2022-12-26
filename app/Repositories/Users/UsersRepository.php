<?php

namespace App\Repositories\Users;

use App\Models\Collections\TransactionsCollection;
use App\Models\Collections\UserCoinCollection;
use App\Models\Collections\UserShortCollection;
use App\Models\Cryptocurrency;
use App\Models\NewUser;
use App\Models\Transaction;
use App\Models\User;

interface UsersRepository
{
    public function getUserID(string $email): ?int;
    public function getUser(int $id): User;
    public function addUser(NewUser $newUser): void;
    public function changeName(string $newName): void;
    public function changeEmail(string $email): void;
    public function changePassword(string $password): void;
    public function deleteAccount(): void;
    public function addMoney(float $amount): void;
    public function withdrawMoney(float $amount): void;
    public function getUserCoins(int $userId): UserCoinCollection;
    public function getUserCoinsBySymbol(int $userId, string $symbol): UserCoinCollection;
    public function buyCoins(Cryptocurrency $cryptocurrency, int $amount): void;
    public function getCoinSymbol(int $coinId):string;
    public function updateUserCoin(int $coinId, int $amount): void;
    public function addShort(Cryptocurrency $cryptocurrency, int $amount): void;
    public function getUserShorts(int $userId): UserShortCollection;
    public function getUserShortsBySymbol(int $userId, string $symbol): UserShortCollection;
    public function getShortSymbol(int $shortId):string;
    public function updateUserShort(int $shortId, int $amount): void;
    public function getTransactionHistory(int $userId): TransactionsCollection;
    public function addTransaction(Transaction $transaction): void;
}
