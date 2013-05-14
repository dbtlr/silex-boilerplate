<?php

/*
 * This file is part of the Silex framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Base\Controller;

use Base\Controller\Controller;
use Silex\ControllerResolver as SilexControllerResolver;
use Symfony\Component\HttpFoundation\Request;

/**
 * Adds Application as a valid argument for controllers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ControllerResolver extends SilexControllerResolver
{
    protected function doGetArguments(Request $request, $controller, array $parameters)
    {
        if (isset($controller[0]) && $controller[0] instanceof Controller) {
            $controller[0]->setApplication($this->app);
        }

        return parent::doGetArguments($request, $controller, $parameters);
    }
}
