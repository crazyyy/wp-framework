<?php

namespace FakerPress\ThirdParty\Faker\Provider\de_CH;

class Company extends \FakerPress\ThirdParty\Faker\Provider\Company
{
    protected static $formats = [
        '{{lastName}} {{companySuffix}}',
        '{{lastName}} {{lastName}} {{companySuffix}}',
        '{{lastName}}',
        '{{lastName}}',
    ];

    protected static $companySuffix = ['AG', 'GmbH'];
}
