<?php

namespace App\Services\Accountant;

use App\Models\File;
use Mpdf\MpdfException;

class ActFile extends DocFile implements FileInterface
{
    /**
     * @throws MpdfException
     */
    function createPdf(ActHtmlForPdf|HtmlForPdfInterface $html) {
        $this->fileName = 'act_'.$this->number.".pdf";
        $this->mpdf->WriteHTML($html);
    }
}
