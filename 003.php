<?php 
/**
 * 
 */
class Login
{
	protected $users;
	protected $current_login;
	function __construct()
	{
		$this->users = ['id_users'=> "USERS".time(),'username'=> 'root', 'password'=> 'secret'];
		$this->current_login = [];
	}

	public function update_current($id="", $username="", $password="", $last="", $status="")
	{
		if ($status == 'logged in') 
		{
			$this->current_login['id_login'] = $id;
			$this->current_login['username'] = $username;
			$this->current_login['password'] = $password;
			$this->current_login['last_login'] = $last;
			$this->current_login['status'] = $status;
		}
		elseif ($status == 'logged out') 
		{
			$this->current_login['status'] = $status;
		}
	}

	public function data_login()
	{
		return $this->current_login;
	}

	protected function data_users()
	{
		$this->users['password'] = hash('md5', $this->users['password']);
		return $this->users;
	}
}

/**
 * 
 */
class Auth extends Login
{
	protected $users, $current_login;
	function __construct()
	{
		parent::__construct();
		$this->users = parent::data_users();
		$this->current_login = parent::data_login();
	}


	function login($data_login)
	{
		// PERIKSA LOGIN
		if ($data_login['username'] == $this->users['username'] and hash('md5', $data_login['password']) == $this->users['password']) 
		{
			parent::update_current(date("Ymd")."-".time(), $this->users['username'], hash('md5', $data_login['password']), 	date("d F Y g:i a"), "logged in");
		}
	}

	function validate($data_login)
	{
		if ($data_login['username'] == $this->users['username'] and hash('md5', $data_login['password']) == $this->users['password']) 
		{
			return true;
		}
	}

	function logout()
	{
		parent::update_current("","","","","logged out");
	}

	function user()
	{
		return $this->current_login;
	}

	function id()
	{
		return $this->users['id_users'];
	}

	function check()
	{
		if ($this->current_login['status'] == 'logged in') 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function guest()
	{
		if ($this->current_login['status'] == 'logged out') 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function lastLogin()
	{
		return $this->current_login['last_login'];
	}
}


$auth = new Auth;
$auth->login(['username'=> 'root', 'password'=> 'secret']);
$auth->validate(['username'=> 'root', 'password'=> 'secret']);
$auth->logout();
$auth->id();
$auth->check();
$auth->guest();
$auth->lastLogin();

 ?>