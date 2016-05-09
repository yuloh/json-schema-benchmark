## Meta Schema Validaton

### Introduction

This test checks the performance of validating the meta schema which defines JSON Schema against itself.  The meta schema contains a lot of references and most (all?) allowed validation keywords, so it's a pretty good way to check performance.

### Time To Validate

![validation-speed]({{ chart.wt }})

| Validator | Wall Clock Time (in microseconds) |
|-----------|:---------------------------------:|
{% for subject, result in results %}
| {{ subject }} | {{ result.wt }} |
{% endfor %}

### Memory usage

![validation-memory-usage]({{ chart.pmu }})

| Validator | Peak Memory Usage (in bytes) |
|-----------|:----------------------------:|
{% for subject, result in results %}
| {{ subject }} | {{ result.pmu }} |
{% endfor %}
