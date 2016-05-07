<?php

namespace Yuloh\JsonSchemaBenchmark;

class TestRunner
{
    public function __construct(array $tests, array $subjects)
    {
        $this->tests    = $tests;
        $this->subjects = $subjects;
    }

    public function run()
    {
        $results = [];
        foreach ($this->tests as $test) {
            $testClass = $test['class'];
            $title = $test['title'];
            foreach ($this->subjects as $subject) {
                $method = 'test' . $subject;
                $failures = $testClass::$method();
                $results[$title][$subject] = [
                    'failures' => count($failures),
                    'messages' => $failures,
                ];
            }
        }

        // for some reason the JsonSchema FileGetContents loader isn't restoring
        // the error handler correctly, so push the extras off the stack.
        for ($i = 0; $i < 3; $i++) {
            restore_error_handler();
        }

        return $results;
    }
}
