<?php

namespace App\Services\Accountant;

use App\Models\Provider;

interface HtmlForPdfInterface
{
    public function __construct(Provider $provider, OurAccountantInterface $ourAccountant,int $number);

    public function getBody(): string;
    public function getStyle(): string;
}
