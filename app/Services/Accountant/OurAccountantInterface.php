<?php

namespace App\Services\Accountant;

interface OurAccountantInterface
{
     public function id(): int;
     public function fio(): string;
     public function fioShort(): string;
     public function inn(): string;
     public function address(): string;
     public function addressPost(): string;
     public function phone(): string;
     public function ogrnip(): string;
     public function rs(): string;
     public function bank(): string;
     public function bik(): string;
     public function ks(): string;
     public function stamp(): string;
     public function signature(): string;
}
