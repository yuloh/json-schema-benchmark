<?php

namespace Yuloh\JsonSchemaBenchmark;

use League;

class JsonGuardAdapter implements ValidatorAdapter
{
    /**
     * {@inheritdoc}
     */
    public function validate($data, $schemaPath)
    {
        $deref  = new League\JsonGuard\Dereferencer();
        $schema = $deref->dereference('file://' . $schemaPath);
        $validator = new League\JsonGuard\Validator($data, $schema);
        return $validator->passes();
    }
}
