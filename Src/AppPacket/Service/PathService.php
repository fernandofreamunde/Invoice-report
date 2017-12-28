<?php 

namespace App\AppPacket\Service;

use App\AppPacket\Repository\PathRepository;

/**
* 
*/
class PathService
{
    
    function __construct(PathRepository $pathRepo)
    {
    	echo '<pre>',print_r($pathRepo->getAll()),'</pre>';
        echo "I'm a service for humanity<br>";
    }
}