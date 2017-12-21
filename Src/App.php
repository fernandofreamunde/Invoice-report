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
        require_once 'Core/Psr4Autoloader.php';
        #use App\Connection\Database;
        //echo getcwd();die;
        $loader = new \App\Core\Psr4Autoloader;
        $loader->register();
        $loader->addNamespace('App', '../Src');

        $router = new Router($this->configuration['router']);

        $targetWithParams = $router->getTarget();

        $this->call($targetWithParams['target'], $targetWithParams['params']);

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

    private function call($target, $params)
    {
        echo '<pre>', print_r($target),'</pre>';
        echo '<pre>', print_r($params),'</pre>';
        # code...
    }
}


$app = new App;

$app->run();