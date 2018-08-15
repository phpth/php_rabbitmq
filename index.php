<?php

require_once "./vendor/autoload.php";

use Cto\Rabbit\Publisher\Publisher;


for ($i = 0; $i < 100; $i++) {
    Publisher::publish('publisher1', "hello world");
}