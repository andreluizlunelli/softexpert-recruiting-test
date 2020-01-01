<?php

namespace RecruitingApp;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use League\Container\Container;
use League\Route\RouteCollection;
use League\Route\Strategy\JsonStrategy;
use RecruitingApp\Api\Controller\ProductController;
use RecruitingApp\Api\Controller\TypeProductController;
use RecruitingApp\Model\Product;
use RecruitingApp\Service\CreateProductService;
use RecruitingApp\Service\CreateTypeProductService;
use RecruitingApp\Service\DeleteProductService;
use RecruitingApp\Service\DeleteTypeProductService;
use Symfony\Component\Dotenv\Dotenv;
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
        $this->dependencyInjection();
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
        $route->group('/api', function ($route) {
            $route->get('/product[/{id}]', ProductController::class.'::get');
            $route->post('/product', ProductController::class.'::post');
            $route->delete('/product/{id}', ProductController::class.'::delete');
            $route->post('/type-product', TypeProductController::class.'::post');
            $route->delete('/type-product/{id}', TypeProductController::class.'::delete');
        })->setStrategy(new JsonStrategy());
    }

    private function dependencyInjection()
    {
        $entityManager = $this->getContainer('em');

        $this->container->add(CreateProductService::class, new CreateProductService($entityManager));
        $this->container->add(DeleteProductService::class, new DeleteProductService($entityManager));
        $this->container->add(ProductController::class, new ProductController(
            $this->getContainer(CreateProductService::class),
            $this->getContainer(DeleteProductService::class),
            $entityManager->getRepository(Product::class)
        ));
        $this->container->add(CreateTypeProductService::class, new CreateTypeProductService($entityManager));
        $this->container->add(DeleteTypeProductService::class, new DeleteTypeProductService($entityManager));
        $this->container->add(TypeProductController::class, new TypeProductController(
            $this->getContainer(CreateTypeProductService::class),
            $this->getContainer(DeleteTypeProductService::class)
        ));
    }

    /**
     * @return Container|mixed
     */
    public function getContainer($alias = null)
    {
        if (is_null($alias)) {
            return $this->container;
        }

        return $this->container->get($alias);
    }
}