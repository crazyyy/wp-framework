<?php

/**
 * This file is part of the Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Carbon\Exceptions;

use InvalidArgumentException as BaseInvalidArgumentException;
use Throwable;

class NotLocaleAwareException extends BaseInvalidArgumentException implements InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param mixed          $object
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($object, $code = 0, Throwable $previous = null)
    {
        $dump = \is_object($object) ? \get_class($object) : \gettype($object);

        parent::__construct("$dump does neither implements FakerPress\ThirdParty\Symfony\Contracts\Translation\LocaleAwareInterface nor getLocale() method.", $code, $previous);
    }
}
