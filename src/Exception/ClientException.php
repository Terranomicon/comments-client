<?php

namespace Client\Exception;

use Exception;
use Throwable;

class ClientException extends Exception
{
    private $status;

    /**
     * @param string $message
     * @param int $status
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $status = 400, int $code = 0, Throwable $previous = null)
    {
        $this->status = $status;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}