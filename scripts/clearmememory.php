<?php
$output = null;
$retval = null;
$command1  = "sync; echo 1 > /proc/sys/vm/drop_caches";
exec($command1, $output, $retval);

$command2  = "sync; echo 2 > /proc/sys/vm/drop_caches";
exec($command2, $output, $retval);

$command3  = "sync; echo 3 > /proc/sys/vm/drop_caches";
exec($command3, $output, $retval);

$command4  = "swapoff -a && swapon -a";
exec($command4, $output, $retval);
?>
