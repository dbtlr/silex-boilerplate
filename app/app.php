<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Base\Application();
$app->addRouter(new Base\Router\RootRouter());
$app->start(__DIR__ . '/views');

return $app;

