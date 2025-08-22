<?php

namespace FakerPress\ThirdParty\Faker\Provider\bn_BD;

class PhoneNumber extends \FakerPress\ThirdParty\Faker\Provider\PhoneNumber
{
    public function phoneNumber()
    {
        $number = '+880';
        $number .= static::randomNumber(7);

        return Utils::getBanglaNumber($number);
    }
}
