<?php

include("../config.php");
$user=20;
	lock_rst($user);
	$rst=read_rst($user);

	$rst[Status][4]=strval(100);
	$rst[Status][8]=strval(100);
	$rst[Status][2]=strval(100);

	write_rst($user,$rst);
	unlock_rst($user);
?>