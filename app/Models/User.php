<?php

namespace App\Models;

use App\Notifications\SmsUserCode;
use App\Services\TextService;
use Database\Factories\UserFactory;
use Eloquent;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $second_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string|null $login
 * @property string|null $post
 * @property string|null $sms_hash
 * @property string|null $google_id
 * @property int|null $blocked
 * @property Carbon|null $blocked_date
 * @property-read Collection|OauthAccessToken[] $authAccessToken
 * @property-read int|null $auth_access_token_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read string $char
 * @property-read string $login_to_phone
 * @property-read Collection|UserGroup[] $groups
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'second_name',
        'last_name',
        'phone',
        'login',
        'post',
        'sms_hash',
        'google_id',
        'blocked',
        'blocked_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'sms_hash',
        'google_id',
        'email_verified_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'blocked_date' => 'datetime',
    ];

    protected $appends = ['login_to_phone', 'char'];

    public function canAccessFilament(): bool
    {
        return str_ends_with($this->email, '@panel.ru') && $this->hasVerifiedEmail();
    }

    public function routeNotificationForMainSms(): ?string
    {
        return $this->login;
    }

    public function getByLogin(string $login): Model|Builder|User|null
    {
        return $this->where('login', $login);
    }

    public function inGroups(array $groups): bool
    {
        if (count(array_intersect($this->groups->unique()->getQueueableIds(), $groups)) > 0)
            return true;
        return false;
    }

    public function inGroupsByCode(array $codes): bool
    {
        $userGroups = array_column($this->groups()->get(['code'])->toArray(), 'code');
        if (count(array_intersect($userGroups, $codes)) > 0)
            return true;
        return false;
    }

    public function sendSmsCode()
    {
        $smsCode = rand(1000, 9999);
        $this->sms_hash = Hash::make($smsCode);
        $this->save();

        Notification::send($this, new SmsUserCode(['smsCode' => $smsCode]));
    }

    public function getLoginToPhoneAttribute(): string
    {
        return TextService::loginToPhone($this->login);
    }

    public function getCharAttribute(): string
    {
        return ($this->name)?mb_substr($this->name,0,1):"-";
    }

    /**
     * The groups that belong to the user.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(UserGroup::class, 'user_groups', 'user_id', 'group_id');
    }

    /**
     * Find the user instance for the given username.
     *
     * @param string $login
     * @return User
     */
    public function findForPassport(string $login): User
    {
        return $this->where('login', str_replace(['-', '_', '', '+', '(', ')'], '', $login))->first();
    }

    public function validateForPassportPasswordGrant($password): bool
    {
        return Hash::check($password, $this->sms_hash);
    }

    public function authAccessToken(): HasMany
    {
        return $this->hasMany(OauthAccessToken::class);
    }
    public function notes(): HasMany
    {
        return $this->hasMany(UserNote::class, 'user_id')->limit(5);
    }

    public function managers(): HasMany
    {
        return $this->hasMany(Manager::class, 'user_id');
    }
}
