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
        $this['resolver'] = $this->share(
            function () use ($app) {
                return new ControllerResolver($app, $app['logger']);
            }
        );

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
        $this->error(
            function (\Exception $e, $code) use ($app) {
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
                        $message .= '<pre>' . $app->backtrace($e->getTrace()) . '</pre>';
                }

                return new Response($message);
            }
        );
    }

    /**
     * Flatten the given debug_backtrace() array for easy printing. If none
     * is given, one will be derived.
     *
     * @param array|null $backtrace
     * @return string
     */
    public function backtrace($backtrace = null)
    {
        if (!isset($backtrace)) {
            $backtrace = debug_backtrace();
            array_shift($backtrace);
        }

        $backtraceOut = '';
        $enableFor    = array('include', 'include_once', 'require', 'require_once');

        foreach ($backtrace as $event) {
            $arguments = '';

            // disable argument output for all but the listed functions.
            if (in_array($event['function'], $enableFor) && isset ($event['args'])) {
                $arguments = ArrayUtils::toArgString($event['args'], true);
            }

            if (isset($event['file']) && isset($event['line'])) {
                $backtraceOut .= 'File: ' . $event['file'] . ' Line: ' . $event['line'] . "\n";
            }

            $backtraceOut .= (isset($event['class']) ? $event['class'] . $event['type'] : '')
                          . $event['function'] . '(' . $arguments . ")\n\n";
        }

        return trim($backtraceOut);
    }
}
