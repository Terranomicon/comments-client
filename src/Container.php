<?php

namespace Client;

use Exception;

class Container
{
    private static $instance;

    private $dependencies = [];

    private function __construct($dependencies = [])
    {
        $this->dependencies = $dependencies;
    }

    public static function instance($dependencies = []): Container
    {
        if (null === self::$instance) {
            self::$instance = new self($dependencies);
        }

        return self::$instance;
    }

    public function has(string $name): bool
    {
        return isset($this->dependencies[$name]);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function get(string $name)
    {
        if ($this->has($name)) {
            return $this->resolve($name);
        } else {
            throw new Exception("Dependency $name not found.");
        }
    }

    public function make(string $name)
    {
        try {
            return $this->get($name);
        } catch (Exception $e) {
            return new $name();
        }
    }

    private function resolve(string $name)
    {
        return call_user_func($this->dependencies[$name], $this);
    }
}