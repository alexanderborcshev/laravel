<?php

namespace App\Services\Accountant;

class OurAccountantZelenova implements OurAccountantInterface
{
     public function id(): int
     {
         return 1;
     }
     public function fio(): string
     {
         return 'Зеленова Александра Валерьевна';
     }
     public function fioShort(): string
     {
         return 'Зеленова А. В.';
     }
     public function inn(): string
     {
         return '502103057165';
     }
     public function address(): string
     {
         return '142184, Московская обл, г. Подольск, мкр. Климовск, ул. Революции, д. 4, кв. 303';
     }
     public function addressPost(): string
     {
         return '142110, Московская обл., г. Подольск, ул. Кирова, д. 46 а/я 286';
     }
     public function phone(): string
     {
         return '';
     }
     public function ogrnip(): string
     {
         return '321508100351329 от 29.07.21';
     }
     public function rs(): string
     {
         return '40802810240000018678';
     }
     public function bank(): string
     {
         return 'ПАО СБЕРБАНК';
     }
     public function bik(): string
     {
         return '044525225';
     }
     public function ks(): string
     {
         return '30101810400000000225';
     }
     public function stamp(): string
     {
         return env('APP_PATH_FILE_STORE').'/accountant/stamp-zelenova.png';
     }
     public function signature(): string
     {
         return env('APP_PATH_FILE_STORE').'/accountant/signature-zelenova.png';
     }
}
