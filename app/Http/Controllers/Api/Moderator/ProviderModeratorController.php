<?php

namespace App\Http\Controllers\Api\Moderator;

use App\Http\Actions\Provider\ProviderAdd;
use App\Http\Actions\Provider\ProviderForOfferModeratorList;
use App\Http\Actions\Provider\ProviderModeratorList;
use App\Http\Actions\Provider\ProviderUpdate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Provider\ProviderModeratorIndexRequest;
use App\Http\Requests\Api\Provider\ProviderModeratorStoreRequest;
use App\Http\Requests\Api\Provider\ProviderModeratorUpdateRequest;
use App\Http\Resources\Api\Provider\ProviderDetailResource;
use App\Http\Resources\Api\Provider\ProviderDetailWithOfferResource;
use App\Http\Resources\Api\Provider\ProviderForOrderResource;
use App\Http\Resources\Api\Provider\ProviderListResource;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class ProviderModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProviderModeratorIndexRequest $request
     * @param ProviderModeratorList $action
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(ProviderModeratorIndexRequest $request, ProviderModeratorList $action): AnonymousResourceCollection|JsonResponse
    {
        return ProviderListResource::collection($action->execute($request->validated()));
    }

    public function forOffer(Request $request, ProviderForOfferModeratorList $action): AnonymousResourceCollection|JsonResponse
    {
        return ProviderForOrderResource::collection($action->execute([]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return ProviderDetailResource
     */
    public function show(Request $request, Provider $provider): ProviderDetailResource
    {
        return new ProviderDetailResource($provider);
    }

    /**
     * Display the specified resource.
     *
     * @param Provider $provider
     * @return ProviderDetailWithOfferResource
     */
    public function with_offer(Provider $provider): ProviderDetailWithOfferResource
    {
        return new ProviderDetailWithOfferResource($provider);
    }

    /**
     * Store the specified resource.
     *
     * @param ProviderModeratorStoreRequest $request
     * @param ProviderAdd $action
     * @return void
     */
    public function store(ProviderModeratorStoreRequest $request, ProviderAdd $action): void
    {
        $action->execute($request->validated());
    }

    /**
     * Update the specified resource.
     * @param ProviderModeratorUpdateRequest $request
     * @param ProviderUpdate $action
     * @return void
     */
    public function update(ProviderModeratorUpdateRequest $request, ProviderUpdate $action): void
    {
        $action->execute($request->validated());
    }
}
