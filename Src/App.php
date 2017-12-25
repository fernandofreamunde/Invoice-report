<?php 

namespace App;

use App\Core\Router;
use App\Core\Psr4Autoloader;
use App\Core\DependencyInjection;

/**
* App
*/
class App
{
    const CONFIGURATION_DIR = __dir__.'/Config/';
    
    private $configuration = [];

    public function __construct()
    {
        $this->getConfiguration();
    }
    
    public function run()
    {
        // Sorry I didn't code this file my self
        // got it from http://www.php-fig.org/psr/psr-4/examples/
        require_once 'Core/Psr4Autoloader.php';
        $loader = new Psr4Autoloader;
        $loader->register();
        $loader->addNamespace('App', '../Src');

        $route = new Router($this->configuration['router']);
        $di    = new DependencyInjection($route);

        #echo '<pre>',print_r($route),'</pre>';

        $this->call(
            $di->getController(), 
            $di->getAction(), 
            $di->getParameters());

        #$con = new \App\Core\Database($this->configuration['database']);
        #$con->connect();
    }

    private function getConfiguration()
    {
        $configs = glob(self::CONFIGURATION_DIR . "*.yaml");

        foreach($configs as $path)
        {
            // get file name
            $filename = str_replace(self::CONFIGURATION_DIR, '', $path);

            // remove extension
            $configurationType = explode('.', $filename)[0];

            // save the content in property
            $this->configuration[$configurationType] = yaml_parse_file($path);
        }
    }

    private function call($controller, $action, $params)
    {
        call_user_func_array([$controller, $action], $params);
    }
}
