<?php

namespace Yuloh\JsonSchemaBenchmark;

use function Yuloh\Neko\kebab_case;

class Reporter
{
    public function __construct($basePath, $reportPath, $templates)
    {
        $this->basePath   = $basePath;
        $this->reportPath = $reportPath;
        $this->templates  =  $templates;
    }

    public function report(array $testResults, array $metrics)
    {
        foreach ($testResults as $title => $results) {
            $charts = [];
            foreach ($metrics as $label => $metric) {
                $charts[$metric] = $this->generateChart($title, $results, $label, $metric);
            }
            $this->generateMarkdownReport($title, $results, $charts);
        }
    }

    private function generateChart($title, $results, $label, $metric)
    {
        $resultData = array_values(array_map(function ($result) use ($metric) {
            return $result[$metric];
        }, $results));

        $data = json_encode([
            'labels'   => array_keys($results),
            'datasets' => [
                [
                    'label'           => $label,
                    'backgroundColor' => 'rgba(255,99,132,0.2)',
                    'borderColor'     => 'rgba(255,99,132,1)',
                    'borderWidth'     => 1,
                    'data'            => $resultData
                ]
            ]
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

    private function generateMarkdownReport($title, $results, $charts)
    {
        $loader = new \Twig_Loader_Array($this->templates);
        $twig = new \Twig_Environment($loader);

        $data = [
            'chart' => array_map(function ($chart) {
                return str_replace($this->basePath, '', $chart);
            }, $charts),
            'results' => $results
        ];

        $reportPath = $this->reportPath . '/' . kebab_case($title) . '.md';
        file_put_contents($reportPath, $twig->render($title, $data));
    }
}
