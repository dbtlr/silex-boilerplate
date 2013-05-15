<?php
namespace App\Router;

use Base\Application;
use Base\Router\RouterInterface;

class RootRouter implements RouterInterface
{
    public function load(Application $app)
    {
        $app->get('/', function () use ($app) { return $app->redirect('/hello/visitor'); });

        $app->get('/hello/{name}', 'App\Controller\RootController::helloAction'); 
    }
}