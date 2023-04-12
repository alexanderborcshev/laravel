<?php

namespace App\Http\Controllers\Api\Moderator;

use App\Http\Actions\User\UserNoteCreate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserNoteCreateRequest;
use App\Http\Resources\Api\Order\OrderListResource;
use App\Http\Resources\Api\User\UserNoteResource;
use App\Models\UserNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        return response()->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserNoteCreateRequest $request
     * @return UserNoteResource
     */
    public function store(UserNoteCreateRequest $request, UserNoteCreate $action): UserNoteResource
    {
        return new UserNoteResource($action->execute($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserNote  $userNote
     * @return JsonResponse
     */
    public function show(UserNote $userNote): JsonResponse
    {
        return response()->json();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserNote  $userNote
     * @return JsonResponse
     */
    public function edit(UserNote $userNote): JsonResponse
    {
        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\UserNote  $userNote
     * @return JsonResponse
     */
    public function update(Request $request, UserNote $userNote)
    {
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserNote  $userNote
     * @return JsonResponse
     */
    public function destroy(UserNote $userNote): JsonResponse
    {
        return response()->json();
    }
}
