<?php require( "assets/php-header.php" );
	$core->debug($_GET);
	$core->debug($_POST);

	if ($_GET['authFor']) {
		$auth->handleLogin($_GET['authFor'], true);
	} else {
		$core->redirect();
	}
?>