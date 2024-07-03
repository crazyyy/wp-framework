<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace FakerPress\ThirdParty\Faker\Container;

use FakerPress\ThirdParty\Faker\Core;
use FakerPress\ThirdParty\Faker\Extension;

/**
 * @experimental This class is experimental and does not fall under our BC promise
 */
final class ContainerBuilder
{
    /**
     * @var array<string, callable|object|string>
     */
    private array $definitions = [];

    /**
     * @param callable|object|string $definition
     *
     * @throws \InvalidArgumentException
     */
    public function add(string $id, $definition): self
    {
        if (!is_string($definition) && !is_callable($definition) && !is_object($definition)) {
            throw new \InvalidArgumentException(sprintf(
                'First argument to "%s::add()" must be a string, callable or object.',
                self::class,
            ));
        }

        $this->definitions[$id] = $definition;

        return $this;
    }

    public function build(): ContainerInterface
    {
        return new Container($this->definitions);
    }

    private static function defaultExtensions(): array
    {
        return [
            Extension\BarcodeExtension::class => Core\Barcode::class,
            Extension\BloodExtension::class => Core\Blood::class,
            Extension\ColorExtension::class => Core\Color::class,
            Extension\DateTimeExtension::class => Core\DateTime::class,
            Extension\FileExtension::class => Core\File::class,
            Extension\NumberExtension::class => Core\Number::class,
            Extension\UuidExtension::class => Core\Uuid::class,
            Extension\VersionExtension::class => Core\Version::class,
        ];
    }

    public static function withDefaultExtensions(): self
    {
        $instance = new self();

        foreach (self::defaultExtensions() as $id => $definition) {
            $instance->add($id, $definition);
        }

        return $instance;
    }
}
