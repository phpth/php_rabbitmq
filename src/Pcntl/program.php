[program:<?= $consumer_name ?>]
command=<?= $consumer_command ?>
numprocs=<?= $consumer_num ?>
process_name=%(program_name)s_349%(process_num)01d
<?php
if (isset($consumer_out_log)) {
?>
stdout_logfile=<?= $consumer_out_log ?>
<?php
}
?>
<?php
if (isset($consumer_error_log)) {
    ?>
stdout_logfile=<?= $consumer_error_log ?>
<?php
}
?>
autostart=<?= $consumer_autostart ?>
autorestart=<?= $consumer_autorestart ?>
startsecs=<?= $consumer_startsecs ?>