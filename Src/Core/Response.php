<?php 

namespace App\Core;

/**
* 
*/
class Response
{
    const TYPE_CSV  = 'text/csv';
    const TYPE_JSON = 'text/json';
    private $type;
    private $content;

    // by default we would render html
    function __construct($content, string $type) {

        $this->type    = $type;
        $this->content = $content;
    }

    public function render()
    {

        switch ($this->type) {

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