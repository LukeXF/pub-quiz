<?php
$config = [
	'keys'     => [
		'github'   => [ 'id' => '', 'secret' => '' ],
		'facebook' => [ 'id' => '', 'secret' => '' ],
		'twitter' => [ 'id' => '', 'secret' => '' ],
		'instagram' => [ 'id' => '', 'secret' => '' ],
		'google' => [ 'id' => '', 'secret' => '' ],
	],
	'callback' => 'http://localhost/pub-quiz/callback.php',
	'homepage' => 'http://localhost/pub-quiz',
	'db'       => [
		'host' => 'localhost',     // the database hostname (url)
		'user' => 'root',          // the database username
		'pass' => '',  // the database username's password
		'data' => 'pub_quiz'     // the name of the database
	]
];
?>