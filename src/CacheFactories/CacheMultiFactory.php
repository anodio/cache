<?php

namespace Anodio\Cache\CacheFactories;

use Anodio\Cache\Config\CacheConfig;
use Psr\Log\LoggerAwareInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\ResettableInterface;
use Symfony\Contracts\Cache\CacheInterface;

class CacheMultiFactory implements FactoryInterface
{
    public CacheConfig $config;

    public function __construct(
        CacheConfig $config,
        private ArrayCacheFactory $arrayCacheFactory,
        private RedisCacheFactory $redisCacheFactory,
    )
    {
        $this->config = $config;
    }

    public function makeCacheAdapter(): AdapterInterface|CacheInterface|LoggerAwareInterface|ResettableInterface
    {
        $driver = $this->config->driver;
        if ($driver === 'array') {
            return $this->arrayCacheFactory->makeCacheAdapter();
        }
        if ($driver === 'redis') {
            return $this->redisCacheFactory->makeCacheAdapter();
        }
        throw new \Exception("Unsupported cache driver: $driver");
    }
}