<?php

namespace App\Infrastructure;

use App\Domain\IPageRepository;
use App\Domain\Page;

class ReportGeneratorService
{
    public IPageRepository $pageRepository;

    public function __construct(IPageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function generate() : void
    {
        $file = fopen($this->generateName(), "w");
        fwrite($file, $this->generateHtml());
        fclose($file);
    }

    private function generateName() : string
    {
        return BASE_DIR . 'reports/report_' . date("d_m_Y") . '.html';
    }

    private function generateHtml() : string
    {
        $html = "<html>";
        $html .= $this->generateHtmlHead();
        $html .= $this->generateHtmlBody();
        $html .= "</html>";

        return $html;
    }

    private function generateHtmlHead() : string
    {
        $head = "<head>";
        $head .= "<style>";
        $head .= "table, td, th {
            border: 1px solid black;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
              padding: 15px;
              text-align: left;
        }
        td {
            height: 50px;
            vertical-align: bottom;
        }";
        $head .= "</style>";
        $head .= "</head>";

        return $head;
    }

    private function generateHtmlBody() : string
    {
        $body = "<body>";
        $body .= "<table class=\"report\">";
        $body .= <<<HTML
                <tr>
                  <th>Page</th>
                  <th>Image count</th>
                  <th>Loading time</th>
                </tr>
            HTML;
        $body .= $this->addReportData();
        $body .= "</table>";
        $body .= "</body>";

        return $body;
    }

    private function addReportData()
    {
        $body = '';
        /**
         * @var Page[] $pages
         */
        $pages = $this->pageRepository->getAll();
        foreach ($pages as $page) {
            $body .= <<<HTML
                <tr>
                  <td>{$page->getUrl()}</td>
                  <td>{$page->getImageCount()}</td>
                  <td>{$page->getLoadingTime()}</td>
                </tr>
            HTML;
        }

        return $body;
    }
}