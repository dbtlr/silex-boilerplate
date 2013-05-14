<?php
namespace Base\Controller;

use Base\Controller\Controller;
use Silex\ControllerResolver as SilexControllerResolver;
use Symfony\Component\HttpFoundation\Request;

class ControllerResolver extends SilexControllerResolver
{
    /**
     * Override to make sure the Application is added to the controller, if it is set.
     */
    protected function doGetArguments(Request $request, $controller, array $parameters)
    {
        if (is_array($controller) && isset($controller[0]) && $controller[0] instanceof Controller) {
            $controller[0]->setApplication($this->app);
        }

        return parent::doGetArguments($request, $controller, $parameters);
    }
}
