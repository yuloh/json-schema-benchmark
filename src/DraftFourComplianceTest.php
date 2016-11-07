<?php

namespace Yuloh\JsonSchemaBenchmark;

class DraftFourComplianceTest
{
    public static function testJsonGuard()
    {
        $validator = new JsonGuardAdapter();

        return self::runTests($validator);
    }

    public static function testCachingJsonGuard()
    {
        $validator = new CachingJsonGuardAdapter();

        self::runTests($validator);
    }

    public static function testJsonSchema()
    {
        $validator = new JsonSchemaAdapter();

        return self::runTests($validator);
    }

    public static function runTests(ValidatorAdapter $validator)
    {
        $failures    = [];

        foreach (self::draft4Tests() as $file) {
            $test = json_decode(file_get_contents($file), false, 512, JSON_BIGINT_AS_STRING);

            foreach ($test as $testCase) {
                $schema      = $testCase->schema;
                $description = $testCase->description;
                foreach ($testCase->tests as $test) {
                    $msg  = $description . ' : ' . $test->description;
                    $data = $test->data;

                    $schemaPath = tempnam(sys_get_temp_dir(), 'draft4-test');

                    $schemaJson = json_encode($schema);

                    // PHP can't actually re-encode it properly as JSON, so we do it manually.
                    // The end result is identical to the schema in the test.
                    if ($description === 'float comparison with high precision') {
                        $schemaJson = str_replace('9.7278379818799e+26', '972783798187987123879878123.18878137', $schemaJson);
                    }

                    file_put_contents($schemaPath, $schemaJson);

                    try {
                        $result = $validator->validate($data, $schemaPath);
                    } catch (\Exception $e) {
                        $failures[] = $msg;
                    }

                    if ($result !== $test->valid) {
                        $failures[] = $msg;
                    }
                }
            }
        }

        return $failures;
    }

    public static function draft4Tests()
    {
        $required = glob('vendor/json-schema/JSON-Schema-Test-Suite/tests/draft4/*.json');
        $optional = glob('vendor/json-schema/JSON-Schema-Test-Suite/tests/draft4/optional/*.json');
        return array_merge($required, $optional);
    }
}
