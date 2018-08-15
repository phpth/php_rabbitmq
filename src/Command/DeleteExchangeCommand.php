<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Cto\Rabbit\Helper\RabbitHelper;
use Cto\Rabbit\Command\RabbitCommand;
use Cto\Rabbit\Message\Message;

class DeleteExchangeCommand extends RabbitCommand
{
    public function configure()
    {
        $this->setName(Message::DELETE_EXCHANGE_COMMAND);
        $this->setDescription(Message::DELETE_EXCHANGE_DESCRIPTION);
        $this->addArgument(Message::EXCHANGE_PARAMETER, InputArgument::OPTIONAL, Message::EXCHANGE_NAME);
        $this->addArgument(Message::CONNECTION_PARAMETER, InputArgument::OPTIONAL, Message::CONNECTION);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $exchange = $input->getArgument(Message::EXCHANGE_PARAMETER);
        $connection = $input->getArgument(Message::CONNECTION_PARAMETER);
        $this->info(Message::START);
        $this->info(Message::START_DELETING_EXCHANGE);
        RabbitHelper::manageExchange($exchange, $connection, true);
        $this->info(Message::SUCCESS);
    }
}