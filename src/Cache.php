<?php

namespace Zeus\Memoize;

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
    public function __construct(HashInterface $closureHash)
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
}
