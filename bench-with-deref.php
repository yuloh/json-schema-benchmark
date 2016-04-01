<?php

require __DIR__ . '/vendor/autoload.php';

use Lavoiesl\PhpBenchmark\Benchmark;

$benchmark = new Benchmark();

$benchmark->add('yuloh',   function() {
    $deref  = new Yuloh\JsonGuard\Dereferencer();
    $schema = $deref->dereference('file://' . __DIR__ . '/schema.json');

    $data = json_decode(file_get_contents(__DIR__ . '/data.json'));

    $validator = new Yuloh\JsonGuard\Validator($data, $schema);

    assert($validator->fails());
});

$benchmark->add('justin-rainbow',  function() {
    $refResolver = new JsonSchema\RefResolver(
        new JsonSchema\Uri\UriRetriever(),
        new JsonSchema\Uri\UriResolver()
    );

    $schema = $refResolver->resolve('file://' . realpath('schema.json'));

    $data = json_decode(file_get_contents(__DIR__ . '/data.json'));

    $validator = new JsonSchema\Validator();
    $validator->check($data, $schema);

    assert(!$validator->isValid());
});

$benchmark->run();
