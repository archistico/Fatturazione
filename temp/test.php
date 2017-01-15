<?php

include '../php/config.php';
include '../php/utilita.php';

$mysqlUserName      = $dbuser;
$mysqlPassword      = $dbpswd;
$mysqlHostName      = $dbhost;
$DbName             = $dbname;

$filename = "../backup/backup-" . date('Y-m-d')."_".date('H-i-s') . ".sql";
exec("mysqldump --user=$mysqlUserName --password=$mysqlPassword --host=$mysqlHostName $DbName > $filename");

