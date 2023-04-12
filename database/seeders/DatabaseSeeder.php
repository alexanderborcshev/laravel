<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Manager;
use App\Models\Offer;
use App\Models\OfferStatistic;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        if (Category::count() == 0) {
            $categories = [
                [ 'name' => 'Окна и остекление', 'icon' => 'window' ],
                [ 'name' => 'Кухни и мебель', 'icon' => 'kitchen' ],
                [ 'name' => 'Натяжные потолки', 'icon' => 'roof'  ],
                [ 'name' => 'Электрика и электромонтаж', 'icon' => 'electric' ],
                [ 'name' => 'Полы и покрытия', 'icon' => 'floor' ],
                [ 'name' => 'Сантехника и отопление', 'icon' => 'plumbing' ],
                [ 'name' => 'Кондиционеры и вентиляция', 'icon' => 'vent' ],
                [ 'name' => 'Плитка и керамогранит', 'icon' => 'tile' ],
                [ 'name' => 'Стены и покрытия', 'icon' => 'walls' ],
                [ 'name' => 'Двери и перегородки', 'icon' => 'door' ],
                [ 'name' => 'Свет и освещение', 'icon' => 'light' ],
                [ 'name' => 'Инструменты и оборудование', 'icon' => 'instruments' ],
                [ 'name' => 'Декор и интерьер', 'icon' => 'decor' ],
                [ 'name' => 'Юридические услуги', 'icon' => 'legal' ],
            ];
            $sort = 100;
            foreach ($categories as $item) {
                Category::factory()->create([
                    'name' => $item['name'],
                    'icon' => $item['icon'],
                    'code' => $item['icon'],
                    'sort' => $sort,
                ]);
                $sort += 100;
            }
        }
    }
}
