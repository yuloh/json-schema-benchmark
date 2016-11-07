<?php

use Yuloh\JsonSchemaBenchmark\ComposerBench;
use Yuloh\JsonSchemaBenchmark\MetaValidationBench;
use Yuloh\JsonSchemaBenchmark\DraftFourComplianceTest;

return [
    'benchmarks' => [
        [
            'class' => ComposerBench::class,
            'title' => 'Validating Composer',
            'template' => file_get_contents(__DIR__ . '/templates/composer.md')
        ],
        [
            'class' => MetaValidationBench::class,
            'title' => 'Validating the Meta Schema',
            'template' => file_get_contents(__DIR__ . '/templates/meta-schema.md')
        ],
    ],
    'tests' => [
        [
            'class' => DraftFourComplianceTest::class,
            'title' => 'Draft Four Compliance',
            'template' => file_get_contents(__DIR__ . '/templates/draft-four-compliance.md')
        ]
    ],
    'subjects' => [
        'JsonGuard',
        'CachingJsonGuard',
        'JsonSchema'
    ],
    'report_path' => __DIR__ . '/reports',
    'base_path'   => __DIR__,
    'samples'     => 10,
];
