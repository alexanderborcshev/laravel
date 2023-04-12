<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Actions\Accountant\BillAccept;
use App\Http\Actions\Accountant\BillProviderCurrentMonth;
use App\Http\Actions\Accountant\BillProviderList;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Accountant\BillAcceptRequest;
use App\Http\Requests\Api\Accountant\BillProviderIndexRequest;
use App\Http\Requests\Api\Accountant\BillPayedRequest;
use App\Http\Requests\Api\Accountant\ShowBillRequest;
use App\Http\Requests\Api\Accountant\StoreBillRequest;
use App\Http\Requests\Api\Accountant\UpdateBillRequest;
use App\Http\Resources\Api\Accountant\BillDetailResource;
use App\Http\Resources\Api\Accountant\BillProviderListResource;
use App\Models\Bill;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BillProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BillProviderIndexRequest $request
     * @param BillProviderList $action
     * @return AnonymousResourceCollection
     */
    public function index(BillProviderIndexRequest $request, BillProviderList $action): AnonymousResourceCollection
    {
        return BillProviderListResource::collection($action->execute($request->validated()));
    }

    /**
     * Display a listing of the resource.
     *
     * @param BillProviderIndexRequest $request
     * @param BillProviderCurrentMonth $action
     * @return Application|ResponseFactory|Response
     */
    public function currentMonth(BillProviderIndexRequest $request, BillProviderCurrentMonth $action): Application|ResponseFactory|Response
    {
        return response($action->execute($request->validated()));
    }

    /**
     *
     * @param BillAcceptRequest $request
     * @param BillAccept $action
     * @return void
     */
    public function accept(BillAcceptRequest $request, BillAccept $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Accountant\StoreBillRequest  $request
     * @return Response
     */
    public function store(StoreBillRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return BillDetailResource
     */
    public function show(ShowBillRequest $request, Bill $bill): BillDetailResource
    {
        return new BillDetailResource($bill);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Accountant\UpdateBillRequest  $request
     * @param  \App\Models\Bill  $bill
     * @return Response
     */
    public function update(UpdateBillRequest $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return Response
     */
    public function destroy(Bill $bill)
    {
        //
    }
}
