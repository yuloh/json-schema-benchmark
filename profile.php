<?php

require __DIR__ . '/vendor/autoload.php';

/**
 * This script is for profiling with blackfire.
 * Just call it with the name of the function name
 * for the library you want to test, i.e.
 * `blackfire --samples 100 run php profile.php yuloh`
 */

bench_draft4_meta($argv[1]);
