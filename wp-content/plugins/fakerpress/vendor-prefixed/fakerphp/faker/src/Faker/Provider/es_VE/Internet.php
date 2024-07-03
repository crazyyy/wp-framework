<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Faker\Provider\es_VE;

class Internet extends \FakerPress\ThirdParty\Faker\Provider\Internet
{
    protected static $freeEmailDomain = ['gmail.com', 'hotmail.com', 'hotmail.es', 'yahoo.com', 'yahoo.es', 'live.com', 'hispavista.com', 'latinmail.com', 'terra.com'];
    protected static $tld = ['com', 'com.ve', 'net', 'net.ve', 'org', 'org.ve', 'info.ve', 'co.ve', 'web.ve'];
}
