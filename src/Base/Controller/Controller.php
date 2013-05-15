<?php

namespace Base\Controller;

use Base\Application;

abstract class Controller
{
    protected $app;

    /**
     * Set the application class to the controller.
     *
     * @param Base\Application $app
     */
    public function setApplication(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Base render method.
     *
     * @param string $tpl
     * @param array $values
     * @param Symfony\Component\HttpFoundation\Request|null $request
     * @return Symfony\Component\HttpFoundation\Response
     */
    protected function render($tpl, $values = array(), $request = null)
    {
        preg_match('/^(.*)Controller$/', get_class($this), $matches);

        $pieces  = explode('\\', $matches[1]);
        $pieces  = array_filter(
            $pieces,
            function ($piece) {
                return $piece != 'Controller';
            }
        );

        $tplPath = implode('/', $pieces);

        return $this->app->render($tplPath . '/' . $tpl . '.twig', $values, $request);
    }
}
