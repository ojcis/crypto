<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\GetUserCryptocurrencyService;
use App\Services\GetUserShortsService;
use App\View;
use App\Services\ShowCryptocurrenciesService;
use App\Services\ShowCryptocurrencyService;

class CryptocurrencyController
{
    private ShowCryptocurrenciesService $showCryptocurrenciesService;
    private ShowCryptocurrencyService $showCryptocurrencyService;
    private GetUserCryptocurrencyService $getUserCryptocurrencyService;
    private GetUserShortsService $getUserShortsService;

    public function __construct(
        ShowCryptocurrenciesService $showCryptocurrenciesService,
        ShowCryptocurrencyService $showCryptocurrencyService,
        GetUserCryptocurrencyService $getUserCryptocurrencyService,
        GetUserShortsService $getUserShortsService
    )
    {
        $this->showCryptocurrenciesService = $showCryptocurrenciesService;
        $this->showCryptocurrencyService = $showCryptocurrencyService;
        $this->getUserCryptocurrencyService = $getUserCryptocurrencyService;
        $this->getUserShortsService = $getUserShortsService;
    }

    public function showCryptocurrencies(): View
    {
        $limit=10;
        $currency='EUR';
        $cryptocurrencies=$this->showCryptocurrenciesService->execute($limit,$currency);
        return new View('cryptocurrencies.twig',[
            'cryptocurrencies' => $cryptocurrencies
        ]);
    }

    public function showCryptocurrency(array $vars): View
    {
        $cryptocurrency=$this->showCryptocurrencyService->execute($vars['symbol']);
        if ($_SESSION['userId']) {
            $userCoins = $this->getUserCryptocurrencyService->execute($_SESSION['userId'], $vars['symbol'])->getUserCoinCollection();
            $userShorts = $this->getUserShortsService->execute($_SESSION['userId'], $vars['symbol'])->getUserShortCollection();
            return new View('cryptocurrency.twig', [
                'cryptocurrency' => $cryptocurrency,
                'userCoins' => $userCoins,
                'userShorts' => $userShorts
            ]);
        }
        return new View('cryptocurrency.twig', [
            'cryptocurrency' => $cryptocurrency,
        ]);
    }

    public function searchCryptocurrency(): Redirect
    {
        $symbol=$_GET['search'];
        return new Redirect("coin/$symbol");
    }
}
