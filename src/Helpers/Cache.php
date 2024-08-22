<?php

namespace Anodio\Cache\Helpers;

use Anodio\Cache\Interfaces\JsonCacheToObjectInterface;
use Anodio\Cache\Interfaces\ObjectToJsonCacheInterface;
use Anodio\Core\ContainerStorage;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class Cache
{
    /**
     * @param string $key
     * @template T
     * @param string|class-string<T> $template
     * @return mixed|T
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function get(string $key, string $template)
    {
        $container = ContainerStorage::getContainer();
        $cacheAdapter = $container->get(AdapterInterface::class);
        $data = $cacheAdapter->getItem($key)->get();
        $object = $container->make($template);
        if ($object instanceof \Anodio\Cache\Interfaces\JsonCacheToObjectInterface) {
            return $object->fromCache($data);
        } else {
            throw new \Exception('The template must implement '. JsonCacheToObjectInterface::class);
        }
    }

    public static function set(string $key, ObjectToJsonCacheInterface $value, int $ttl = 0): bool
    {
        $container = ContainerStorage::getContainer();
        $cacheAdapter = $container->get(AdapterInterface::class);
        $item = $cacheAdapter->getItem($key);
        $item->set($value->toCache());
        $item->expiresAfter($ttl);
        return $cacheAdapter->save($item);
    }

    public static function delete(string $key): bool
    {
        $container = ContainerStorage::getContainer();
        $cacheAdapter = $container->get(AdapterInterface::class);
        return $cacheAdapter->deleteItem($key);
    }

    public static function has(string $key) {
        $container = ContainerStorage::getContainer();
        $cacheAdapter = $container->get(AdapterInterface::class);
        return $cacheAdapter->hasItem($key);
    }

    public static function clear(): bool
    {
        $container = ContainerStorage::getContainer();
        $cacheAdapter = $container->get(AdapterInterface::class);
        return $cacheAdapter->clear();
    }
}