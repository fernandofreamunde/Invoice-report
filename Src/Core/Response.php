<?php 

namespace App\Core;

/**
* 
*/
class Response
{
    const TYPE_CSV  = 'text/csv';
    const TYPE_HTML = 'text/html';
    const TYPE_JSON = 'text/json';
    private $type;
    private $content;

    // by default we would render html
    function __construct($content, string $type = self::TYPE_HTML) {

        $this->type    = $type;
        $this->content = $content;
    }

    public function render()
    {

        switch ($this->type) {

            case self::TYPE_HTML:
                $this->renderHtml();
                break;

            case self::TYPE_CSV:
                $this->renderDownloadCsv();
                break;

            case self::TYPE_JSON:
                $this->renderJson();
                break;
            
            default:
                # code...
                break;
        }
    }

    private function renderHtml() // TODO : add content as param and typehint as VIEW
    {
        $menu = $this->content;
        $content = $this->content;
        ob_start();
        include __dir__.'/../AppPacket/Views/layout.php';
        $renderedView = ob_get_clean();

        echo $renderedView;
    }

    private function renderDownloadCsv()
    {
        header('Content-Type: '.$this->type);
        header('Content-Disposition: attachment; filename="report.csv"');

        $file = fopen('php://output', 'w');
        foreach ($this->content as $fields) {
            fputcsv($file, $fields);
        }

        fclose($file);
    }

    private function renderJson()
    {
        header('Content-Type: '.$this->type);

        echo json_encode($this->content);
    }
}