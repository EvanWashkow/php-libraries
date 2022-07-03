<?php

declare(strict_types=1);

return [
    'preset' => 'default',
    'exclude' => [
        //  'path/to/directory-or-file'
        'tests',
        'src-php',
        'tests-php',
    ],
    'add' => [
        //  ExampleMetric::class => [
        //      ExampleInsight::class,
        //  ]
    ],
    'remove' => [
        //  ExampleInsight::class,
    ],
    'config' => [
        //  ExampleInsight::class => [
        //      'key' => 'value',
        //  ],
    ],
];
