<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Offer;
use App\Models\Provider;

class OfferAdd implements ActionInterface
{
    public function execute(array $data): void
    {
        $provider = Provider::find($data['partner']);
        $fields = [
            'status' => OfferStatusEnum::new->name,
            'name' => $data['offerName'],
            'price_min' => $data['minCheck'],
            'price_max' => $data['maxCheck'],
            'provider_id' => $data['partner'],
            'main_text' => $data['mainTextBlock'],
            'main_text_title' => $data['mainTextBlockTitle'],
            'main_photo_id' => $data['mainPhoto'],
            'advantages' => $data['advantagesTextBlock'],
            'description' => $data['promo'],
            'prices' => [],
            'gifts' => json_encode([
                $data['gift1'],
                $data['gift2'],
                $data['gift3'],
                $data['gift4']?:"",
            ]),
            'category_id' => $data['category'],
            'commission' => $data['commission'],
            'text_sections' => [],
            'orders_count' => 0,
            'manager_id' => $provider->managers()->where('owner', 1)->first()?->id ?? '',
        ];
        foreach (json_decode($data['pricesList'], true) as $item) {
            $fields['prices'][] = [
                'from' => $item['from'],
                'price' => $item['price'],
                'measure' => $item['unit'],
                'description' => $item['priceName'],
            ];
        }
        foreach (json_decode($data['textBlocks'], true) as $item) {
            $fields['text_sections'][] = [
                'title' => $item['title'],
                'text' => $item['area'],
            ];
        }
        $fields['prices'] = json_encode($fields['prices']);
        $fields['text_sections'] = json_encode($fields['text_sections']);
        $offer = Offer::create($fields);
        $offer->images()->detach();
        $offer->statistic()->create();
        $sort = 1;
        foreach (json_decode($data['photos']) as $item) {
            $offer->images()->attach($item, ['sort'=>$sort]);
            $sort++;
        }
    }
}
