<?php
namespace Base\Router;

use Base\Application;

class RootRouter implements RouterInterface
{
    public function load(Application $app)
    {
        $app->get('/hello/{name}', function($name) use ($app) { 
            return $app->render('hello.twig', array(
                'name' => $name,
            ));
        }); 
    }
}