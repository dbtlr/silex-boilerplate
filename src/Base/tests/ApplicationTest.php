<?php
namespace Base;

use Base\Router\RouterInterface;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testWillConstructProperly()
    {
        $app = new Application();
        $this->assertInstanceOf('Base\Application', $app);
    }

    public function testWillLoadRoutesFromGivenRouter()
    {
        $app = new Application();
        $app->addRouter(new ApplicationTestRouter());

        // This let's us access the $app['routes']
        $app->flush();

        $this->assertInstanceOf('Silex\Route', $app['routes']->get('GET_test'));
    }

    public function testWillRegisterTwigProvider()
    {
        $app = new Application();
        $app->start(__DIR__);

        $this->assertTrue(isset($app['twig']));
        $this->assertTrue(isset($app['twig.loader']));
        $this->assertEquals(__DIR__, $app['twig.path']);
    }

    public function testWillRegisterErrorHandler()
    {
        $app = new Application();
        $dispatcher = $app['dispatcher'];
        $startCount = count($dispatcher->getListeners('kernel.exception'));
        $app->start(__DIR__);
        $endCount = count($dispatcher->getListeners('kernel.exception'));

        // We should have gained one more exception listener.
        $this->assertEquals($startCount + 1, $endCount);
    }
}

class ApplicationTestRouter implements RouterInterface
{
    public function load(Application $app)
    {
        $app->get('/test', function($name) use ($app) { 
            return 'test';
        }); 
    }
}