<?php

require __DIR__ . '/../vendor/autoload.php';

$combineType = new \DrLenux\Helpers\CSV\combine\CombineStrPosCount(1, 0, 0);

@unlink(__DIR__ . '/results/brands.csv');
@unlink(__DIR__ . '/results/products.csv');

copy(__DIR__ . '/original/brands.csv', __DIR__ . '/results/brands.csv');
copy(__DIR__ . '/original/products.csv', __DIR__ . '/results/products.csv');

(new \DrLenux\Helpers\CSV\CombineCSV())
    ->setPathToMainCSV(__DIR__ . '/results/brands.csv')
    ->setPathToSlaveCSV(__DIR__ . '/results/products.csv')
    ->setDelimiterToMainCSV(',')
    ->setDelimiterToSlaveCSV(',')
    ->run($combineType);