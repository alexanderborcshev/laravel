<?php

namespace App\Services\Accountant;

use App\Models\Provider;

interface FileInterface
{
    public function __construct(Provider $provider, $orders, int $number);
    function createPdf(HtmlForPdfInterface $html);
    function storage();
    function inline();
}
