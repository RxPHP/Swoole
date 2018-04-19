<?php

namespace Rx\Swoole;

use Rx\Observable;
use Rx\ObserverInterface;

final class Http
{

    public static function get(string $url, array $headers = []): Observable
    {
        return Observable::create(function (ObserverInterface $obs) use ($url, $headers) {
            try {
                [$cli, $path] = self::createClient($url);

                $cli->setHeaders($headers);
                $cli->set(['keep_alive' => false]);

                $cli->get($path, function ($cli) use ($obs) {
                    $obs->onNext($cli->body);
                    $obs->onCompleted();
                });
            } catch (\Throwable $t) {
                $obs->onError($t);
            }
        });
    }

    public static function post(string $url, string $body = null, array $headers = []): Observable
    {
        return Observable::create(function (ObserverInterface $obs) use ($url, $headers, $body) {
            try {
                [$cli, $path] = self::createClient($url);

                $cli->setHeaders($headers);
                $cli->set(['keep_alive' => false]);

                $cli->post($path, $body, function ($cli) use ($obs) {
                    $obs->onNext($cli->body);
                    $obs->onCompleted();
                });
            } catch (\Throwable $t) {
                $obs->onError($t);
            }
        });
    }

    public static function put(string $url, string $body = null, array $headers = []): Observable
    {

    }

    public static function delete(string $url, array $headers = []): Observable
    {

    }

    public static function patch(string $url, string $body = null, array $headers = []): Observable
    {

    }

    public static function head(string $url, array $headers = []): Observable
    {

    }

    private static function createClient($url)
    {
        $urlParts = parse_url($url);
        $secure   = 'https' === substr($url, 0, 3);
        $port     = $urlParts['port'] ?? ($secure ? 443 : 80);

        $cli = new \Swoole\Http\Client($urlParts['host'], $port);

        return [$cli, $urlParts['path']];
    }
}