<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Accountant\BillIssue;
use App\Http\Actions\Offer\OffersStatisticUpdate;
use App\Http\Actions\Order\OrdersReturnToInProgress;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Mpdf\MpdfException;

class ConsoleController extends Controller
{
    /**
     * @throws MpdfException
     */
    public function bill_issue(BillIssue $action): Response|Application|ResponseFactory
    {
        $action->execute([]);
        return response('OK');
    }

    public function offers_statistic(OffersStatisticUpdate $action): Response|Application|ResponseFactory
    {
        $action->execute([]);
        return response('OK');
    }
    public function return_to_in_progress(OrdersReturnToInProgress $action): Response|Application|ResponseFactory
    {
        $action->execute([]);
        return response('OK');
    }
}
