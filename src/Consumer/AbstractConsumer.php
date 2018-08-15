<?php

namespace Cto\Rabbit\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractConsumer
{
    public static function execute(AMQPMessage $message)
    {
        $result = self::consume($message);
        $chan = $message->delivery_info['channel'];
        $delivery_tag = $message->delivery_info['delivery_tag'];
        $result ? $chan->basic_ack($delivery_tag) : $chan->basic_nack($delivery_tag);
    }

    public abstract static function consume(AMQPMessage $message);
}
