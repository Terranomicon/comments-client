<?php

namespace Client\Entities;

class CommentEntity
{
    private $id;
    private $name;
    private $text;

    /**
     * @param int|null $id
     * @param string $name
     * @param string $text
     */
    public function __construct(?int $id, string $name, string $text)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setText($text);
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array['id'] = $this->getId();
        $array['name'] = $this->getName();
        $array['text'] = $this->getText();
        return $array;
    }
}