<?php

namespace App\Models;

use Database\Factories\OfferStatisticFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OfferStatistic
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $new
 * @property int $in_progress
 * @property int $postpone
 * @property int $canceled
 * @property int $finished
 * @property int $offer_id
 * @property int $profit
 * @property int $show_detail
 * @method static OfferStatisticFactory factory(...$parameters)
 * @method static Builder|OfferStatistic newModelQuery()
 * @method static Builder|OfferStatistic newQuery()
 * @method static Builder|OfferStatistic query()
 * @method static Builder|OfferStatistic whereCanceled($value)
 * @method static Builder|OfferStatistic whereCreatedAt($value)
 * @method static Builder|OfferStatistic whereFinished($value)
 * @method static Builder|OfferStatistic whereId($value)
 * @method static Builder|OfferStatistic whereInProgress($value)
 * @method static Builder|OfferStatistic whereNew($value)
 * @method static Builder|OfferStatistic whereOfferId($value)
 * @method static Builder|OfferStatistic wherePostpone($value)
 * @method static Builder|OfferStatistic whereProfit($value)
 * @method static Builder|OfferStatistic whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OfferStatistic extends Model
{
    use HasFactory;
    protected $fillable = [
        'new',
        'in_progress',
        'postpone',
        'canceled',
        'finished',
        'offer_id',
        'profit',
        'show_detail',
    ];

    public function negativeToZeroValue()
    {
        if ($this->new < 0) {
            $this->new = 0;
        }
        if ($this->in_progress < 0) {
            $this->in_progress = 0;
        }
        if ($this->postpone < 0) {
            $this->postpone = 0;
        }
        if ($this->canceled < 0) {
            $this->canceled = 0;
        }
        if ($this->finished < 0) {
            $this->finished = 0;
        }
    }
}
