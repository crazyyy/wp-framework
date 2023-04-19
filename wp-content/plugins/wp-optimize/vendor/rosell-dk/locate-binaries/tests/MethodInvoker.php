<?php

namespace LocateBinaries\Tests;

class MethodInvoker
{
    public static function invoke($object, string $methodName, array $args=[]) {
        $privateMethod = self::getMethod(get_class($object), $methodName);

        return $privateMethod->invokeArgs($object, $args);
    }

    private static function getMethod(string $className, string $methodName) {
        $class = new \ReflectionClass($className);

        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }
}
