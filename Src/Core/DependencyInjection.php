<?php 
namespace App\Core;

use App\Core\Router;

/**
* DI class Should resolve dependencies set in constructs of
* controllers and their respective dependencies. 
*/
class DependencyInjection
{
    private $route;
    private $controller;
    private $action;
    private $params;
    const CONTROLLER_FOLDER = 'App\AppPacket\Controller\\';

    function __construct(Router $route)
    {
        $this->route = $route;
        $this->init();
    }

    private function init()
    {
        // Get target controller and action from the route 
        $target = explode(':', $this->route->getTarget());
        $targetController = self::CONTROLLER_FOLDER.$target[0];

        $this->controller = $this->getObject($targetController);
        $this->action = $target[1];

        // Reflect upon the action we are going to execute
        $reflection = new \ReflectionMethod($targetController, $this->action);

        // Get its parameters
        $reflectionParams = $reflection->getParameters();

        // resolve the parameters
        $params = $this->resolve($reflectionParams);

        // set the route parameters that we already got from the route
        $this->params = $this->route->getParams();

        // Set the Params needed for the action that are not from the route
        foreach ($params as $param => $value) {
            $this->params[$param] = $value; 
        }
    }


    private function resolve($reflectionParameters)
    {
        $resolevedParams = [];
        foreach ($reflectionParameters as $parameter) {
            
            if (!$this->isRouteParameter($parameter->getName())) {
                $class = $parameter->getClass();

                $obj = $this->getObject($class->getName());

                $resolevedParams[$parameter->getName()] = $obj;
            }
        }
        return $resolevedParams;
    }

    private function isRouteParameter($name)
    {
        return isset($this->route->getParams()['{'.$name.'}']);
    }

    private function getObject($name)
    {
        if (class_exists($name)) {
            $reflection = new \ReflectionMethod($name, '__construct');

            $reflectionParams = $reflection->getParameters();

            $parammeters = $this->resolve($reflectionParams);

            $reflectionObject = new \ReflectionClass($name);
            return $reflectionObject->newInstanceArgs($parammeters);
             
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParameters()
    {
        return $this->params === null ? [] : $this->params;
    }
}