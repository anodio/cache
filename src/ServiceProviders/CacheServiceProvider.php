<?php

namespace Anodio\Cache\ServiceProviders;

use Anodio\Cache\CacheFactories\CacheMultiFactory;
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
            'cacheFactory'=>\Di\create(CacheMultiFactory::class)
                ->constructor(
                    \Di\get(CacheConfig::class),
                    \Di\create(\Anodio\Cache\CacheFactories\ArrayCacheFactory::class),
                    \Di\create(\Anodio\Cache\CacheFactories\RedisCacheFactory::class)
                        ->constructor(\Di\get(RedisCacheConfig::class))
                ),
//            'cacheAdapter'=>\Di\factory([\Di\get('cacheFactory'), 'makeCacheAdapter']),
            'cacheAdapter'=>\Di\factory(fn(CacheMultiFactory $cacheFactory) => $cacheFactory->makeCacheAdapter())->parameter('cacheFactory', \Di\get('cacheFactory')),
            AdapterInterface::class=>\Di\get('cacheAdapter'),
            CacheInterface::class=>\Di\get('cacheAdapter'),
            LoggerAwareInterface::class=>\Di\get('cacheAdapter'),
            ResettableInterface::class=>\Di\get('cacheAdapter'),
        ]
        );
    }
}
