<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Faker\ORM\Mandango;

use FakerPress\ThirdParty\Faker\Provider\Base;
use Mandango\Mandango;

/**
 * Service class for populating a table through a Mandango ActiveRecord class.
 */
class EntityPopulator
{
    protected $class;
    protected $columnFormatters = [];

    /**
     * @param string $class A Mandango ActiveRecord classname
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    public function setColumnFormatters($columnFormatters)
    {
        $this->columnFormatters = $columnFormatters;
    }

    /**
     * @return array
     */
    public function getColumnFormatters()
    {
        return $this->columnFormatters;
    }

    public function mergeColumnFormattersWith($columnFormatters)
    {
        $this->columnFormatters = array_merge($this->columnFormatters, $columnFormatters);
    }

    /**
     * @return array
     */
    public function guessColumnFormatters(\FakerPress\ThirdParty\Faker\Generator $generator, Mandango $mandango)
    {
        $formatters = [];
        $nameGuesser = new \FakerPress\ThirdParty\Faker\Guesser\Name($generator);
        $columnTypeGuesser = new \FakerPress\ThirdParty\Faker\ORM\Mandango\ColumnTypeGuesser($generator);

        $metadata = $mandango->getMetadata($this->class);

        // fields
        foreach ($metadata['fields'] as $fieldName => $field) {
            if ($formatter = $nameGuesser->guessFormat($fieldName)) {
                $formatters[$fieldName] = $formatter;

                continue;
            }

            if ($formatter = $columnTypeGuesser->guessFormat($field)) {
                $formatters[$fieldName] = $formatter;

                continue;
            }
        }

        // references
        foreach (array_merge($metadata['referencesOne'], $metadata['referencesMany']) as $referenceName => $reference) {
            if (!isset($reference['class'])) {
                continue;
            }
            $referenceClass = $reference['class'];

            $formatters[$referenceName] = static function ($insertedEntities) use ($referenceClass) {
                if (isset($insertedEntities[$referenceClass])) {
                    return Base::randomElement($insertedEntities[$referenceClass]);
                }

                return null;
            };
        }

        return $formatters;
    }

    /**
     * Insert one new record using the Entity class.
     */
    public function execute(Mandango $mandango, $insertedEntities)
    {
        $metadata = $mandango->getMetadata($this->class);

        $obj = $mandango->create($this->class);

        foreach ($this->columnFormatters as $column => $format) {
            if (null !== $format) {
                $value = is_callable($format) ? $format($insertedEntities, $obj) : $format;

                if (isset($metadata['fields'][$column])
                    || isset($metadata['referencesOne'][$column])) {
                    $obj->set($column, $value);
                }

                if (isset($metadata['referencesMany'][$column])) {
                    $adder = 'add' . ucfirst($column);
                    $obj->$adder($value);
                }
            }
        }
        $mandango->persist($obj);

        return $obj;
    }
}
