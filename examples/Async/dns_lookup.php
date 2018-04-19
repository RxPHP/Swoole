<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$ip = \Rx\Swoole\Async::dns_lookup('www.google.com');

$ip->subscribe(
    'print_r',
    function (Throwable $throwable) {
        echo "Error: " . $throwable->getMessage() . "\n";
    },
    function () {
        echo "Completed.\n";
    });