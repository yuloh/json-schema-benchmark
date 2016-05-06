<?php

namespace Yuloh\JsonSchemaBenchmark;

use Blackfire\Client;

class BenchmarkRunner
{
    public function __construct(array $config)
    {
        $this->client  = new Client();
        $this->samples    = $config['samples'];
        $this->benchmarks = $config['benchmarks'];
        $this->subjects   = $config['subjects'];
    }

    public function run()
    {
        foreach ($this->benchmarks as $benchmark) {
            $benchmarkClass = $benchmark['class'];
            $title = $benchmark['title'];
            $results[$title] = $this->runBenchmark($benchmarkClass, $this->subjects);
        }

        return $results;
    }

    private function runBenchmark($benchmarkClass, $subjects)
    {
        $benchmark = new $benchmarkClass();
        $results = [];
        foreach ($subjects as $subject) {
            $method = 'bench' . $subject;
            $results[$subject] = $this->runBenchmarkMethod($benchmark, $method);
        }
        return $results;
    }

    private function runBenchmarkMethod($instance, $method)
    {
        $config = (new \Blackfire\Profile\Configuration())->setSamples($this->samples);
        $probe = $this->client->createProbe($config, false);

        for ($i = 1; $i <= $this->samples; $i++) {
            $probe->enable();
            $instance->$method();
            $probe->close();
        }

        $profile = $this->client->endProbe($probe);
        $cost = $profile->getMainCost();

        return [
            'wt'  => $cost->getWallTime(),
            'cpu' => $cost->getCpu(),
            'io'  => $cost->getIo(),
            'nw'  => $cost->getNetwork(),
            'pmu' => $cost->getPeakMemoryUsage(),
            'mu'  => $cost->getMemoryUsage(),
        ];
    }
}
