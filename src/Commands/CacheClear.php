<?php

namespace Anodio\Cache\Commands;

use Anodio\Core\Attributes\Command;
use DI\Attribute\Inject;
use Symfony\Component\Cache\ResettableInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[Command('cache:clear')]
class CacheClear extends \Symfony\Component\Console\Command\Command
{
    #[Inject]
    public  $cacheAdapter;
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->cacheAdapter->reset();
        echo 'CACHE WAS NOT CLEARED';
        return 0;
    }
}