# RxPHP Swoole

This project allows you to use RxPHP with Swoole.  

## Installation

First, install [swoole](https://www.swoole.co.uk/)

Then add rx/swoole to your project with composer:

```bash
    composer require rx/swoole
```

It bootstraps a swoole scheduler for you, so you can do things like:

```PHP
  \Rx\Observable::interval(1000)
    ->take(5)
    ->subscribe(function($i){
      echo $i, PHP_EOL;
    });
    
```

## Use with other Swoole modules

A small number of Swoole modules have helper Rx wrappers in this library.
You can use these to combine into more complex examples:
```php

// this example uses the rx/operator-extras package for `cut`

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
```

