<?php

namespace Zeus\Memoize;

use Exception;
use ReflectionException;

/**
 *
 */
class OnceWrapper
{
    public function __construct(readonly private object $object)
    {
    }

    /**
     * @throws ReflectionException
     */
    public function __call(string $method, array $parameters)
    {
        $cache = new Cache($this->createHash($method, $parameters));
        if (!$cache->exists()) {
            $cache->set($this->object->$method(...$parameters));
        }
        return $cache->get();
    }

    /**
     */
    private function createHash(string $method, array $parameters): HashInterface
    {
        return (new MethodHash())
            ->setObject($this->object)
            ->setMethod($method)
            ->setParameters($parameters);
    }
}
