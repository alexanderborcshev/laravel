<?php

namespace App\Models;

use App\Services\DateTimeService;
use App\Services\TextService;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $provider_id
 * @property int $offer_id
 * @property string $phone
 * @property string $name
 * @property string $email
 * @property string $comment
 * @property string $status
 * @property boolean $accepted
 * @property boolean $verified
 * @property string $postpone
 * @property integer $price
 * @property int $bill_id
 * @property int $manager_id
 * @property int $commission
 * @property string $how_connect
 * @property-read Collection|OrderEvent[] $events
 * @property-read Offer $offer
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereComment($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereEmail($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereName($value)
 * @method static Builder|Order whereOrderId($value)
 * @method static Builder|Order wherePhone($value)
 * @method static Builder|Order whereProviderId($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'created_at',
        'updated_at',
        'provider_id',
        'offer_id',
        'phone',
        'name',
        'email',
        'comment',
        'status',
        'accepted',
        'price',
        'postpone',
        'verified',
        'bill_id',
        'manager_id',
        'how_connect',
    ];

    protected $appends = ['created_date','created_date_only','created_time','created_day_diff','updated_day_diff','updated_date_only', 'phone_format'];

    public function routeNotificationForMainSms(): ?string
    {
        return $this->phone;
    }
    public function events(): HasMany
    {
        return $this->hasMany(OrderEvent::class);
    }

    public function getCreatedDateAttribute(): string
    {
        return DateTimeService::dateShortTime($this->created_at);
    }
    public function getCreatedDateOnlyAttribute(): string
    {
        return DateTimeService::date($this->created_at);
    }

    public function getCreatedTimeAttribute(): string
    {
        return $this->created_at ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('H:i') : '';
    }
    public function getPhoneFormatAttribute(): string
    {
        return TextService::loginToPhone($this->phone);
    }

    public function getCreatedDayDiffAttribute(): string
    {
        return $this->created_at ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->diffInDays() : '';
    }

    public function getUpdatedDayDiffAttribute(): string
    {
        return $this->updated_at ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->diffInDays() : '';
    }

    public function getUpdatedDateOnlyAttribute(): string
    {
        return DateTimeService::date($this->updated_at);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class, 'offer_id')->withTrashed();
    }
}
