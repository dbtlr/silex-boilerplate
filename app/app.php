<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Base\Application(array(
    'app.path'      => __DIR__,
    'app.view_path' => __DIR__ . '/views',
));

$app->start();
$app->run();
