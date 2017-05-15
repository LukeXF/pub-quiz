<?php

class Core {
	var $name;


	public function debug( $data ) {
		echo "<pre>";
		print_r( $data );
		echo "</pre>";
	}

	public function sqlSetup() {
		global $config;

		$configDB = $config['db'];
		try {
			$sql = new PDO( 'mysql:host=' . $configDB['host'] . ';dbname=' . $configDB['data'], $configDB['user'], $configDB['pass'] );
			$sql->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			return $sql;
		} catch ( PDOException $e ) {
			die( "Error setting up PDO:<hr>" . $e );
		}
	}

	public function message( $message, $severity ) {
		$this->debug( "MESSAGE: " . $message );
	}

	public function redirect( $page = false ) {
		global $config;
		$actual_link = rtrim( $config['homepage'], "/" ) . "/" . $page;
		header( "Refresh:0; url=" . $actual_link );
	}

	public function is_localhost() {
		
		$local = array( '127.0.0.1', '::1' );

		if ( in_array( $_SERVER['REMOTE_ADDR'], $local ) ) {
			return true;
		} else {
			return false;
		}
	}


}