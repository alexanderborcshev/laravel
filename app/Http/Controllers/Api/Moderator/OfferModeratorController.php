<?php

namespace App\Http\Controllers\Api\Moderator;

use App\Http\Actions\Offer\OfferAdd;
use App\Http\Actions\Offer\OfferDelete;
use App\Http\Actions\Offer\OfferModeratorList;
use App\Http\Actions\Offer\OfferPause;
use App\Http\Actions\Offer\OfferPublish;
use App\Http\Actions\Offer\OfferResume;
use App\Http\Actions\Offer\OfferSendToProvider;
use App\Http\Actions\Offer\OfferUpdate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Offer\OfferModeratorDeleteRequest;
use App\Http\Requests\Api\Offer\OfferModeratorIndexRequest;
use App\Http\Requests\Api\Offer\OfferModeratorPauseRequest;
use App\Http\Requests\Api\Offer\OfferModeratorResumeRequest;
use App\Http\Requests\Api\Offer\OfferModeratorSendToProviderRequest;
use App\Http\Requests\Api\Offer\OfferModeratorStoreRequest;
use App\Http\Requests\Api\Offer\OfferModeratorUpdateRequest;
use App\Http\Requests\Api\Offer\OfferModeratorPublishRequest;
use App\Http\Resources\Api\Offer\OfferDetailResource;
use App\Http\Resources\Api\Offer\OfferListResource;
use App\Http\Resources\Api\Offer\OfferPartnerDetailResource;
use App\Models\Offer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OfferModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OfferModeratorIndexRequest $request
     * @param OfferModeratorList $action
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(OfferModeratorIndexRequest $request, OfferModeratorList $action): AnonymousResourceCollection|JsonResponse
    {
        return OfferListResource::collection($action->execute($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param Offer $offer
     * @return OfferPartnerDetailResource
     */
    public function show(Offer $offer): OfferPartnerDetailResource
    {
        return new OfferPartnerDetailResource($offer);
    }

    /**
     * Store the specified resource.
     *
     * @param OfferModeratorStoreRequest $request
     * @return void
     */
    public function store(OfferModeratorStoreRequest $request, OfferAdd $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Update the specified resource.
     * @param OfferModeratorUpdateRequest $request
     * @param OfferUpdate $action
     * @return void
     */
    public function update(OfferModeratorUpdateRequest $request, OfferUpdate $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Delete the specified resource.
     * @param OfferModeratorDeleteRequest $request
     * @param OfferDelete $action
     * @return void
     */
    public function delete(OfferModeratorDeleteRequest $request, OfferDelete $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Publish the specified resource.
     * @param OfferModeratorPublishRequest $request
     * @param OfferPublish $action
     * @return void
     */
    public function publish(OfferModeratorPublishRequest $request, OfferPublish $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Send to provider the specified resource.
     * @param OfferModeratorSendToProviderRequest $request
     * @param OfferSendToProvider $action
     * @return void
     */
    public function sendToProvider(OfferModeratorSendToProviderRequest $request, OfferSendToProvider $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Pause the specified resource.
     * @param OfferModeratorPauseRequest $request
     * @param OfferPause $action
     * @return void
     */
    public function pause(OfferModeratorPauseRequest $request, OfferPause $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Resume the specified resource.
     * @param OfferModeratorResumeRequest $request
     * @param OfferResume $action
     * @return void
     */
    public function resume(OfferModeratorResumeRequest $request, OfferResume $action): void
    {
        $action->execute($request->validated());
    }
}
