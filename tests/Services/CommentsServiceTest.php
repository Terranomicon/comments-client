<?php

namespace Services;

use Client\Entities\CommentEntity;
use Client\Exception\ClientException;
use Client\Services\CommentsService;
use JsonException;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;

class CommentsServiceTest extends TestCase
{
    /**
     * @dataProvider getAllDataProvider
     * @throws ClientException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws JsonException
     */
    public function testGetAllComments(array $data, array $expected)
    {
        $mockResponseJson = json_encode($data, JSON_THROW_ON_ERROR);
        $mockResponse = new MockResponse($mockResponseJson, [
            'http_code' => 200,
            'response_headers' => ['Content-Type: application/json'],
        ]);

        $httpClient = new MockHttpClient($mockResponse, 'http://example.com');
        $service = new CommentsService($httpClient);

        $responseData = $service->getAll();
        self::assertSame('GET', $mockResponse->getRequestMethod());
        self::assertSame('http://example.com/comments', $mockResponse->getRequestUrl());
        self::assertEquals($expected, $responseData);
    }

    public function getAllDataProvider()
    {
        return [
            [
                ['data' =>
                    [['id' => 1, 'name' => 'Dima', 'text' => 'text']]],
                [new CommentEntity(1, 'Dima', 'text')]
            ],
            [
                ['data' => []],
                []
            ],
            [
                ['data' =>
                    [
                        ['id' => 5, 'name' => 'Test1', 'text' => 'text1'],
                        ['id' => 6, 'name' => 'Test2', 'text' => 'text2'],
                        ['id' => 7, 'name' => 'Test3', 'text' => 'text3'],
                    ]],
                [
                    new CommentEntity(5, 'Test1', 'text1'),
                    new CommentEntity(6, 'Test2', 'text2'),
                    new CommentEntity(7, 'Test3', 'text3')]
            ]
        ];
    }

    /**
     * @dataProvider createDataProvider
     * @param array $expected
     * @throws ClientException
     * @throws JsonException
     * @throws TransportExceptionInterface
     */
    public function testCreateComments(array $expected)
    {
        $mockResponseJson = json_encode($expected, JSON_THROW_ON_ERROR);
        $mockResponse = new MockResponse($mockResponseJson, [
            'http_code' => 200,
            'response_headers' => ['Content-Type: application/json'],
        ]);

        $httpClient = new MockHttpClient($mockResponse, 'http://example.com');
        $service = new CommentsService($httpClient);

        $service->create(...$expected[0]);
        self::assertSame('POST', $mockResponse->getRequestMethod());
        self::assertSame('http://example.com/comment', $mockResponse->getRequestUrl());
        self::assertSame(200, $mockResponse->getStatusCode());
    }

    public function createDataProvider()
    {
        return [
            [
                [['Dima', 'text']]
            ],
            [
                [['Roma', 'text2']]
            ],
            [
                [['Test', 'text3']]
            ]
        ];
    }

    /**
     * @dataProvider updateDataProvider
     * @param array $expected
     * @throws ClientException
     * @throws JsonException
     * @throws TransportExceptionInterface
     */
    public function testUpdateComments(array $expected)
    {
        $mockResponseJson = json_encode($expected, JSON_THROW_ON_ERROR);
        $mockResponse = new MockResponse($mockResponseJson, [
            'http_code' => 200,
            'response_headers' => ['Content-Type: application/json'],
        ]);

        $httpClient = new MockHttpClient($mockResponse, 'http://example.com');
        $service = new CommentsService($httpClient);

        $service->update(...$expected[0]);
        self::assertSame('PUT', $mockResponse->getRequestMethod());
        self::assertSame('http://example.com/comment/' . $expected[0][0], $mockResponse->getRequestUrl());
        self::assertSame(200, $mockResponse->getStatusCode());
    }

    public function updateDataProvider()
    {
        return [
            [
                [[1, 'Dima', 'textCheck']]
            ],
            [
                [[100, 'Roma', 'textCheck2']]
            ],
            [
                [[999, 'Test', 'textCheck3']]
            ]
        ];
    }
}
