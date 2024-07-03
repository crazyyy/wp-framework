<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Faker\Provider;

class Medical extends Base
{
    protected static $bloodTypes = ['A', 'AB', 'B', 'O'];

    protected static $bloodRhFactors = ['+', '-'];

    /**
     * @example 'AB'
     */
    public static function bloodType(): string
    {
        return static::randomElement(static::$bloodTypes);
    }

    /**
     * @example '+'
     */
    public static function bloodRh(): string
    {
        return static::randomElement(static::$bloodRhFactors);
    }

    /**
     * @example 'AB+'
     */
    public function bloodGroup(): string
    {
        return $this->generator->parse('{{bloodType}}{{bloodRh}}');
    }
}
