<?php 
namespace App\Core;

/**
* 
*/
class View
{
    const VIEWS_FOLDER = __dir__.'/../AppPacket/Views/';
    private $views;
    private $view;
    private $data;

    function __construct($view, $data = [])
    {
        $this->view = $view;
        $this->views = glob(self::VIEWS_FOLDER. "*.html");


        $this->data = $data;

       # $this->parse($view);
    }


    public function render()
    {
        $this->viewContent = file_get_contents(self::VIEWS_FOLDER.$this->view. '.php');

        $layout    = $this->getParentLayout();
        $placement = $this->getPlacement();


        if ($layout && $placement) {
            $this->data[$placement] = $this->renderFile($this->view);
        }
        #echo "<pre>";var_dump($$placement);
        echo $this->renderFile($layout);

    }

    private function getPlacement()
    {
        preg_match_all('/<!--\s@placing\((.*)\)\s-->/Us', $this->viewContent, $placing);

        // Very Flexible and future proof... not
        return isset($placing[1][0]) ? $placing[1][0] : false;
    }

    private function getParentLayout()
    {
        preg_match_all('/<!--\s@extends\((.*)\)\s-->/U', $this->viewContent, $viewsToLoad);

        // Yet again, flexibility and future proof...
        // maybe some day I'll fix this
        return isset($viewsToLoad[1][0]) ? $viewsToLoad[1][0] : false;
    }

    public function renderFile($view)
    {
        ob_start();
        extract($this->data);
        include self::VIEWS_FOLDER.$view. '.php';
        $renderedView = ob_get_clean();

        return $renderedView;
    }
}