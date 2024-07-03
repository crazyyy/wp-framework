<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Faker\Provider\en_NZ;

class Internet extends \FakerPress\ThirdParty\Faker\Provider\Internet
{
    /**
     * An array of New Zealand TLDs.
     *
     * @see https://en.wikipedia.org/wiki/.nz
     *
     * @var array
     */
    protected static $tld = [
        'com', 'nz', 'ac.nz', 'co.nz', 'geek.nz', 'gen.nz', 'kiwi.nz', 'maori.nz', 'net.nz', 'org.nz', 'school.nz', 'cri.nz', 'govt.nz', 'health.nz', 'iwi.nz', 'mil.nz', 'parliament.nz',
    ];
}
