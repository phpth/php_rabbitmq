<?php

namespace Cto\Rabbit\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputIntrface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Process\Process;
use Cto\Rabbit\Helper\RabbitHelper;

class ConsumerPcntlConsumer extends Command
{
    public static $supportedAction = ['init', 'start', 'stop', 'reload'];

    public static $config;

    public $pcntlPath;

    public function __construct()
    {
        parent::__construct();
        $this->pcntlPath = __DIR__ . '/../Pcntl';   
    }

    public function configure()
    {
        $this->setName("rabbit:consumer:pcntl");
        $this->addArgument("action", InputArgument::REQUIRED, sprintf("supported actions: %s", implode(" ", self::$supportedAction)));
        $this->addArgument("param", InputArgument::OPTIONAL, "action parameter");
        $this->addArgument("connnection", InputArgument::OPTIONAL, "connection");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        self::$config = RabbitHelper::getConfig();
        $action = $input->getArgument("action");
        $param = $input->getArgument("param");
        $connection = $input->getArgument("connection") ? : self::$config['rabbitmq']['default_connection'];
        $this->checkActionSuppored($action);
        call_user_func_array([$this, $action], [$param, $connection]);
    }

    private function checkActionSuppored($action) {
        if (!in_array($action, self::$supportedAction)) {
            throw new \Exception("unsupported action");
        }
    }

    private function init($consumer, $connection)
    {
        $consumerDetail = $this->getConsumerDetail($consumer, $connection);

        $configTemplateLoader = new FilesystemLoader($this->pcntlPath);
        $templating = new PhpEngine(new TemplateNameParser(), $configTemplateLoader);

        $consumerCommand = sprintf('%s rabbit:consume %s', __DIR__ . '/../../rabbit_manager', $consumer);
        $consumerNumProcs = $consumerDetail['num_procs'] !== null ? $consumerDetail['num_procs'] : 1;

        $configValArray = [
            'consumer_name' => "$connection_$consumer",
            'consumer_command' => $consumerCommand,
            'consumer_num' => $consumerNumProcs,
            'consumer_autostart' => $consumerDetail['autostart'] !== null ? $consumerDetail['autostart'] : true,
            'consumer_autorestart' => $consumerDetail['autorestart'] !== null ? $consumerDetail['autorestart'] : true,
            'consumer_startsecs' => $consumerDetail['startsecs'] !== null ? $consumerDetail['startsecs'] : 30
        ];

        $consumerDetail['out_log'] !== null && $configValArray['consumer_out_log'] = $consumerDetail['out_log'];
        $consumerDetail['error_log'] !== null && $configValArray['consumer_error_log'] = $consumerDetail['error_log'];

        $config = $templating->render("program.php", $configValArray);

        $targetConfigFile = sprintf("%s/Conf/%s.ini", $this->pcntlPath, $consumer);
        file_put_contents($targetConfigFile, $config);
    }

    private function start($consumer, $connection)
    {
        $this->checkPcntlConfigExist($consumer);
        $cmd = sprintf("/usr/bin/supervisorctl -c %s start %s", $this->pcntlPath . '/supervisord.conf', "$connection_$consumer");
        $this->runCommand($cmd);
    }

    private function stop($consumer, $connection)
    {
        $this->checkPcntlConfigExist($consumer);
        $cmd = sprintf("/usr/bin/supervisorctl -c %s stop %s", $this->pcntlPath . '/supervisord.conf', "$connection_$consumer");
        $this->runCommand($cmd);
    }

    private function reload($consumer = null, $connection = null)
    {
        $this->checkPcntlConfigExist($consumer);
        $cmd = sprintf("/usr/bin/supervisorctl -c %s reload", $this->pcntlPath . '/supervisord.conf');
        $this->runCommand($cmd);
    }

    private function status($consumer, $connection)
    {
        // $this->checkPcntlConfigExist($consumer);
    }

    private function getConsumerDetail($consumer, $connection)
    {
        $config = self::$config;
        if (!isset($config['rabbitmq']['connections'][$connection]['consumers'][$consumer])) {
            throw new \Exception("consumer $consumer not exits");
        }
        return $config['rabbitmq']['connections'][$connection]['consumers'][$consumer];
    }

    private function checkPcntlConfigExist($consumer)
    {
        $configPath = sprintf("%s/Conf/%s.ini", $this->pcntlPath, $consumer);
        if (!file_exists($configPath)) {
            throw new \Exception("config file not found, init first");
        }
    }

    private function runCommand($cmd)
    {
        $proc = new Process($cmd);
        $proc->run();
    }
}