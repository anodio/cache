<?php

namespace Anodio\Cache\Config;

use Anodio\Core\AttributeInterfaces\AbstractConfig;
use Anodio\Core\Attributes\Config;
use Anodio\Core\Configuration\Env;

#[Config(name: 'redisCache')]
class RedisCacheConfig extends AbstractConfig
{
    #[Env('REDIS_CACHE_HOST', default: '0.0.0.0')]
    public string $host;

    #[Env('REDIS_CACHE_PORT', default: '6379')]
    public int $port;

    #[Env('REDIS_CACHE_USERNAME', default: '')]
    public string $username;

    #[Env('REDIS_CACHE_PASSWORD', default: '')]
    public string $password;

    #[Env('REDIS_CACHE_DATABASE_NUM', default: '0')]
    public int $databaseNum;

    #[Env('REDIS_CACHE_PREFIX', default: 'cache_')]
    public string $prefix;
}