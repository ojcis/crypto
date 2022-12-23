<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\TransactionServices\CloseShortService;

class CloseShortController
{
    private CloseShortService $closeShortService;

    public function __construct(CloseShortService $closeShortService)
    {
        $this->closeShortService = $closeShortService;
    }

    public function closeShort(array $vars): Redirect
    {
        $shortId=$vars['shortId'];
        $amount=$_POST['amount'];
        $coinSymbol=$this->closeShortService->execute($shortId, $amount);
        return new Redirect("/coin/$coinSymbol");
    }
}
