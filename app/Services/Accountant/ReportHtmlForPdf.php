<?php

namespace App\Services\Accountant;


use App\Models\Enums\OrderStatusEnum;
use App\Models\Enums\ProviderFromOfBusinessEnum;
use App\Services\TextService;
use Carbon\Carbon;

class ReportHtmlForPdf extends HtmlForPdf
{
    public function getBody(): string
    {
        $ogrn = 'ОГРН';
        if($this->provider->form_business === ProviderFromOfBusinessEnum::ip->name){
            $ogrn .= 'ИП';
        }
        $ogrn .=  ' № '.$this->provider->ogrn;
        $billDateObject =  Carbon::createFromTimestamp($this->timestamp);
        $billDate =  $billDateObject->format('d.m.Y');
        $html = '<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
            <col class="col0">
            <col class="col1">
            <col class="col2">
            <col class="col3">
            <col class="col4">
            <col class="col5">
            <col class="col6">
            <tbody>
                <tr class="row0">
                    <td class="column0 style1 s style0" colspan="7">От кого: ИП '.$this->ourAccountant->fio().'</td>
                </tr>
                <tr class="row1">
                    <td class="column0 style1 s style0" colspan="7">ОГРНИП № '.$this->ourAccountant->ogrnip().'</td>
                </tr>
                <tr class="row2">
                    <td class="column0 style1 s style0" colspan="7">Кому: '.$this->provider->company_name.'</td>
                </tr>
                <tr class="row3">
                    <td class="column0 style1 s style0" colspan="7">'.$ogrn.'</td>
                </tr>
                <tr class="row4">
                    <td class="column0 style2 null"></td>
                    <td class="column1">&nbsp;</td>
                    <td class="column2">&nbsp;</td>
                    <td class="column3">&nbsp;</td>
                    <td class="column4">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                    <td class="column6">&nbsp;</td>
                </tr>
                <tr class="row5">
                    <td class="column0 style3 s style0 text-bold" colspan="7">Отчет</td>
                </tr>
                <tr class="row6">
                    <td class="column0 style3 s style0 text-bold" colspan="7">исполнителя по агентскому договору от '.$this->provider->contract_date_only.'г.</td>
                </tr>
                    <tr class="row7">
                    <td class="column0 style4 null"></td>
                    <td class="column1">&nbsp;</td>
                    <td class="column2">&nbsp;</td>
                    <td class="column3">&nbsp;</td>
                    <td class="column4">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                    <td class="column6">&nbsp;</td>
                </tr>
                <tr class="row8">
                    <td class="column0 style5 s" colspan="2">г. Подольск </td>
                    <td class="column2">&nbsp;</td>
                    <td class="column3">&nbsp;</td>
                    <td class="column4">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                    <td class="column6 style1 s">'.$billDate.'г.</td>
                </tr>
                <tr class="row9">
                    <td class="column0 style4 null"></td>
                    <td class="column1">&nbsp;</td>
                    <td class="column2">&nbsp;</td>
                    <td class="column3">&nbsp;</td>
                    <td class="column4">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                    <td class="column6">&nbsp;</td>
                </tr>
                <tr class="row10">
                    <td class="column0 style4 null"></td>
                    <td class="column1">&nbsp;</td>
                    <td class="column2">&nbsp;</td>
                    <td class="column3">&nbsp;</td>
                    <td class="column4">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                    <td class="column6">&nbsp;</td>
                </tr>
                <tr class="row11">
                    <td class="column0 style5 s style0" colspan="7">Направляю Отчет исполнителя по договору возмездного оказания услуг от '.$this->provider->contract_date_only.'г.</td>
                </tr>
                <tr class="row12">
                    <td class="column0 style4 null"></td>
                    <td class="column1">&nbsp;</td>
                    <td class="column2">&nbsp;</td>
                    <td class="column3">&nbsp;</td>
                    <td class="column4">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                    <td class="column6">&nbsp;</td>
                </tr>
                <tr class="row13 padding">
                    <td class="column0 style6 text-center s text-bold bold-line-top bold-line-left">№ купона</td>
                    <td class="column1 style6 text-center s text-bold bold-line-top">Держатель</td>
                    <td class="column2 style6 text-center s text-bold bold-line-top">Оформлена</td>
                    <td class="column3 style6 text-center s text-bold bold-line-top">Погашена</td>
                    <td class="column4 style6 text-center s text-bold bold-line-top">Комиссия<br />исполнителя</td>
                    <td class="column6 style6 text-center s text-bold bold-line-top">Покупка</td>
                    <td class="column6 style6 text-center s text-bold bold-line-top bold-line-right">Вознаграждение<br />исполнителя</td>
                </tr>';
        $totalSum = 0;
        $totalOur = 0;

        $i = 0;
        $orders = $this->provider->orders()
            ->where('status', OrderStatusEnum::finished->name)
            ->whereNot('bill_id','>', 0 )
            ->get();
        foreach ($orders as $item) {
            $i++;
            $totalSum += $item->price;
            $totalOur += $item->price * ($item->commission/100);
            $html .= '
                <tr class="row14 padding">
                    <td class="column0 style6 s bold-line-left '.($i == count($orders) ? 'bold-line-bottom' : '').'">'.$item->id.'</td>
                    <td class="column1 style6 s '.($i == count($orders) ? 'bold-line-bottom' : '').'">'.TextService::loginToPhone($item->phone).'</td>
                    <td class="column2 style9 n '.($i == count($orders) ? 'bold-line-bottom' : '').'">'.$item->created_date_only.'</td>
                    <td class="column3 style9 n '.($i == count($orders) ? 'bold-line-bottom' : '').'">'.$item->updated_date_only.'</td>

                    <td class="column4 style6 n '.($i == count($orders) ? 'bold-line-bottom' : '').'">'.$item->commission.'</td>
                    <td class="column4 style6 n">'.$item->price.'</td>
                    <td class="column6 style6 n bold-line-right">'.((int)($item->price * ($item->commission / 100))).'</td>
                </tr>';
        }
            $html .= '
                <tr class="row25 padding">
                    <td class="column0 style10 null"></td>
                    <td class="column1 style10 null"></td>
                    <td class="column2 style10 null"></td>
                    <td class="column2 style10 null"></td>
                    <td class="column3 style11 s">Итого:</td>
                    <td class="column4 style6 n bold-line-bottom  bold-line-left">'.(int)$totalSum.'</td>
                    <td class="column6 style6 n bold-line-bottom  bold-line-right">'.(int)$totalOur.'</td>
                </tr>

                <tr class="row26">
                    <td class="column0 style12 null"></td>
                    <td class="column1">&nbsp;</td>
                    <td class="column2">&nbsp;</td>
                    <td class="column3">&nbsp;</td>
                    <td class="column4">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                  <td class="column6">&nbsp;</td>
                </tr>
                <tr class="row27">
                    <td class="column0 style12 null"></td>
                    <td class="column1">&nbsp;</td>
                    <td class="column2">&nbsp;</td>
                    <td class="column3">&nbsp;</td>
                    <td class="column4">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                    <td class="column6">&nbsp;</td>
                </tr>
            </table>
            <table>
                <tr class="row28">
                    <td style="width: 50%;" class="column0 style13 s style0 text-uppercase"><b>Отчет сдал</b>       </td>
                    <td style="width: 50%;" class="column3 style13 s style0 text-uppercase"><b>Отчет принял</b></td>
                </tr>
                <tr class="row29">
                    <td style="width: 50%;" class="column3 style13 s style0">ИП '.$this->ourAccountant->fio().'</td>
                    <td style="width: 50%;" class="column0 style13 s style0">'.$this->provider->company_name.'</td>
                </tr>
                <tr class="row30">
                    <td style="width: 50%;" class="column0">&nbsp;</td>
                    <td style="width: 50%;" class="column3">&nbsp;</td>
                </tr>';

            if ($this->clear) {
                $html .='
                <tr class="row31">
                    <td style="width: 50%;" class="column3 style13 s style0">______________________________ ('.$this->ourAccountant->fioShort().')</td>
                    <td style="width: 50%;" class="column0 style13 s style0">________________________(____________)</td>
                </tr>';
            } else {
                $html .='
                <tr class="row31">
                    <td style="width: 50%;" class="column3 style13 s style0">______________________________ ('.$this->ourAccountant->fioShort().')<img style="margin-bottom: -1cm;margin-left: -6cm;" src="'.$_SERVER['DOCUMENT_ROOT']. '/' . $this->ourAccountant->signature().'" width="50" /></td>
                    <td style="width: 50%;" class="column0 style13 s style0">________________________(____________)</td>
                </tr>';
            }
                $html .='
                <tr class="row32">
                    <td style="width: 50%;" class="column0">&nbsp;</td>
                    <td style="width: 50%;" class="column3">&nbsp;</td>
                </tr>
                <tr class="row33">
                    <td style="width: 50%;" class="column0 style13 s">М.П.</td>
                    <td style="width: 50%;" class="column3 style13 s">М.П.</td>
                </tr>';
            if (!$this->clear) {
                $html .= '
                <tr class="row34">
                    <td style="width: 50%;" class="column3"><img style="margin-top: -2.5cm;"  src="' . $_SERVER['DOCUMENT_ROOT'] .  '/' . $this->ourAccountant->stamp() . '" width="170" /></td>
                    <td style="width: 50%;" class="column0"></td>
                </tr>';
            }
                $html .='
                </tbody>
            </table>';

        return $html;
    }

    public function getStyle(): string
    {
        return '<style type="text/css">
            html { font-family:Calibri, Arial, Helvetica, sans-serif;  }
            a.comment-indicator:hover + div.comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em }
            a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em }
            div.comment { display:none }
            table { border-collapse:collapse; width: 100%;}
            .b { text-align:center }
            .e { text-align:center }
            .f { text-align:right }
            .inlineStr { text-align:left }
            .n { text-align:right }
            .s { text-align:left }
            .footer td { font-size: 9pt;}
            tr.padding td {  }
            td.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style1 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style1 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style2 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style2 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style3 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style3 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style4 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style4 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style5 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style5 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style6 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style6 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style7 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style7 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style8 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style8 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style9 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style9 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style10 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style10 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style11 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style11 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style12 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style12 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            td.style13 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            th.style13 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-size:9pt;  font-family:\'Arial\'; }
            table.sheet0 col.col0 { width:42pt }
            table.sheet0 col.col1 { width:86.75555456pt }
            table.sheet0 col.col2 { width:42pt }
            table.sheet0 col.col3 { width:42pt }
            table.sheet0 col.col4 { width:42pt }
            table.sheet0 col.col5 { width:42pt }
            table.sheet0 col.col6 { width:72.52222139pt }
            table.sheet0 tr { height:15.75pt }
            table .bold-line-top { border-top:2px solid #000000 !important; }
            table .bold-line-bottom { border-bottom:2px solid #000000 !important; }
            table .bold-line-left { border-left:2px solid #000000 !important; }
            table .bold-line-right { border-right:2px solid #000000 !important; }
            table .text-uppercase { text-transform: uppercase; }
            table .text-bold { font-weight:bold; }
            table .text-center { text-align: center; }
        </style>';
    }

}
