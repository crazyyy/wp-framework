<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Faker\Provider\en_ZA;

class Company extends \FakerPress\ThirdParty\Faker\Provider\Company
{
    protected static $legalEntities = [
        '01', '02', '06', '07', '08', '09', '10', '11', '12', '14', '15', '16', '17', '20', '21', '22', '23', '24', '25',
        '26', '30', '31', '80',
    ];

    /**
     * Return a valid company registration number.
     *
     * @return string
     */
    public function companyNumber()
    {
        return sprintf(
            '%s/%s/%s',
            \FakerPress\ThirdParty\Faker\Provider\DateTime::dateTimeBetween('-50 years', 'now')->format('Y'),
            static::randomNumber(6, true),
            static::randomElement(static::$legalEntities),
        );
    }
}
