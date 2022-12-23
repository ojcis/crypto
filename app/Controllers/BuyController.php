<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\TransactionServices\BuyService;

class BuyController
{
    private BuyService $buyService;

    public function __construct(BuyService $buyService)
    {
        $this->buyService = $buyService;
    }

    public function buy(array $vars): Redirect
    {
        $amount=$_POST['amount'];
        $symbol=$vars['symbol'];
        $this->buyService->execute($symbol,$amount);
        return new Redirect("/coin/$symbol");
    }
}
