<?php require( "assets/header.php" );

if (isset($_GET['social'])) {

	$auth->handleLogin($_GET['social']);
} else { ?>



	hi
<?php }
/*
$loginWith = "github";


if ( $loginWith == "github" ) {


	$config = [
		'callback' => 'http://localhost/pub-quiz/auth.php',
		// or Hybridauth\HttpClient\Util::getCurrentUrl()

		'keys' => [ 'id' => 'dc3cd4490114e1f1c6d6', 'secret' => 'bc4dcfbafc4a128b4f1e9e88165e7d3d076d4972' ], // Your Github application credentials
		//'keys'     => [ 'id' => '1767923339900912', 'secret' => 'abc04f558f47a8af87b21056e2b8611f' ],
		// Your facebook application credentials
	];

	// Instantiate Github Adapter
	$github = new Hybridauth\Provider\GitHub( $config );

	// Authenticate using Github
	$github->authenticate();

	// Retrieve User's profile
	$userProfile = $github->getUserProfile(); //Returns an instance of class Hybridauth\User\Profile
} else {


	$config = [
		'callback' => 'http://localhost/pub-quiz/auth.php',
		// or Hybridauth\HttpClient\Util::getCurrentUrl()

		//'keys' => [ 'id' => 'dc3cd4490114e1f1c6d6', 'secret' => 'bc4dcfbafc4a128b4f1e9e88165e7d3d076d4972' ], // Your Github application credentials
		'keys'     => [ 'id' => '1767923339900912', 'secret' => 'abc04f558f47a8af87b21056e2b8611f' ],
		// Your facebook application credentials
	];

//Instantiate Facebook Adapter
	$facebook = new Hybridauth\Provider\Facebook( $config );

//Authenticate using Facebook
	$facebook->authenticate();


//Retrieve User's profile
	$userProfile = $facebook->getUserProfile(); //Returns an instance of class Hybridauth\User\Profile

}
//Access User's dispaly name
echo 'Hi ' . $userProfile->displayName;
*/
?>