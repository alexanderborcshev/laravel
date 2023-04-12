<?php

namespace App\Http\Actions\Accountant;

use App\Http\Actions\ActionInterface;
use App\Models\Bill;
use App\Models\Enums\BillStatusEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Enums\ProviderStatusEnum;
use App\Models\Provider;
use App\Services\Accountant\ActFile;
use App\Services\Accountant\ActHtmlForPdf;
use App\Services\Accountant\BillFile;
use App\Services\Accountant\BillHtmlForPdf;
use App\Services\Accountant\OurAccountantInterface;
use App\Services\Accountant\OurAccountantZelenova;
use App\Services\Accountant\ReportFile;
use App\Services\Accountant\ReportHtmlForPdf;
use Mpdf\MpdfException;

class BillIssue implements ActionInterface
{
    /**
     * @throws MpdfException
     */
    public function execute(array $data)
    {
        $providers = Provider::where('status', ProviderStatusEnum::active->name)->get();
        $lastBill = Bill::orderByDesc('number')->first();
        $number = $lastBill ? $lastBill->number + 1 : 1;
        $ourAccountant = new OurAccountantZelenova();
        foreach ($providers as $provider) {
            $bill = $this->addBill($provider, (int)$number, $ourAccountant);
            if ($bill) {
                $number ++;
            }
        }
    }

    /**
     * @throws MpdfException
     */
    public function addBill(Provider $provider, int $number, OurAccountantInterface $ourAccountant)
    {
        $orders = $provider->orders()
            ->where('status', OrderStatusEnum::finished->name)
            ->whereNot('bill_id','>', 0 )
            ->get();
        $sum = 0.0;
        $profit = 0;
        foreach ($orders as $order) {
            $sum += $order->price * $order->commission / 100;
            $profit += $order->price;
        }
        if ($sum > 0) {
            $billFile = new BillFile($provider, $orders, $number);
            $billFile->createPdf(new BillHtmlForPdf($provider, $ourAccountant, $number, 0, $sum));
            $billFile->storage();

            $actFile = new ActFile($provider, $orders, $number);
            $actFile->createPdf(new ActHtmlForPdf($provider, $ourAccountant, $number,0, $sum));
            $actFile->storage();

            $reportFile = new ReportFile($provider, $orders, $number);
            $reportFile->createPdf(new ReportHtmlForPdf($provider, $ourAccountant, $number));
            $reportFile->storage();

            $bill = Bill::create([
                'status' => BillStatusEnum::new->name,
                'provider_id' => $provider->id,
                'accountant_id' => $ourAccountant->id(),
                'accept_user_id' => 0,
                'sum' => $sum,
                'number' => $number,
                'file_act_id' => $actFile->file->id,
                'file_report_id' => $reportFile->file->id,
                'file_bill_id' => $billFile->file->id,
                'profit' => $profit,
            ]);
            foreach ($orders as $order) {
                $order->bill_id = $bill->id;
                $order->save();
            }
            return $bill->id;
        }
        return null;
    }
}
