<?php

namespace Zeus\Memoize;

class TestOnce
{
    public function foo(\Closure  $closure)
    {
        return once($closure);
    }
}
