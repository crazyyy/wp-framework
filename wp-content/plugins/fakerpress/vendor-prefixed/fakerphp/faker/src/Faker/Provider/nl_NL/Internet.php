<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Faker\Provider\nl_NL;

class Internet extends \FakerPress\ThirdParty\Faker\Provider\Internet
{
    protected static $freeEmailDomain = ['gmail.com', 'hotmail.nl', 'live.nl', 'yahoo.nl'];
    protected static $tld = ['com', 'com', 'com', 'net', 'org', 'nl', 'nl', 'nl'];
}
