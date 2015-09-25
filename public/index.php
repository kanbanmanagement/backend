<?php

require_once '../vendor/autoload.php';

use Slimvc\FrontController;
use SlimApi\JSONApi\View as JSONApiView;
use SlimApi\JSONApi\Middleware as JSONApiMiddleware;
use SlimApi\JSONRequest\Middleware as JSONRequestMiddleware;

$app = new \Slim\Slim();
$app->config('debug', false);
$app->view((new JSONApiView($app))->setEncodingJSON(JSON_PRETTY_PRINT));
$app->add(new JSONApiMiddleware($app));
$app->add(new JSONRequestMiddleware());

$fc = (new FrontController($app, require_once('../config/bootstrap.php')))->init();
