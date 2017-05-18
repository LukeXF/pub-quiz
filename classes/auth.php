<?php

class Auth extends Core {
	var $name;
	var $authConfig;
	var $onCallbackPage;

	function __construct() {

		if ( ! isset( $_SESSION ) ) {
			session_start();
		}
		if ( isset( $_GET['logout'] ) ) {
			$this->logout();
		}

	}

	public function handleLogin( $loginType, $callback = false ) {

		global $config;

		if ( $callback ) {
			$this->onCallbackPage = true;
		}
		if ( $loginType != "email" ) {
			$this->authConfig = [
				"callback" => $config['callback'] . "?authFor=" . $loginType,
				"keys"     => $config['keys'][ $loginType ]
			];
		}

		if ( $loginType == "email" ) {
			$this->loginWithEmail();
		} else if ( $loginType == "facebook" ) {
			$this->loginWithFacebook();

		} else if ( $loginType == "twitter" ) {
			$this->loginWithTwitter();

		} else if ( $loginType == "google" ) {
			$this->loginWithGoogle();

		} else if ( $loginType == "instagram" ) {
			$this->loginWithInstagram();

		} else if ( $loginType == "tumblr" ) {
			$this->loginWithTumblr();

		} else if ( $loginType == "reddit" ) {
			$this->loginWithReddit();

		}
	}


	private function loginWithEmail() {

	}

	private function loginWithFacebook() {

		$facebook = new Hybridauth\Provider\Facebook( $this->authConfig );
		$facebook->authenticate();
		$userProfile = $facebook->getUserProfile();

		if ( $this->onCallbackPage ) {
			$this->addUser( $userProfile, "facebook" );
		} else {
			// $this->setSession( $userProfile, "facebook" );
			$this->redirect( "create-quiz" );
		}
	}

	private function loginWithTwitter() {

		$twitter = new Hybridauth\Provider\Twitter( $this->authConfig );
		$twitter->authenticate();
		$userProfile = $twitter->getUserProfile();

		if ( $this->onCallbackPage ) {
			$this->addUser( $userProfile, "twitter" );
		} else {
			$this->redirect( "create-quiz" );
		}
	}

	private function loginWithGoogle() {


		if ( ! $this->is_localhost() ) {
			$google = new Hybridauth\Provider\Google( $this->authConfig );
			$google->authenticate();
			$userProfile = $google->getUserProfile();


			if ( $this->onCallbackPage ) {
				$this->addUser( $userProfile, "google" );
			} else {
				$this->redirect( "create-quiz" );
			}
		} else {
			$this->message( "The Google 0Auth API requires you to verify each domain you use their API on. As you cannot verify localhost, logging in with Google is blocked. Go to product to enable this.", "danger" );
		}
	}

	private function loginWithInstagram() {

		$instagram = new Hybridauth\Provider\Instagram( $this->authConfig );
		$instagram->authenticate();
		$userProfile = $instagram->getUserProfile();

		if ( ! empty( $userProfile->email ) ) {
			if ( $this->onCallbackPage ) {
				$this->addUser( $userProfile, "instagram" );
			} else {
				$this->redirect( "create-quiz" );
			}
		} else {
			$this->message( "Either your Instagram 0Auth app is in sandbox mode and can't view the email address, or the user has no email address.", "danger" );
		}
	}

	private function loginWithTumblr() {

		$tumblr = new Hybridauth\Provider\Tumblr( $this->authConfig );
		$tumblr->authenticate();
		$userProfile = $tumblr->getUserProfile();

		if ( $this->onCallbackPage ) {
			$this->addUser( $userProfile, "tumblr" );
		} else {
			$this->redirect( "create-quiz" );
		}
	}

	private function loginWithReddit() {
		$reddit = new Hybridauth\Provider\Reddit( $this->authConfig );
		$reddit->authenticate();
		$userProfile = $reddit->getUserProfile();

		if ( $this->onCallbackPage ) {
			$this->addUser( $userProfile, "reddit" );
		} else {
			$this->redirect( "create-quiz" );
		}
	}

	public function logout() {
		session_destroy();
		$this->redirect();
	}

	private function checkIfExists( $userProfile ) {
		$sql   = $this->sqlSetup();
		$query = $sql->prepare( "
           		SELECT * FROM `users` WHERE `user_email` = :user_email
        	" );
		$query->bindParam( ':user_email', $userProfile->email, PDO::PARAM_STR );

		$query->execute();
		$row = $query->fetch( PDO::FETCH_ASSOC );

		if ( $row ) {
			return true;
		} else {
			return false;
		}
	}


	private function getUserId( $email ) {
		$sql   = $this->sqlSetup();
		$query = $sql->prepare( "
           		SELECT `user_id` FROM `users` WHERE `user_email` = :user_email
        	" );
		$query->bindParam( ':user_email', $email, PDO::PARAM_STR );

		$query->execute();
		$row = $query->fetch( PDO::FETCH_ASSOC );

		if ( $row ) {
			return $row['user_id'];
		} else {
			return false;
		}
	}

	private function addUser( $data, $socialMediaType ) {

		// $this->debug($data);
		if ( ! empty( $data->email ) && ( $this->checkIfExists( $data ) == false ) ) {

			$sql   = $this->sqlSetup();
			$query = $sql->prepare( "
            INSERT INTO `users`(
            `user_name`, `user_email`, `user_picture`, `user_social_type`, `user_social_id`) 
            VALUES (
            :user_name, :user_email, :user_picture, :user_social_type, :user_social_id
            )
        " );
			$query->bindParam( 'user_name', $data->displayName, PDO::PARAM_STR );
			$query->bindParam( 'user_email', $data->email, PDO::PARAM_STR );
			$query->bindParam( 'user_picture', $data->photoURL, PDO::PARAM_STR );
			$query->bindParam( 'user_social_type', $socialMediaType, PDO::PARAM_STR );
			$query->bindParam( 'user_social_id', $data->identifier, PDO::PARAM_INT );

			if ( $query->execute() ) {
				$this->setSession( $data, $socialMediaType);
				$this->message( $data->displayName . " has been added to the database.", "success" );
			} else {
				$this->message( $data->displayName . " has NOT been added to the database due to an error.", "danger" );
				$this->debug( $query->errorInfo() );
			}

			$this->redirect( "create-quiz" );
		} else if ( empty( $data->email ) ) {
			$this->message( "There is no email address given from " . $socialMediaType . ".", "danger" );
			$this->redirect( "create-quiz" );
		} else {
			$this->updateUser( $data, $socialMediaType );
		}

	}

	private function updateUser( $data, $socialMediaType ) {

		$this->debug( $data );
		$sql   = $this->sqlSetup();
		$query = $sql->prepare( "
            UPDATE `users` SET 
            `user_name` = :user_name,
            `user_picture` = :user_picture,
            `user_social_type` = :user_social_type,
            `user_social_id` = :user_social_id
            
            WHERE `user_email` = :user_email
        " );

		$query->bindParam( 'user_name', $data->displayName, PDO::PARAM_STR );
		$query->bindParam( 'user_email', $data->email, PDO::PARAM_STR );
		$query->bindParam( 'user_picture', $data->photoURL, PDO::PARAM_STR );
		$query->bindParam( 'user_social_type', $socialMediaType, PDO::PARAM_STR );
		$query->bindParam( 'user_social_id', $data->identifier, PDO::PARAM_INT );

		if ( $query->execute() ) {
			$this->setSession( $data, $socialMediaType);
			$this->message( $data->displayName . " has been updated.", "success" );
		} else {
			$this->message( $data->displayName . " has NOT been added to the database due to an error.", "danger" );
			$this->debug( $query->errorInfo() );
		}

		$this->redirect( "create-quiz" );
	}

	private function setSession( $data, $socialMediaType, $user_id = null) {
		if ( ! isset( $_SESSION ) ) {
			session_start();
		}
		$_SESSION['user_id']          = $this->getUserId($data->email);
		$_SESSION['user_name']        = $data->displayName;
		$_SESSION['user_email']       = $data->email;
		$_SESSION['user_picture']     = $data->photoURL;
		$_SESSION['user_social_type'] = $socialMediaType;
		$_SESSION['user_social_id']   = $data->identifier;
	}

	public function loginButtons() {
		// TODO: make these dynamic build off the config file
		echo '
		<div class="col-xs-4">
			<a class="btn btn-default btn-facebook btn-block" href="login.php?social=facebook" role="button">
				<i class="fab fab-facebook"></i>Facebook
			</a>
		</div>
		<div class="col-xs-4">
			<a class="btn btn-default btn-twitter btn-block disabled" href="login.php?social=twitter" role="button">
				<i class="fab fab-twitter"></i>Twitter
			</a>
		</div>
		<div class="col-xs-4">
			<a class="btn btn-default btn-google btn-block" href="login.php?social=google" role="button">
				<i class="fab fab-google"></i>Google
			</a>
		</div>
		<div class="col-xs-4">
			<a class="btn btn-default btn-instagram btn-block disabled" href="login.php?social=instagram" role="button">
				<i class="fab fab-instagram"></i>Instagram
			</a>
		</div>
		<div class="col-xs-4">
			<a class="btn btn-default btn-tumblr btn-block disabled" href="login.php?social=tumblr" role="button">
				<i class="fab fab-tumblr"></i>Tumblr
			</a>
		</div>
		<div class="col-xs-4">
			<a class="btn btn-default btn-reddit btn-block" href="login.php?social=reddit" role="button">
				<i class="fab fab-reddit"></i>Reddit
			</a>
		</div>
		';
	}

	public function emailLogin() {
		echo '
		<input type="email" class="form-control" title="email" placeholder="your email - coming soon">
		<div class="input-group-btn">
			<button type="button" class="btn btn-gold disabled">next</button>
		</div><!-- /btn-group -->
		';
	}
}