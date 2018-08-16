<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Cto\Rabbit\Message\Message;

class ConfigCommand extends RabbitCommand
{
    public function configure()
    {
        $this->setName(Message::CONFIG_COMMAND);
        $this->addArgument(Message::CONFIG_PARAMETER, InputArgument::REQUIRED, Message::CONFIG);
        $this->setDescription(Message::CONFIG_DESCRIPTION);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $root = trim($input->getArgument(Message::CONFIG_PARAMETER));
        if ($root[strlen($root) - 1] != DIRECTORY_SEPARATOR) {
            $root .= DIRECTORY_SEPARATOR;
        }
        if (!is_dir($root)) {
            $output->writeln($this->error("path $root not exists"));
            return;
        }
        $localConfigFile = dirname(dirname(dirname(__FILE__))) . '/config';
        if (!file_exists($localConfigFile)) {
            touch($localConfigFile);
        }
        file_put_contents($localConfigFile, $root);
        $output->writeln($this->info(Message::SUCCESS));
    }
}