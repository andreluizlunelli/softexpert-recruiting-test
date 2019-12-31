<?php

namespace RecruitingApp;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RecruitingApp\Api\Controller\ProductController;
use Symfony\Component\Dotenv\Dotenv;
use League\Container\Container;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

class Bootstrap
{
    /**
     * @var Container $container
     */
    private $container;

    /**
     * @var Dotenv $env
     */
    private $env;

    /**
     * Bootstrap constructor.
     * @param Container $container
     * @param Dotenv|null $env
     */
    public function __construct(Container $container = null, Dotenv $env = null)
    {
        if (is_null($container)) {
            $container = new Container();
        }

        if (is_null($env)) {
            $env = new Dotenv();
            $env->load(__DIR__.'/../config/.env');
        }

        $this->container = $container;
        $this->env = $env;

        $this->configEntityManager();
    }

    public function run()
    {
        $this->container->share('response', Response::class);
        $this->container->share('request', function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });

        $this->container->share('emitter', Response\SapiEmitter::class);

        $route = new RouteCollection($this->container);

        $this->routes($route);

        $response = $route->dispatch($this->container->get('request'), $this->container->get('response'));

        $this->container->get('emitter')->emit($response);
    }

    private function configEntityManager()
    {
        $paths = [__DIR__ . '/Model'];

        $isDevMode = true;

        $dbParams = [
            'driver' => getenv('driver'),
            'user' => getenv('user'),
            'password' => getenv('password'),
            'dbname' => getenv('dbname'),
            'port' => getenv('port'),
            'host' => getenv('host')
        ];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

        $driver = new AnnotationDriver(new AnnotationReader(), $paths);

        $config->setMetadataDriverImpl($driver);

        $entityManager = EntityManager::create($dbParams, $config);

        $this->container->share('em', $entityManager);
    }

    private function routes(RouteCollection $route)
    {
        $route->map('GET', '/', function (ServerRequestInterface $request, ResponseInterface $response) {
            $response->getBody()->write('<h1>Hello, World!</h1>');

            return $response;
        });

        $route->post('/api/product', ProductController::class.'::post');
    }

    /**
     * @return Container
     */
    public function getContainer($alias = null)
    {
        if (is_null($alias)) {
            return $this->container;
        }

        return $this->container->get($alias);
    }

}