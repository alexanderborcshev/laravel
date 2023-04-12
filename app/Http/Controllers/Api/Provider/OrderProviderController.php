<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Actions\Order\OrderAccept;
use App\Http\Actions\Order\OrderAdd;
use App\Http\Actions\Order\OrderNoteAdd;
use App\Http\Actions\Order\OrderCancel;
use App\Http\Actions\Order\OrderCanceledList;
use App\Http\Actions\Order\OrderFinish;
use App\Http\Actions\Order\OrderInProgress;
use App\Http\Actions\Order\OrderInProgressModeratorList;
use App\Http\Actions\Order\OrderNewList;
use App\Http\Actions\Order\OrderPostpone;
use App\Http\Actions\Order\OrderProviderList;
use App\Http\Actions\Order\OrderVerify;
use App\Http\Actions\Order\SearchProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\OrderAcceptRequest;
use App\Http\Requests\Api\Order\OrderNoteStoreRequest;
use App\Http\Requests\Api\Order\OrderProviderListRequest;
use App\Http\Requests\Api\Order\OrderStoreRequest;
use App\Http\Requests\Api\Order\OrderCancelRequest;
use App\Http\Requests\Api\Order\OrderFinishRequest;
use App\Http\Requests\Api\Order\OrderInProgressRequest;
use App\Http\Requests\Api\Order\OrderPostponeRequest;
use App\Http\Requests\Api\Order\OrderVerifyRequest;
use App\Http\Requests\Api\Order\SearchRequest;
use App\Http\Resources\Api\Offer\OfferWithNewOrdersCollection;
use App\Http\Resources\Api\Order\OrderEventResource;
use App\Http\Resources\Api\Order\OrderCanceledModeratorListResource;
use App\Http\Resources\Api\Order\OrderListResource;
use App\Http\Resources\Api\Order\OrderSearchListResource;
use App\Http\Resources\Api\Provider\ProviderWithInProgressOrdersCollection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OrderProviderController extends Controller
{
    /**
     *
     * @param OrderProviderListRequest $request
     * @param OrderProviderList $action
     * @return AnonymousResourceCollection
     */
    public function index(OrderProviderListRequest $request, OrderProviderList $action): AnonymousResourceCollection
    {
        return OrderListResource::collection($action->execute($request->validated()));
    }

    /**
     * Список новых заказов, в кабинете модератора, сгруппированные по оферам.
     *
     * @param SearchRequest $request
     * @param SearchProvider $action
     * @return AnonymousResourceCollection
     */
    public function search(SearchRequest $request, SearchProvider $action): AnonymousResourceCollection
    {
        return OrderSearchListResource::collection($action->execute($request->validated()));
    }

    /**
     * Партнер, просмотрел заказ
     *
     * @param OrderAcceptRequest $request
     * @param OrderAccept $action
     * @return void
     */
    public function accept(OrderAcceptRequest $request, OrderAccept $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Новая заметка в заказе
     *
     * @param OrderNoteStoreRequest $request
     * @param OrderNoteAdd $action
     * @return OrderEventResource
     */
    public function note(OrderNoteStoreRequest $request, OrderNoteAdd $action): OrderEventResource
    {
        return new OrderEventResource($action->execute($request->validated()));
    }

    /**
     * Перевод заказа в работу
     *
     * @param OrderInProgressRequest $request
     * @param OrderInProgress $action
     * @return void
     */
    public function in_progress(OrderInProgressRequest $request, OrderInProgress $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Перевод заказа в отложенные
     *
     * @param OrderPostponeRequest $request
     * @param OrderPostpone $action
     * @return void
     * @todo добавить в коммент время откладывания
     */
    public function postpone(OrderPostponeRequest $request, OrderPostpone $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Перевод заказа в отменные
     *
     * @param OrderCancelRequest $request
     * @param OrderCancel $action
     * @return void
     */
    public function canceled(OrderCancelRequest $request, OrderCancel $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Перевод заказа в завершенные
     *
     * @param OrderFinishRequest $request
     * @param OrderFinish $action
     * @return void
     */
    public function finished(OrderFinishRequest $request, OrderFinish $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return request();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderStoreRequest $request
     * @param OrderAdd $action
     * @return void
     */
    public function store(OrderStoreRequest $request, OrderAdd $action): void
    {
        $action->execute($request->validated());;
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(): Response
    {
        return request();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(): Response
    {
        return request();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(): Response
    {
        return request();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(): Response
    {
        return request();
    }
}
