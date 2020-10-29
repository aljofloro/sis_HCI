<?php
  require_once("../classes/Configuration.php");
  $configuration = Configuration::getConfiguration();
  $configuration->set('dbDriver', 'mysql');
  $configuration->set('dbServer', 'localhost');
	$configuration->set('dbBase', 'csjtacna');
	$configuration->set('dbUser', 'root');
  $configuration->set('dbPwd', '');
  $configuration->set('dbCharset','utf8');
?>