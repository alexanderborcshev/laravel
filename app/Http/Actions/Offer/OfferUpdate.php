<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Enums\OrderEventEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderEvent;

class OfferUpdate implements ActionInterface
{
    public function execute(array $data): void
    {
        $fields = [
            'name' => $data['offerName'],
            'price_min' => $data['minCheck'],
            'price_max' => $data['maxCheck'],
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
        $offer = Offer::find($data['id']);
        $offer->update($fields);
        $offer->images()->detach();
        $sort = 1;
        foreach (json_decode($data['photos'], true) as $item) {
            $offer->images()->attach($item, ['sort'=>$sort]);
            $sort++;
        }
    }
}
