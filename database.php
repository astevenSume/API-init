<?php
	$conf=require("config/config.php");
	require("common/MyConnection.php");
	$db = new Workerman\MySQL\Connection($conf['host'], $conf['port'], $conf['user'], $conf['password'], $conf['db_name']);
	unset($conf);

