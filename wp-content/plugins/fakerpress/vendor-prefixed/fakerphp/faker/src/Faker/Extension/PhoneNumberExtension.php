<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Faker\Extension;

/**
 * @experimental This interface is experimental and does not fall under our BC promise
 */
interface PhoneNumberExtension extends Extension
{
    /**
     * @example '555-123-546'
     */
    public function phoneNumber(): string;

    /**
     * @example +27113456789
     */
    public function e164PhoneNumber(): string;
}
