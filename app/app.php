<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Base\Application();
$app->start(__DIR__ . '/views');

// Add routers
$app->addRouter(new App\Router\RootRouter());

return $app;
