<?php

namespace phpunit;

use Zeus\Memoize\CacheAdapter;

/**
 *
 */
class OnceWrapperCache implements CacheAdapter
{
    /**
     * @var array
     */
    private static array $cache = [];

    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool
    {
        return isset(static::$cache[$key]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return static::$cache[$key];
    }

    /**
     * @param string $key
     * @param mixed $content
     * @return void
     */
    public function set(string $key, mixed $content): void
    {
        static::$cache[$key] = $content;
    }
}
