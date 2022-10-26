<?php

namespace Zeus\Memoize;

use Exception;
use ReflectionException;

/**
 *
 */
class OnceWrapper
{
    private ?CacheAdapter $cacheAdapter = null;

    public function __construct(readonly private object $object)
    {
    }

    /**
     * @throws ReflectionException
     */
    public function __call(string $method, array $parameters)
    {
        $hash = $this->createHash($method, $parameters);
        $cache = new Cache($hash);
        if ($this->cacheAdapter === null) {
            if (!$cache->exists()) {
                $cache->set($this->object->$method(...$parameters));
            }
            return $cache->get();
        }

        return $this->getCacheFromAdapter($hash->getHash(), $method, $parameters);
    }

    /**
     */
    private function createHash(string $method, array $parameters): Hash
    {
        return (new MethodHash())
            ->setObject($this->object)
            ->setMethod($method)
            ->setParameters($parameters);
    }

    /**
     * @param CacheAdapter|null $cacheAdapter
     * @return OnceWrapper
     */
    public function setCacheAdapter(?CacheAdapter $cacheAdapter): OnceWrapper
    {
        $this->cacheAdapter = $cacheAdapter;
        return $this;
    }

    /**
     * @param string $methodHash
     * @param string $method
     * @param array $parameters
     * @return bool|mixed
     */
    public function getCacheFromAdapter(string $methodHash, string $method, array $parameters): mixed
    {
        if (!$this->cacheAdapter->exists($methodHash)) {
            $this->cacheAdapter->set($methodHash, $this->object->$method(...$parameters));
        }

        return $this->cacheAdapter->get($methodHash);
    }
}
