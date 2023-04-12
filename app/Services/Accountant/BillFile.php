<?php

namespace App\Services\Accountant;

use Mpdf\MpdfException;

class BillFile extends DocFile implements FileInterface
{
    /**
     * @throws MpdfException
     */
    function createPdf(BillHtmlForPdf|HtmlForPdfInterface $html) {
        $this->fileName = 'bill_'.$this->number.'_'.$this->provider->id.".pdf";
        $this->mpdf->WriteHTML($html);
    }
}
