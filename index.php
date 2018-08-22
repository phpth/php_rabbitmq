<?php

require_once "./vendor/autoload.php";

use Cto\Rabbit\Publisher\Publisher;


Publisher::publish('publisher1', "hello world");