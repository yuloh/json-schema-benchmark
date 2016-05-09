# JSON Schema Benchmark (For PHP)

## Introduction

This repo is a (WIP) benchmark of JSON Schema validators for PHP.

### How It Works

The validators are profiled using the [Blackfire PHP SDK](https://blackfire.io/docs/reference-guide/php-sdk).

The test results are ran through phantom.js to build the charts and then through twig to build markdown.

### Running The Tests

First you need to start a test server, which is used to test loading remote references:

```bash
$ node server.js
```

Now you can run the tests:

```bash
$ php build-reports
```


{{ validating_the_meta_schema|raw }}
{{ draft_four_compliance|raw }}
{{ validating_composer|raw }}

## Credits

The files [`fixtures/data/composer.json`](fixtures/data/composer.json) and [`fixtures/schema/composer-schema.json`](fixtures/schema/composer-schema.json) are from the [Composer project](https://github.com/composer/composer) and Licensed under the MIT license.  Copyright (c) 2016 Nils Adermann, Jordi Boggiano.
