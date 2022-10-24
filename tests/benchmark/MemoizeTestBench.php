<?php

use function Zeus\Memoize\once;

class MemoizeTestBench
{
    /**
     * @throws ReflectionException
     */
    #[\PhpBench\Attributes\Iterations(2)]
    public function benchMemoize(): void
    {
        once($this->getClosure());
    }

    /**
     * @throws ReflectionException
     */
    #[\PhpBench\Attributes\Sleep(2),\PhpBench\Attributes\Iterations(2)]
    public function benchMemoizeWithSleep(): void
    {
        once($this->getClosure());
    }

    /**
     * @return Closure
     */
    public function getClosure(): Closure
    {
        return static function () {
            sleep(1);
            return true;
        };
    }
}
