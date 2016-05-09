## Meta Schema Validaton

### Introduction

This test checks the performance of validating the meta schema which defines JSON Schema against itself.  The meta schema contains a lot of references and most (all?) allowed validation keywords, so it's a pretty good way to check performance.

### Time To Validate

![validation-speed](/reports/validating-the-meta-schema-wt.png)

| Validator | Wall Clock Time (in microseconds) |
|-----------|:---------------------------------:|
| JsonGuard | 15802.8 |
| JsonSchema | 96509.7 |

### Memory usage

![validation-memory-usage](/reports/validating-the-meta-schema-pmu.png)

| Validator | Peak Memory Usage (in bytes) |
|-----------|:----------------------------:|
| JsonGuard | 138158.4 |
| JsonSchema | 162374.4 |
