<?php

namespace FakerPress\ThirdParty\Faker\Provider\he_IL;

class PhoneNumber extends \FakerPress\ThirdParty\Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '05#-#######',
        '0#-#######',
        '972-5#-#######',
        '972-#-########',
        '0#########',
    ];
}
