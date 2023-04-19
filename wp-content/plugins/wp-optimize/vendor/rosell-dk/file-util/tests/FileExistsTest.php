<?php

namespace FileUtil\Tests;

use PHPUnit\Framework\TestCase;
use FileUtil\FileExists;
use org\bovigo\vfs\vfsStream;

class FileExistsTest extends TestCase
{
    public function testFileExists()
    {
        $this->assertTrue(FileExists::fileExists(__DIR__ . '/FileExistsTest.php'));
        $this->assertFalse(FileExists::fileExists(__DIR__ . '/not-here.php'));
    }

    public function testFileExistsTryHarder()
    {
        if (function_exists('exec')) {
            $this->assertTrue(FileExists::fileExistsTryHarder(__DIR__ . '/FileExistsTest.php'));
            $this->assertFalse(FileExists::fileExistsTryHarder(__DIR__ . '/not-here.php'));
        }
    }


    /*
    public function testFileExistsNoReadPermission()
    {
        $root = vfsStream::setup();
        $file = vfsStream::newFile('hello.txt')
            ->withContent('hello')
            ->at($root)
            ->chmod(0000);

        // fopen should now fail...
        //$this->expectException(\Exception::class);
        $this->assertTrue(FileExists::fileExists($file->url()));
    }
    */
}
