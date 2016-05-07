<?php

namespace Yuloh\JsonSchemaBenchmark;

interface ValidatorAdapter
{
    /**
     * @param  object $data       The decoded data
     * @param  string $schemaPath The absolute path to the file
     * @return bool
     */
    public function validate($data, $schemaPath);
}
