<?php
namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{

    public function numArgs(&$arg = null)
    {
        //echo 'number of arguments:' . func_num_args();
        return func_num_args();
    }

    public function getArg0Default8(&$arg = 8)
    {
        return func_get_arg(0);
    }

    public function getArg0DefaultNull(&$arg = null)
    {
        //return $arg;
        return func_get_arg(0);
    }

    public function isArg0Set(&$arg0 = null, &$arg1 = null)
    {
        //return (func_num_args() > 0);
        $a = func_get_args();
        try {
            $b = $a[0];
        } catch (\Exception $e) {
            return false;
        } catch (\Throwable $e) {
            return false;
        }
        if (count($a) == 2) {
            return isset($a[0]);
        }
        //print_r($a);
        //echo count($a);
        return true;
        //return !is_null($arg0);
        //return isset($a[0]);
        //return count($a) > 0;
        //return isset($a[0])
        //return isset($a[0]);
    }

    public function testFuncNumArgs()
    {
        $this->assertSame(0, $this->numArgs());
        $this->assertSame(1, $this->numArgs($arg));
    }

    public function supplied($command, &$output = null, &$result_code = null)
    {
        //echo "\n" . $command . ':' . func_num_args() . "\n";

        $outputSupplied = (func_num_args() >= 2);
        $resultCodeSupplied = (func_num_args() >= 3);
        /*
        $a = func_get_args();
        //return (func_num_args() > 0);
        $outputSupplied = true;
        try {
            $o = $a[1];
        } catch (\Exception $e) {
            $outputSupplied = false;
        } catch (\Throwable $e) {
            $outputSupplied = false;
        }
        if (count($a) == 3) {
            //$outputSupplied = isset($a[1]);
        }

        $resultCodeSupplied = true;
        try {
            $r = $a[2];
        } catch (\Exception $e) {
            $resultCodeSupplied = false;
        } catch (\Throwable $e) {
            $resultCodeSupplied = false;
        }*/

        //echo $command;
        //print_r($a);

        $result = 0;
        if ($outputSupplied) $result += 1;
        if ($resultCodeSupplied) $result += 2;
        return $result;

        //return !is_null($arg0);
        //return isset($a[0]);
        //return count($a) > 0;
        //return isset($a[0])
        //return isset($a[0]);*/
    }

    public function testFuncGetArg()
    {
        $seven = 7;
        //$this->assertSame(7, $this->getArg0Default8($seven));

        /*$a=[];
        $this->assertFalse(isset($a[1]));
        $a[0] = null;
        $this->assertTrue(isset($a[1]));*/

        $this->assertSame(0, $this->supplied('only-one'));
        $this->assertSame(1, $this->supplied('two', $seven));
        $this->assertSame(3, $this->supplied('three', $seven, $seven));
        $this->assertSame(1, $this->supplied('', $yetUndefined));
        $this->assertSame(3, $this->supplied('', $yetUndefined, $yetUndefined));

        /*
        TODO: enable in PHP 8.0
        $this->assertSame(3, $this->supplied(
            command:'hi',
            output: $yetUndefined,
            result_code: $yetUndefined
        ));

        // Sorry, the two below would be better if they return 2,
        // but it seems impossible
        // So, these are handled as if $output is supplied.
        // - which means our selector will not choose system(), even though
        //   it could
        $this->assertSame(3, $this->supplied(
            command:'hi2',
            result_code: $yetUndefined
        ));
        $this->assertSame(3, $this->supplied(
            '',
            result_code: $yetUndefined
        ));
        */


        /*
        $this->assertFalse($this->isArg0Set());
        $this->assertTrue($this->isArg0Set($seven));
        $this->assertTrue($this->isArg0Set($yetUndefined));

        // PHP 8:
        $this->assertTrue($this->isArg0Set(arg0: $seven));
        $this->assertTrue($this->isArg0Set(arg0: $yetUndefined));
        $this->assertFalse($this->isArg0Set(arg1: $seven));
        */

        //$this->assertSame(null, $this->getArg0Default8($yetUndefined));
//$this->assertSame(8,9);
    }
}
