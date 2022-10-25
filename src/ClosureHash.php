<?php

namespace Zeus\Memoize;

use Closure;
use Exception;
use ReflectionException;
use ReflectionFunction;

/**
 *
 */
class ClosureHash implements HashInterface
{
    /**
     * @var ReflectionFunction
     */
    private ReflectionFunction $reflection;

    /**
     * @throws ReflectionException
     */
    public function __construct(Closure $closure)
    {
        $this->reflection = new ReflectionFunction($closure);
    }


    /**
     * @return string
     */
    public function getHash(): string
    {
        return md5(
            sprintf(
                '%s.%d.%s',
                $this->getFileName(),
                $this->getEndLine(),
                $this->useVariablesToString()
            )
        );
    }

    /**
     * @return string
     */
    private function useVariablesToString(): string
    {
        $string = (string)null;
        foreach ($this->getUseVariables() as $useVariable) {
            if (is_object($useVariable)) {
                $string .= $this->objectToString($useVariable);
                continue;
            }
            $string .= serialize($useVariable);
        }
        return $string;
    }

    /**
     * @param object $object
     * @return string
     */
    private function objectToString(object $object): string
    {
        try {
            return serialize($object);
        } catch (Exception) {
            return spl_object_hash($object);
        }
    }

    /**
     * @return array
     */
    private function getUseVariables(): array
    {
        return $this->reflection->getClosureUsedVariables();
    }

    /**
     * @return int
     */
    private function getEndLine(): int
    {
        return $this->reflection->getEndLine();
    }

    /**
     * @return string
     */
    private function getFileName(): string
    {
        return $this->reflection->getFileName();
    }
}
