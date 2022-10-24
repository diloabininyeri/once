<?php


use PHPUnit\Framework\TestCase;

use function Zeus\Memoize\once;

class MemoizeTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testOnce(): void
    {
        /**
         * @throws Exception
         */
        $closure = function () {
            return random_int(1, 4500);
        };

        $first = once($closure);
        foreach (range(1, 10) as $item) {
            $this->assertEquals($first, once($closure));
        }
    }
}
