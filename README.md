# JSON Schema Benchmark (For PHP)

## Introduction

This repo is a (WIP) benchmark of JSON Schema validators for PHP.

## Tests

### Meta Validation

This test validates the [JSON Schema Meta-Schema](http://json-schema.org/documentation.html) against itself.

[View Results](reports/meta.md)

### Composer

This test validates the `composer.json` schema used by Composer against sample data.

[View Results](reports/composer.md)

## Credits

The files [`fixtures/data/composer.json`](fixtures/data/composer.json) and [`fixtures/schema/composer-schema.json`](fixtures/schema/composer-schema.json) are from the [Composer project](https://github.com/composer/composer) and Licensed under the MIT license.  Copyright (c) 2016 Nils Adermann, Jordi Boggiano.
