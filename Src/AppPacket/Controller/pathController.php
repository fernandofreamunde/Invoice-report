<?php

namespace App\AppPacket\Controller;
use App\AppPacket\Service\PathService;
/**
* 
*/
class PathController
{
    public function __construct(PathService $service)
    {
        # code...
    }

    public function indexAction()
    {
        die('INDEX ACTION HERE');
    }

    public function resourceAction($to)
    {
        die('RESOURCE ACTION HERE WITH VAL:'.$to);
    }

    public function serviceNeededAction()
    {
        die('ServiceShould be an object by now');
    }
}