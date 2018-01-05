<?php 

namespace App;

use App\Core\Router;
use App\Core\Response;
use App\Core\Configuration;
use App\Core\Psr4Autoloader;
use App\Core\DependencyInjection;

/**
* App
*/
class App
{
    private $configuration;
    
    public function run()
    {
        // Sorry I didn't code this file my self
        // got it from http://www.php-fig.org/psr/psr-4/examples/
        require_once 'Core/Psr4Autoloader.php';
        $loader = new Psr4Autoloader;
        $loader->register();
        $loader->addNamespace('App', '../Src');

        $this->configuration = new Configuration;

        $route = new Router($this->configuration->get('router'));
        $di    = new DependencyInjection($route);

        $response = $this->call(
            $di->getController(), 
            $di->getAction(), 
            $di->getParameters());

        // This can be a View or a Response Object, not what I wanted initially
        // but since both have the render method and it works as is, will leave like this
        // Would be something to refactor on a later stage
        $response->render();
    }

    private function call($controller, $action, $params)
    {
        return call_user_func_array([$controller, $action], $params);
    }
}
