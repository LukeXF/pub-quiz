<?php
include 'vendor/autoload.php';
require_once( 'lib/config.php' );
require_once( 'classes/Core.php' );
require_once( 'classes/Auth.php' );
require_once( 'classes/Quiz.php' );
require_once( 'classes/Leaderboards.php' );

$core = new Core;
$auth = new Auth;
$quiz = new Quiz;
$lb = new Leaderboards;
