<?php

namespace App\Services\Accountant;

use App\Models\Provider;
use App\Services\TextService;
use Carbon\Carbon;

class BillHtmlForPdf extends HtmlForPdf
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
        $billDatePay = $billDateObject->addDays(3)->format('d.m.Y');

        $client =  $this->provider->company_name.', ИНН '.$this->provider->inn;
        if ($this->provider->kpp)  {
            $client .= ', КПП '.$this->provider->kpp;
        }
        $client .=  ', '.$this->provider->ur_address;

        $sumFormatted = number_format($this->sum, 2);
        $sumFormattedPoint = number_format($this->sum, 2, '.',' ');
        $sumFormattedText = TextService::ucFirst(TextService::num2str($this->sum));

        $html = ' <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">';
        for ($i = 0; $i <= 44; $i++) {
            $html .= '<col class="col' . $i . '">';
        }
        $html .= '
        <tbody>
        <tr class="row1">
            <td class="column0"></td>
            <td class="column1 style5 s padding" colspan="22">' . $this->ourAccountant->bank() . '</td>
            <td class="column23 style6 s style6 padding" colspan="6">БИК</td>
            <td class="column29 style7 s style7 padding" colspan="15">' . $this->ourAccountant->bik() . '</td>
            <td class="column44"> </td>
        </tr>
        <tr class="row2">
            <td class="column0"></td>
            <td class="column1 style5_2 s padding" colspan="22">&nbsp;</td>
            <td class="column23 s style10 padding" colspan="6">Сч. №</td>
            <td class="column29 style12 s style10 padding" colspan="15">' . $this->ourAccountant->ks() . '</td>
            <td class="column44"> </td>
        </tr>
        <tr class="row3">
            <td class="column0"></td>
            <td class="column1 style13 s style13 padding" colspan="22">Банк получателя</td>
            <td class="column23 style5_2 s style10 padding" colspan="6">&nbsp;</td>
            <td class="column29 style5_2 s style10 padding" colspan="15">&nbsp;</td>
            <td class="column44"> </td>
        </tr>
        <tr class="row4">
            <td class="column0"></td>
            <td class="column1 style14 s padding" colspan="3">ИНН</td>
            <td class="column4 style15 s padding" colspan="8">' . $this->ourAccountant->inn() . '</td>
            <td class="column12 style14 s padding" colspan="2">КПП  </td>
            <td class="column14 style15 e padding" colspan="9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="column23 style11 s padding" colspan="6">Сч. №</td>
            <td class="column29 style11 s padding" colspan="15">' . $this->ourAccountant->rs() . '</td>
            <td class="column44"> </td>
        </tr>
        <tr class="row5">
            <td class="column0"></td>
            <td class="column1 style19 s padding" colspan="22">Индивидуальный предприниматель <br> ' . $this->ourAccountant->fio() . '</td>
            <td class="column23 s style10_2 padding" colspan="6">&nbsp;</td>
            <td class="column29 s style10_2 padding" colspan="15">&nbsp;</td>
            <td class="column44"> </td>
        </tr>
        <tr class="row7">
            <td class="column0"></td>
            <td class="column1 style20 s style20 padding" colspan="22">Получатель</td>
            <td class="column23 s style10_3 padding" colspan="6">&nbsp;</td>
            <td class="column29 s style10_3 padding" colspan="15">&nbsp;</td>
            <td class="column44"> </td>
        </tr>';
        $html .= $this->emptyRow(8);
        $html .= '
        <tr class="row9">
            <td class="column0"></td>
            <td class="column1 style21 s style21" colspan="43" rowspan="2">Счет на оплату № ' . $this->number . ' от ' . $billDateText . ' г.</td>
            <td class="column44"> </td>
        </tr>
        <tr class="row10">
            <td class="column0"></td>
            <td class="column44"> </td>
        </tr>
        <tr class="row11">
            <td class="column0"></td>
            <td class="column1 style22 e style22" colspan="43">&nbsp;</td>
            <td class="column44"> </td>
        </tr>';
        $html .= $this->emptyRow(12);
        $html .= '
        <tr class="row13">
            <td class="column0"></td>
            <td class="column1 style3 s style17" colspan="5" rowspan="2">Поставщик<br />
            (Исполнитель):&nbsp;</td>
            <td class="column6 style23 s style23" colspan="38" rowspan="2">ИП ' . $this->ourAccountant->fioShort() . ', ИНН ' . $this->ourAccountant->inn() . ', ' . $this->ourAccountant->address() . $this->ourAccountant->phone() . '</td>
            <td class="column44"> </td>
        </tr>
        <tr class="row14">
            <td class="column0"></td>
            <td class="column44"> </td>
        </tr>';
        $html .= $this->emptyRow(15);
        $html .= '

        <tr class="row16">
            <td class="column0"></td>
            <td class="column1 style3 s style17" colspan="5" rowspan="2">Покупатель<br />
            (Заказчик):</td>
            <td class="column6 style23 s style23" colspan="38" rowspan="2">' . $client . '</td>
            <td class="column44"> </td>
        </tr>
        <tr class="row17">
             <td class="column0"></td>
             <td class="column44"> </td>
        </tr>';
        $html .= $this->emptyRow(18);
        $html .= '
        <tr class="row19">
            <td class="column0"></td>
            <td class="column1 style17 s style17" colspan="5">Основание:</td>
            <td class="column6 style23 s style23" colspan="38">Агентский договор от ' . $this->provider->contract_date_only . 'г.</td>';
                $html .= '
            <td class="column44"> </td>
        </tr>';
        $html .= $this->emptyRow(20);
        $html .= '
    </table>
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">
        <tr class="row21">
            <td class="column1 style24 s">№</td>
            <td class="column3 style25 s">Товары (работы, услуги)</td>
            <td class="column24 style25 s">Кол-во</td>
            <td class="column28 style25 s">Ед.</td>
            <td class="column31 style25 s">Цена</td>
            <td class="column36 style26 s">Сумма</td>
        </tr>
        <tr class="row22">
            <td class="column1 style27 s" >1</td>
            <td class="column3 style28 s">&nbsp;Вознаграждение исполнителя по отчету исполнителя от ' . $billDate . 'г.</td>
            <td class="column24 style29 n">1</td>
            <td class="column28 style30 e">&nbsp;</td>
            <td class="column31 style32 n">' . $sumFormatted . '</td>
            <td class="column36 style33 n">' . $sumFormatted . '</td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">';
    $html .= $this->emptyRow(23, 'style34 e');
    $html .= '
    <tr class="row24">
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
        <td class="column26 style35 e">&nbsp;</td>
        <td class="column27 style35 e">&nbsp;</td>
        <td class="column28 style35 e">&nbsp;</td>
        <td class="column29 style35 e">&nbsp;</td>
        <td class="column30 style35 e">&nbsp;</td>
        <td class="column31 style35 e">&nbsp;</td>
        <td class="column32 style35 e">&nbsp;</td>
        <td class="column33 style35 e">&nbsp;</td>
        <td class="column34 style35 e">&nbsp;</td>
        <td class="column35 style35 e">&nbsp;</td>
        <td class="column36 style35 s">Итого:</td>
        <td class="column37 style36 n style36" colspan="6">' . $sumFormatted . '</td>
        <td class="column43">&nbsp;</td>
        <td class="column44"> </td>
    </tr>
    <tr class="row25">
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
        <td class="column26 style35 e">&nbsp;</td>
        <td class="column27 style35 e">&nbsp;</td>
        <td class="column28 style35 e">&nbsp;</td>
        <td class="column29 style35 e">&nbsp;</td>
        <td class="column30 style35 e">&nbsp;</td>
        <td class="column31 style35 e">&nbsp;</td>
        <td class="column32 style35 e">&nbsp;</td>
        <td class="column33 style35 e">&nbsp;</td>
        <td class="column34 style35 e">&nbsp;</td>
        <td class="column35 style35 e">&nbsp;</td>
        <td class="column36 style35 s">Без&nbsp;налога&nbsp;(НДС)</td>
        <td class="column37 style35 e">&nbsp;</td>
        <td class="column38 style35 e">&nbsp;</td>
        <td class="column39 style35 e">&nbsp;</td>
        <td class="column40 style35 e">&nbsp;</td>
        <td class="column41 style35 e">&nbsp;</td>
        <td class="column42 style35 s">-</td>
        <td class="column43">&nbsp;</td>
        <td class="column44"> </td>
    </tr>
    <tr class="row26">
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
        <td class="column26 style35 e">&nbsp;</td>
        <td class="column27 style35 e">&nbsp;</td>
        <td class="column28 style35 e">&nbsp;</td>
        <td class="column29 style35 e">&nbsp;</td>
        <td class="column30 style35 e">&nbsp;</td>
        <td class="column31 style35 e">&nbsp;</td>
        <td class="column32 style35 e">&nbsp;</td>
        <td class="column33 style35 e">&nbsp;</td>
        <td class="column34 style35 e">&nbsp;</td>
        <td class="column35 style35 e">&nbsp;</td>
        <td class="column36 style35 s">Всего к оплате:</td>
        <td class="column37 style36 n style36" colspan="6">' . $sumFormatted . '</td>
        <td class="column43">&nbsp;</td>
        <td class="column44"> </td>
    </tr>
    <tr class="row27">
        <td class="column0"></td>
        <td class="column1 style37 s style37" colspan="43">Всего наименований 1, на сумму ' . $sumFormattedPoint . ' руб.</td>
        <td class="column44"> </td>
    </tr>
    <tr class="row28">
        <td class="column0"></td>
        <td class="column1 style23 s style23" colspan="41">' . $sumFormattedText . ', НДС не облагается</td>
        <td class="column42">&nbsp;</td>
        <td class="column43">&nbsp;</td>
        <td class="column44"> </td>
    </tr>';
    $html .= $this->emptyRow(29);
    $html .= '
    <tr class="row30">
        <td class="column0"></td>
        <td class="column1 style37 s style37" colspan="43">Оплатить не позднее ' . $billDatePay . '</td>
        <td class="column44"> </td>
    </tr>';
    $html .= $this->emptyRow(34, 'style22 e');
    $html .= $this->emptyRow(35);
    $html .= $this->emptyRow(36);
    $html .= '
    <tr class="row37">
        <td class="column0"></td>
        <td class="column1 style39 s">Предприниматель</td>
        <td class="column2">&nbsp;</td>
        <td class="column3">&nbsp;</td>
        <td class="column4">&nbsp;</td>
        <td class="column5">&nbsp;</td>
        <td class="column6">&nbsp;</td>
        <td class="column7">&nbsp;</td>
        <td class="column8">&nbsp;</td>
        <td class="column9 style40 e">&nbsp;</td>
        <td class="column10 style40 e">&nbsp;</td>
        <td class="column11 style40 e">&nbsp;</td>
        <td class="column12 style40 e style40" colspan="11">&nbsp;</td>
        ';

        if ($this->clear) {
            $html .= '<td class="column23 style41 s style41" colspan="21">' . $this->ourAccountant->fioShort() . '</td>';
        } else {
            $html .= '<td class="column23 style41 s style41" colspan="21"><img style="margin-bottom: -1cm;margin-right: 1cm;" src="' . $_SERVER['DOCUMENT_ROOT'] . '/' . $this->ourAccountant->signature() . '" width="50" />' . $this->ourAccountant->fioShort() . '</td>';
        }


        $html .= '
        <td class="column44"> </td>
    </tr>';
    if (!$this->clear) {
        $html .= '<tr class="row37">
        <td class="column0"></td>
        <td class="column1"></td>
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
        <td class="column12" colspan="11">&nbsp;</td>
        <td class="column23" colspan="21"><img style="margin-top: -1cm;margin-left: 2cm;"  src="' . $_SERVER['DOCUMENT_ROOT'] . '/' . $this->ourAccountant->stamp() . '" width="170" /></td>
        <td class="column44"> </td>
        </tr>';
    }
    $html .= '
        </tbody>
    </table>';
        return $html;
    }

    public function getStyle(): string
    {
        return '<style type="text/css">
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
            td.padding { padding: 3px !important; }
            td.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style1 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style1 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style2 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style2 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style3 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style3 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style4 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style4 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style5 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style5_2 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none !important; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style5 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style6 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style6 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style7 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style7 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style8 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style8 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style9 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style9 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style10 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style10_2 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none !important; border-top:none #000000; border-left:1px solid #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style10_3 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:1px solid #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style10 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style10_2 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none !important; border-top:none #000000; border-left:1px solid #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style10_3 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:1px solid #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style11 { text-align:left; padding-left:0px; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style11 { text-align:left; padding-left:0px; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style12 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style12 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style13 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style13 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:1px solid #000 !important; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style14 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style14 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style15 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:none #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style15 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:none #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style16 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style16 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style17 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style17 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style18 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style18 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style19 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style19 { text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style20 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style20 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style21 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:14pt;  }
            th.style21 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:14pt;  }
            td.style22 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:2px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style22 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:2px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style23 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style23 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style24 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:2px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style24 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:2px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style25 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style25 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style26 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:1px solid #000 !important; border-right:2px solid #000 !important; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style26 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:2px solid #000 !important; border-left:1px solid #000 !important; border-right:2px solid #000 !important; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style27 { vertical-align:top; text-align:center; border-bottom:2px solid #000; border-top:1px solid #000 !important; border-left:2px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style27 { vertical-align:top; text-align:center; border-bottom:2px solid #000; border-top:1px solid #000 !important; border-left:2px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style28 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:2px solid #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style28 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:2px solid #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style29 { vertical-align:top; text-align:right; padding-right:0px; border-bottom:2px solid #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style29 { vertical-align:top; text-align:right; padding-right:0px; border-bottom:2px solid #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style30 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:2px solid #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style30 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:2px solid #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style31 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style31 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style32 { vertical-align:top; text-align:right; padding-right:0px; border-bottom:2px solid #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style32 { vertical-align:top; text-align:right; padding-right:0px; border-bottom:2px solid #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style33 { vertical-align:top; text-align:right; padding-right:0px; border-bottom:2px solid #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:2px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style33 { vertical-align:top; text-align:right; padding-right:0px; border-bottom:2px solid #000000; border-top:1px solid #000 !important; border-left:1px solid #000 !important; border-right:2px solid #000 !important; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style34 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000;  border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style34 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000;  border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style35 { vertical-align:top; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style35 { vertical-align:top; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style36 { vertical-align:top; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style36 { vertical-align:top; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style37 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style37 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style38 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style38 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style39 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            th.style39 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Arial\'; font-size:9pt;  }
            td.style40 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style40 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            td.style41 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            th.style41 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Arial\'; font-size:8pt;  }
            table.sheet0 col.col0 { width:0 }
            table.sheet0 col.col1 { width:14.23333317pt }
            table.sheet0 col.col2 { width:7.45555547pt }
            table.sheet0 col.col3 { width:6.7777777pt }
            table.sheet0 col.col4 { width:14.23333317pt }
            table.sheet0 col.col5 { width:17.62222202pt }
            table.sheet0 col.col6 { width:10.16666655pt }
            table.sheet0 col.col7 { width:2.03333331pt }
            table.sheet0 col.col8 { width:12.19999986pt }
            table.sheet0 col.col9 { width:14.23333317pt }
            table.sheet0 col.col10 { width:14.23333317pt }
            table.sheet0 col.col11 { width:14.23333317pt }
            table.sheet0 col.col12 { width:14.23333317pt }
            table.sheet0 col.col13 { width:14.23333317pt }
            table.sheet0 col.col14 { width:14.23333317pt }
            table.sheet0 col.col15 { width:14.23333317pt }
            table.sheet0 col.col16 { width:11.52222209pt }
            table.sheet0 col.col17 { width:5.42222216pt }
            table.sheet0 col.col18 { width:5.42222216pt }
            table.sheet0 col.col19 { width:11.52222209pt }
            table.sheet0 col.col20 { width:11.52222209pt }
            table.sheet0 col.col21 { width:8.81111101pt }
            table.sheet0 col.col22 { width:5.42222216pt }
            table.sheet0 col.col23 { width:0.67777777pt }
            table.sheet0 col.col24 { width:13.5555554pt }
            table.sheet0 col.col25 { width:8.81111101pt }
            table.sheet0 col.col26 { width:5.42222216pt }
            table.sheet0 col.col27 { width:8.81111101pt }
            table.sheet0 col.col28 { width:5.42222216pt }
            table.sheet0 col.col29 { width:16.26666648pt }
            table.sheet0 col.col30 { width:7.45555547pt }
            table.sheet0 col.col31 { width:7.45555547pt }
            table.sheet0 col.col32 { width:14.23333317pt }
            table.sheet0 col.col33 { width:14.23333317pt }
            table.sheet0 col.col34 { width:14.23333317pt }
            table.sheet0 col.col35 { width:8.81111101pt }
            table.sheet0 col.col36 { width:1.35555554pt }
            table.sheet0 col.col37 { width:4.06666662pt }
            table.sheet0 col.col38 { width:14.23333317pt }
            table.sheet0 col.col39 { width:14.23333317pt }
            table.sheet0 col.col40 { width:14.23333317pt }
            table.sheet0 col.col41 { width:14.23333317pt }
            table.sheet0 col.col42 { width:5.42222216pt }
            table.sheet0 col.col43 { width:2.71111108pt }
            table.sheet0 col.col44 { width:0 }
            table.sheet0 tr { height:11.429pt }
            table.sheet0 tr.row0 { height:11pt }
            table.sheet0 tr.row1 { height:13pt }
            table.sheet0 tr.row2 { height:11pt }
            table.sheet0 tr.row3 { height:11pt }
            table.sheet0 tr.row4 { height:13pt }
            table.sheet0 tr.row5 { height:13pt }
            table.sheet0 tr.row6 { height:12pt }
            table.sheet0 tr.row7 { height:11pt }
            table.sheet0 tr.row9 { height:11pt }
            table.sheet0 tr.row10 { height:11pt }
            table.sheet0 tr.row11 { height:7pt }
            table.sheet0 tr.row12 { height:7pt }
            table.sheet0 tr.row13 { height:14pt }
            table.sheet0 tr.row14 { height:11pt }
            table.sheet0 tr.row15 { height:7pt }
            table.sheet0 tr.row16 { height:14pt }
            table.sheet0 tr.row17 { height:11pt }
            table.sheet0 tr.row18 { height:7pt }
            table.sheet0 tr.row19 { height:13pt }
            table.sheet0 tr.row20 { height:7pt }
            table.sheet0 tr.row21 { height:13pt }
            table.sheet0 tr.row22 { height:11pt }
            table.sheet0 tr.row23 { height:7pt }
            table.sheet0 tr.row24 { height:13pt }
            table.sheet0 tr.row25 { height:13pt }
            table.sheet0 tr.row26 { height:13pt }
            table.sheet0 tr.row27 { height:13pt }
            table.sheet0 tr.row28 { height:13pt }
            table.sheet0 tr.row29 { height:7pt }
            table.sheet0 tr.row30 { height:12pt }
            table.sheet0 tr.row31 { height:12pt }
            table.sheet0 tr.row32 { height:12pt }
            table.sheet0 tr.row33 { height:24pt }
            table.sheet0 tr.row34 { height:7pt }
            table.sheet0 tr.row37 { height:13pt }
            table.sheet0 tr.row50 { height:11pt }
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
            <td class="column33 '.$class.'">&nbsp;</td>
            <td class="column34 '.$class.'">&nbsp;</td>
            <td class="column35 '.$class.'">&nbsp;</td>
            <td class="column36 '.$class.'">&nbsp;</td>
            <td class="column37 '.$class.'">&nbsp;</td>
            <td class="column38 '.$class.'">&nbsp;</td>
            <td class="column39 '.$class.'">&nbsp;</td>
            <td class="column40 '.$class.'">&nbsp;</td>
            <td class="column41 '.$class.'">&nbsp;</td>
            <td class="column42 '.$class.'">&nbsp;</td>
            <td class="column43 '.$class.'">&nbsp;</td>
            <td class="column44"> </td>
        </tr>';
    }
}
