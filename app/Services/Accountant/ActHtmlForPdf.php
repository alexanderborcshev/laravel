<?php

namespace App\Services\Accountant;

use App\Models\Provider;
use App\Services\TextService;
use Carbon\Carbon;

class ActHtmlForPdf extends HtmlForPdf
{
    private int|float $sum;

    public function __construct(Provider $provider, OurAccountantInterface $ourAccountant, int $number, int $timestamp = 0, float $sum = 0)
    {
        $this->sum = $sum;
        parent::__construct($provider, $ourAccountant, $number, $timestamp);
    }
    public function getBody(): string
    {
        $billDateObject =  Carbon::createFromTimestamp($this->timestamp);
        $billDateText =  $billDateObject->translatedFormat('d F Y');
        $billDate =  $billDateObject->format('d.m.Y');
        $client = $this->provider->company_name .', ИНН '.$this->provider->inn .', '.$this->provider->ur_address
            . ', р/с '.$this->provider->checking_account .', в банке '.$this->provider->bank .', БИК '.$this->provider->bik;
        $sumFormatted = number_format($this->sum, 2);
        $sumFormattedPoint = number_format($this->sum, 2, '.',' ');
        $sumFormattedText = TextService::ucFirst(TextService::num2str($this->sum));

        $html = '<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">';
        for ($i = 0; $i <= 44; $i++) {
            $html .= '<col class="col' . $i . '">';
        }
        $html .= '
        <tbody>
            <tr class="row2">
                <td class="column0"></td>
                <td class="column1 style2 s style2" colspan="31">Акт № '.$this->number.' от '.$billDateText.' г.</td>
                <td class="column32">&nbsp;</td>
            </tr>';
        $html .= $this->emptyRow(3);
        $html .= '
            <tr class="row4">
                <td class="column0"></td>
                <td class="column1 style3 s style3" colspan="4">Исполнитель:</td>
                <td class="column5 style4 s style4" colspan="28">ИП '.$this->ourAccountant->fioShort().', ИНН '.$this->ourAccountant->inn().', '.$this->ourAccountant->address().$this->ourAccountant->phone().', р/с '.$this->ourAccountant->rs().', в банке '.$this->ourAccountant->bank().', БИК '.$this->ourAccountant->bik().', к/с '.$this->ourAccountant->ks().'</td>
            </tr>';
        $html .= $this->emptyRow(5);
        $html .= '
            <tr class="row6">
                <td class="column0"></td>
                <td class="column1 style3 s style3" colspan="4">Заказчик:</td>
                <td class="column5 style4 s style4" colspan="28">'.$client.'</td>
            </tr>';
        $html .= $this->emptyRow(7);
        $html .= '
            <tr class="row8">
                <td class="column0"></td>
                <td class="column1 style3 s style3" colspan="4">Основание:</td>';
        $html .= '<td class="column5 style4 s style4" colspan="28">Агентский договор от '.$this->provider->contract_date_only.'г.</td>';
        $html .= '</tr>';
        $html .= $this->emptyRow(9);
        $html .= '
            <tr class="row10">
                <td class="column0"></td>
                <td class="column1 style7 s" colspan="2" rowspan="2">№</td>
                <td class="column3 style9 s" colspan="17" rowspan="2">Наименование работ, услуг</td>
                <td class="column20 style9 s" colspan="3" rowspan="2">Кол-во</td>
                <td class="column23 style9 s" colspan="2" rowspan="2">Ед.</td>
                <td class="column25 style9 s" colspan="4" rowspan="2">Цена</td>
                <td class="column29 style11 s" colspan="4" rowspan="2">Сумма</td>
            </tr>
            <tr class="row11">
                <td class="column0"></td>
            </tr>
            <tr class="row12">
                <td class="column0"></td>
                <td class="column1 style12 s" colspan="2">1</td>
                <td class="column3 style13 s" colspan="17">Вознаграждение исполнителя по отчету исполнителя от '.$billDate.'г.</td>
                <td class="column20 style14 n" colspan="3">1</td>
                <td class="column23 style15 e" colspan="2">&nbsp;</td>
                <td class="column25 style16 n" colspan="4">'.$sumFormatted.'</td>
                <td class="column29 style17 n" colspan="4">'.$sumFormatted.'</td>
            </tr>';
        $html .= $this->emptyRow(13, 'style18 e');
        $html .= '
            <tr class="row14">
                <td class="column0"></td>
                <td class="column1">&nbsp;</td>
                <td class="column2">&nbsp;</td>
                <td class="column3">&nbsp;</td>
                <td class="column4">&nbsp;</td>
                <td class="column5">&nbsp;</td>
                <td class="column6">&nbsp;</td>
                <td class="column7">&nbsp;</td>
                <td class="column8">&nbsp;</td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
                <td class="column12">&nbsp;</td>
                <td class="column13">&nbsp;</td>
                <td class="column14">&nbsp;</td>
                <td class="column15">&nbsp;</td>
                <td class="column16">&nbsp;</td>
                <td class="column17">&nbsp;</td>
                <td class="column18">&nbsp;</td>
                <td class="column19">&nbsp;</td>
                <td class="column20">&nbsp;</td>
                <td class="column21">&nbsp;</td>
                <td class="column22">&nbsp;</td>
                <td class="column23">&nbsp;</td>
                <td class="column24">&nbsp;</td>
                <td class="column25">&nbsp;</td>
                <td class="column26">&nbsp;</td>
                <td class="column27">&nbsp;</td>
                <td class="column28 style19 s">Итого:</td>
                <td class="column29 style19 s style19" colspan="4">'.$sumFormatted.'</td>
            </tr>
            <tr class="row15">
                <td class="column0"></td>
                <td class="column1">&nbsp;</td>
                <td class="column2">&nbsp;</td>
                <td class="column3">&nbsp;</td>
                <td class="column4">&nbsp;</td>
                <td class="column5">&nbsp;</td>
                <td class="column6">&nbsp;</td>
                <td class="column7">&nbsp;</td>
                <td class="column8">&nbsp;</td>
                <td class="column9">&nbsp;</td>
                <td class="column10">&nbsp;</td>
                <td class="column11">&nbsp;</td>
                <td class="column12">&nbsp;</td>
                <td class="column13">&nbsp;</td>
                <td class="column14">&nbsp;</td>
                <td class="column15">&nbsp;</td>
                <td class="column16">&nbsp;</td>
                <td class="column17">&nbsp;</td>
                <td class="column18">&nbsp;</td>
                <td class="column19">&nbsp;</td>
                <td class="column20">&nbsp;</td>
                <td class="column21">&nbsp;</td>
                <td class="column22">&nbsp;</td>
                <td class="column23">&nbsp;</td>
                <td class="column24">&nbsp;</td>
                <td class="column25">&nbsp;</td>
                <td class="column26">&nbsp;</td>
                <td class="column27">&nbsp;</td>
                <td class="column28 style19 s">Без налога (НДС)</td>
                <td class="column29 style19 s style19" colspan="4">-</td>
            </tr>';
        $html .= $this->emptyRow(16);
        $html .= '
            <tr class="row17">
                <td class="column0"></td>
                <td class="column1 style1 s style1" colspan="32">Всего оказано услуг 1, на сумму '.$sumFormattedPoint.' руб.</td>
            </tr>
            <tr class="row18">
                <td class="column0"></td>
                <td class="column1 style4 s style4" colspan="31">'.$sumFormattedText.', НДС не облагается</td>
                <td class="column32">&nbsp;</td>
            </tr>';
        $html .= $this->emptyRow(19);
        $html .= '
            <tr class="row20">
                <td class="column0"></td>
                <td class="column1 style20 s style20" colspan="32" rowspan="2">Вышеперечисленные услуги выполнены полностью и в срок. Заказчик претензий по объему, качеству и срокам оказания услуг не имеет.</td>
            </tr>
            <tr class="row21">
                <td class="column0"></td>
            </tr>';
        $html .= $this->emptyRow(22, 'style21 e');
        $html .= $this->emptyRow(23);
        $html .= '
            <tr class="row24">
                <td class="column0"></td>
                <td class="column1 style22 s style22" colspan="16">ИСПОЛНИТЕЛЬ</td>
                <td class="column17">&nbsp;</td>
                <td class="column18">&nbsp;</td>
                <td class="column19">&nbsp;</td>
                <td class="column20 style23 s style23" colspan="13">ЗАКАЗЧИК</td>
            </tr>
            <tr class="row25">
                <td class="column0"></td>
                <td class="column1 style24 s style24" colspan="16">ИП '.$this->ourAccountant->fioShort().'</td>
                <td class="column17">&nbsp;</td>
                <td class="column18">&nbsp;</td>
                <td class="column19">&nbsp;</td>
                <td class="column20 style25 s style25" colspan="13">'.$this->provider->company_name.'</td>
            </tr>
            <tr class="row26">
                <td class="column0"></td>
                <td class="column1 style26 e">&nbsp;</td>
                <td class="column2 style26 e">&nbsp;</td>
                <td class="column3 style26 e">&nbsp;</td>
                <td class="column4 style27 e">&nbsp;</td>
                <td class="column5 style28 e">&nbsp;</td>
                <td class="column6 style28 e">&nbsp;</td>
                <td class="column7 style28"></td>
                <td class="column8 style28 e">&nbsp;</td>
                <td class="column9 style28 e">&nbsp;</td>
                <td class="column10 style28 e">&nbsp;</td>
                <td class="column11 style28 e">&nbsp;</td>';

        if ($this->clear) {
            $html .='<td class="column12 style28 e"></td>';
        } else {
            $html .='<td class="column12 style28 e"><img style="margin-bottom: -1cm;" src="'.$_SERVER['DOCUMENT_ROOT']. '/' . $this->ourAccountant->signature().'" width="50" /></td>';
        }

        $html .='
                <td class="column13 style28 e">&nbsp;</td>
                <td class="column14 style28 e">&nbsp;</td>
                <td class="column15 style28 e">&nbsp;</td>
                <td class="column16 style26 e">&nbsp;</td>
                <td class="column17">&nbsp;</td>
                <td class="column18">&nbsp;</td>
                <td class="column19">&nbsp;</td>
                <td class="column20 style26 e">&nbsp;</td>
                <td class="column21 style26 e">&nbsp;</td>
                <td class="column22 style26 e">&nbsp;</td>
                <td class="column23 style26 e">&nbsp;</td>
                <td class="column24 style26 e">&nbsp;</td>
                <td class="column25 style26 e">&nbsp;</td>
                <td class="column26 style26 e">&nbsp;</td>
                <td class="column27 style26 e">&nbsp;</td>
                <td class="column28 style26 e">&nbsp;</td>
                <td class="column29 style26 e">&nbsp;</td>
                <td class="column30 style26 e">&nbsp;</td>
                <td class="column31 style26 e">&nbsp;</td>
                <td class="column32 style26 e">&nbsp;</td>
            </tr>
            <tr class="row27">
                <td class="column0"></td>
                <td class="column1 style29 s style29" colspan="16">'.$this->ourAccountant->fioShort().'</td>
                <td class="column17">&nbsp;</td>
                <td class="column18">&nbsp;</td>
                <td class="column19">&nbsp;</td>
                <td class="column20">&nbsp;</td>
                <td class="column21">&nbsp;</td>
                <td class="column22">&nbsp;</td>
                <td class="column23">&nbsp;</td>
                <td class="column24">&nbsp;</td>
                <td class="column25">&nbsp;</td>
                <td class="column26">&nbsp;</td>
                <td class="column27">&nbsp;</td>
                <td class="column28">&nbsp;</td>
                <td class="column29">&nbsp;</td>
                <td class="column30">&nbsp;</td>
                <td class="column31">&nbsp;</td>
                <td class="column32">&nbsp;</td>
            </tr>';

        if(!$this->clear)
        {
            $html .='
            <tr class="row27">
                <td class="column0"></td>
                <td class="column1 style29 s style29" colspan="16"><img style="margin-top: -1.5cm;margin-left: -0.5cm;"  src="' . $_SERVER['DOCUMENT_ROOT'] . '/' . $this->ourAccountant->stamp() . '" width="170" /></td>
                <td class="column17">&nbsp;</td>
                <td class="column18">&nbsp;</td>
                <td class="column19">&nbsp;</td>
                <td class="column20">&nbsp;</td>
                <td class="column21">&nbsp;</td>
                <td class="column22">&nbsp;</td>
                <td class="column23">&nbsp;</td>
                <td class="column24">&nbsp;</td>
                <td class="column25">&nbsp;</td>
                <td class="column26">&nbsp;</td>
                <td class="column27">&nbsp;</td>
                <td class="column28">&nbsp;</td>
                <td class="column29">&nbsp;</td>
                <td class="column30">&nbsp;</td>
                <td class="column31">&nbsp;</td>
                <td class="column32">&nbsp;</td>
            </tr>';
        }
        $html .='
            </tbody>
        </table>';

        return $html;
    }
    public function getStyle(): string
    {
        return '
        <style type="text/css">
            html { font-family:Calibri, Arial, Helvetica, sans-serif; font-size:11pt;  }
            a.comment-indicator:hover + div.comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em }
            a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em }
            div.comment { display:none }
            table { border-collapse:collapse; width: 100%; }
            .b { text-align:center }
            .e { text-align:center }
            .f { text-align:right }
            .inlineStr { text-align:left }
            .n { text-align:right }
            .s { text-align:left }
            td.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style1 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style1 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style2 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:2px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:14pt;  }
            th.style2 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:2px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:14pt;  }
            td.style3 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style3 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style4 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style4 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style5 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:2px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style5 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:2px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style6 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style6 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style7 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:2px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style7 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:2px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style8 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style8 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style9 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style9 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style10 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:2px solid #000 !important; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style10 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:2px solid #000 !important; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style11 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:1px solid #000 !important; border-right:2px solid #000 !important; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style11 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:1px solid #000 !important; border-right:2px solid #000 !important; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style12 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:2px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style12 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:2px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style13 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style13 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style14 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style14 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style15 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style15 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style16 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style16 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style17 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:2px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style17 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:2px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style18 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style18 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style19 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style19 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style20 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style20 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style21 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:2px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style21 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:2px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style22 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:10pt;  }
            th.style22 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:10pt;  }
            td.style23 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:10pt;  }
            th.style23 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:10pt;  }
            td.style24 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style24 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style25 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style25 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style26 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style26 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style27 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style27 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style28 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:7pt;  }
            th.style28 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:7pt;  }
            td.style29 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style29 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            table.sheet0 col.col0 { width:14.23333317pt }
            table.sheet0 col.col1 { width:14.23333317pt }
            table.sheet0 col.col2 { width:14.23333317pt }
            table.sheet0 col.col3 { width:14.23333317pt }
            table.sheet0 col.col4 { width:16.94444425pt }
            table.sheet0 col.col5 { width:14.23333317pt }
            table.sheet0 col.col6 { width:14.23333317pt }
            table.sheet0 col.col7 { width:14.23333317pt }
            table.sheet0 col.col8 { width:14.23333317pt }
            table.sheet0 col.col9 { width:14.23333317pt }
            table.sheet0 col.col10 { width:14.23333317pt }
            table.sheet0 col.col11 { width:14.23333317pt }
            table.sheet0 col.col12 { width:14.23333317pt }
            table.sheet0 col.col13 { width:14.23333317pt }
            table.sheet0 col.col14 { width:14.23333317pt }
            table.sheet0 col.col15 { width:14.23333317pt }
            table.sheet0 col.col16 { width:14.23333317pt }
            table.sheet0 col.col17 { width:14.23333317pt }
            table.sheet0 col.col18 { width:14.23333317pt }
            table.sheet0 col.col19 { width:14.23333317pt }
            table.sheet0 col.col20 { width:14.23333317pt }
            table.sheet0 col.col21 { width:14.23333317pt }
            table.sheet0 col.col22 { width:14.23333317pt }
            table.sheet0 col.col23 { width:14.23333317pt }
            table.sheet0 col.col24 { width:14.23333317pt }
            table.sheet0 col.col25 { width:14.23333317pt }
            table.sheet0 col.col26 { width:14.23333317pt }
            table.sheet0 col.col27 { width:14.23333317pt }
            table.sheet0 col.col28 { width:14.23333317pt }
            table.sheet0 col.col29 { width:14.23333317pt }
            table.sheet0 col.col30 { width:14.23333317pt }
            table.sheet0 col.col31 { width:14.23333317pt }
            table.sheet0 col.col32 { width:14.23333317pt }
            table.sheet0 tr { height:11.429pt }
            table.sheet0 tr.row0 { height:11pt }
            table.sheet0 tr.row1 { height:1pt }
            table.sheet0 tr.row2 { height:22pt }
            table.sheet0 tr.row3 { height:7pt }
            table.sheet0 tr.row4 { height:38pt }
            table.sheet0 tr.row5 { height:5pt }
            table.sheet0 tr.row6 { height:13pt }
            table.sheet0 tr.row7 { height:5pt }
            table.sheet0 tr.row8 { height:13pt }
            table.sheet0 tr.row9 { height:5pt }
            table.sheet0 tr.row10 { height:7pt }
            table.sheet0 tr.row11 { height:11pt }
            table.sheet0 tr.row12 { height:11pt }
            table.sheet0 tr.row13 { height:5pt }
            table.sheet0 tr.row14 { height:13pt }
            table.sheet0 tr.row15 { height:13pt }
            table.sheet0 tr.row16 { height:5pt }
            table.sheet0 tr.row17 { height:11pt }
            table.sheet0 tr.row18 { height:13pt }
            table.sheet0 tr.row19 { height:11pt }
            table.sheet0 tr.row20 { height:11pt }
            table.sheet0 tr.row21 { height:14pt }
            table.sheet0 tr.row22 { height:7pt }
            table.sheet0 tr.row23 { height:11pt }
            table.sheet0 tr.row24 { height:13pt }
            table.sheet0 tr.row25 { height:13pt }
            table.sheet0 tr.row26 { height:19pt }
            table.sheet0 tr.row27 { height:13pt }
            table.sheet0 tr.row29 { height:11pt }
        </style>';
    }

    public function emptyRow(int $number, string $class = ''): string
    {
        return '<tr class="row'.$number.'">
            <td class="column0"></td>
            <td class="column1 '.$class.'">&nbsp;</td>
            <td class="column2 '.$class.'">&nbsp;</td>
            <td class="column3 '.$class.'">&nbsp;</td>
            <td class="column4 '.$class.'">&nbsp;</td>
            <td class="column5 '.$class.'">&nbsp;</td>
            <td class="column6 '.$class.'">&nbsp;</td>
            <td class="column7 '.$class.'">&nbsp;</td>
            <td class="column8 '.$class.'">&nbsp;</td>
            <td class="column9 '.$class.'">&nbsp;</td>
            <td class="column10 '.$class.'">&nbsp;</td>
            <td class="column11 '.$class.'">&nbsp;</td>
            <td class="column12 '.$class.'">&nbsp;</td>
            <td class="column13 '.$class.'">&nbsp;</td>
            <td class="column14 '.$class.'">&nbsp;</td>
            <td class="column15 '.$class.'">&nbsp;</td>
            <td class="column16 '.$class.'">&nbsp;</td>
            <td class="column17 '.$class.'">&nbsp;</td>
            <td class="column18 '.$class.'">&nbsp;</td>
            <td class="column19 '.$class.'">&nbsp;</td>
            <td class="column20 '.$class.'">&nbsp;</td>
            <td class="column21 '.$class.'">&nbsp;</td>
            <td class="column22 '.$class.'">&nbsp;</td>
            <td class="column23 '.$class.'">&nbsp;</td>
            <td class="column24 '.$class.'">&nbsp;</td>
            <td class="column25 '.$class.'">&nbsp;</td>
            <td class="column26 '.$class.'">&nbsp;</td>
            <td class="column27 '.$class.'">&nbsp;</td>
            <td class="column28 '.$class.'">&nbsp;</td>
            <td class="column29 '.$class.'">&nbsp;</td>
            <td class="column30 '.$class.'">&nbsp;</td>
            <td class="column31 '.$class.'">&nbsp;</td>
            <td class="column32 '.$class.'">&nbsp;</td>
        </tr>';
    }
}
