<?php

namespace FakerPress\ThirdParty\Faker\Provider\sl_SI;

class Company extends \FakerPress\ThirdParty\Faker\Provider\Company
{
    protected static $formats = [
        '{{firstName}} {{lastName}} s.p.',
        '{{lastName}} {{companySuffix}}',
        '{{lastName}}, {{lastName}} in {{lastName}} {{companySuffix}}',
    ];

    protected static $companySuffix = ['d.o.o.', 'd.d.', 'k.d.', 'k.d.d.', 'd.n.o.', 'so.p.'];
}
