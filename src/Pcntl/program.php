[program:<?= $consumer_name ?>]<?= PHP_EOL ?>
command=<?= $consumer_command ?><?= PHP_EOL ?>
numprocs=<?= $consumer_num ?><?= PHP_EOL ?>
process_name=%(program_name)s_%(process_num)02d<?= PHP_EOL ?>
<?php
if (isset($consumer_out_log)) {
    ?>
stdout_logfile=<?= $consumer_out_log ?><?= PHP_EOL ?>
<?php

}
?>
<?php
if (isset($consumer_error_log)) {
    ?>
stdout_logfile=<?= $consumer_error_log ?><?= PHP_EOL ?>
<?php

}
?>
autostart=<?= $consumer_autostart ?><?= PHP_EOL ?>
autorestart=<?= $consumer_autorestart ?><?= PHP_EOL ?>
startsecs=<?= $consumer_startsecs ?><?= PHP_EOL ?>