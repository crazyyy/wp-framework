<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Faker\Provider\es_VE;

class PhoneNumber extends \FakerPress\ThirdParty\Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '+58 2## ### ####',
        '+58 2## #######',
        '+58 2#########',
        '+58 2##-###-####',
        '+58 2##-#######',
        '2## ### ####',
        '2## #######',
        '2#########',
        '2##-###-####',
        '2##-#######',
        '+58 4## ### ####',
        '+58 4## #######',
        '+58 4#########',
        '+58 4##-###-####',
        '+58 4##-#######',
        '4## ### ####',
        '4## #######',
        '4#########',
        '4##-###-####',
        '4##-#######',
    ];
}
