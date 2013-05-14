<?php
namespace Base\Controller;

use Base\Application;

class RootController extends Controller
{
    public function helloAction($name)
    {
        return $this->render('hello', array('name' => $name));
    }
}