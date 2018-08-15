<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Cto\Rabbit\Helper\RabbitHelper;
use Cto\Rabbit\Command\RabbitCommand;
use Cto\Rabbit\Message\Message;

class DeleteAllCommand extends RabbitCommand
{
    public function configure()
    {
        $this->setName(Message::DELETE_ALL_COMMAND);
        $this->setDescription(Message::DELETE_ALL_DESCRIPTION);
        $this->addArgument(Message::FORCE_PARAMETER, InputArgument::OPTIONAL, Message::FORCE);
        $this->addArgument(Message::CONNECTION_PARAMETER, InputArgument::OPTIONAL, Message::CONNECTION);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $force = $input->getArgument(Message::FORCE_PARAMETER);
        if (!$force) {
            $output->writeln($this->error(Message::FORCE_WARNING));
            return;
        }
        $connection = $input->getArgument(Message::CONNECTION_PARAMETER);
        $output->writeln($this->info(Message::START));
        $output->writeln($this->info(Message::START_DELETING_BINDING));
        RabbitHelper::manageBinding(null, $connection, true);
        $output->writeln($this->info(Message::START_DELETING_EXCHANGE));
        RabbitHelper::manageExchange(null, $connection, true);
        $output->writeln($this->info(Message::START_DELETING_QUEUE));
        RabbitHelper::manageQueue(null, $connection, true);
        $output->writeln($this->info(Message::SUCCESS));
    }
}