<?php

session_start();

require_once 'config.php';
date_default_timezone_set($config['timezone']);

require_once 'helpers.php';

require_once 'models/base.php';
foreach(glob("lib/models/*.php") as $filter)
	require_once $filter;

foreach(glob("lib/filters/*.php") as $filter)
	require $filter;