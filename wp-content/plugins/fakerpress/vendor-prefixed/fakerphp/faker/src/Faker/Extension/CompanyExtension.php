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
interface CompanyExtension extends Extension
{
    /**
     * @example 'Acme Ltd'
     */
    public function company(): string;

    /**
     * @example 'Ltd'
     */
    public function companySuffix(): string;

    public function jobTitle(): string;
}
