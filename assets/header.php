<?php

	require_once('php-header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Pub Quiz">
	<meta name="author" content="me@luke.sx">
	<link rel="icon" href="assets/img/favicon.png" type="image/png"/>
	<title>Pub Quiz</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" crossorigin="anonymous" />
	<link rel="stylesheet" href="assets/css/black-tie.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700|Permanent+Marker" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	
	<script data-rocketsrc="//use.typekit.net/bnt2qso.js" type="text/rocketscript"></script>
	<script type="text/rocketscript">try{Typekit.load();}catch(e){}</script>
	<script type="text/rocketscript"
	        data-rocketsrc="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/rocketscript"
	        data-rocketsrc="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
			        data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand animate" href="<?= $config['homepage']; ?>">Quizzed</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li class='current'><a class='animate' href='login.php'>Login</a></li>
			</ul>
		</div>
	</div>
</nav>