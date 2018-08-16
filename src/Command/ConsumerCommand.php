<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Cto\Rabbit\Message\Message;
use Symfony\Component\Console\Input\InputArgument;
use Cto\Rabbit\Helper\RabbitHelper;


class ConsumerCommand extends RabbitCommand
{
    public function configure()
    {
        $this->setName(Message::CONSUME_COMMAND);
        $this->setDescription(Message::CONSUME_DESCRIPTION);
        $this->addArgument(Message::CONSUMER_PARAMETER, InputArgument::REQUIRED, Message::CONSUMER);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $consumer = $input->getArgument(Message::CONSUMER_PARAMETER);
        $output->writeln($this->info(Message::START));
        RabbitHelper::consume($consumer);
    }
}