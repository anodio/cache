<?php

namespace Anodio\Cache\Commands;

use Anodio\Cache\Config\CacheConfig;
use Anodio\Cache\Config\RedisCacheConfig;
use Anodio\Cache\Helpers\Cache;
use Anodio\Core\Attributes\Command;
use DI\Attribute\Inject;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[Command('cache:clear', 'Clear the cache')]
class CacheClear extends \Symfony\Component\Console\Command\Command
{
    #[Inject]
    public AdapterInterface $cacheAdapter;

    #[Inject]
    public RedisCacheConfig $redisCacheConfig;

    #[Inject]
    public CacheConfig $cacheConfig;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        Cache::clear();
        $output->writeln('Cache cleared: '.$this->cacheConfig->driver);

        return 0;
    }
}