<?php

namespace FileUtil\Tests;

use PHPUnit\Framework\TestCase;
use FileUtil\FileExistsUsingExec;

class FileExistsUsingExecTest extends TestCase
{
    public function testFileExists()
    {
        if (function_exists('exec')) {
            $this->assertTrue(FileExistsUsingExec::fileExists(__DIR__ . '/FileExistsTest.php'));
            $this->assertFalse(FileExistsUsingExec::fileExists(__DIR__ . '/not-here.php'));
        }
    }

}
