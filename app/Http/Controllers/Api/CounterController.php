<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\User\Counter;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request, Counter $action): JsonResponse
    {
        return response()->json($action->execute(['provider_id'=>$request->id]));
    }
}
