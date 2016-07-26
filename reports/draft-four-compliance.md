## Draft Four Compliance

### Description

This test uses the official JSON Schema test suite to determine the validator's compliance with the official Draft 4 specification.

### Results

![test-failures](/reports/draft-four-compliance-failures.png)

| Validator | Total Test Failures |
|-----------|:---------------------------------:|
| JsonGuard | 0 |
| JsonSchema | 12 |


### JsonGuard

No test failures.

### JsonSchema

* forbidden property : property absent
* change resolution scope : changed scope ref valid
* change resolution scope : changed scope ref valid
* change resolution scope : changed scope ref invalid
* integer : a bignum is an integer
* number : a bignum is a number
* integer : a negative bignum is an integer
* number : a negative bignum is a number
* string : a bignum is not a string
* integer comparison : comparison works for very negative numbers
* float comparison with high precision on negative numbers : comparison works for very negative numbers
* validation of URIs : a valid protocol-relative URI
