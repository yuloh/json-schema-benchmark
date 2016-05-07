<?php

namespace Yuloh\JsonSchemaBenchmark;

use JsonSchema;

class JsonSchemaAdapter implements ValidatorAdapter
{
    /**
     * {@inheritdoc}
     */
    public function validate($data, $schemaPath)
    {
        $refResolver = new JsonSchema\RefResolver(
            new JsonSchema\Uri\UriRetriever(),
            new JsonSchema\Uri\UriResolver()
        );

        $schema = $refResolver->resolve('file://' . $schemaPath);

        $validator = new JsonSchema\Validator();
        $validator->check($data, $schema);
        return $validator->isValid();
    }
}
