<?php
date_default_timezone_set("Asia/Kolkata");
$output = null;
$retval = null;
$command  = "mysqldump psc > /var/www/html/psc/datadump/psc_".date("Y_m_d_His").".sql";
exec($command, $output, $retval);
echo "Returned with status $retval and output:\n";
?>
