<?php

namespace Yuloh\JsonSchemaBenchmark;

interface ValidatorAdapter
{
    /**
     * @param  object $data       The decoded data
     * @param  string $schemaPath The absolute path to the file
     * @param  bool   $isValid    If the data is valid
     */
    public function validate($data, $schemaPath, $isValid);
}
