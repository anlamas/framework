<?php
namespace Core\Config;

use Gestalt\Configuration;

class Config implements ConfigInterface
{
    /**
     * @var Configuration
     */
    private $repository;

    /**
     * Create a new configuration repository.
     *
     * @param Configuration $repository
     */
    public function __construct(Configuration $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the specified configuration value.
     *
     * @param  int|string|null $key
     * @param  mixed default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->repository->get($key, $default);
    }

    /**
     * Set a given configuration value.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return void
     */
    public function set($key, $value = null)
    {
        $this->repository->set($key, $value);
    }
}
