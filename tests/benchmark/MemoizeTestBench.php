<?php

use function Zeus\Memoize\once;

class MemoizeTestBench
{
    #[\PhpBench\Attributes\Iterations(2)]
    /**
     * @return void
     *
     */
    public function benchMemoize(): void
    {
        $closure = function () {
            sleep(1);
            return true;
        };

        $testOnce = new \Zeus\Memoize\TestOnce();
        $testOnce->foo($closure);
    }
}
