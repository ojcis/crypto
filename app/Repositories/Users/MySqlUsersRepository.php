<?php

namespace App\Repositories\Users;

use App\DataBase;
use App\Models\Collections\TransactionsCollection;
use App\Models\Collections\UserCoinCollection;
use App\Models\Collections\UserShortCollection;
use App\Models\Cryptocurrency;
use App\Models\NewUser;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserCoin;
use App\Models\UserShort;

class MySqlUsersRepository implements UsersRepository
{
    public function getUserID(string $email): ?int
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        $userId=$queryBuilder
            ->select('id')
            ->from('users')
            ->where('email=?')
            ->setParameter(0,$email)
            ->fetchOne();
        return ($userId);
    }

    public function getUser(int $id): User
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        $user=$queryBuilder
            ->select('*')
            ->from('users')
            ->where('id=?')
            ->setParameter(0,$id)
            ->fetchAssociative();
        return new User($id, $user['name'], $user['email'], $user['password'], $user['money']);
    }

    public function addUser(NewUser $newUser): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->insert('users', [
            'name' => $newUser->getName(),
            'email' => $newUser->getEmail(),
            'password' => password_hash($newUser->getPassword(),PASSWORD_DEFAULT)
        ]);
    }

    public function changeName(string $newName): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->update(
            'users',
            ['name' => $newName],
            ['id' => $_SESSION['userId']]
        );
    }

    public function changeEmail(string $email): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->update(
            'users',
            ['email' => $email],
            ['id' => $_SESSION['userId']]
        );
    }

    public function changePassword(string $password): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->update(
            'users',
            ['password' => password_hash($password,PASSWORD_DEFAULT)],
            ['id' => $_SESSION['userId']]
        );
    }

    public function deleteAccount(): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->delete(
            'users',
            ['id' => $_SESSION['userId']]
        );
    }

    public function addMoney(float $amount): void
    {
        $dataBase=DataBase::getConnection();
        $queryBuilder=$dataBase->createQueryBuilder();
        $userMoney=$queryBuilder
            ->select('money')
            ->from('users')
            ->where('id=?')
            ->setParameter(0,$_SESSION['userId'])
            ->fetchOne();
        $userMoney+=$amount;
        $dataBase->update(
            'users',
            ['money' => $userMoney],
            ['id' => $_SESSION['userId']]
        );
    }

    public function withdrawMoney(float $amount): void
    {
        $dataBase=DataBase::getConnection();
        $queryBuilder=$dataBase->createQueryBuilder();
        $userMoney=$queryBuilder
            ->select('money')
            ->from('users')
            ->where('id=?')
            ->setParameter(0,$_SESSION['userId'])
            ->fetchOne();
        $userMoney-=$amount;
        $dataBase->update(
            'users',
            ['money' => $userMoney],
            ['id' => $_SESSION['userId']]
        );
    }

    public function getUserCoins(int $userId): UserCoinCollection
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        $userCoins=$queryBuilder
            ->select('*')
            ->from('cryptocurrencies')
            ->where('user_id=?')
            ->setParameter(0,$userId)
            ->fetchAllAssociative();
        $userCoinCollection=[];
        foreach ($userCoins as $userCoin){
            $userCoinCollection[]=new UserCoin(
                $userCoin['id'],
                $userCoin['symbol'],
                $userCoin['price'],
                $userCoin['amount']
            );
        }
        return new UserCoinCollection($userCoinCollection);
    }

    public function buyCoins(Cryptocurrency $cryptocurrency, int $amount): void
    {
        $price=$cryptocurrency->getPrice()*$amount;
        $this->withdrawMoney($price);
        $dataBase=DataBase::getConnection();
        $dataBase->insert('cryptocurrencies',[
            'symbol' => $cryptocurrency->getSymbol(),
            'price' => $cryptocurrency->getPrice(),
            'amount' => $amount,
            'user_id' => $_SESSION['userId']
        ]);
    }

    public function getUserCoinsBySymbol(int $userId, string $symbol): UserCoinCollection
    {
        $userCoinCollection=$this->getUserCoins($userId)->getUserCoinCollection();
        $userCoins=[];
        foreach ($userCoinCollection as $userCoin){
            if ($userCoin->getSymbol()==$symbol){
                $userCoins[]=$userCoin;
            }
        }
        return new UserCoinCollection($userCoins);
    }

    public function getCoinSymbol(int $coinId): string
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        return $queryBuilder
            ->select('symbol')
            ->from('cryptocurrencies')
            ->where('id=?')
            ->setParameter(0,$coinId)
            ->fetchOne();
    }

    public function updateUserCoin(int $coinId, int $amount): void
    {
        $dataBase=DataBase::getConnection();
        $queryBuilder=$dataBase->createQueryBuilder();
        $coinAmount=$queryBuilder
            ->select('amount')
            ->from('cryptocurrencies')
            ->where('id=?')
            ->setParameter(0,$coinId)
            ->fetchOne();
        if ($coinAmount>$amount){
            $newAmount=$coinAmount-$amount;
            $dataBase->update(
                'cryptocurrencies',
                ['amount' => $newAmount],
                ['id' => $coinId]
            );
        }else{
            $dataBase->delete(
                'cryptocurrencies',
                ['id' => $coinId]
            );
        }
    }

    public function addShort(Cryptocurrency $cryptocurrency, int $amount): void
    {
        $symbol=$cryptocurrency->getSymbol();
        $price=$cryptocurrency->getPrice();
        $dataBase=DataBase::getConnection();
        $dataBase->insert('shorts',[
            'symbol' => $symbol,
            'price' => $price,
            'amount' => $amount,
            'user_id' => $_SESSION['userId']
        ]);
    }

    public function getUserShorts(int $userId): UserShortCollection
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        $userShorts=$queryBuilder
            ->select('*')
            ->from('shorts')
            ->where('user_id=?')
            ->setParameter(0,$userId)
            ->fetchAllAssociative();
        $userShortCollection=[];
        foreach ($userShorts as $userShort){
            $userShortCollection[]=new UserShort(
                $userShort['id'],
                $userShort['symbol'],
                $userShort['price'],
                $userShort['amount']
            );
        }
        return new UserShortCollection($userShortCollection);
    }

    public function getUserShortsBySymbol(int $userId, string $symbol): UserShortCollection
    {
        $userShortCollection=$this->getUserShorts($userId)->getUserShortCollection();
        $userShorts=[];
        foreach ($userShortCollection as $userShort){
            if ($userShort->getSymbol()==$symbol){
                $userShorts[]=$userShort;
            }
        }
        return new UserShortCollection($userShorts);
    }

    public function getShortSymbol(int $shortId): string
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        return $queryBuilder
            ->select('symbol')
            ->from('shorts')
            ->where('id=?')
            ->setParameter(0,$shortId)
            ->fetchOne();
    }

    public function updateUserShort(int $shortId, int $amount): void
    {
        $dataBase=DataBase::getConnection();
        $queryBuilder=$dataBase->createQueryBuilder();
        $shortAmount=$queryBuilder
            ->select('amount')
            ->from('shorts')
            ->where('id=?')
            ->setParameter(0,$shortId)
            ->fetchOne();
        if ($shortAmount>$amount){
            $newAmount=$shortAmount-$amount;
            $dataBase->update(
                'shorts',
                ['amount' => $newAmount],
                ['id' => $shortId]
            );
        }else{
            $dataBase->delete(
                'shorts',
                ['id' => $shortId]
            );
        }
    }

    public function getTransactionHistory(int $userId): TransactionsCollection
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        $transactions=$queryBuilder
            ->select('*')
            ->from('transactions')
            ->where('user_id=?')
            ->orderBy('date','DESC')
            ->setParameter(0,$userId)
            ->fetchAllAssociative();
        $transactionsCollection=[];
        foreach ($transactions as $transaction){
            $transactionsCollection[]=new Transaction(
                $userId,
                $transaction['transaction'],
                $transaction['money_amount'],
                $transaction['coin_symbol'],
                $transaction['coin_amount'],
                $transaction['date']
            );
        }
        return new TransactionsCollection($transactionsCollection);
    }

    public function addTransaction(Transaction $transaction): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->insert('transactions',[
            'user_id' => $transaction->getUserId(),
            'transaction' => $transaction->getTransaction(),
            'coin_symbol' => $transaction->getCoinSymbol(),
            'coin_amount' => $transaction->getCoinAmount(),
            'money_amount' => $transaction->getMoneyAmount(),
            'date' => $transaction->getDate()
        ]);
    }
}
