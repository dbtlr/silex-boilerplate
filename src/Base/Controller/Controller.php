<?php

namespace Base\Controller;

use Base\Application;

abstract class Controller
{
    protected $app;

    public function setApplication(Application $app)
    {
        $this->app = $app;
    }

    protected function render($tpl, $values, $request=null)
    {
        preg_match('/^(.*)Controller$/', get_class($this), $matches);

        $pieces  = explode('\\', $matches[1]);
        $pieces  = array_filter($pieces, function($piece) { return $piece != 'Controller'; });
        $tplPath = implode('/', $pieces);

        return $this->app->render($tplPath . '/' . $tpl . '.twig', $values, $request);
    }
}
