<?php 

namespace App;

use App\Core\Router;
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

        #$con = new \App\Core\Database($this->configuration['database']);
        $this->call(
            $di->getController(), 
            $di->getAction(), 
            $di->getParameters());

        #$con->connect();
    }

    private function call($controller, $action, $params)
    {
        call_user_func_array([$controller, $action], $params);
    }
}
