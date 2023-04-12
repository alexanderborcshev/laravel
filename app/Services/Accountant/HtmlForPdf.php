<?php

namespace App\Services\Accountant;

use App\Models\Provider;

abstract class HtmlForPdf implements HtmlForPdfInterface
{
    public string $html = '';
    public Provider $provider;
    public int $number;
    public int $timestamp;
    public bool $clear = false;
    public OurAccountantInterface $ourAccountant;

    public function __construct(Provider $provider, OurAccountantInterface $ourAccountant, int $number, int $timestamp = 0)
    {
        $this->ourAccountant = $ourAccountant;
        $this->provider = $provider;
        $this->number = $number;
        $this->timestamp = $timestamp ?: time();
        $this->html = $this->getStyle();
        $this->html .= $this->getBody();
    }

    public function __toString(): string
    {
        return $this->html;
    }
}
