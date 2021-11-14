<?php

namespace Client\Interfaces;

use Client\Entities\CommentEntity;
use Client\Exception\ClientException;

interface CommentsInterface
{

    /**
     * @return array
     */
    public function getAll(): array;


    /**
     * @param string $name
     * @param string $text
     * @return void
     */
    public function create(string $name, string $text): void;


    /**
     * @param int $id
     * @param string $name
     * @param string $text
     * @return void
     */
    public function update(int $id, string $name, string $text): void;
}