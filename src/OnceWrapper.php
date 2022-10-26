<?php

namespace Zeus\Memoize;

use Exception;
use ReflectionException;

/**
 *
 */
class OnceWrapper implements HashInterface
{
    /**
     * @var string
     */
    private string $hash;

    /**
     * @throws ReflectionException
     */
    public function __construct(readonly private object $object)
    {
        $this->hash = $this->getObjectHash($this->object);
    }

    /**
     * @throws ReflectionException
     */
    private function getObjectHash(object $object): string
    {
        return once(static function () use ($object) {
            try {
                return serialize($object);
            } catch (Exception) {
                return spl_object_hash($object);
            }
        });
    }


    /**
     * @throws ReflectionException
     */
    public function __call(string $method, array $parameters)
    {
        $this->hash = $this->createHash($method, $parameters);
        $cache = new Cache($this);
        if (!$cache->exists()) {
            $cache->set($this->object->$method(...$parameters));
        }
        return $cache->get();
    }

    /**
     * @throws ReflectionException
     */
    private function createMethodHash(string $method, array $parameters): string
    {
        $string = (string)null;
        $string .= $method;
        foreach ($parameters as $argument) {
            if (is_object($argument)) {
                $string .= $this->getObjectHash($argument);
                continue;
            }
            $string .= serialize($argument);
        }
        return $string;
    }

    /**
     * @throws ReflectionException
     */
    private function createHash(string $method, array $parameters): string
    {
        $methodHash = $this->createMethodHash($method, $parameters);
        $objectHash = $this->getObjectHash($this->object);
        return md5(sprintf(
            '%s.%s',
            $objectHash,
            $methodHash
        ));
    }


    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }
}
