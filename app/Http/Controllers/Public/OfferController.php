<?php

namespace App\Http\Controllers\Public;

use App\Http\Actions\Offer\OfferPublicList;
use App\Http\Actions\Order\OrderAdd;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\OrderStoreRequest;
use App\Http\Resources\Public\Offer\OfferDetailResource;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(Request $request, OfferPublicList $action): AnonymousResourceCollection|JsonResponse
    {
        return $action->execute(['code'=>$request->filter['code']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return OfferDetailResource
     */
    public function show(Offer $offer): OfferDetailResource
    {
        $statistic = $offer->statistic()->first();
        $statistic->show_detail = $statistic->show_detail + 1;
        $statistic->save();
        return new OfferDetailResource($offer);
    }

    /**
     * Display the specified resource.
     *
     * @param OrderStoreRequest $request
     * @param OrderAdd $action
     * @return JsonResponse
     */
    public function order(OrderStoreRequest $request, OrderAdd $action): JsonResponse
    {
        return response()->json($action->execute($request->validated()));
    }
}
