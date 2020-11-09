<?php
session_start();
include('class/user_class.php');
include('class/shoutbox_class.php');
try
{
	include('pdo.php');
	if(isset($_POST) && !empty($_POST))
	{
		if(isset($_GET['a']) && !empty($_GET['a']))
		{
			switch($_GET['a'])
			{
				case 'login':
				
				if(isset($_POST['login']) && isset($_POST['pass']))
				{
					$usr = new user($pdo);
					if($usr->loginUser($_POST['login'], md5($_POST['pass']), true))
						echo 'OK';
				}
				break;
					
				case 'logout':
				
				if(isset($_SESSION['logged']))
				{
					$usr = new user($pdo, $_SESSION['nick']);
					$usr->logoutUser();
					echo 'OK';
				}
				break;
				
				case 'change_topic':
				
				if(isset($_SESSION['logged']) && isset($_POST['topic_input']))
				{
					$sb = new shoutbox($pdo, $_SESSION['nick']);
					if($sb->changeTopic($_POST['topic_input']))
						echo 'OK';
				}
				break;
				
				case 'sendmsg':
				
				if(isset($_SESSION['logged']) && isset($_POST['text']))
				{
					$sb = new shoutbox($pdo, $_SESSION['nick']);
					$sb->sendMessage($_POST['text']);
					echo 'OK';
				}
				break;
			}
		}
	}
	else if(isset($_GET['a']) && !empty($_GET['a']))
	{
		switch($_GET['a'])
		{
			case 'getmsgs':
				$sb = new shoutbox($pdo, ($_SESSION['logged'] ? $_SESSION['nick'] : null));
				echo $sb->GetMessages();
			break;
			
			case 'gettopic':
				$sb = new shoutbox($pdo, ($_SESSION['logged'] ? $_SESSION['nick'] : null));
				$data = $sb->GetTopicData();
				echo 'OK' . "\n" . $data['who'] . "\n" . $data['topic'];
			break;
		}
		
		
	}
}
catch (PDOException $e)
{
	echo "ERROR: " . $e->GetMessage();
}
?>