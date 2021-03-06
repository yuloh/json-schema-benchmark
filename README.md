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


## Meta Schema Validaton

### Introduction

This test checks the performance of validating the meta schema which defines JSON Schema against itself.  The meta schema contains a lot of references and most (all?) allowed validation keywords, so it's a pretty good way to check performance.

### Time To Validate

![validation-speed](/reports/validating-the-meta-schema-wt.png)

| Validator | Wall Clock Time (in microseconds) |
|-----------|:---------------------------------:|
| JsonGuard | 32803.2 |
| JsonSchema | 222773.2 |

### Memory usage

![validation-memory-usage](/reports/validating-the-meta-schema-pmu.png)

| Validator | Peak Memory Usage (in bytes) |
|-----------|:----------------------------:|
| JsonGuard | 138288 |
| JsonSchema | 180384 |

## Composer Schema Validaton

### Introduction

This test checks the performance of validating a composer.json file against the schema the composer project uses.  This test was picked because it's an actual schema being used for a single file without references.  This should give a decent indication of performance when validating without references.

### Time To Validate

![validation-speed](/reports/validating-composer-wt.png)

| Validator | Wall Clock Time (in microseconds) |
|-----------|:---------------------------------:|
| JsonGuard | 9614.3 |
| JsonSchema | 18412.3 |

### Memory usage

![validation-memory-usage](/reports/validating-composer-pmu.png)

| Validator | Peak Memory Usage (in bytes) |
|-----------|:----------------------------:|
| JsonGuard | 142616 |
| JsonSchema | 209424 |

## Draft Four Compliance

### Description

This test uses the official JSON Schema test suite to determine the validator's compliance with the official Draft 4 specification.

### Results

![test-failures](/reports/draft-four-compliance-failures.png)

| Validator | Total Test Failures |
|-----------|:---------------------------------:|
| JsonGuard | 0 |
| JsonSchema | 19 |


### JsonGuard

No test failures.

### JsonSchema

* invalid definition : invalid definition schema
* forbidden property : property absent
* nested refs : nested ref invalid
* remote ref, containing refs itself : remote ref invalid
* remote ref : remote ref invalid
* fragment within remote ref : remote fragment invalid
* ref within remote ref : ref within ref invalid
* change resolution scope : changed scope ref valid
* change resolution scope : changed scope ref invalid
* change resolution scope : changed scope ref invalid
* integer : a bignum is an integer
* number : a bignum is a number
* integer : a negative bignum is an integer
* number : a negative bignum is a number
* string : a bignum is not a string
* integer comparison : comparison works for very negative numbers
* float comparison with high precision on negative numbers : comparison works for very negative numbers
* validation of URIs : a valid protocol-relative URI
* validation of host names : a host name with a component too long


## Credits

The files [`fixtures/data/composer.json`](fixtures/data/composer.json) and [`fixtures/schema/composer-schema.json`](fixtures/schema/composer-schema.json) are from the [Composer project](https://github.com/composer/composer) and Licensed under the MIT license.  Copyright (c) 2016 Nils Adermann, Jordi Boggiano.
