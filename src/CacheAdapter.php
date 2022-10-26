<?php

namespace Zeus\Memoize;

use Closure;

/**
 *
 */
interface CacheAdapter
{
    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool;

    /**
     * @return bool
     */
    public function get(string $key): mixed;

    /**
     * @param string $key
     * @param mixed $content
     * @return void
     */
    public function set(string $key, mixed $content): void;
}
