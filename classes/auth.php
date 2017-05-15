<?php

class Auth extends Core {
	var $name;
	var $authConfig;
	var $onCallbackPage;

	function __construct() {
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
			$this->redirect( "quiz.php" );
		}
	}

	private function loginWithTwitter() {

		$twitter = new Hybridauth\Provider\Twitter( $this->authConfig );
		$twitter->authenticate();
		$userProfile = $twitter->getUserProfile();

		if ( $this->onCallbackPage ) {
			$this->addUser( $userProfile, "twitter" );
		} else {
			$this->redirect( "quiz.php" );
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
				$this->redirect( "quiz.php" );
			}
		} else {
			$this->message("The Google 0Auth API requires you to verify each domain you use their API on. As you cannot verify localhost, logging in with Google is blocked. Go to product to enable this.", "danger");
		}
	}

	private function loginWithInstagram() {

		$instagram = new Hybridauth\Provider\Instagram( $this->authConfig );
		$instagram->authenticate();
		$userProfile = $instagram->getUserProfile();

		if (!empty($userProfile->email)) {
			if ( $this->onCallbackPage ) {
				$this->addUser( $userProfile, "instagram" );
			} else {
				$this->redirect( "quiz.php" );
			}
		} else {
			$this->message("Either your Instagram 0Auth app is in sandbox mode and can't view the email address, or the user has no email address.", "danger");
		}
	}

	private function loginWithTumblr() {

		$tumblr = new Hybridauth\Provider\Tumblr( $this->authConfig );
		$tumblr->authenticate();
		$userProfile = $tumblr->getUserProfile();

		if ( $this->onCallbackPage ) {
			$this->addUser( $userProfile, "tumblr" );
		} else {
			$this->redirect( "quiz.php" );
		}
	}

	private function loginWithReddit() {
		$reddit = new Hybridauth\Provider\Reddit( $this->authConfig );
		$reddit->authenticate();
		$userProfile = $reddit->getUserProfile();

		if ( $this->onCallbackPage ) {
			$this->addUser( $userProfile, "reddit" );
		} else {
			$this->redirect( "quiz.php" );
		}
	}

	public function logout() {
		session_destroy();
		$actual_link = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"];
		header( "Refresh:0; url=" . $actual_link );
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

	private function addUser( $data, $socialMediaType ) {

		$this->debug($data);
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
				$this->setSession( $data, $socialMediaType );
				$this->message( $data->displayName . " has been added to the database.", "success" );
			} else {
				$this->message( $data->displayName . " has NOT been added to the database due to an error.", "danger" );
				$this->debug( $query->errorInfo() );
			}
		} else if ( empty( $data->email ) ) {
			$this->message( "There is no email address given from " . $socialMediaType . ".", "danger" );
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
			$this->setSession( $data, $socialMediaType );
			$this->message( $data->displayName . " has been updated.", "success" );
		} else {
			$this->message( $data->displayName . " has NOT been added to the database due to an error.", "danger" );
			$this->debug( $query->errorInfo() );
		}
	}

	private function setSession( $data, $socialMediaType ) {
		if ( ! isset( $_SESSION ) ) {
			session_start();
		}

		$SESSION['user_name']        = $data->displayName;
		$SESSION['user_email']       = $data->email;
		$SESSION['user_picture']     = $data->photoURL;
		$SESSION['user_social_type'] = $socialMediaType;
		$SESSION['user_social_id']   = $data->identifier;
	}
}