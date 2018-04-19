<?php

namespace Rx\Swoole;

use Rx\Disposable\CallbackDisposable;
use Rx\Disposable\EmptyDisposable;
use Rx\Observable\AnonymousObservable;
use Rx\ObserverInterface;

final class Async
{
    public static function read(string $filename, int $size = 8192, int $offset = 0)
    {
        return new AnonymousObservable(function (ObserverInterface $observer) use ($filename, $size, $offset) {
            $disposed = false;

            $disposable = new CallbackDisposable(function () use (&$disposed) {
                $disposed = true;
            });

            $callback = function ($filename, $data) use ($observer, &$disposed) {
                if ($data === '') { // read complete
                    $observer->onCompleted();
                    return false;
                }
                if ($disposed) {
                    return false;
                }

                $observer->onNext($data);
                return true;
            };

            $retVal = \Swoole\Async::read($filename, $callback, $size, $offset);

            if ($retVal === false) {
                $observer->onError(new \Exception('Swoole\Asynd::read returned false'));
                return;
            }

            return $disposable;
        });
    }

    public static function dns_lookup($host)
    {
        return new AnonymousObservable(function (ObserverInterface $observer) use ($host) {
            $callback = function ($host, $ip) use ($observer) {
                if (empty($ip)) {
                    $observer->onError(new \Exception('dns_lookup failed'));
                }

                $observer->onNext($ip);
                $observer->onCompleted();
            };

            swoole_async_dns_lookup($host, $callback);

            return new EmptyDisposable();
        });
    }
}