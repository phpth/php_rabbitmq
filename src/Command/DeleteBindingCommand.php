<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Cto\Rabbit\Helper\RabbitHelper;
use Cto\Rabbit\Command\RabbitCommand;
use Cto\Rabbit\Message\Message;

class DeleteBindingCommand extends RabbitCommand
{
    public function configure()
    {
        $this->setName(Message::DELETE_BINDING_COMMAND);
        $this->setDescription(Message::DELETE_BINDING_DESCRIPTION);
        $this->addArgument(Message::BINDING_PARAMETER, InputArgument::OPTIONAL, Message::BINDING);
        $this->addArgument(Message::CONNECTION_PARAMETER, InputArgument::OPTIONAL, Message::CONNECTION);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $binding = $input->getArgument(Message::BINDING_PARAMETER);
        $connection = $input->getArgument(Message::CONNECTION_PARAMETER);
        $this->info(Message::START);
        $this->info(Message::START_DELETING_BINDING);
        RabbitHelper::manageBinding($binding, $connection, true);
        $this->info(Message::SUCCESS);
    }
}