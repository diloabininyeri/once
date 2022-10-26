<?php

namespace phpunit;

use PHPUnit\Framework\TestCase;
use Random;
use ReflectionException;
use Zeus\Memoize\OnceWrapper;

class ObjectWrapperTest extends TestCase
{
    /**
     * @test
     * @return void
     * @throws ReflectionException
     */
    public function wrapper(): void
    {
        $random = new Random();
        $once = new OnceWrapper($random);

        $first = $once->getInteger(1, 100);

        foreach (range(1, 10) as $item) {
            $this->assertEquals($first, $once->getInteger(1, 100));
        }
    }

    /**
     * @test
     * @return void
     */
    public function withAdapter():void
    {
        $random = new Random();
        $once = new OnceWrapper($random);
        $once->setCacheAdapter(new OnceWrapperCache());

        $first = $once->getInteger(1, 100);

        foreach (range(1, 10) as $item) {
            $this->assertEquals($first, $once->getInteger(1, 100));
        }
    }
}
