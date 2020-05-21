<?php

namespace Src;

class MyLogger {
    public static $memoryLog = [];

    public static function logCurrentMemory()
    {
        $currentMemoryUsage = memory_get_usage();
        $currentTime = date('Y.m.d:H.i.s');
        self::$memoryLog[] = [
            "memoryUse" => $currentMemoryUsage,
            "currentDateTime" => $currentTime
        ];

        return end(self::$memoryLog);
    }

    /*
     * @param int $step Number of steps to go back. E.g. 1 compares to
     * previous measure.
    */
    public static function displayMemoryDifference(int $step)
    {
        $currentMemoryUsage = self::logCurrentMemory();
        $previousMemoryUsage = self::$memoryLog[count(self::$memoryLog) - ($step + 1)];
        $difference = $currentMemoryUsage["memoryUse"] - $previousMemoryUsage["memoryUse"];
        return "Memory usage changed by $difference bytes since $step measure";
    }
}