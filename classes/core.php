<?php

class Core
{
	var $name;


	public function debug($data)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}

	public function sqlSetup()
	{
		global $config;

		$configDB = $config['db'];
		try {
			$sql = new PDO('mysql:host=' . $configDB['host'] . ';dbname=' . $configDB['data'], $configDB['user'], $configDB['pass']);
			$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $sql;
		} catch (PDOException $e) {
			die("Error setting up PDO:<hr>" . $e);
		}
	}

	public function message($message, $severity)
	{
		$this->debug("MESSAGE: " . $message);
	}

	public function redirect($page = "index")
	{
		global $config;
		$actual_link = rtrim($config['homepage'], "/") . "/" . $page . ".php";
		header("Refresh:0; url=" . $actual_link);
	}

	public function is_localhost()
	{

		$local = array('127.0.0.1', '::1');

		if (in_array($_SERVER['REMOTE_ADDR'], $local)) {
			return true;
		} else {
			return false;
		}
	}

	public function is_logged_in()
	{
		if (isset($_SESSION) && isset($_SESSION["user_email"]) && !empty("user_email")) {
			return true;
		} else {
			return false;
		}

	}

	public function navLogin()
	{
		if ($this->is_logged_in()) {
			return '
				<li class="dropdown">               
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="' . $_SESSION["user_picture"] . '" class="user-img"> ' . $_SESSION["user_name"] . ' <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="no-hover">Logged in via ' . $_SESSION["user_social_type"] . ' </a></li>
                        <li><a href="#">Your History</a></li>
                        <li><a href="#">Your Account</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="?logout">Logout</a></li>
                    </ul>
                </li>';
		} else {
			return "<a class='animate' href='login.php'>Login to Play</a>";
		}
	}

}