## Meta Schema Validaton

### Introduction

This test checks the performance of validating the meta schema which defines JSON Schema against itself.  The meta schema contains a lot of references and most (all?) allowed validation keywords, so it's a pretty good way to check performance.

### Time To Validate

![validation-speed](/reports/validating-the-meta-schema-wt.png)

| Validator | Wall Clock Time (in microseconds) |
|-----------|:---------------------------------:|
| JsonGuard | 35239.8 |
| JsonSchema | 255050.7 |

### Memory usage

![validation-memory-usage](/reports/validating-the-meta-schema-pmu.png)

| Validator | Peak Memory Usage (in bytes) |
|-----------|:----------------------------:|
| JsonGuard | 137595.2 |
| JsonSchema | 180880 |
