<?php

require __DIR__ . '/vendor/autoload.php';

use Lavoiesl\PhpBenchmark\Benchmark;

declare(ticks=1);

$benchmark = new Benchmark();

$benchmark->add('yuloh', function () {
    run_tests('yuloh');
});
$benchmark->add('justin-rainbow', function () {
    run_tests('justin_rainbow');
});

$benchmark->run();
