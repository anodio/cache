<?php

namespace Anodio\Cache\Config;

use Anodio\Core\AttributeInterfaces\AbstractConfig;
use Anodio\Core\Attributes\Config;
use Anodio\Core\Configuration\Env;

#[Config(name: 'cache')]
class CacheConfig extends AbstractConfig
{
    #[Env('CACHE_DRIVER', default: 'array')]
    public string $driver;
}