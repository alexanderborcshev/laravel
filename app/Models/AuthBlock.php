<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AuthBlock
 *
 * @property int $id
 * @property string $ip
 * @property string|null $date_sms
 * @property string $date_login
 * @property int $count_sms
 * @property int $count_login
 * @property string $login
 * @property int $permanent
 * @method static Builder|AuthBlock newModelQuery()
 * @method static Builder|AuthBlock newQuery()
 * @method static Builder|AuthBlock query()
 * @method static Builder|AuthBlock whereCountLogin($value)
 * @method static Builder|AuthBlock whereCountSms($value)
 * @method static Builder|AuthBlock whereDateLogin($value)
 * @method static Builder|AuthBlock whereDateSms($value)
 * @method static Builder|AuthBlock whereId($value)
 * @method static Builder|AuthBlock whereIp($value)
 * @method static Builder|AuthBlock whereLogin($value)
 * @method static Builder|AuthBlock wherePermanent($value)
 * @mixin Eloquent
 */
class AuthBlock extends Model
{
    use HasFactory;

    const timeThreshold = 3600;
    const count_login_ip = 10;
    const count_login = 5;
    const count_sms_ip = 10;
    const count_sms = 3;

    public $timestamps = false;
    protected $fillable = [
        'id', 'ip', 'date_sms', 'date_login', 'count_sms', 'count_login', 'login', 'permanent'
    ];

    public static function getByIP($ip): Model|AuthBlock|null
    {
        $item = self::firstWhere('ip', $ip);
        if (!$item) {
            $item = self::create([
                'ip'=>$ip,
                'login'=>'',
            ]);
        }
        return $item;
    }

    public static function getByLogin(string $login): Model|AuthBlock|null
    {
        $item = self::firstWhere('login', $login);
        if (!$item) {
            $item = self::create([
                'ip'=>'',
                'login'=>$login,
            ]);
        }
        return $item;
    }

    public static function checkSms($ip, string $login): bool
    {
        $authBlockIP = AuthBlock::getByIP($ip);
        $authBlockLogin = AuthBlock::getByLogin($login);
        if ($authBlockIP->count_sms > self::count_sms_ip && !$authBlockIP->checkSmsDate()
            || $authBlockLogin->count_sms > self::count_sms && !$authBlockLogin->checkSmsDate()) {
            return false;
        }
        if ($authBlockIP->checkSmsDate()) {
            $authBlockIP->setOneSms();
        } else {
            $authBlockIP->incrementSms();
        }
        if ($authBlockLogin->checkSmsDate()) {
            $authBlockLogin->setOneSms();
        } else {
            $authBlockLogin->incrementSms();
        }
        return true;
    }

    public static function checkLogin($ip, string $login, bool $isIncrement = true): bool
    {
        $authBlockIP = AuthBlock::getByIP($ip);
        $authBlockLogin = AuthBlock::getByLogin($login);
        if ($authBlockIP->count_login > self::count_login_ip && !$authBlockIP->checkLoginDate()
            || $authBlockLogin->count_login > self::count_login && !$authBlockLogin->checkLoginDate()) {
            return false;
        }
        if ($isIncrement) {
            if ($authBlockIP->checkLoginDate()) {
                $authBlockIP->setOneLogin();
            } else {
                $authBlockIP->incrementLogin();
            }
            if ($authBlockLogin->checkLoginDate()) {
                $authBlockLogin->setOneLogin();
            } else {
                $authBlockLogin->incrementLogin();
            }
        }
        return true;
    }

    public function checkLoginDate(): bool
    {
        return strtotime($this->date_login) + self::timeThreshold < time();
    }

    public function checkSmsDate(): bool
    {
        return strtotime($this->date_sms) + self::timeThreshold < time();
    }

    public function clearAll() {
        $this->count_sms = 0;
        $this->count_login = 0;
        $this->save();
    }

    public function clearSms() {
        $this->count_sms = 0;
        $this->save();
    }

    public function clearLogin() {
        $this->count_login = 0;
        $this->save();
    }

    public function setOneSms() {
        $this->count_sms = 1;
        $this->date_sms = Carbon::now();
        $this->save();
    }

    public function setOneLogin() {
        $this->count_login = 1;
        $this->date_login = Carbon::now();
        $this->save();
    }

    public function incrementSms() {
        $this->count_sms += 1;
        $this->date_sms = Carbon::now();
        $this->save();
    }

    public function incrementLogin() {
        $this->count_login += 1;
        $this->date_login = Carbon::now();
        $this->save();
    }
}
