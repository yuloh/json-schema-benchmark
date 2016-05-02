<?php

function yuloh($data, $schema)
{
    $schema = json_decode($schema, false, 512, JSON_BIGINT_AS_STRING);
    $deref  = new Yuloh\JsonGuard\Dereferencer();
    $schema = $deref->dereference($schema);
    $validator = new Yuloh\JsonGuard\Validator($data, $schema);
    return $validator->errors();
}

function justin_rainbow($data, $schema)
{
    $uriRetriever = new JsonSchema\Uri\UriRetriever();
    $uriRetriever->setUriRetriever(
        new ChainableRetriever(
            new JsonSchema\Uri\Retrievers\PredefinedArray(['file://schema' => $schema]),
            $uriRetriever->getUriRetriever()
        )
    );
    $refResolver = new JsonSchema\RefResolver(
        $uriRetriever,
        new JsonSchema\Uri\UriResolver()
    );

    $schema = $refResolver->resolve('file://schema');

    $validator = new JsonSchema\Validator();
    $validator->check($data, $schema);
    return $validator->getErrors();
}

function get_files()
{
    $schemaTestSuitePath = realpath(__DIR__ . '/vendor/json-schema/JSON-Schema-Test-Suite/tests/draft4');
    $required = glob($schemaTestSuitePath . '/*.json');
    return $required;

    // These aren't all passed by justin-rainbow, so skipping for now.
    // $optional = glob($schemaTestSuitePath . '/optional/*.json');
    // return array_merge($required, $optional);
}

function run_tests($callback)
{
    foreach (get_files() as $file) {
        // skipping for now, since IDK how to make justin rainbow pass this test.
        if (strpos($file, 'refRemote.json') !== false) {
            continue;
        }

        $test = json_decode(file_get_contents($file), false, 512, JSON_BIGINT_AS_STRING);

        foreach ($test as $testCase) {
            $schema      = $testCase->schema;
            $description = $testCase->description;
            foreach ($testCase->tests as $test) {
                $callback($test->data, json_encode($schema));
            }
        }
    }
}
