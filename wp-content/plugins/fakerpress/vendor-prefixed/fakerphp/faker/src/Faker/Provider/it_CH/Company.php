<?php

namespace FakerPress\ThirdParty\Faker\Provider\it_CH;

class Company extends \FakerPress\ThirdParty\Faker\Provider\Company
{
    protected static $formats = [
        '{{lastName}} {{companySuffix}}',
        '{{lastName}} {{lastName}} {{companySuffix}}',
        '{{lastName}}',
        '{{lastName}}',
    ];

    protected static $companySuffix = ['SA', 'Sarl'];
}
