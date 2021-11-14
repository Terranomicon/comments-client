<?php

namespace Client;

use Client\Entities\CommentEntity;
use Client\Interfaces\CommentsInterface;
use Client\Exception\ClientException;
use Exception;

class CommentsRepository
{
    /**
     * @var CommentsInterface
     */
    private $client;

    /**
     * CommentsRepository constructor.
     * @param CommentsInterface $client
     */
    public function __construct(CommentsInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return CommentEntity[]
     * @throws Exception
     */
    public function getAll(): array
    {
        try {
            return $this->client->getAll();
        } catch (Exception $e) {
            throw new ClientException($e->getMessage() . $e->getCode());
        }
    }

    /**
     * @param CommentEntity $comment
     * @throws Exception
     */
    public function create(CommentEntity $comment): void
    {
        try {
            $this->client->create($comment->getName(), $comment->getText());
        } catch (Exception $e) {
            throw new ClientException($e->getMessage() . $e->getCode());
        }
    }

    /**
     * @param CommentEntity $comment
     * @throws Exception
     */
    public function update(CommentEntity $comment): void
    {
        try {
            $this->client->update($comment->getId(), $comment->getName(), $comment->getText());
        } catch (Exception $e) {
            throw new ClientException($e->getMessage() . $e->getCode());
        }
    }
}