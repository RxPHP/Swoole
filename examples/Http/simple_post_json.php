<?php
include __DIR__ . '/../../vendor/autoload.php';
$postData = json_encode(['test' => 'data']);
$headers  = ['Content-Type' => 'application/json'];
$source   = \Rx\Swoole\Http::post('http://httpbin.org/post', $postData, $headers);
$source->subscribe(
  function ($data) {
    echo $data, PHP_EOL;
  },
  function (\Throwable $e) {
    echo $e->getMessage(), PHP_EOL;
  },
  function () {
    echo 'completed', PHP_EOL;
  }
);