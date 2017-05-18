<?php

class Core
{

	/**
	 * Simple debug, saves time writing out debug code each time.
	 * Should not be used in a production environment.
	 *
	 * @param mixed $data - the data you would like to debug
	 */
	public function debug($data)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}

	/**
	 * Responsible for building every single MySQL interaction.
	 *
	 * @throws string - on PDO will kill page and output an error
	 * @return PDO|false $sql - returns true if the score has been added
	 */
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

	/**
	 * Currently used for outputting straight errors.
	 *
	 * @param string $message - The string to output
	 * @param boolean $severity - Color coding based off of bootstraps colour
	 */
	public function message($message, $severity = false)
	{
		// TODO: Place messages inside of session and output with another function like displayMessage() which clears message session on display
		$this->debug("MESSAGE: " . $message);
	}

	/**
	 * Redirects users with the PHP header.
	 * Builds redirection URL from the config and adds the input on the end.
	 *
	 * @param string $page - the page you would like to send the user to
	 */
	public function redirect($page = "index")
	{
		global $config;
		$actual_link = rtrim($config['homepage'], "/") . "/" . $page . ".php";
		header("Refresh:0; url=" . $actual_link);
	}

	/**
	 * Checks if this project is running on localhost.
	 *
	 * @return true|false - returns true if running on localhost
	 */
	public function is_localhost()
	{

		$local = array('127.0.0.1', '::1');

		if (in_array($_SERVER['REMOTE_ADDR'], $local)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks if the visitor is logged in.
	 *
	 * @return true|false - true if PHP session is set and user_email is present
	 */
	public function is_logged_in()
	{
		if (isset($_SESSION) && isset($_SESSION["user_email"]) && !empty($_SESSION["user_email"])) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Returns the dynamic nav content based on the user been logged in
	 *
	 * @return string - content to display
	 */
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

	/**
	 * Sort an array by rank (used for usort)
	 *
	 * @param array $a
	 * @param array $b
	 * @return array
	 */
	public function sortByOrder($a, $b)
	{
		return $a['rank'] - $b['rank'];
	}

}