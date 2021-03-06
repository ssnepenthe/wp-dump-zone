<?php

use DumpZone\DumpZone;

if (! function_exists('dz')) {
    function dz($var, ...$moreVars)
    {
        DumpZone::dump($var);

        foreach ($moreVars as $v) {
            DumpZone::dump($v);
        }

        if (1 < \func_num_args()) {
            return \func_get_args();
        }

        return $var;
    }
}
