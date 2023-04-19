<?php
namespace ExecWithFallback;

class ExecWithFallbackWithSetMethods extends ExecWithFallback
{

    public static function setMethods($methods)
    {
        self::$methods = $methods;
    }

    public static function resetMethods()
    {
        self::$methods = ['exec', 'passthru', 'popen', 'proc_open', 'shell_exec'];
    }
}

namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;
use ExecWithFallback\ExecWithFallback;
use ExecWithFallback\ExecWithFallbackWithSetMethods;


class ExecWithFallbackTest extends BaseTest
{
    public $className = 'ExecWithFallback';

    public function isAvailable()
    {
        return
            ExecWithFallback::functionEnabled('exec') ||
            ExecWithFallback::functionEnabled('proc_open') ||
            ExecWithFallback::functionEnabled('passthru') ||
            ExecWithFallback::functionEnabled('popen') ||
            ExecWithFallback::functionEnabled('shell_exec');
    }

    public function runExec($command, &$output = null, &$result_code = null)
    {
        return ExecWithFallback::exec($command, $output, $result_code);
    }

    public function testFunctionEnabled()
    {
        $this->assertTrue(ExecWithFallback::functionEnabled('function_exists'));
        $this->assertFalse(ExecWithFallback::functionEnabled('atoehutaoeut'));

        $d = ini_get('disable_functions');
        if (function_exists('ini_set') && ini_set('disable_functions', 'passthru')) {
            $this->assertFalse(ExecWithFallback::functionEnabled('passthru'));
            ini_set('disable_functions', $d);
        }
        $d = ini_get('suhosin.executor.func.blacklist');
        if (function_exists('ini_set') && ini_set('suhosin.executor.func.blacklist', 'passthru')) {
            $this->assertFalse(ExecWithFallback::functionEnabled('passthru'));
            ini_set('suhosin.executor.func.blacklist', $d);
        }
    }

    public function testRunExec()
    {
        if (ExecWithFallback::functionEnabled('exec')) {
            $result = ExecWithFallback::runExec('exec', 'echo hi');
            $this->assertEquals('hi', $result);
        } elseif (ExecWithFallback::functionEnabled('passthru')) {
              $result = ExecWithFallback::runExec('passthru', 'echo hi');
              $this->assertEquals('hi', $result);
        } else {
            $this->assertTrue(true);
        }

        /*
        if (ExecWithFallback::functionEnabled('shell_exec')) {
            $result = ExecWithFallback::runExec('shell_exec', 'echo hi', $output, $result_code);
            $this->assertFalse($result);
        }*/
    }

    public function testAnyMethodAvailable()
    {
        $methods = ['exec', 'passthru', 'popen', 'proc_open', 'shell_exec'];
        $anyAvailable = false;
        $anyOtherThanShellExecAvailable = false;
        foreach ($methods as $method) {
            if (ExecWithFallback::functionEnabled($method)) {
                $anyAvailable = true;
                if ($method != 'shell_exec') {
                    $anyOtherThanShellExecAvailable = true;
                }
            }
        }

        $this->assertSame($anyAvailable, ExecWithFallback::anyAvailable(false));
        $this->assertSame($anyOtherThanShellExecAvailable, ExecWithFallback::anyAvailable(true));
        $this->assertSame($anyOtherThanShellExecAvailable, ExecWithFallback::anyAvailable());
    }

    public function testExec()
    {
        if (ExecWithFallback::anyAvailable()) {
            $result = ExecWithFallback::exec('echo hi', $output);
            $this->assertSame('hi', $result);
        } else {
            $exceptionThrown = true;
            try {
                $result = ExecWithFallback::exec('echo hi', $output);
            } catch (\Exception $e) {
                $exceptionThrown = true;
            }
            $this->assertTrue($exceptionThrown);
        }

    }

    public function testExecNoMethods()
    {
        ExecWithFallbackWithSetMethods::setMethods([]);
        $exceptionThrown = true;
        try {
            $result = ExecWithFallbackWithSetMethods::exec('echo hi', $output);
        } catch (\Exception $e) {
            $exceptionThrown = true;
        }
        ExecWithFallbackWithSetMethods::resetMethods();
        $this->assertTrue($exceptionThrown);
    }

    public function testExecOnlyShellExec()
    {
        ExecWithFallbackWithSetMethods::setMethods(['shell_exec']);
        $exceptionThrown = false;
        try {
            // shell_exec cannot be used with 3 arguments, so an exception is expected
            $result = ExecWithFallbackWithSetMethods::exec('echo hi', $output, $result_code);
        } catch (\Exception $e) {
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);

        if (ExecWithFallback::functionEnabled('shell_exec')) {
            // shell_exec works with 2 arguments, so no exception is expected
            $result = ExecWithFallbackWithSetMethods::exec('echo hm', $output);
            $this->assertSame('hm', $result);
        }
        ExecWithFallbackWithSetMethods::resetMethods();
    }

    public function testExecOnlyPassthru()
    {
        ExecWithFallbackWithSetMethods::setMethods(['passthru']);
        if (ExecWithFallback::functionEnabled('passthru')) {
            // shell_exec works with 2 arguments, so no exception is expected
            $result = ExecWithFallbackWithSetMethods::exec('echo hi', $output);
            $this->assertSame('hi', $result);
        }
        ExecWithFallbackWithSetMethods::resetMethods();
    }


    /**
     * This may throw FATAL! (but does not do in any of the systems in our CI)
     */
    public function testExecNoMercyNoMethods()
    {
        ExecWithFallbackWithSetMethods::setMethods([]);

        $exceptionThrown = false;
        try {
            $result = ExecWithFallbackWithSetMethods::exec('echo hi', $output);
        } catch (\Exception $e) {
            $exceptionThrown = true;
        } catch (\Error $e) {
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
        ExecWithFallbackWithSetMethods::resetMethods();
    }


}
