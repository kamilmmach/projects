<?php
class shoutbox 
{
	private $_pdo;
	private $_users;
	
	public function __construct($pdo, $nick = null)
	{
		$this->_pdo = $pdo;
		$this->_users = array(0 => null, 1 => new user($pdo));
		if($nick != null)
			$this->_users[0] = new user($pdo, $nick);
			
	}
	
	public function GetTopicData()
	{
        $q = $this->_pdo->query('SELECT * FROM topic ORDER BY id DESC');

        $r = $q->fetch();
    
		return $this->TranslateMessage($r);
	}
	
	public function ChangeTopic($topic)
	{
		if($this->_users[0]->GetUserProp('level') >= 5)
		{
			$query = $this->_pdo->prepare('INSERT INTO topic(who, topic) VALUES(:nick, :topic)');
			$query->bindParam(':nick', $this->_users[0]->GetUserProp('nick'), PDO::PARAM_STR, strlen($this->_users[0]->GetUserProp('nick')));
			$query->bindParam(':topic', $topic, PDO::PARAM_STR, strlen($topic));
			$query->execute();
			return true;
		}
		return false;
	}
	
	private function GetMessagesFromDB($limit = 15)
	{
		$limit = (int)$limit;
		$query = $this->_pdo->prepare('SELECT * FROM messages ORDER BY time DESC LIMIT :limit');
		$query->bindParam(':limit', $limit, PDO::PARAM_INT);
		$query->execute();
		$row = $query->fetchAll();
		krsort($row);
		return $row;
	}
	
	public function GetMessages()
	{
		$msg = '';
		if($this->_users[0] instanceof users)
		{
			$message_array = $this->GetMessagesFromDB($this->_users[0]->GetUserProp('per_page'));
		}
		else
		{
			$message_array = $this->GetMessagesFromDB();
		}
		$last_date = 0;
		foreach ($message_array as $n)
		{
			if($last_date == 0)
			{
				$last_date = date("d-m-Y", $n['time']);
			}
			else
			{
				if(strtotime(date("d-m-Y", $n['time'])) > strtotime($last_date))
				{
					$msg .= '<p class="newday"> </p>';
				}
			}
			if($n['type'] == 1)
			{
				if (!$this->_users[1]->GetUserData($n['nick']))
				{
					$msg .= '<p class="post gray"><span title="' .date("d-m-Y H:i:s", $n['time']). '">(' .date("H:i", $n['time']). ')</span> ' . $n['nick'] . ': ' .$this->TranslateMessage($n['message']). '</p>' . "\n";
				}
				else
				{
					$msg .= '<p class="post"><span title="' .date("d-m-Y H:i:s", $n['time']). '">(' .date("H:i", $n['time']). ')</span> ' . $this->_users[1]->GetUserSign() . '<span style="color: '. $this->_users[1]->GetUserColor() .'">' . $n['nick'] . '</span>: ' .$this->TranslateMessage($n['message']). '</p>' . "\n";
				}
			}
			elseif ($n['type'] == 2)
			{
				$msg .= '<p class="post"><span style="color: #cb1b1b">* '. $this->TranslateMessage($n['message']) .'</span></p>' . "\n";
			}
			$last_date = date("d-m-Y", $n['time']);
		}
		
		return $msg;
	}
	
	public function sendMessage($msg)
	{
		$type = $this->getTypeOfMsg($msg);
		$time = time();
		$query = $this->_pdo->prepare('INSERT INTO messages(type, nick, time, message) VALUES(:type, :nick, :time, :msg)');
		$query->bindParam(':type', $type, PDO::PARAM_INT);
		$query->bindValue(':nick', $this->_users[0]->GetUserProp('nick'), PDO::PARAM_STR);
		$query->bindParam(':time', $time, PDO::PARAM_INT);
		$query->bindParam(':msg', $msg, PDO::PARAM_STR, strlen($msg));
		$query->execute();
	}
	
	private function getTypeOfMsg(&$msg)
	{
		if(substr($msg, 0, 1) != '/')
			return 1;
		else
		{
			$fs = strpos($msg, ' ');
			$cmd = substr($msg, 1, $fs-1);
			switch($cmd)
			{
				case 'ann':
					$msg = substr($msg, $fs);
					if($this->_users[0]->GetUserProp('level') >= 5)
					{
						return 2;
					}
				break;
			}
			return 1;
		}
			
	}
	
	private function TranslateMessage($msg)
	{
		if (is_array($msg))
		{
			foreach ($msg as $name => $value)
			{
				$msg[$name] = $this->TranslateMessage($value);
			}
		}
		else 
		{
			$msg = htmlspecialchars(trim($msg));
			$msg = preg_replace("#\[b\](.*?)\[/b\]#si", "<b>\\1</b>", $msg);
			$msg = preg_replace("#\[i\](.*?)\[/i\]#si", "<i>\\1</i>", $msg);
			$msg = preg_replace("#\[u\](.*?)\[/u\]#si", "<u>\\1</u>", $msg);
			
		}
		return $msg;
	}
}
?>
