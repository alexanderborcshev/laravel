<?php

namespace App\Http\Controllers\Api\Moderator;

use App\Http\Actions\Accountant\BillModeratorList;
use App\Http\Actions\Accountant\BillPayed;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Accountant\BillModeratorIndexRequest;
use App\Http\Requests\Api\Accountant\BillPayedRequest;
use App\Http\Requests\Api\Accountant\ShowBillRequest;
use App\Http\Requests\Api\Accountant\StoreBillRequest;
use App\Http\Requests\Api\Accountant\UpdateBillRequest;
use App\Http\Resources\Api\Accountant\BillDetailResource;
use App\Http\Resources\Api\Accountant\BillModeratorListResource;
use App\Models\Bill;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BillModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(BillModeratorIndexRequest $request, BillModeratorList $action): AnonymousResourceCollection
    {
        return BillModeratorListResource::collection($action->execute($request->validated()));
    }

    /**
     *
     * @param BillPayedRequest $request
     * @param BillPayed $action
     * @return void
     */
    public function payed(BillPayedRequest $request, BillPayed $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Accountant\StoreBillRequest  $request
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBillRequest $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }
}
