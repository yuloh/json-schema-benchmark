## Draft Four Compliance

### Description

This test uses the official JSON Schema test suite to determine the validator's compliance with the official Draft 4 specification.

### Results

![test-failures]({{ chart.failures }})

| Validator | Total Test Failures |
|-----------|:---------------------------------:|
{% for subject, result in results %}
| {{ subject }} | {{ result.failures }} |
{% endfor %}

{% for subject, result in results %}

### {{ subject }}

{% if result.messages %}
{% for message in result.messages %}
* {{ message }}
{% endfor %}
{% else %}
No test failures.
{% endif %}
{% endfor %}
