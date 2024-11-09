<?php

declare(strict_types=1);

namespace App;

use Dikki\DotEnv\DotEnv;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Router;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Tracy\Debugger;

class Bootstrap
{
    private ContainerBuilder $container;

    public function __construct()
    {
        $this->container = new ContainerBuilder();
        $this->initializeEnvironment();
        $this->initializeServices();
    }

    private function initializeEnvironment(): void
    {
        (new DotEnv(ROOT_PATH))->load();

        $environment = $_ENV['ENVIRONMENT'] == 'development' ? Debugger::Development : Debugger::Production;
        Debugger::enable($environment, LOGS_PATH);
    }

    private function initializeServices(): void
    {
        // Router
        $this->container->register('router', Router::class);

        // Load and register services from config
        $services = config('services.services');
        foreach ($services as $id => $service) {
            $definition = $this->container->register($id, $service['class']);

            if (isset($service['arguments'])) {
                foreach ($service['arguments'] as $argument) {
                    if (is_string($argument) && str_starts_with($argument, '@')) {
                        // Convert @service notation to Reference
                        $definition->addArgument(new Reference(substr($argument, 1)));
                    } else {
                        $definition->addArgument($argument);
                    }
                }
            }
        }

        $router = $this->getRouter(); // initialize router; to be used in route files being required below...

        // Load routes only from autoloaded modules
        $autoloadModules = config('modules.autoload') ?? [];
        foreach ($autoloadModules as $module) {
            $routeFile = MODULES_PATH . $module . '/Routes.php';
            if (file_exists($routeFile)) {
                require_once $routeFile; // relies on $router being initialized above
            }
        }
    }

    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );

        $router = $this->container->get('router');
        $response = $router->dispatch($request);

        (new SapiEmitter())->emit($response);
    }

    public function getRouter(): Router
    {
        $router = $this->container->get('router');
        $router->setStrategy(new \App\Libraries\RoutingStrategy);

        // Global middlewares
        $router->middlewares(config('app.middlewares'));

        return $router;
    }
}
