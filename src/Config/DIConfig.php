<?php

namespace Client\Config;

use Client\CommentsRepository;
use Client\Container;
use Client\Interfaces\CommentsInterface;
use Client\Services\CommentsService;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DIConfig
{
    public static function getDependencies(): array
    {
        return [
            HttpClientInterface::class => function () {
                return new Http();
            },
            CommentsInterface::class => function (Container $container) {
                return new CommentsService($container->get(HttpClientInterface::class));
            },
            CommentsRepository::class => function (Container $container) {
                return new CommentsRepository($container->get(CommentsInterface::class));
            }];
    }
}