<?php

namespace Client;

use Client\Entities\CommentEntity;
use Client\Config\DIConfig;
use Exception;

class CommentClient
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var CommentsRepository
     */
    private $repo;

    /**
     * CommentClient constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->container = Container::instance(DIConfig::getDependencies());
        $this->repo = Container::instance()->get(CommentsRepository::class);
    }

    /**
     * @return CommentEntity[]
     * @throws Exception
     */
    public function getComments(): array
    {
        return $this->repo->getAll();
    }

    /**
     * @param string $name
     * @param string $text
     * @throws Exception
     */
    public function createComment(string $name, string $text): void
    {
        $this->repo->create(new CommentEntity(null, $name, $text));
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $text
     * @throws Exception
     */
    public function updateComment(int $id, string $name, string $text): void
    {
        $this->repo->update(new CommentEntity($id, $name, $text));
    }
}