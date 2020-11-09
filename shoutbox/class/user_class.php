<?php
class user
{
	private $_pdo;
	private $_userData;
	
	public function __construct($pdo, $nick = null)
	{
		$this->_pdo = $pdo;
		if($nick == null)
		{
			$this->_userData = null;
		}
		else
		{
			if(!$this->GetUserData($nick))
				throw new PDOException("User does not exist.");
		}
	}
		
	public function GetUserData($nick)
	{
		$query = $this->_pdo->prepare('SELECT * FROM users WHERE nick = :nick');
		$query->bindParam(':nick', $nick, PDO::PARAM_STR, strlen($nick));
		$query->execute();
		$this->_userData = $query->fetch(PDO::FETCH_ASSOC);
		
		if($this->_userData !== false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function GetUserColor()
	{
		return $this->GetUserProp('color');
	}
	
	public function GetUserPassword()
	{
		return $this->GetUserProp('password');
	}
	
	public function GetUserSign()
	{
		return $this->GetUserProp('sign');
	}
	
	public function GetUserProp($what)
	{
		if($this->_userData === null)
			throw new PDOException("No user selected.");
			
		if(isset($this->_userData[$what]))
		{
			return $this->_userData[$what];
		}
		else
		{
			throw new PDOException('No such prop as ' . $what . '.');
		}
	}
	
	public function loginUser($nick, $pass, $staylogged = false)
	{
		if($this->GetUserData($nick))
		{
			if($this->_userData['password'] == $pass)
			{
				$_SESSION['logged'] = true;
				$_SESSION['nick'] = $nick;
				if($staylogged)
				{
					setcookie('sb_login', $nick);
					setcookie('sb_pass', $pass);
				}
				return true;
			}
		}
		return false;
	}
	
	public function loginByCookie($login, $pass)
	{
		if($this->loginUser($login, $pass, true))
		{
			return true;
		}
		return false;
	}
	
	public function logoutUser()
	{
		session_destroy();
		setcookie('sb_login', '', time() - 3600);
		setcookie('sb_pass', '', time() - 3600);
	}
}
?>