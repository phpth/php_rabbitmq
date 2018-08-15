<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Cto\Rabbit\Helper\RabbitHelper;
use Cto\Rabbit\Command\RabbitCommand;
use Cto\Rabbit\Message\Message;

class DeleteQueueCommand extends RabbitCommand
{
    public function configure()
    {
        $this->setName(Message::DELETE_QUEUE_COMMAND);
        $this->setDescription(Message::DELETE_QUEUE_DESCRIPTION);
        $this->addArgument(Message::QUEUE_PARAMETER, InputArgument::OPTIONAL, Message::QUEUE_NAME);
        $this->addArgument(Message::CONNECTION_PARAMETER, InputArgument::OPTIONAL, Message::CONNECTION);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $queue = $input->getArgument(Message::QUEUE_PARAMETER);
        $connection = $input->getArgument(Message::CONNECTION_PARAMETER);
        $output->writeln($this->info(Message::START));
        $output->writeln($this->info(Message::START_DELETING_QUEUE));
        RabbitHelper::manageQueue($queue, $connection, true);
        $output->writeln($this->info(Message::SUCCESS));
    }
}