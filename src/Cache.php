<?php

namespace Zeus\Memoize;

use Closure;

/**
 *
 */
class Cache
{
    /**
     * @var array
     */
    private static array $caches = [];


    /**
     * @var string
     */
    private string $hash;


    /**
     * @param ClosureHash $closureHash
     */
    public function __construct(Hash $closureHash)
    {
        $this->hash = $closureHash->getHash();
    }

    /**
     * @return bool
     *
     */
    public function exists(): bool
    {
        return isset(static::$caches[$this->hash]);
    }

    /**
     * @return bool
     */
    public function get(): mixed
    {
        return static::$caches[$this->hash];
    }

    /**
     * @param mixed $content
     * @return void
     *
     */
    public function set(mixed $content): void
    {
        static::$caches[$this->hash] = $content;
    }

    /**
     * @param Closure $closure
     * @return mixed
     */
    public function remember(Closure $closure): mixed
    {
        if (!$this->exists()) {
            $this->set($closure());
        }
        return $this->get();
    }
}
