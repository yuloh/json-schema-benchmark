<?php

namespace Yuloh\JsonSchemaBenchmark;

class ComposerBench
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

    public function benchCachingJsonGuard()
    {
        $validator = new CachingJsonGuardAdapter();

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
        $data = json_decode(file_get_contents(__DIR__ . '/../fixtures/data/composer.json'));
        $result = $validator->validate($data, __DIR__ . '/../fixtures/schema/composer-schema.json');
        assert('$result === true');
    }
}
