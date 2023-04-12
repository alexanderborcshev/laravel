<?php

namespace App\Models;

use App\Models\Enums\ProviderFromOfBusinessEnum;
use App\Services\DateTimeService;
use App\Services\TextService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Provider
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property string $description
 * @property string $api_key
 * @property string $legal_entity
 * @property string $inn
 * @property string $ogrn
 * @property string $site
 * @property string $work_time
 * @property string $work_time_start
 * @property string $work_time_end
 * @property string $status
 * @property string $first_name
 * @property string $second_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $kpp
 * @property string $checking_account
 * @property string $bik
 * @property string $bank
 * @property string $ur_address
 * @property string $post_address
 * @property string $form_business
 * @property string $contract_number
 * @property string $contract_date
 * @property boolean $need_email
 * @property-read  string $company_name
 * @property-read  string $contract_date_only
 * @method static Builder|Provider newModelQuery()
 * @method static Builder|Provider newQuery()
 * @method static Builder|Provider query()
 * @method static Builder|Provider whereApiKey($value)
 * @method static Builder|Provider whereCreatedAt($value)
 * @method static Builder|Provider whereDescription($value)
 * @method static Builder|Provider whereId($value)
 * @method static Builder|Provider whereInn($value)
 * @method static Builder|Provider whereLegalEntity($value)
 * @method static Builder|Provider whereName($value)
 * @method static Builder|Provider whereOgrn($value)
 * @method static Builder|Provider whereSite($value)
 * @method static Builder|Provider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Provider extends Model
{
    use HasFactory;
    protected $fillable = [
        'created_at',
        'updated_at',
        'name',
        'description',
        'api_key',
        'legal_entity',
        'inn',
        'ogrn',
        'site',
        'work_time',
        'work_time_start',
        'work_time_end',
        'status',
        'first_name',
        'second_name',
        'last_name',
        'phone',
        'email',
        'kpp',
        'checking_account',
        'bik',
        'bank',
        'ur_address',
        'post_address',
        'form_business',
        'contract_number',
        'contract_date',
        'need_email',
    ];

    protected $appends = ['company_name','contract_date_only'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }
    public function managers(): HasMany
    {
        return $this->hasMany(Manager::class);
    }

    public function getContractDateOnlyAttribute(): string
    {
        return DateTimeService::date($this->contract_date);
    }

    /**
     * Формируем наименование компании
     *
     * @return string
     */
    public function getCompanyNameAttribute(): string
    {
        $result = '';
        if ($this->form_business == ProviderFromOfBusinessEnum::ooo->name || $this->form_business == ProviderFromOfBusinessEnum::ao->name) {
            $type = 'ООО';
            if($this->form_business == ProviderFromOfBusinessEnum::ao->name){
                $type = 'АО';
            }

            $legal_entity = TextService::htmlSpecialCharsBack($this->legal_entity);
            $legal_entity = str_replace('"', '', $legal_entity);
            $legal_entity = str_replace('»', '', $legal_entity);
            $legal_entity = str_replace('«', '', $legal_entity);
            if(strpos($legal_entity, 'ООО')==0) {
                $legal_entity = str_replace('ООО', '', $legal_entity);
            }
            if(strpos($legal_entity, 'АО')==0) {
                $legal_entity = str_replace('АО', '', $legal_entity);
            }
            if(strpos($legal_entity, 'ИП')==0) {
                $legal_entity = str_replace('ИП', '', $legal_entity);
            }

            $legal_entity = trim($legal_entity);
            $result = $type.' «' . $legal_entity . '»';;
        } elseif ($this->form_business == ProviderFromOfBusinessEnum::ip->name) {
            $result = 'ИП ' . $this->legal_entity;
        }

        return $result;
    }
}
