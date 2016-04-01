<?php

require __DIR__ . '/vendor/autoload.php';

use Lavoiesl\PhpBenchmark\Benchmark;

$benchmark = new Benchmark();

$benchmark->add('yuloh',   function() {
    $schema = json_decode('{ "properties": { "id": { "type": "string", "format": "uri" } } }');
    $data = json_decode('{ "id": "json-guard.dev/schema#" }');

    $validator = new Yuloh\JsonGuard\Validator($data, $schema);
    assert($validator->fails());
});

$benchmark->add('justin-rainbow',  function() {
    $schema = json_decode('{ "properties": { "id": { "type": "string", "format": "uri" } } }');
    $data = json_decode('{ "id": "json-guard.dev/schema#" }');

    $validator = new JsonSchema\Validator();
    $validator->check($data, $schema);
    assert(!$validator->isValid());
});

$benchmark->setCount(1);
$benchmark->run();
?>
