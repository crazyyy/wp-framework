<?php
namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;
use ExecWithFallback\Availability;

class AvailabilityTest extends TestCase
{

    public function testMethodAvailable()
    {
        $methods = ['exec', 'passthru', 'popen', 'proc_open', 'shell_exec'];
        $anyAvailable = false;
        $anyOtherThanShellExecAvailable = false;
        foreach ($methods as $method) {
            if (function_exists($method)) {
                $anyAvailable = true;
                if ($method == 'shell_exec') {
                    $this->assertTrue(Availability::methodAvailable($method, false));
                    $this->assertFalse(Availability::methodAvailable($method, true));
                    $this->assertFalse(Availability::methodAvailable($method));
                } else {
                    $anyOtherThanShellExecAvailable = true;
                    $this->assertTrue(Availability::methodAvailable($method));
                }
            } else {
                $this->assertFalse(Availability::methodAvailable($method));
            }
        }

        $this->assertSame($anyAvailable, Availability::anyAvailable(false));
        $this->assertSame($anyOtherThanShellExecAvailable, Availability::anyAvailable(true));
        $this->assertSame($anyOtherThanShellExecAvailable, Availability::anyAvailable());
    }
}
