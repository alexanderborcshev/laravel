<?php

namespace App\Models;

use App\Services\DateTimeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
/**
 * App\Models\Bill
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property int $provider_id
 * @property int $accountant_id
 * @property int $sum
 * @property int $number
 * @property int $file_act_id
 * @property int $file_report_id
 * @property int $file_bill_id
 * @property int $auto_accept
 * @property int $send
 * @property string|null $accept_date
 * @property string|null $used_date
 * @property int|null $accept_user_id
 * @property int|null $profit
 * @property-read User|null $accept_user
 * @property-read File|null $file_act
 * @property-read File|null $file_bill
 * @property-read File|null $file_report
 * @property-read string $accept_date_only
 * @property-read string $created_date
 * @property-read string $created_date_diff
 * @property-read string $created_date_only
 * @property-read string $created_date_text
 * @property-read string $created_day_diff
 * @property-read string $used_date_only
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @property-read Provider|null $provider
 * @method static Builder|Bill newModelQuery()
 * @method static Builder|Bill newQuery()
 * @method static Builder|Bill query()
 * @method static Builder|Bill whereAcceptDate($value)
 * @method static Builder|Bill whereAcceptUserId($value)
 * @method static Builder|Bill whereAccountantId($value)
 * @method static Builder|Bill whereAutoAccept($value)
 * @method static Builder|Bill whereCreatedAt($value)
 * @method static Builder|Bill whereFileActId($value)
 * @method static Builder|Bill whereFileBillId($value)
 * @method static Builder|Bill whereFileReportId($value)
 * @method static Builder|Bill whereId($value)
 * @method static Builder|Bill whereNumber($value)
 * @method static Builder|Bill whereProfit($value)
 * @method static Builder|Bill whereProviderId($value)
 * @method static Builder|Bill whereSend($value)
 * @method static Builder|Bill whereStatus($value)
 * @method static Builder|Bill whereSum($value)
 * @method static Builder|Bill whereUpdatedAt($value)
 * @method static Builder|Bill whereUsedDate($value)
 * @mixin \Eloquent
 */
class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'status',
        'provider_id',
        'accountant_id',
        'accept_user_id',
        'sum',
        'number',
        'file_act_id',
        'file_report_id',
        'file_bill_id',
        'auto_accept',
        'send',
        'accept_date',
        'used_date',
        'profit',
    ];
    protected $appends = ['created_date','created_date_only','created_day_diff','created_date_diff','created_date_text','accept_date_only','used_date_only'];
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function getCreatedDateDiffAttribute(): string
    {
        return DateTimeService::diffFormat($this->created_at);
    }
    public function getCreatedDateTextAttribute(): string
    {
        return $this->created_at->translatedFormat('F Y');
    }

    public function getCreatedDateOnlyAttribute(): string
    {
        return DateTimeService::date($this->created_at);
    }

    public function getCreatedDayDiffAttribute(): string
    {
        return $this->created_at ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->diffInDays() : '';
    }

    public function getCreatedDateAttribute(): string
    {
        return $this->created_at->format('d.m.Y');
    }
    public function getAcceptDateOnlyAttribute(): string
    {
        return DateTimeService::date($this->accept_date);
    }
    public function getUsedDateOnlyAttribute(): string
    {
        return DateTimeService::date($this->used_date);
    }

    public function file_act(): HasOne
    {
        return $this->hasOne(File::class,'id', 'file_act_id');
    }
    public function file_report(): HasOne
    {
        return $this->hasOne(File::class,'id', 'file_report_id');
    }
    public function file_bill(): HasOne
    {
        return $this->hasOne(File::class,'id', 'file_bill_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'bill_id', 'id');
    }

    public function accept_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accept_user_id');
    }
}













