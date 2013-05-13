<?php

$app->get('/hello/{name}', function($name) use ($app) { 
    return $app->render('hello.twig', array(
        'name' => $name,
    ));
}); 