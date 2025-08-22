<?php

declare(strict_types=1);

namespace FakerPress\ThirdParty\Faker\Container;

use FakerPress\ThirdParty\Psr\Container\ContainerExceptionInterface;

/**
 * @experimental This class is experimental and does not fall under our BC promise
 */
final class ContainerException extends \RuntimeException implements ContainerExceptionInterface
{
}
