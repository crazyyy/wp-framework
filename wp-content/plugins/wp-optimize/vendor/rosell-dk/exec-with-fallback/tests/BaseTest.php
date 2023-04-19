<?php
namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public $className = '';
    public $supportsResultCode = true;

    public function checkAvailability()
    {
        $this->assertEquals(0, 0);    // to awoid warnings about risky tests
        return $this->isAvailable();
    }

    public function isAvailable()
    {
        $this->assertEquals(0, 0);
        return function_exists('exec');
    }

    public function runExec($command, &$output = null, &$result_code = null)
    {
        return exec($command, $output, $result_code);
    }


    /*
    Doesn't work with ProcOpen
    public function testDevNull()
    {
        $output = [];
        $execResult = $this->runExec('ls 1>/dev/null', $output, $result_code);
        $this->assertEquals(0, $result_code);
        $this->assertEquals(0, count($output));
        $this->assertEquals('', $execResult);
    }
    */


    public function testNoReturnCodeSupplied()
    {
        if ($this->checkAvailability()) {
            $output = [];
            $execResult = $this->runExec('echo hi', $output);

            $this->assertEquals('hi', $execResult);
        }
    }

    public function testNoOutputSupplied()
    {
        if ($this->checkAvailability()) {
            $result = $this->runExec('echo hi');
            $this->assertEquals('hi', $result);
        }
    }

    /*
    TODO: enable this test in PHP 8
    public function testNoOutputSuppliedButReturnCodeIs()
    {
        if ($this->checkAvailability()) {
            //$result = $this->runExec('echo hi', null, $result_code);
            //$result = exec('echo hi', null, $result_code);
            // https://stackoverflow.com/questions/1066625/how-would-i-skip-optional-arguments-in-a-function-call
            //$result = exec(command:'echo hi', result_code:$result_code);
            $result = $this->runExec(command:'echo hi', result_code:$result_code);

            $this->assertEquals('hi', $result);
            $this->assertSame(0, $result_code);
        }
    }
    */

    public function testTwoLines()
    {
        if ($this->checkAvailability()) {
            if ($this->supportsResultCode) {
                $result = $this->runExec('echo hi && echo world', $output, $result_code);
                $this->assertEquals(0, $result_code);
            } else {
                $result = $this->runExec('echo hi && echo world', $output);
            }
            $this->assertEquals('world', $result);
            $this->assertEquals(count($output), 2, print_r($output, true));
            $this->assertEquals('hi', trim($output[0]));  // "hi " on windows, using exec()
            $this->assertEquals('world', $output[1]);
        }
    }

    public function testWhiteSpace()
    {
        if ($this->checkAvailability()) {
            if ($this->supportsResultCode) {
                $result = $this->runExec('echo " hi " && echo " world "', $output, $result_code);
            } else {
                $result = $this->runExec('echo " hi " && echo " world "', $output);
            }
            $this->assertThat(
                $result,
                $this->logicalOr(
                    $this->identicalTo(' world'),     // Linux
                    $this->identicalTo('" world "')   // Windows
                )
            );
            $this->assertThat(
                $output,
                $this->logicalOr(
                    $this->equalTo([' hi', ' world']),     // Linux
                    $this->identicalTo(['" hi "', '" world "'])   // Windows
                )
            );
        }
    }

    public function testNoOutput()
    {
        if ($this->checkAvailability()) {
            $result = $this->runExec('echo hi 1>/dev/null', $output);
            $this->assertSame('', $result);
        }
    }

    public function testStdErrPipedToStdOut()
    {
        if ($this->checkAvailability()) {
            $result = $this->runExec('echo hi && aoeuaoeuaoeu 2>&1', $output);
            $this->assertTrue(count($output) > 1);
        }
    }

    public function testOutputIsInt()
    {
        if ($this->checkAvailability()) {
            $output = 10;

            if ($this->supportsResultCode) {
                $result = $this->runExec('echo hi', $output, $result_code);
                $this->assertEquals(0, $result_code);
            } else {
                $result = $this->runExec('echo hi', $output);
            }
            $this->assertSame('hi', $result);
            $this->assertEquals('array', gettype($output));
            $this->assertSame($output[0], 'hi');
        }
    }

    public function testOutputIsString()
    {
        if ($this->checkAvailability()) {
            $output = 'abc';
            if ($this->supportsResultCode) {
                $result = $this->runExec('echo hi', $output, $result_code);
                $this->assertEquals(0, $result_code);
            } else {
                $result = $this->runExec('echo hi', $output);
            }
            $this->assertEquals('hi', $result);
            $this->assertEquals('array', gettype($output));
            $this->assertEquals('hi', $output[0]);
        }
    }

    public function testOutputIsExistingArray()
    {
        if ($this->checkAvailability()) {
            $output = ['abc'];

            if ($this->supportsResultCode) {
                $result = $this->runExec('echo hi', $output, $result_code);
                $this->assertEquals(0, $result_code);
            } else {
                $result = $this->runExec('echo hi', $output);
            }
            $this->assertEquals('hi', $result);
            $this->assertEquals('array', gettype($output));
            $this->assertEquals('abc', $output[0]);
            $this->assertEquals('hi', $output[1]);
        }
    }

    public function testUnknownCommand()
    {
        if ($this->checkAvailability()) {
            if ($this->supportsResultCode) {
                $result = $this->runExec('aoebuaoeu', $output, $result_code);
                $this->assertNotEquals(0, $result_code);  // 127 on linux, 1 on windows
            } else {
                $result = $this->runExec('aoebuaoeu', $output);
            }
            $this->assertEquals('', $result);
        }
    }

    public function testUnknownCommand2()
    {
        if ($this->checkAvailability()) {
            if ($this->supportsResultCode) {
                $result = $this->runExec('aoebuaoeu 2>&1', $output, $result_code);
                $this->assertNotEquals(0, $result_code);  // 127 on linux, 1 on windows
            } else {
                $result = $this->runExec('aoebuaoeu 2>&1', $output);
            }
            $this->assertSame('string', gettype($result));
            $this->assertTrue(strlen($result) > 0);
        }
    }

    public function testIsAvailable()
    {
        // The purpose of this test is merely to inform
        //echo $this->className . function_exists('proc_open') ? 'yes' : 'no';
        if ($this->isAvailable()) {
        } else {
            echo "\nNote: " . ($this->className ? $this->className : 'exec()') . ' is not tested, as it is unavailable';
        }
        $this->assertEquals(0, 0);

    }

    public function testWhenUnavailable()
    {
        if ($this->isAvailable()) {
            $this->assertEquals(0, 0);
        } else {
            $hasThrown = false;
            //$result = $this->runExec('echo "hi"', $output, $result_code);
            try {
                $result = $this->runExec('echo hi', $output, $result_code);
            } catch (\Exception $e) {
                $hasThrown = true;
            } catch (\Throwable $e) {
                $hasThrown = true;
            }
            $this->assertEquals(true, $hasThrown, "Expected it to throw when unavailable");
        }

    }

    /*
    // test wait script (only locally available...)
    public function testWaitScript()
    {
        $result = $this->runExec('wait.sh 0.1 0', $output, $result_code);
        $this->assertEquals(0, $result_code, 'wait.sh command did not return with exit code 0');
        $this->assertEquals('Sleep for 0.1 seconds', $output[0]);
        $this->assertEquals('OK', $output[1]);
    }

    // test wait script (only locally available...)
    public function testWaitScriptReturnCode2()
    {
        $result = $this->runExec('wait.sh 0.1 2', $output, $result_code);
        $this->assertEquals(2, $result_code, 'wait.sh command did not return with exit code 2');
        $this->assertEquals('NOT OK', $output[1]);
    }

    public function testWaitScriptLongWait()
    {
        $result = $this->runExec('wait.sh 5 0', $output, $result_code);
        $this->assertEquals(0, $result_code, 'wait.sh command did not return with exit code 0');
        $this->assertEquals('OK', $output[1]);
    }
*/
/*
    public function all()
    {
        $this->devNull($className);
        $this->noReturnCodeSupplied($className);
        $this->noOutputSupplied($className);
    }
*/
}
