<?php

namespace App\Core;

/**
* Router Class
*/
class Router
{
    private $routes;
    private $requestMethod;
    private $uri;
    private $controller;
    private $action;
    private $params;

    const CONTROLLER_FOLDER = 'App\AppPacket\Controller\\';

    function __construct(Array $routes)
    {

        $this->routes = $routes;

        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->uri           = $_SERVER['REQUEST_URI'];
        $this->params        = [];

        $this->initialize();

        /*        
        $content = file_get_contents("php://input");
        var_dump($content);die;
        */
    }

    public function initialize()
    {
        if (isset($this->routes[$this->requestMethod][$this->uri])) {
            // if an exact match exists between existing routes and the URI, just get the controller and Method 
            return $this->getTargetControllerWithParams($this->routes[$this->requestMethod][$this->uri]);
        }

        $explodedUri = explode('/', ltrim($this->uri, '/'));
        foreach ($this->routes[$this->requestMethod] as $route => $classMethod) {
            $explodedRoute = explode('/', ltrim($route, '/'));

            // if the current route has a different number of
            // elements than the target route just skip it
            if (count($explodedRoute) !== count($explodedUri)) {
                continue;
            }

            preg_match_all('/{.*}/U', $route, $params);

            $paramPositionMaping = [];

            if (count($params[0]) != 0) {

                foreach ($params[0] as $param) {

                    foreach ($explodedRoute as $key => $value) {

                        if ($value == $param) {
                            $paramPositionMaping[$key] = $param; 
                        }
                    }
                }
            }

            // Replace the mapped params with the values of the current uri
            $virtualRoute = $explodedRoute;
            $paramsToPass = [];
            foreach ($paramPositionMaping as $key => $value) {
                $virtualRoute[$key] = $explodedUri[$key];
                $paramsToPass[$value] = $explodedUri[$key];
            }

            // create a virtual route
            $virtualRoute = '/'.implode('/',$virtualRoute);

            // if the virtual route matches the URI we have a winner!
            if ($this->uri == $virtualRoute) {
                return $this->getTargetControllerWithParams(
                        $this->routes[$this->requestMethod][$route], 
                        $paramsToPass
                    );
            }
        }

        $this->uri = '/';
        return $this->getTargetControllerWithParams($this->routes[$this->requestMethod][$this->uri]);
        echo 'get target fun';
    }


    private function getTargetControllerWithParams(string $target, $routeParams = null)
    {
        $target = explode(':', $target);
        $this->controller = self::CONTROLLER_FOLDER.$target[0];
        $this->action = $target[1];

        $reflection = new \ReflectionMethod($this->controller, $this->action);

        $reflectionParams = $reflection->getParameters();

        $params = [];
        if (!empty($reflectionParams)) {
            foreach ($reflectionParams as $reflectionParam) {

                $class = $reflectionParam->getClass();

                if (!empty($class)) {
                    $params[$reflectionParam->getName()] = $class->getName();
                }
                else {
                    $params[$reflectionParam->getName()] = $routeParams['{'.$reflectionParam->getName().'}'];
                }
                #echo $reflectionParam->getName();
                #echo $reflectionParam->isOptional();
            }
        }

        $this->params = $params;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParams()
    {
        return $this->params;
    }
}
