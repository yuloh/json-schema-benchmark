# Composer Schema Validaton

## Introduction

This test checks the performance of validating a composer.json file against the schema the composer project uses.  This test was picked because it's an actual schema being used for a single file without references.  This should give a decent indication of performance when validating without references.

## Time To Validate

![validation-speed]({{ chart.wt }})

| Validator | Wall Clock Time (in microseconds) |
|-----------|:---------------------------------:|
{% for subject, result in results %}
| {{ subject }} | {{ result.wt }} |
{% endfor %}

## Memory usage

![validation-memory-usage]({{ chart.pmu }})

| Validator | Peak Memory Usage (in bytes) |
|-----------|:----------------------------:|
{% for subject, result in results %}
| {{ subject }} | {{ result.pmu }} |
{% endfor %}
