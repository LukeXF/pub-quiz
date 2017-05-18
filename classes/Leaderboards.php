<?php

class Leaderboards extends Core {


	function __construct() {

	}

	public function getLeaderboards() {
		$sql = $this->sqlSetup();

		$query = $sql->prepare( "
           		
			SELECT users.user_name, users.user_email, users.user_picture, users.user_social_type, leaderboards.lb_score, leaderboards.lb_category, leaderboards.lb_date, FIND_IN_SET( lb_score, (
				SELECT GROUP_CONCAT( lb_score
				ORDER BY lb_score DESC ) 
				FROM leaderboards )
				) AS rank
			FROM leaderboards
			INNER JOIN users 
			ON users.user_id = leaderboards.lb_user_id
        " );

		$query->execute();
		$row = $query->fetchAll( PDO::FETCH_ASSOC );

		if ( $row ) {
			usort($row, array($this, 'sortByOrder'));
			return $row;
		} else {
			return false;
		}
	}

	public function addScore( $data ) {

		//$this->debug($data);;
		if ( /*$this->is_logged_in() &&*/
			isset( $data['score'] ) && isset( $data['category'] ) && isset( $data['user_id'] )
		) {

			$sql   = $this->sqlSetup();
			$query = $sql->prepare( "
	            INSERT INTO `leaderboards`(
	            `lb_score`, `lb_category`, `lb_user_id`) 
	            VALUES (:lb_score, :lb_category, :lb_user_id) 
	        " );

			$query->bindParam( 'lb_score', $data['score'], PDO::PARAM_INT );
			$query->bindParam( 'lb_category', $data['category'], PDO::PARAM_INT );
			$query->bindParam( 'lb_user_id', $data['user_id'], PDO::PARAM_INT );

			if ( $query->execute() ) {
				return true;
			} else {
				// $this->debug($query->errorInfo());
				return false;
			}

		} else {
			return false;
		}
	}

	public function checkIfAlreadyEnteredRecently( $data ) {
		$sql   = $this->sqlSetup();
		$query = $sql->prepare( "
           		SELECT lb_date
				FROM leaderboards
				WHERE lb_date >= DATE_SUB(NOW(),INTERVAL 5 MINUTE) AND `lb_user_id` = :lb_user_id AND `lb_score` = :lb_score AND `lb_category` = :lb_category; 
        	" );

		$query->bindParam( 'lb_score', $data['score'], PDO::PARAM_INT );
		$query->bindParam( 'lb_category', $data['category'], PDO::PARAM_INT );
		$query->bindParam( 'lb_user_id', $data['user_id'], PDO::PARAM_INT );

		$query->execute();
		$row = $query->fetch( PDO::FETCH_ASSOC );

		if ( $row ) {
			return true;
		} else {
			return false;
		}
	}

	private function getRecentQuizzes() {
		/*

			select count(*) as cnt
			from  leaderboards
			where lb_date >= DATE_SUB(NOW(),INTERVAL 1 HOUR);
		*/
	}

	public function buildLeaderboards() {
		$lb = $this->getLeaderboards();
	}

}