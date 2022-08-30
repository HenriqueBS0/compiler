<?php

use HenriqueBS0\Compiler\Controllers\AnalisadorLexicoController;
use HenriqueBS0\Router\Inner\Route;
use HenriqueBS0\Router\Router;

require_once __DIR__ . '/vendor/autoload.php';

$router = new Router();

$router->get('/', [AnalisadorLexicoController::class, 'interface']);
$router->post('/tokens', [AnalisadorLexicoController::class, 'getTokens']);

$router->resolve();