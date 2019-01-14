<?php
namespace Core\Config;

interface ConfigInterface
{
    /**
     * Get the specified configuration value.
     *
     * @param  int|string|null $key
     * @param  mixed default
     *
     * @return mixed
     */
    public function get($key, $default = null);


    /**
     * Set a given configuration value.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return void
     */
    public function set($key, $value = null);
}
