<?php

require_once "./vendor/autoload.php";

define("RABBITMQ_CONFIG_FILE", realpath("./rabbitmq.example.yml"));

Publisher::init();