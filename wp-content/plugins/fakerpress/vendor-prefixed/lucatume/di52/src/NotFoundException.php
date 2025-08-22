<?php

/**
 * An exception used to signal no binding was found for container ID.
 *
 * @package lucatume\DI52
 */
namespace FakerPress\ThirdParty\lucatume\DI52;

use FakerPress\ThirdParty\Psr\Container\NotFoundExceptionInterface;
/**
 * Class NotFoundException
 *
 * @package \lucatume\DI52
 */
class NotFoundException extends ContainerException implements NotFoundExceptionInterface
{
}