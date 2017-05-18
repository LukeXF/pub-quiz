<?php require("assets/php-header.php");


if (!isset($_GET['noJson'])) {
	header('Content-Type: application/json');
}


$error = null; // any error that occur
$return = array(); // the returned output

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$request = $_POST;
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
	$request = $_GET;
} else {
	$error = "Invalid request method, this API service only accepts GET and POST request";
	$request = false;
}
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
	$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}


if (isset($request['type']) && $request['type'] == "addScore") {

	if ($core->is_logged_in()) {

		if (isset($request['score']) && isset($request['category']) && isset($_SESSION['user_id'])) {
			$request['user_id'] = $_SESSION['user_id'];
			if (!$lb->checkIfAlreadyEnteredRecently($request)) {
				$return['meta']['success'] = $lb->addScore($request);
			} else {
				$error = "That result has already been entered in the past 5 minutes";
			}

		} else {
			$error = "Invalid data provided to add a new leaderboard score. Please check you are passing score, category and user_id.";
		}

	} else {
		$error = "You are not logged in.";
	}
} else if (isset($request['type']) && $request['type'] == "getLeaderboards") {
	$return['meta']['success'] = $lb->getLeaderboards();
} else {
	$error = "There was no valid request type assigned, please check that valid request type is set.";
}


if ($error != null) {
	$return['meta']['error'] = $error;
	$return['meta']['success'] = false;
}
$return['debug']['request_method'] = $_SERVER['REQUEST_METHOD'];
$return['debug']['request'] = $request;

if (isset($_GET['debug'])) {
	unset($return['debug']);
}
echo json_encode($return);
