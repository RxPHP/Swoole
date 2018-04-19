<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$file = \Rx\Swoole\Async::read(
    __DIR__ . '/some_file.txt',
    5);

$file->subscribe(
    'print_r',
    function (Throwable $throwable) {
        echo "Error: " . $throwable->getMessage() . "\n";
    },
    function () {
        echo "Completed.\n";
    });