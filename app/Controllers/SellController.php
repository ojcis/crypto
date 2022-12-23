<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\TransactionServices\SellService;

class SellController
{
    private SellService $sellService;

    public function __construct(SellService $sellService)
    {
        $this->sellService = $sellService;
    }

    public function sell(array $vars): Redirect
    {
        $coinId=$vars['coinId'];
        $amount=$_POST['amount'];
        $coinSymbol=$this->sellService->execute($coinId,$amount);
        return new Redirect("/coin/$coinSymbol");
    }
}
