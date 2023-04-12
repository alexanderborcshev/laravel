<?php

namespace App\Models;

use App\Services\DateTimeService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderEvent extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'order_id', 'comment', 'code', 'created_at', 'updated_at'];
    protected $appends = ['created_date_only','created_time','created_date_diff'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getCreatedDateDiffAttribute(): string
    {
        return DateTimeService::diffFormat($this->created_at);
    }
    public function getCreatedDateOnlyAttribute(): string
    {
        return DateTimeService::date($this->created_at);
    }

    public function getCreatedTimeAttribute(): string
    {
        return $this->created_at ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('H:i') : '';
    }
}
