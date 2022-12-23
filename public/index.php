<?php

require_once '../vendor/autoload.php';

use App\Repositories\Users\UsersRepository;
use App\Repositories\Users\MySqlUsersRepository;
use App\Repositories\Cryptocurrencies\CryptocurrencyRepository;
use App\Repositories\Cryptocurrencies\CoinMarketCapApiCryptocurrencyRepository;
use App\Controllers\CryptocurrencyController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\ProfileController;
use App\Controllers\LogoutController;
use App\Controllers\BuyController;
use App\Controllers\SellController;
use App\Controllers\OpenShortController;
use App\Controllers\CloseShortController;
use App\ViewVariables\ErrorViewVariables;
use App\ViewVariables\UserViewVariables;
use App\ViewVariables\ViewVariables;
use App\View;
use App\Redirect;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

session_start();

$dotenv = Dotenv::createImmutable(__DIR__,'../.env');
$dotenv->load();

$loader = new FilesystemLoader('../views');
$twig = new Environment($loader);

$container = new DI\Container();
$container->set(
    CryptocurrencyRepository::class, \DI\create(CoinMarketCapApiCryptocurrencyRepository::class)
);
$container->set(
    UsersRepository::class, \DI\create(MySqlUsersRepository::class)
);

$viewVariables = [
    ErrorViewVariables::class,
    UserViewVariables::class
];
/** @var ViewVariables $variable */
foreach ($viewVariables as $variable) {
    $variable = new $variable;
    $twig->addGlobal($variable->getName(), $variable->getValue());
}
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/', [CryptocurrencyController::class, 'showCryptocurrencies']);
    $route->addRoute('GET', '/coin/{symbol}', [CryptocurrencyController::class, 'showCryptocurrency']);
    $route->addRoute('GET', '/search', [CryptocurrencyController::class, 'searchCryptocurrency']);
    $route->addRoute('GET', '/login', [LoginController::class, 'showForm']);
    $route->addRoute('POST', '/login', [LoginController::class, 'login']);
    $route->addRoute('GET', '/register', [RegisterController::class, 'showForm']);
    $route->addRoute('POST', '/register', [RegisterController::class, 'register']);
    $route->addRoute('GET', '/logout', [LogoutController::class, 'logout']);
    $route->addRoute('GET', '/profile', [ProfileController::class, 'showForm']);
    $route->addRoute('POST', '/profile=changeName', [ProfileController::class, 'changeName']);
    $route->addRoute('POST', '/profile=changeEmail', [ProfileController::class, 'changeEmail']);
    $route->addRoute('POST', '/profile=changePassword', [ProfileController::class, 'changePassword']);
    $route->addRoute('POST', '/profile=deleteAccount', [ProfileController::class, 'deleteAccount']);
    $route->addRoute('POST', '/profile=addMoney', [ProfileController::class, 'addMoney']);
    $route->addRoute('POST', '/profile=withdrawMoney', [ProfileController::class, 'withdrawMoney']);
    $route->addRoute('GET', '/profile/{userId}', [ProfileController::class, 'showUserCoins']);
    $route->addRoute('POST', '/coin/{symbol}/buy', [BuyController::class, 'buy']);
    $route->addRoute('POST', '/coin/{coinId}/sell', [SellController::class, 'sell']);
    $route->addRoute('POST', '/coin/{symbol}/openShort', [OpenShortController::class, 'openShort']);
    $route->addRoute('POST', '/coin/{shortId}/closeShort', [CloseShortController::class, 'closeShort']);
});
// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;

        $response = $container->get($controller)->{$method}($vars);

        if ($response instanceof View) {
            echo $twig->render($response->getPath(), $response->getData());
            unset($_SESSION['error']);
            unset($_SESSION['user']);
        }

        if ($response instanceof Redirect) {
            header('Location: ' . $response->getUrl());
        }
        break;
}