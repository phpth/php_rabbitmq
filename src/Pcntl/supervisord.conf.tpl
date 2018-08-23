[unix_http_server]
file=<?= $sock_path . PHP_EOL ?>
chmod=0777

[supervisord]
logfile=<?= $log_file . PHP_EOL ?>
pidfile=<?= $pid_file . PHP_EOL ?>

[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface

[supervisorctl]
serverurl=unix://<?= $sock_path . PHP_EOL ?>

[include]
files = <?= $config_pattern . PHP_EOL ?>
