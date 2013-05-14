<?php

namespace Base;

use Base\Router\RouterInterface;
use Base\Controller\ControllerResolver;

use Silex\Application as SilexApplication;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\TwigServiceProvider;

class Application extends SilexApplication
{
    use SilexApplication\TwigTrait;

    public function start($viewPath)
    {
        $app = $this;
        $this['resolver'] = $this->share(function () use ($app) {
            return new ControllerResolver($app, $app['logger']);
        });

        $this->register(new TwigServiceProvider(), array( 'twig.path' => $viewPath ));
        $this->createErrorHandler();
    }

    public function addRouter(RouterInterface $router)
    {
        $router->load($this);
    }

    protected function createErrorHandler()
    {
        $app = $this;
        $this->error(function (\Exception $e, $code) use ($app) {
            if ($app['debug']) {
                return;
            }

            switch ($code) {
                case 404:
                    $message = 'The requested page could not be found.';
                    break;
                default:
                    $message = 'We are sorry, but something went terribly wrong.';
                    $message .= '<p>' . $e->getMessage() . '</p>';
                    $message .= '<pre>' . backtrace($e->getTrace()) . '</pre>';
            }

            return new Response($message);
        });
    }
}
