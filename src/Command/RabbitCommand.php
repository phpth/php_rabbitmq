<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Command\Command;

class RabbitCommand extends Command
{
    public $stringTemplate = "<%s>%s</%s>";

    public function info($message)
    {
        return sprintf($this->stringTemplate, "info", $message, "info");
    }

    public function error($message)
    {
        return sprintf($this->stringTemplate, "error", $message, "error");
    }

    public function question($message)
    {
        return sprintf($this->stringTemplate, "question", $message, "question");
    }

    public function comment($message)
    {
        return sprintf($this->stringTemplate, "comment", $message, "comment");
    }
}