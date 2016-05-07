<?php

namespace Yuloh\JsonSchemaBenchmark;

class MetaValidationBench
{
    /**
     * @Revs(50)
     * @Iterations(5)
     */
    public function benchJsonGuard()
    {
        $validator = new JsonGuardAdapter();

        self::validate($validator);
    }

    /**
     * @Revs(50)
     * @Iterations(5)
     */
    public function benchJsonSchema()
    {
        $validator = new JsonSchemaAdapter();

        self::validate($validator);
    }

    private static function validate(ValidatorAdapter $validator)
    {
        $schema = realpath(__DIR__ . '/../fixtures/schema/draft4.json');
        $data = json_decode(file_get_contents($schema));
        $result = $validator->validate($data, $schema);
        assert('$result === true');
    }
}
