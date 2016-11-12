## Composer Schema Validaton

### Introduction

This test checks the performance of validating a composer.json file against the schema the composer project uses.  This test was picked because it's an actual schema being used for a single file without references.  This should give a decent indication of performance when validating without references.

### Time To Validate

![validation-speed](/reports/validating-composer-wt.png)

| Validator | Wall Clock Time (in microseconds) |
|-----------|:---------------------------------:|
| JsonGuard | 9902.2 |
| CachingJsonGuard | 9786.4 |
| JsonSchema | 19539.5 |

### Memory usage

![validation-memory-usage](/reports/validating-composer-pmu.png)

| Validator | Peak Memory Usage (in bytes) |
|-----------|:----------------------------:|
| JsonGuard | 142616 |
| CachingJsonGuard | 187184.8 |
| JsonSchema | 209424 |
