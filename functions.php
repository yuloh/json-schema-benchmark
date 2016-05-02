<?php

/**
 * @param  object $data       The decoded data
 * @param  string $schemaPath The absolute path to the file
 * @param  bool   $isValid    If the data is valid
 */
function yuloh($data, $schemaPath, $isValid)
{
    $deref  = new Yuloh\JsonGuard\Dereferencer();
    $schema = $deref->dereference('file://' . $schemaPath);
    $validator = new Yuloh\JsonGuard\Validator($data, $schema);
    $result = $validator->passes();
    assert('$result === $isValid');
}

/**
 * @param  object $data       The decoded data
 * @param  string $schemaPath The absolute path to the file
 * @param  bool   $isValid    If the data is valid
 */
function justin_rainbow($data, $schemaPath, $isValid)
{
    $refResolver = new JsonSchema\RefResolver(
        new JsonSchema\Uri\UriRetriever(),
        new JsonSchema\Uri\UriResolver()
    );

    $schema = $refResolver->resolve('file://' . $schemaPath);

    $validator = new JsonSchema\Validator();
    $validator->check($data, $schema);
    $result = $validator->isValid();
    assert('$result === $isValid');
}

/**
 * Benchmark validating the draft4 meta schema against the draft4 meta schema.
 *
 * @param  \Callable $callback
 * @return bool
 */
function bench_draft4_meta($callback)
{
    $path = realpath(__DIR__ . '/draft4.json');
    $schema = json_decode(file_get_contents($path));
    return $callback($schema, $path, true);
}
