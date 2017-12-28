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
    private $target;
    private $params;

    function __construct(Array $routes)
    {

        $this->routes = $routes;

        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->uri           = $_SERVER['REQUEST_URI'];
        $this->target        = $this->getTargetAndSetParams();

        /*        
        $content = file_get_contents("php://input");
        var_dump($content);die;
        */
    }

    private function getTargetAndSetParams()
    {
        if (isset($this->routes[$this->requestMethod][$this->uri])) {
            // if an exact match exists between existing routes and the URI, just set the target
            return $this->routes[$this->requestMethod][$this->uri];
        }

        // If we got here this means either that the route does not exist 
        // or it has paramters
        $explodedUri = explode('/', ltrim($this->uri, '/'));
        foreach ($this->routes[$this->requestMethod] as $route => $classMethod) {
            $explodedRoute = explode('/', ltrim($route, '/'));

            // if the current route has a different number of
            // elements than the target route just skip it
            if (count($explodedRoute) !== count($explodedUri)) {
                continue;
            }

            // search for params in the route
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

                // therefore set the route paramters and return the target
                $this->params = $paramsToPass;
                return $this->routes[$this->requestMethod][$route];
            }
        }

        // if a corresponding route is not found just return the index
        $this->uri = '/';
        return $this->routes[$this->requestMethod][$this->uri];
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getParams()
    {
        return $this->params;
    }
}
