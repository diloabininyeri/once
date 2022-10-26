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
     */
    public function __construct(readonly private object $object)
    {
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
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
    private function createHash(string $method, array $parameters): string
    {
        return md5(sprintf(
            '%s.%s',
            $this->getObjectHash($this->object),
            $this->createMethodHash($method, $parameters)
        ));
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
    private function createMethodHash(string $method, array $parameters): string
    {
        $string = (string)null;
        $string .= $method;
        foreach ($parameters as $parameter) {
            if (is_object($parameter)) {
                $string .= $this->getObjectHash($parameter);
                continue;
            }
            $string .= serialize($parameter);
        }
        return $string;
    }
}
