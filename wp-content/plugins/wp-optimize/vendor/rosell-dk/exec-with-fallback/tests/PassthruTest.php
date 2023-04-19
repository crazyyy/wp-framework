<?php
namespace ExecWithFallback\Tests;

use ExecWithFallback\Passthru;

use PHPUnit\Framework\TestCase;


class PassthruTest extends BaseTest
{

    public $className = 'Passthru';

    public function isAvailable()
    {
        return function_exists('passthru');
    }

    public function runExec($command, &$output = null, &$result_code = null)
    {
        return Passthru::exec($command, $output, $result_code);
    }
}
