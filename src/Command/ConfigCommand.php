<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class ConfigCommand extends RabbitCommand
{
    public function configure()
    {
        $this->setName("rabbit:config");
        $this->addArgument("config_file_path", InputArgument::REQUIRED, "配置参数");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $input->getArgument("config_file_path");
        $fs = new Filesystem();
        if (!$fs->exists($config)) {
            $output->writeln($this->error("file $config not exists"));
        }
        $localConfigFile = dirname(dirname(dirname(__FILE__))) . '/rabbit_config';
        if ($fs->exists($localConfigFile)) {
            $fs->remove($$localConfigFile);
        }
        $fs->symlink($config, $localConfigFile);
        $fs->exists($localConfigFile) ? $output->writeln($this->info("config success")) : $output->writeln($this->error("config error"));
    }
}