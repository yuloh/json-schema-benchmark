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
        $schema    = (object)['$ref' => 'file://' . $schemaPath];
        $validator = new JsonSchema\Validator();

        $validator->check($data, $schema);
        return $validator->isValid();
    }
}
