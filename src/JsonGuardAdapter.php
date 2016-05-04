<?php

namespace Yuloh\JsonSchemaBenchmark;

use League;

class JsonGuardAdapter implements ValidatorAdapter
{
    /**
     * {@inheritdoc}
     */
    public function validate($data, $schemaPath, $isValid)
    {
        $deref  = new League\JsonGuard\Dereferencer();
        $schema = $deref->dereference('file://' . $schemaPath);
        $validator = new League\JsonGuard\Validator($data, $schema);
        $result = $validator->passes();
        assert('$result === $isValid');
    }
}
