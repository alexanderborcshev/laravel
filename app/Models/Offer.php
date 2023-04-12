<?php

namespace App\Models;

use App\Casts\Json;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Services\DateTimeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Offer
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property int $orders_count
 * @property int $price_min
 * @property int $price_max
 * @property int $provider_id
 * @property int $manager_id
 * @property string $main_text
 * @property string $main_text_title
 * @property string $work_time
 * @property string $description
 * @property int $commission
 * @property mixed $prices
 * @property mixed $gifts
 * @property mixed $text_sections
 * @property string $status
 * @property string $pause_comment
 * @property int $number
 * @property int $main_photo
 * @property string $advantages
 * @method static Builder|Offer newModelQuery()
 * @method static Builder|Offer newQuery()
 * @method static Builder|Offer query()
 * @method static Builder|Offer whereAdvantages($value)
 * @method static Builder|Offer whereCreatedAt($value)
 * @method static Builder|Offer whereDescription($value)
 * @method static Builder|Offer whereGifts($value)
 * @method static Builder|Offer whereId($value)
 * @method static Builder|Offer whereName($value)
 * @method static Builder|Offer whereOrders($value)
 * @method static Builder|Offer wherePriceMax($value)
 * @method static Builder|Offer wherePriceMin($value)
 * @method static Builder|Offer wherePrices($value)
 * @method static Builder|Offer whereProviderId($value)
 * @method static Builder|Offer whereUpdatedAt($value)
 * @method static Builder|Offer whereWarning($value)
 * @method static Builder|Offer whereWorkTime($value)
 * @mixin \Eloquent
 */
class Offer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'name',
        'orders_count',
        'price_min',
        'price_max',
        'provider_id',
        'manager_id',
        'main_text',
        'main_text_title',
        'work_time',
        'description',
        'prices',
        'gifts',
        'category_id',
        'commission',
        'text_sections',
        'status',
        'number',
        'pause_comment',
        'main_photo_id',
        'advantages',
    ];

    protected $casts = [
        'prices' => Json::class,
        'gifts' => Json::class,
        'text_sections' => Json::class,
    ];

    protected $appends = ['updated_day_diff'];

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(File::class,'offer_images','offer_id', 'file_id');
    }

    public function main_photo(): BelongsTo
    {
        return $this->belongsTo(File::class,'main_photo_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function statistic(): HasOne
    {
        return $this->hasOne(OfferStatistic::class);
    }
    /**
     * Фильтруем список
     */
    public static function getFiltered($arFilter): Collection
    {
        if (isset($arFilter['category_id'])) {
            return self::where('category_id', $arFilter['category_id'])->where('status', OfferStatusEnum::public->name)->orderByDesc('orders_count')->get();
        }
        return self::where('status', OfferStatusEnum::public->name)->orderByDesc('orders_count')->get();
    }

    public function getUpdatedDayDiffAttribute(): string
    {
        return $this->updated_at ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->diffInDays() : '';
    }

    public function updateStatistic()
    {
        $orders = $this->orders()->get();
        $statistic = $this->statistic()->first();
        if (!$statistic) {
            $statistic = $this->statistic()->create();
        }
        $statistic->new = 0;
        $statistic->in_progress = 0;
        $statistic->postpone = 0;
        $statistic->canceled = 0;
        $statistic->finished = 0;

        foreach ($orders as $order) {
            switch ($order->status) {
                case OrderStatusEnum::new->name:
                    $statistic->new = $statistic->new + 1;
                    break;
                case OrderStatusEnum::in_progress->name:
                    $statistic->in_progress = $statistic->in_progress + 1;
                    break;
                case OrderStatusEnum::postpone->name:
                    $statistic->postpone = $statistic->postpone + 1;
                    break;
                case OrderStatusEnum::canceled->name:
                    $statistic->canceled = $statistic->canceled + 1;
                    break;
                case OrderStatusEnum::finished->name:
                    $statistic->finished = $statistic->finished + 1;
                    $statistic->profit = $statistic->profit + $order->price;
                    break;
            }
        }
        $statistic->save();
    }
}
