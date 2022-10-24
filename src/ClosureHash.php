<?php

namespace Zeus\Memoize;

use Closure;
use ReflectionException;
use ReflectionFunction;

/**
 *
 */
class ClosureHash implements HashInterface
{
    /**
     * @throws ReflectionException
     */
    public function __construct(Closure $closure)
    {
        $this->reflection = new ReflectionFunction($closure);
    }


    public function getHash(): string
    {
        return md5(
            sprintf(
                '%s.%d',
                $this->getFileName(),
                $this->getEndLine()
            )
        );
    }

    private function getEndLine(): int
    {
        return $this->reflection->getEndLine();
    }

    private function getFileName(): string
    {
        return $this->reflection->getFileName();
    }
}
