<?php 
namespace App\Core;

/**
* 
*/
class Configuration
{
    const CONFIGURATION_DIR = __dir__.'/../Config/';
    private $configuration;

    function __construct()
    {
        $configs = glob(self::CONFIGURATION_DIR . "*.yaml");

        foreach($configs as $path)
        {
            // get file name
            $filename = str_replace(self::CONFIGURATION_DIR, '', $path);

            $configurationType = explode('.', $filename)[0];

            $this->configuration[$configurationType] = yaml_parse_file($path);
        }
    }

    public function get($value)
    {
        return $this->configuration[$value];
    }
}