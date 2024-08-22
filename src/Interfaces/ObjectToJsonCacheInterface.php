<?php

namespace Anodio\Cache\Interfaces;

interface ObjectToJsonCacheInterface
{
    public function toCache(): string;
}