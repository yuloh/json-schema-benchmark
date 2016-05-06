<?php

namespace Yuloh\JsonSchemaBenchmark;

use function Yuloh\Neko\kebab_case;
use function Yuloh\Neko\pascal_case;

class Reporter
{
    private $labels = [
        'pmu' => 'Peak Memory Usage (in bytes)',
        'wt'  => 'Wall Clock Time (in microseconds)'
    ];

    public function __construct($config)
    {
        $this->reportPath = $config['report_path'];
        $this->templates  = $this->getTemplates($config['benchmarks']);
        $this->basePath   = $config['base_path'];
    }

    private function getTemplates($benchmarks)
    {
        $keys = array_values(array_map(function ($benchmark) {
            return $benchmark['title'];
        }, $benchmarks));

        $values = array_values(array_map(function ($benchmark) {
            return $benchmark['template'];
        }, $benchmarks));

        return array_combine($keys, $values);
    }

    public function report(array $results)
    {
        $this->cleanup();

        foreach ($results as $title => $benchmarkResults) {
            $memChartPath = $this->generateChart($title, 'pmu', $benchmarkResults);
            $perfChartPath = $this->generateChart($title, 'wt', $benchmarkResults);
            $this->generateMarkdownReport(
                $title,
                $benchmarkResults,
                $memChartPath,
                $perfChartPath
            );
        }
    }

    private function cleanup()
    {
        $contents = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->reportPath, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        /** @var \SplFileInfo $file */
        foreach ($contents as $file) {
            if ($file->getType() === 'dir') {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
    }

    private function generateMarkdownReport($title, $results, $memChartPath, $perfChartPath)
    {
        $loader = new \Twig_Loader_Array($this->templates);
        $twig = new \Twig_Environment($loader);

        foreach ($results as $validator => $result) {
            $results[$validator]['validator'] = $validator;
        }

        $data = [
            'chart' => [
                'speed' => str_replace($this->basePath, '', $perfChartPath),
                'memory' => str_replace($this->basePath, '', $memChartPath),
            ],
            'results' => $results
        ];

        $reportPath = $this->reportPath . '/' . kebab_case($title) . '.md';
        file_put_contents($reportPath, $twig->render($title, $data));
    }

    private function pluckDataset($benchmarkResults, $metric)
    {
        return array_values(array_map(function ($cost) use ($metric) {
            return $cost[$metric];
        }, $benchmarkResults));
    }

    private function generateChart($title, $metric, array $benchmarkResults)
    {
        $subjects = array_keys($benchmarkResults);

        $dataset = [
            [
                'label'           => $this->labels[$metric],
                'backgroundColor' => 'rgba(255,99,132,0.2)',
                'borderColor'     => 'rgba(255,99,132,1)',
                'borderWidth'     => 1,
                'data'            => $this->pluckDataset($benchmarkResults, $metric)
            ]
        ];

        $data = json_encode([
            'labels'   => $subjects,
            'datasets' => $dataset
        ]);

        $outPath = $this->reportPath . '/' . kebab_case($title . ucfirst($metric)) . '.png';

        $cmd = sprintf(
            "phantomjs chart.js %s %s",
            escapeshellarg($data),
            escapeshellarg($outPath)
        );
        system($cmd);
        return $outPath;
    }
}
