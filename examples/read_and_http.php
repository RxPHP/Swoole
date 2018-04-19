<?php

require_once __DIR__ . '/../vendor/autoload.php';

$file = \Rx\Swoole\Async::read(__DIR__ . '/url_list.txt');

$urlInfo = $file
    ->cut("\n")
    ->flatMap(function ($url) {
        return \Rx\Swoole\Http::get($url)
            ->map(function ($content) use ($url) {
                return $url . " is " . strlen($content) . " bytes.\n";
            });
    });

$urlInfo->subscribe(function ($info) {
        echo $info;
    });

