<?php

namespace App\AppPacket\Controller;
use App\AppPacket\Service\PathService;
/**
* 
*/
class PathController
{
    public function indexAction()
    {
        die('INDEX ACTION HERE');
    }

    public function resourceAction($to, PathService $service)
    {
        die('RESOURCE ACTION HERE WITH VAL:'.$to);
    }

    public function serviceNeededAction(PathService $service)
    {
        die('ServiceShould be an object by now');
    }
}