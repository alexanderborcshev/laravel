<?php

namespace App\Models;

use App\Services\DateTimeService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNote extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','user_create_id','comment'];
    protected $appends = ['created_date_diff', 'created_date'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_create_id');
    }

    public function getCreatedDateDiffAttribute(): string
    {
        return DateTimeService::diffFormat($this->created_at, false);
    }

    public function getCreatedDateAttribute(): string
    {
        return DateTimeService::dateShortTime($this->created_at);
    }

}
