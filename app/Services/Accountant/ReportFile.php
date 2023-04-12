<?php

namespace App\Services\Accountant;

use App\Models\File;
use Mpdf\MpdfException;

class ReportFile extends DocFile implements FileInterface
{
    /**
     * @throws MpdfException
     */
    function createPdf(ReportHtmlForPdf|HtmlForPdfInterface $html) {
        $this->fileName = 'report_'.$this->number.".pdf";
        $this->mpdf->WriteHTML($html);
    }
}
