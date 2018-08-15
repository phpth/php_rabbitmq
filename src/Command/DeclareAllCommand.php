<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Cto\Rabbit\Helper\RabbitHelper;
use Cto\Rabbit\Command\RabbitCommand;
use Cto\Rabbit\Message\Message;


class DeclareAllCommand extends RabbitCommand
{
    public function configure()
    {
        $this->setName(Message::DECLARE_ALL_COMMAND);
        $this->setDescription(Message::DECLARE_ALL_DESCRIPTION);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->info(Message::START));
        $output->writeln($this->info(Message::START_DECLARING_QUEUE));
        RabbitHelper::manageQueue();
        $output->writeln($this->info(Message::START_DECLARING_EXCHANGE));
        RabbitHelper::manageExchange();
        $output->writeln($this->info(Message::START_DECLARING_BINDING));
        RabbitHelper::manageBinding();
        $output->writeln($this->info(Message::SUCCESS));
    }
}

