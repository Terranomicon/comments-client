<?php


use Client\CommentClient;
use Client\CommentsRepository;
use Client\Config\DIConfig;
use Client\Container;
use Client\Services\CommentsService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class CommentClientTest extends TestCase
{
    public function testGetComments()
    {
//        $mockResponseJson = json_encode($expected, JSON_THROW_ON_ERROR);
//        $mockResponse = new MockResponse($mockResponseJson, [
//            'http_code' => 200,
//            'response_headers' => ['Content-Type: application/json'],
//        ]);
//
//        $httpClient = new MockHttpClient($mockResponse, 'http://example.com');
//        $service = new CommentsService($httpClient);
//
//        $container = Container::instance(DIConfig::getDependencies())->get(CommentsRepository::class);
        $commentClient = new CommentClient();
        $e = 1;

    }
}
