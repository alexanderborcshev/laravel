<?php

namespace App\Models;

use Database\Factories\ManagerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Manager
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $provider_id
 * @property int $user_id
 * @property int $owner
 * @property-read Collection|UserNote[] $notes
 * @property-read int|null $notes_count
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @property-read Provider|null $provider
 * @property-read User|null $user
 * @method static ManagerFactory factory(...$parameters)
 * @method static Builder|Manager newModelQuery()
 * @method static Builder|Manager newQuery()
 * @method static Builder|Manager query()
 * @method static Builder|Manager whereCreatedAt($value)
 * @method static Builder|Manager whereId($value)
 * @method static Builder|Manager whereOwner($value)
 * @method static Builder|Manager whereProviderId($value)
 * @method static Builder|Manager whereUpdatedAt($value)
 * @method static Builder|Manager whereUserId($value)
 * @mixin \Eloquent
 */
class Manager extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'provider_id',
        'user_id',
        'owner',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
    public function notes(): HasMany
    {
        return $this->hasMany(UserNote::class, 'user_id', 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'manager_id');
    }
}
