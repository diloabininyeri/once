<?php



class Random
{
    /**
     * @throws Exception
     */
    public function getInteger(int $start, int $end): int
    {
        return random_int($start, $end);
    }
}
