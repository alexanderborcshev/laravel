<?php

namespace App\Models;

use Database\Factories\UserGroupFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserGroup
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property string|null $description
 * @property int|null $sort
 * @property string $code
 * @property-read Collection|User[] $users
 * @method static UserGroupFactory factory(...$parameters)
 * @method static Builder|UserGroup newModelQuery()
 * @method static Builder|UserGroup newQuery()
 * @method static Builder|UserGroup query()
 * @method static Builder|UserGroup whereCode($value)
 * @method static Builder|UserGroup whereCreatedAt($value)
 * @method static Builder|UserGroup whereDescription($value)
 * @method static Builder|UserGroup whereId($value)
 * @method static Builder|UserGroup whereName($value)
 * @method static Builder|UserGroup whereSort($value)
 * @method static Builder|UserGroup whereUpdatedAt($value)
 * @mixin Eloquent
 */
class UserGroup extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $fillable = ['id', 'name', 'description', 'sort', 'code'];
    /**
     * The users that belong to the group.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_groups', 'group_id', 'user_id');
    }
}
