<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\TransactionServices\OpenShortService;

class OpenShortController
{
    private OpenShortService $openShortService;

    public function __construct(OpenShortService $openShortService)
    {
        $this->openShortService = $openShortService;
    }

    public function openShort(array $vars): Redirect
    {
        $coinSymbol=$vars['symbol'];
        $amount=$_POST['amount'];
        $this->openShortService->execute($coinSymbol, $amount);
        return new Redirect("/coin/$coinSymbol");
    }
}
