<?php

namespace Anodio\Cache\CacheFactories;

use Psr\Log\LoggerAwareInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\ResettableInterface;
use Symfony\Contracts\Cache\CacheInterface;

interface FactoryInterface
{
    public function makeCacheAdapter(): AdapterInterface|CacheInterface|LoggerAwareInterface|ResettableInterface;
}