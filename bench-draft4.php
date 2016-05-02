<?php

require __DIR__ . '/vendor/autoload.php';

use Lavoiesl\PhpBenchmark\Benchmark;

declare(ticks=1);

$benchmark = new Benchmark();

$benchmark->add('yuloh', function () {
    bench_draft4_meta('yuloh');
});
$benchmark->add('justin-rainbow', function () {
    bench_draft4_meta('justin_rainbow');
});

$benchmark->run();
