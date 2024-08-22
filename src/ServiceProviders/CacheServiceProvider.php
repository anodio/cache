<?php

namespace Anodio\Cache\ServiceProviders;

use Anodio\Cache\Config\CacheConfig;
use Anodio\Cache\Config\RedisCacheConfig;
use Anodio\Core\AttributeInterfaces\ServiceProviderInterface;
use Anodio\Core\Attributes\ServiceProvider;
use Psr\Log\LoggerAwareInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\ResettableInterface;
use Symfony\Contracts\Cache\CacheInterface;
use function DI\create;

#[ServiceProvider]
class CacheServiceProvider implements ServiceProviderInterface
{

    public function register(\DI\ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addDefinitions([
            'cacheAdapter'=>\Di\create()
                ->constructor(
                    \Di\get(CacheConfig::class),
                    \Di\create(\Anodio\Cache\CacheFactories\ArrayCacheFactory::class),
                    \Di\create(\Anodio\Cache\CacheFactories\RedisCacheFactory::class)
                        ->constructor(RedisCacheConfig::class)
                )->method('makeCacheAdapter'),
            AdapterInterface::class=>\Di\get('cacheAdapter'),
            CacheInterface::class=>\Di\get('cacheAdapter'),
            LoggerAwareInterface::class=>\Di\get('cacheAdapter'),
            ResettableInterface::class=>\Di\get('cacheAdapter'),
        ]);
    }
}