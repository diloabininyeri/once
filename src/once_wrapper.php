<?php


namespace Zeus\Memoize;

/**
 * @template  T
 * @param object<T> $object
 * @return object<T>
 */
function once_wrapper(object $object): object
{
    return new OnceWrapper($object);
}