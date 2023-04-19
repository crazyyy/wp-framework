<?php
namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;

use ExecWithFallback\ShellExec;

class ShellExecTest extends BaseTest
{

    public $className = 'ShellExec';
    public $supportsResultCode = false;

    public function isAvailable()
    {
        return function_exists('shell_exec');
    }

    public function runExec($command, &$output = null, &$result_code = null)
    {
        if (func_num_args() == 3) {
            return ShellExec::exec($command, $output, $result_code);
        } else {
            return ShellExec::exec($command, $output);
        }
    }

/*
    public function testCodeSupplied()
    {
        if ($this->checkAvailability()) {
            $output = [];
            $execResult = $this->runExec('echo hi', $output, $return_code);
            $this->assertFalse($execResult);
        }
    }*/

}
