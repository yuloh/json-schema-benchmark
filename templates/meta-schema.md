# Meta Schema Validaton

## Introduction

This test checks the performance of validating the meta schema which defines JSON Schema against itself.  The meta schema contains a lot of references and most (all?) allowed validation keywords, so it's a pretty good way to check performance.

## Time To Validate

![validation-speed]({{ chart.speed }})

| Validator | Wall Clock Time (in microseconds) |
|-----------|:---------------------------------:|
{% for result in results %}
| {{ result.validator }} | {{ result.wt }} |
{% endfor %}

## Memory usage

![validation-memory-usage]({{ chart.memory }})

| Validator | Peak Memory Usage (in bytes) |
|-----------|:----------------------------:|
{% for result in results %}
| {{ result.validator }} | {{ result.pmu }} |
{% endfor %}
