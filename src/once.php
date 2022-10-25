<?php

namespace Zeus\Memoize;

use Closure;
use ReflectionException;

/**
 * @throws ReflectionException
 */
function once(Closure $closure): mixed
{
    return  (new Cache(new ClosureHash($closure)))->remember($closure);
}
