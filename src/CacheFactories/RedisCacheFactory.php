<?php

namespace Anodio\Cache\CacheFactories;

use Anodio\Cache\Config\RedisCacheConfig;
use Psr\Log\LoggerAwareInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\ResettableInterface;
use Symfony\Contracts\Cache\CacheInterface;

class RedisCacheFactory implements FactoryInterface
{
    public RedisCacheConfig $config;

    public function __construct(RedisCacheConfig $config)
    {
        $this->config = $config;
    }

    public function makeCacheAdapter(): AdapterInterface|CacheInterface|LoggerAwareInterface|ResettableInterface
    {
        if (!extension_loaded('redis')) {
            throw new \Exception('Redis extension is not loaded');
        }
        $username = ($this->config->username)?:null;
        $password = ($this->config->password)?:null;
        $connection = new \Redis(
            [
                'host'=>$this->config->host,
                'port'=>$this->config->port
            ]
        );
        if ($username && $password) {
            $connection->auth([$username, $password]);
        } elseif ($password) {
            $connection->auth($password);
        }

        $connection->select($this->config->databaseNum);

        return new \Symfony\Component\Cache\Adapter\RedisAdapter($connection, $this->config->prefix);

    }
}