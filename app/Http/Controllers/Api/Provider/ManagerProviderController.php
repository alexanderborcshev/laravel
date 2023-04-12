<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Actions\Manager\ManagerAdd;
use App\Http\Actions\Manager\ManagerBlock;
use App\Http\Actions\Manager\ManagerProviderList;
use App\Http\Actions\Manager\ManagerUpdate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Manager\ManagerProviderBlockRequest;
use App\Http\Requests\Api\Manager\ManagerProviderListRequest;
use App\Http\Requests\Api\Manager\ManagerProviderStoreRequest;
use App\Http\Requests\Api\Manager\ManagerProviderUpdateRequest;
use App\Http\Resources\Api\Manager\ManagerAddResource;
use App\Http\Resources\Api\Manager\ManagerListResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManagerProviderController extends Controller
{
    public function index(ManagerProviderListRequest $request, ManagerProviderList $action): AnonymousResourceCollection|JsonResponse
    {
        return ManagerListResource::collection($action->execute([]));
    }

    /**
     * Store the specified resource.
     *
     * @param ManagerProviderStoreRequest $request
     * @param ManagerAdd $action
     * @return ManagerAddResource
     */
    public function store(ManagerProviderStoreRequest $request, ManagerAdd $action): ManagerAddResource
    {
        return new ManagerAddResource($action->execute($request->validated()));
    }

    /**
     * Update the specified resource.
     * @param ManagerProviderUpdateRequest $request
     * @param ManagerUpdate $action
     * @return ManagerListResource
     */
    public function update(ManagerProviderUpdateRequest $request, ManagerUpdate $action): ManagerListResource
    {
        return new ManagerListResource($action->execute($request->validated()));
    }
    /**
     * Update the specified resource.
     * @param ManagerProviderBlockRequest $request
     * @param ManagerBlock $action
     * @return void
     */
    public function block(ManagerProviderBlockRequest $request, ManagerBlock $action): void
    {
        $action->execute($request->validated());
    }
}
