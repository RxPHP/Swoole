<?php

\Rx\Scheduler::setDefaultFactory(function () {
  return new \Rx\Scheduler\EventLoopScheduler(function ($ms, callable $callable) {

    $timerId = $ms === 0 ? \Swoole\Event::defer($callable) : \Swoole\Timer::after($ms, $callable);

    return new \Rx\Disposable\CallbackDisposable(function () use ($timerId) {
      if ($timerId) {
        \Swoole\Timer::clear($timerId);
      }
    });
  });
});
