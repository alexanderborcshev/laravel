<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Actions\Offer\OfferProviderList;
use App\Http\Actions\Offer\OfferProviderMenuList;
use App\Http\Actions\Offer\OfferPublish;
use App\Http\Actions\Offer\OfferSetManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Offer\OfferProviderListRequest;
use App\Http\Requests\Api\Offer\OfferProviderPublishRequest;
use App\Http\Requests\Api\Offer\OfferProviderSetManagerRequest;
use App\Http\Resources\Api\Offer\OfferListResource;
use App\Http\Resources\Api\Offer\OfferPartnerDetailResource;
use App\Http\Resources\Api\Offer\OfferProviderMenuResource;
use App\Models\Offer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OfferProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OfferProviderListRequest $request
     * @param OfferProviderList $action
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(OfferProviderListRequest $request, OfferProviderList $action): AnonymousResourceCollection|JsonResponse
    {
        return OfferListResource::collection($action->execute([]));
    }

    /**
     * Display a listing of the resource.
     *
     * @param OfferProviderMenuList $action
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function menu(OfferProviderMenuList $action): AnonymousResourceCollection|JsonResponse
    {
        return OfferProviderMenuResource::collection($action->execute([]));
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
     * Publish the specified resource.
     * @param OfferProviderPublishRequest $request
     * @param OfferPublish $action
     * @return Application|ResponseFactory|Response
     */
    public function publish(OfferProviderPublishRequest $request, OfferPublish $action): Application|ResponseFactory|Response
    {
        return response($action->execute($request->validated()));
    }

    /**
     * Set manager the specified resource.
     * @param OfferProviderSetManagerRequest $request
     * @param OfferSetManager $action
     * @return void
     */
    public function manager(OfferProviderSetManagerRequest $request, OfferSetManager $action): void
    {
        $action->execute($request->validated());
    }
}
