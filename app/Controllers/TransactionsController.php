<?php

namespace App\Controllers;

use App\Services\GetTransactionsService;
use App\View;

class TransactionsController
{
    private GetTransactionsService $getTransactionsService;

    public function __construct(GetTransactionsService $getTransactionsService)
    {
        $this->getTransactionsService = $getTransactionsService;
    }

    public function showForm(): View
    {
        $transactions=$this->getTransactionsService->execute($_SESSION['userId'])->getTransactionsCollection();
        return new View("transactions.twig",[
            'transactions' => $transactions
        ]);
    }
}
