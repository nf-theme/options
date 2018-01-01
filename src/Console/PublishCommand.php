<?php

namespace NightFury\Option\Console;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PublishCommand extends Command
{
    protected function configure()
    {
        $this->setName('nfoption:publish')
            ->setDescription('Publish view file for theme option');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!is_dir('resources/views')) {
            throw new Exception("views folder not found", 1);
        }
        if (!is_dir('resources/views/vendor')) {
            mkdir('resources/views/vendor', 0755);
        }
        if (!is_dir('resources/views/vendor/option')) {
            mkdir('resources/views/vendor/option', 0755);
        }
        if (!file_exists('resources/views/vendor/option/admin.blade.php')) {
            copy('vendor/nf/option/resources/views/admin.blade.php', 'resources/views/vendor/option/admin.blade.php');
        }
    }
}
