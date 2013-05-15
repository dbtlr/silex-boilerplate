<?php
namespace Base\Router;

use Base\Application;

interface RouterInterface
{
    public function load(Application $app);
}
