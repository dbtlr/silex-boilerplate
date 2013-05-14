<?php
namespace Base\Router;

use Base\Application;

class RootRouter implements RouterInterface
{
    public function load(Application $app)
    {
        $app->get('/hello/{name}', 'Base\Controller\RootController::helloAction'); 
    }
}