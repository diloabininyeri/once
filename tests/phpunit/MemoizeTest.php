<?php


use PHPUnit\Framework\TestCase;

use function Zeus\Memoize\once;

class MemoizeTest extends TestCase
{
    /**
     * @test
     * @return void
     * @throws ReflectionException
     *
     */
    public function mainOnce(): void
    {
        /**
         * @throws Exception
         */
        $closure = function () {
            return random_int(1, 4500);
        };

        $first = once($closure);
        foreach (range(1, 10) as $item) {
            $this->assertEquals($first, once($closure));
        }
    }


    /**
     * @test
     * @throws ReflectionException
     */
    public function useVariables(): void
    {
        $anonymous = new class () {
            public string $name = 'test';
        };

        $array = ['name' => 'ff'];
        /**
         * @throws Exception
         */
        $closure = static function () use ($anonymous, $array) {
            return random_int(1, 100) . $anonymous->name . $array['name'];
        };

        $first = once($closure);
        foreach (range(1, 10) as $item) {
            $this->assertEquals($first, once($closure));
        }
    }


    /**
     * @test
     * @return void
     * @throws ReflectionException
     */
    public function handleUSeVariablesChanged(): void
    {
        $anonymous = new class () {
            public string $name = 'test';
        };

        $array = ['name' => 'ff'];
        /**
         * @throws Exception
         */
        $closure = static function () use ($anonymous, &$array) {
            return random_int(1, 100) . $anonymous->name . $array['name'];
        };

        $first = once($closure);
        $array['name'] = 'changed';
        $second = once($closure);
        $this->assertNotEquals($second, $first);

        $array['name'] = 'ff';
        $third = once($closure);

        $this->assertEquals($first, $third);
        $this->assertNotEquals($second, $third);
    }


    /**
     * @test
     * @return void
     * @throws ReflectionException@
     */
    public function withObject():void
    {
        $random = new  Random();

        $closure = function () use ($random) {
            return $random->getInteger(1,100);
        };

        $first = once($closure);
        foreach (range(1,10) as $item) {
            $this->assertEquals($first,once($closure));

        }
    }
}
