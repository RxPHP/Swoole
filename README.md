# RxPHP Swoole

This project allows you to use RxPHP with Swoole.  

## Installation

First, install swoole
Then install rx/swoole
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

