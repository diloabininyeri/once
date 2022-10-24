<?php

namespace Zeus\Memoize;

use Closure;
use ReflectionException;

/**
 * @throws ReflectionException
 */
function once(Closure $closure): mixed
{
    $cache = new Cache(new ClosureHash($closure));

    if (!$cache->exists()) {
        $cache->set($closure());
    }
    return $cache->get();
}
