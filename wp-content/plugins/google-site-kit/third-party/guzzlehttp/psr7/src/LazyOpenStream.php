<?php

declare (strict_types=1);
namespace Google\Site_Kit_Dependencies\GuzzleHttp\Psr7;

use Google\Site_Kit_Dependencies\Psr\Http\Message\StreamInterface;
/**
 * Lazily reads or writes to a file that is opened only after an IO operation
 * take place on the stream.
 */
final class LazyOpenStream implements \Google\Site_Kit_Dependencies\Psr\Http\Message\StreamInterface
{
    use StreamDecoratorTrait;
    /** @var string */
    private $filename;
    /** @var string */
    private $mode;
    /**
     * @var StreamInterface
     */
    private $stream;
    /**
     * @param string $filename File to lazily open
     * @param string $mode     fopen mode to use when opening the stream
     */
    public function __construct(string $filename, string $mode)
    {
        $this->filename = $filename;
        $this->mode = $mode;
        // unsetting the property forces the first access to go through
        // __get().
        unset($this->stream);
    }
    /**
     * Creates the underlying stream lazily when required.
     */
    protected function createStream() : \Google\Site_Kit_Dependencies\Psr\Http\Message\StreamInterface
    {
        return \Google\Site_Kit_Dependencies\GuzzleHttp\Psr7\Utils::streamFor(\Google\Site_Kit_Dependencies\GuzzleHttp\Psr7\Utils::tryFopen($this->filename, $this->mode));
    }
}
