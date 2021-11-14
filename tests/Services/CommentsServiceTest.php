<?php

namespace Services;

use Client\Entities\CommentEntity;
use Client\Exception\ClientException;
use Client\Services\CommentsService;
use JsonException;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
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
    public function testGetAllComments(array $expected)
    {
        $mockResponseJson = json_encode($expected, JSON_THROW_ON_ERROR);
        $mockResponse = new MockResponse($mockResponseJson, [
            'http_code' => 200,
            'response_headers' => ['Content-Type: application/json'],
        ]);

        $httpClient = new MockHttpClient($mockResponse, 'http://example.com');
        $service = new CommentsService($httpClient);

        $responseData = $service->getAll();
        $responseCheck = [['id' => $responseData[0]->getId(), 'name' => $responseData[0]->getName(), 'text' => $responseData[0]->getText()]];
        self::assertSame('GET', $mockResponse->getRequestMethod());
        self::assertSame('http://example.com/comments', $mockResponse->getRequestUrl());
        self::assertSame($responseCheck, $expected);
    }

    public function getAllDataProvider()
    {
        return [
            [
                ['id' => 1, 'name' => 'Dima', 'text' => 'text']
            ],
            [
                ['id' => 999, 'name' => 'Last', 'text' => 'text2']
            ],
            [
                ['id' => null, 'name' => 'TestNull', 'text' => 'text3']
            ]
        ];
    }

    /**
     * @dataProvider createDataProvider
     * @throws ClientException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
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
