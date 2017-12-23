<?php 

namespace App;

use App\Core\Router;

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
        $loader = new \App\Core\Psr4Autoloader;
        $loader->register();
        $loader->addNamespace('App', '../Src');

        $router = new Router($this->configuration['router']);

        $this->call(
            $router->getController(), 
            $router->getAction(), 
            $router->getParams());

        $con = new \App\Core\Database($this->configuration['database']);
        #$con->connect();
    }

    private function getConfiguration()
    {
        $configs = glob(self::CONFIGURATION_DIR . "*.yaml");
        
        //print each file name
        foreach($configs as $path)
        {
            // get file name
            $filename = str_replace(self::CONFIGURATION_DIR, '', $path);

            //remove extension
            $configurationType = explode('.', $filename)[0];

            $parsedConfigs = yaml_parse_file($path);

            $this->configuration[$configurationType] = $parsedConfigs;
        }
    }

    private function call($controller, $action, $params)
    {
        $controller = new $controller;

        foreach ($params as $param => $value) {
            $params[$param] = class_exists($value) ? new $value: $value;
        }

        call_user_func_array([$controller, $action], $params);
    }
}


$app = new App;

$app->run();