<?php
error_reporting(E_ALL);
session_start();
ini_set('magic_quotes_gpc', 'off');
include('class/templates_class.php');
include('class/user_class.php');
include('class/shoutbox_class.php');

try 
{	
	include('pdo.php');

	$sb = new shoutbox($pdo, (isset($_SESSION['logged']) ? $_SESSION['nick'] : null));
	$topic = $sb->GetTopicData();
	
	// Layout
	$tpl = new template('templates/standard/');
	$tpl->addVar('topic_who', $topic['who']);
	$tpl->addVar('topic', $topic['topic']);
	$tpl->addVar('text', $sb->GetMessages());
	if(isset($_SESSION['logged']))
	{
		$tpl->addVar('sendform', file_get_contents($tpl->dir . 'sendform.tpl'));
		$tpl->addVar('logout', '<a href="#" id="logout">Logout</a> |');
	}
	else
	{
		$tpl->addVar('sendform', file_get_contents($tpl->dir . 'notlogged.tpl'));
		$tpl->addVar('logout', ' ');
	}
	$tpl->Display('index.tpl');
}
catch (PDOException $e)
{
	echo "ERROR: " . $e->GetMessage();
}


?>
