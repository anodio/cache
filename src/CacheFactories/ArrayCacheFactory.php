<?php

namespace Anodio\Cache\CacheFactories;

use Psr\Log\LoggerAwareInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\ResettableInterface;
use Symfony\Contracts\Cache\CacheInterface;

class ArrayCacheFactory implements FactoryInterface
{
    public function makeCacheAdapter(): AdapterInterface|CacheInterface|LoggerAwareInterface|ResettableInterface
    {
        return new ArrayAdapter();
    }
}