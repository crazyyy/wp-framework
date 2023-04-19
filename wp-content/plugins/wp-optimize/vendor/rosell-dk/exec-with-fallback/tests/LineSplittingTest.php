<?php
namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;

class LineSplittingTest extends TestCase
{

    public function splitLines($text)
    {
        //return preg_split('/\r\n|\r|\n/', $text);
        //return preg_split("/\\n\\r|\\r\\n|\\n|\\r/", $text);
        //return preg_split('/\n\r|\r\n|\n|\r/', $text);
        return preg_split('/\r\n|\n\r|\n|\r/', $text);
    }

    public function splitLinesNoEmpty($text)
    {
        //return preg_split('/\r\n|\r|\n/', $text);
        //return preg_split("/\\n\\r|\\r\\n|\\n|\\r/", $text);
        //return preg_split('/\n\r|\r\n|\n|\r/', $text);
        return preg_split('/[\r\n]+/', $text);
    }


    public function testLineSplitting()
    {
        $this->assertEquals(['one', 'two', 'three'], $this->splitLines("one\r\ntwo\r\nthree"));
        $this->assertEquals(['one', 'two', 'three'], $this->splitLines("one\ntwo\nthree"));
        $this->assertEquals(['one', 'two', 'three'], $this->splitLines("one\rtwo\rthree"));
        $this->assertEquals(['one', '', 'two', 'three'], $this->splitLines("one\n\ntwo\nthree"));
        $this->assertEquals(['one', '', 'two', '', 'three'], $this->splitLines("one\r\n\ntwo\n\r\nthree"));

        // the unusual \n\r sequence
        $this->assertEquals(['one', 'two', 'three'], $this->splitLines("one\n\rtwo\n\rthree"));
        $this->assertEquals(['one', '', 'two', '', 'three'], $this->splitLines("one\n\r\ntwo\n\n\rthree"));
    }

    public function testLineSplittingNoEmpty()
    {
        $this->assertEquals(['one', 'two', 'three'], $this->splitLinesNoEmpty("one\r\ntwo\r\nthree"));
        $this->assertEquals(['one', 'two', 'three'], $this->splitLinesNoEmpty("one\ntwo\nthree"));
        $this->assertEquals(['one', 'two', 'three'], $this->splitLinesNoEmpty("one\rtwo\rthree"));
        $this->assertEquals(['one', 'two', 'three'], $this->splitLinesNoEmpty("one\n\ntwo\nthree"));
        $this->assertEquals(['one', 'two', 'three'], $this->splitLinesNoEmpty("one\r\n\ntwo\n\r\nthree"));

        // the unusual \n\r sequence
        $this->assertEquals(['one', 'two', 'three'], $this->splitLinesNoEmpty("one\n\rtwo\n\rthree"));
        $this->assertEquals(['one', 'two', 'three'], $this->splitLinesNoEmpty("one\n\r\ntwo\n\n\rthree"));
    }
}
