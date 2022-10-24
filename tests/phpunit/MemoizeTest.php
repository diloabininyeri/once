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
            sleep(1);
            return random_int(1, 4500);
        };

        $first = once($closure);
        foreach (range(1, 100) as $item) {
            $this->assertEquals($first, once($closure));
        }
    }
}
