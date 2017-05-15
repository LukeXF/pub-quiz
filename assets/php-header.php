<?php
include 'vendor/autoload.php';
require_once( 'lib/config.php' );
require_once( 'classes/core.php' );
require_once( 'classes/auth.php' );
require_once( 'classes/quiz.php' );

$core = new Core;
$auth = new Auth;
$quiz = new Quiz;
