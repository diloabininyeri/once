<?php

namespace Zeus\Memoize;

use Exception;
use ReflectionException;

/**
 *
 */
class MethodHash implements HashInterface
{
    /**
     * @var object
     */
    private readonly object $object;
    /**
     * @var string
     */
    private readonly string $method;
    /**
     * @var array
     */
    private readonly array $parameters;

    /**
     * @param object $object
     * @return $this
     */
    public function setObject(object $object): self
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;
        return $this;
    }


    /**
     * @return string
     * @throws ReflectionException
     */
    public function getHash(): string
    {
        return md5(sprintf(
            '%s.%s',
            $this->getObjectHash($this->object),
            $this->createMethodHash()
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
    private function createMethodHash(): string
    {
        $string = (string)null;
        $string .= $this->method;
        foreach ($this->parameters as $parameter) {
            if (is_object($parameter)) {
                $string .= $this->getObjectHash($parameter);
                continue;
            }
            $string .= serialize($parameter);
        }
        return $string;
    }
}
