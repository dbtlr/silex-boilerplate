<?php
namespace App\Controller;

use Base\Application;
use Base\Controller\Controller;

class RootController extends Controller
{
    public function helloAction($name)
    {
        return $this->render('hello', array('name' => $name));
    }
}