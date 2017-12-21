<?php

namespace App\Controller;

/**
* 
*/
class PathController
{
    public function indexAction()
    {
        die('INDEX ACTION HERE');
    }

    public function resourceAction($to)
    {
        die('RESOURCE ACTION HERE WITH VAL:'.$to);
    }
}