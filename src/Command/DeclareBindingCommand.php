<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Cto\Rabbit\Helper\RabbitHelper;
use Cto\Rabbit\Command\RabbitCommand;
use Cto\Rabbit\Message\Message;


class DeclareBindingCommand extends RabbitCommand
{
    public function configure()
    {
        $this->setName(Message::DECLARE_BINDING_COMMAND);
        $this->setDescription(Message::DECLARE_BINDING_DECRIPTION);
        $this->addArgument(Message::BINDING_PARAMETER, InputArgument::OPTIONAL, Message::BINDING);
        $this->addArgument(Message::CONNECTION_PARAMETER, InputArgument::OPTIONAL, Message::CONNECTION);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $exchange = $input->getArgument(Message::BINDING_PARAMETER);
        $connection = $input->getArgument(Message::CONNECTION_PARAMETER);
        $output->writeln($this->info(Message::START));
        $output->writeln($this->info(Message::START_DECLARING_BINDING));
        RabbitHelper::manageBinding($exchange, $connection);
        $output->writeln($this->info(Message::SUCCESS));
    }
}

