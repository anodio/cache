<?php

namespace Anodio\Cache\Interfaces;

interface JsonCacheToObjectInterface
{
    public function fromCache(string $json): static;
}