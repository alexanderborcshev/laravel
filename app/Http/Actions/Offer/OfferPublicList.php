<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Http\Resources\Public\Offer\OfferListResource;
use App\Models\Category;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OfferPublicList implements ActionInterface
{

    public function execute(array $data): JsonResponse|AnonymousResourceCollection
    {
        $filter = [];
        if (isset($data['code'])) {
            $category = Category::where('code','=', $data['code']);
            if (!$category->exists()) {
                return response()->json(['message'=>'Section not found','errorCode'=>404], 404);
            }
            $filter['category_id'] = $category->first()->id;
        }
        return OfferListResource::collection(Offer::getFiltered($filter));
    }
}
