<?php

namespace Cto\Rabbit\Publisher;

use Cto\Rabbit\Helper\RabbitHelper;

class Publisher
{
    public static function publish($publisher, $message, $attribute = [])
    {
        RabbitHelper::publish($publisher, $message, $attribute);
    }
}