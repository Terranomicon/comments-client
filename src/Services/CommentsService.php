<?php

namespace Client\Services;

use Client\Entities\CommentEntity;
use Client\Interfaces\CommentsInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Client\Exception\ClientException;

class CommentsService implements CommentsInterface
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     * @throws ClientException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getAll(): array
    {
        try {
            $result = [];
            $response = $this->client->request('GET', '/comments');

            $data = $response->toArray();

            if (empty($data['data'])) {
                return [];
            }

            foreach ($data['data'] as $comment) {
                $result[] = new CommentEntity($comment['id'], $comment['name'], $comment['text']);
            }
            return $result;

        } catch (TransportExceptionInterface $e) {
            throw new ClientException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param string $name
     * @param string $text
     * @return void
     * @throws ClientException
     */
    public function create(string $name, string $text): void
    {
        try {
            $response = $this->client->request('POST', '/comment',
                [
                    'json' => [
                        "name" => $name,
                        "text" => $text
                    ]
                ]
            );
        } catch (TransportExceptionInterface $e) {
            throw new ClientException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $text
     * @return void
     * @throws ClientException
     */
    public function update(int $id, string $name, string $text): void
    {
        try {
            $response = $this->client->request('PUT', "/comment/$id",
                [
                    'json' => [
                        "name" => $name,
                        "text" => $text
                    ]
                ]
            );
        } catch (TransportExceptionInterface $e) {
            throw new ClientException($e->getMessage(), $e->getCode());
        }
    }
}