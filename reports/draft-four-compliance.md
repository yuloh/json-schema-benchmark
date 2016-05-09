## Draft Four Compliance

### Description

This test uses the official JSON Schema test suite to determine the validator's compliance with the official Draft 4 specification.

### Results

![test-failures](/reports/draft-four-compliance-failures.png)

| Validator | Total Test Failures |
|-----------|:---------------------------------:|
| JsonGuard | 0 |
| JsonSchema | 6 |


### JsonGuard

No test failures.

### JsonSchema

* change resolution scope : changed scope ref valid
* change resolution scope : changed scope ref valid
* change resolution scope : changed scope ref invalid
* integer : a bignum is an integer
* number : a bignum is a number
* string : a bignum is not a string
