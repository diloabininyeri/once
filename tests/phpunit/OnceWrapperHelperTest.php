<?php

namespace phpunit;

use PHPUnit\Framework\TestCase;
use Random;
use function Zeus\Memoize\once_wrapper;

class OnceWrapperHelperTest extends TestCase
{


    /**
     * @test
     * @return void
     */
    public function globalFunction(): void
    {
        $first = once_wrapper(new Random())->getInteger(1, 100);
        foreach (range(1,100) as $item) {

            $randomInt = once_wrapper(new Random())->getInteger(1, 100);
            $this->assertEquals($first, $randomInt);
        }
    }
}