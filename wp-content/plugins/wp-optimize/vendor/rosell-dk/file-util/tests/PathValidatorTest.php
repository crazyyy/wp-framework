<?php

namespace FileUtil\Tests;

use PHPUnit\Framework\TestCase;
use FileUtil\PathValidator;
use org\bovigo\vfs\vfsStream;

class PathValidatorTest extends TestCase
{
    public function testFilenameNotString()
    {
        $this->expectException(\Exception::class);
        PathValidator::checkPath(10);
        //$this->mimeSniff(10);
    }

    public function testFilenameHasNULChar()
    {
        $this->expectException(\Exception::class);
        PathValidator::checkPath("a\0");
    }
    public function testFilenameHasControlChars()
    {
        $this->expectException(\Exception::class);
        PathValidator::checkPath("..\1..");
    }

    public function testFilenameIsEmpty()
    {
        $this->expectException(\Exception::class);
        PathValidator::checkPath("");
    }

    public function testFilenameIsPhar()
    {
        $this->expectException(\Exception::class);
        PathValidator::checkPath('phar://aoeu');
    }

    public function testFileNotFound()
    {
       // why does this fail in PHP 7.2 ? (Uninitialized string offset: 0)
        $this->expectException(\Exception::class);
        PathValidator::checkFilePathIsRegularFile(__DIR__ . '/images/no-such-file.jpg');
    }
    public function testFileIsDir()
    {
        $this->expectException(\Exception::class);
        PathValidator::checkFilePathIsRegularFile(__DIR__ . '/images');
    }

    public function testFileOnWebNotFound()
    {
       // why does this fail in PHP 7.2 ? (Uninitialized string offset: 0)
        $this->expectException(\Exception::class);
        PathValidator::checkFilePathIsRegularFile('http://aoeuhtaoeu.eau');
    }

    public function testPhPStreamWrapper()
    {
        $this->expectException(\Exception::class);
        PathValidator::checkFilePathIsRegularFile('php://input');
    }
}
