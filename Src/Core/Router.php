<?php

namespace App\Core;

/**
* Router Class
*/
class Router
{
    private $routes;

    function __construct(Array $routes)
    {

        $this->routes = $routes;

        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->uri           = $_SERVER['REQUEST_URI'];

/*        $content = file_get_contents("php://input");
        var_dump($content);die;*/
    }

    public function getTarget()
    {
        if (isset($this->routes[$this->requestMethod][$this->uri])) {
            
            return $this->getParams();
        }

        foreach ($this->routes[$this->requestMethod] as $route => $classMethod) {

            $explodedUri = explode('/', ltrim($this->uri, '/'));
            $explodedRoute = explode('/', ltrim($route, '/'));

            $levelDiferences = [];
            for ($i=0; $i < count($explodedUri); $i++) { 

                if (!isset($explodedRoute[$i])) {
                    continue;
                }
                
                if ($explodedUri[$i] != $explodedRoute[$i]) {
                    # code...
                    if ($i === 0) {
                        continue;
                    }
                    echo "LEVEL $i IS DIFFERENT <br>";
                    $levelDiferences[] = $i;
                }
            }
            echo "<pre>",var_dump($levelDiferences),"</pre><br>";

            echo "<pre>",var_dump(ltrim($this->uri, '/')),"</pre>";
            echo "<pre>",var_dump($explodedUri),"</pre>";
            echo "<pre>",var_dump($route),"</pre>";
            echo "<pre>",var_dump($classMethod),"</pre>";

            echo '---------------------------------------';
        }

        $this->uri = '/';
        #return $this->getParams();
        echo 'get target fun';
        # code...
    }


    private function getParams()
    {
        $target = explode(':', $this->routes[$this->requestMethod][$this->uri]);

        $r = new \ReflectionMethod('App\Controller\\'.$target[0], $target[1]);
        $params = $r->getParameters();

        /*if (!empty($params)) {

            foreach ($params as $param) {
                //$param is an instance of ReflectionParameter
                echo $param->getName();
                echo $param->isOptional();
            }
        }*/

        return ['target' => $r, 'params' => $params];

        echo '<pre>', print_r($r),'</pre>';
        echo '<pre>', print_r($params),'</pre>';
    }
}
