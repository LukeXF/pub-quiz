<?php

class Quiz extends Core {
	var $quizConfig;

	function __construct() {
		global $config;

		$this->quizConfig = $config['quiz'];

	}

	public function displayCategories() {
		foreach ( $this->quizConfig['categories'] as $category => $id ) {
			echo "
				<div class='col-md-3'>
					<div class='box box-category' id='" . $id . "'>
						" . $category . "
					</div>
				</div>";
		}
	}

	public function displayDifficulties() {
		foreach ( $this->quizConfig['difficulty'] as $difficulty => $multiplier ) {
			echo "
				<div class='col-md-3'>
					<div class='box box-difficulty' id='" . $difficulty . "'>
						" . $difficulty . "<br>
						<h5>" . $multiplier . "x multiplier</h5>
					</div>
				</div>";
		}
	}

	public function displayTypes() {
		foreach ( $this->quizConfig['types'] as $types => $textType ) {
			echo "
				<div class='col-md-6'>
					<div class='box box-type' id='" . $types . "'>
						" . $textType . "<br>
					</div>
				</div>";
		}
	}

	public function getQuizTitle() {


		if ( isset( $_GET['category'] ) ) {
			$key = array_search( $_GET['category'], $this->quizConfig['categories'] );
		} else {
			$key = "Unable to find Quiz";
		}

		return $key;
	}

	public function buildQuizQuestions() {

		$i = 0;

		while ( $i < 20 ) {
			echo "
				<div class='col-md-12'>							
					<div class='tile-question' id='tile-question-" . $i . "' style='display: none'>
						<div class='row'>
							<div class='col-md-12'>
								<h2 class='question-question'>Question " . ( $i + 1 ) . "/20</h5>
								<h3 class='question-title'>No Questions Found</h3>
							</div>											
							<div class='col-md-10 col-md-offset-2' id='tile-answers-" . $i . "'>
							</div>
						</div>
					</div>
				</div>	
			";

			$i ++;
		}
	}

	public function buildQuizResults() {

		$i = 0;


		echo "
				<div class='col-md-4'>							
					<div class='tile-results tile-overview' id='tile-final-amount-right' style='display: none'>
						<h2>0/20</h2>
						<h5>answers correct</h5>
					</div>
				</div>
				<div class='col-md-4'>							
					<div class='tile-results tile-overview' id='tile-final-score' style='display: none'>
						<h2>0</h2>
						<h5>your score</h5>
					</div>
				</div>
				<div class='col-md-4'>							
					<div class='tile-results tile-overview' id='tile-final-leaderboards' style='display: none'>
						<h2>1st</h2>
						<h5>your rank</h5>
					</div>
				</div>
		";
		while ( $i < 20 ) {
			echo "
				<div class='col-md-12'>							
					<div class='tile-results' id='tile-result-" . $i . "' style='display: none'>
						<div class='row'>
							<div class='col-md-12'>
								<h2 class='question-question'>Question " . ( $i + 1 ) . "/20</h5>
								<h3 class='question-title'>-</h3>
							</div>											
							<div class='col-md-5 col-md-offset-2 result-correct-answer' id='result-correct-answer-" . $i . "'>
								<div class='answer-tile'>
									<h2 class='answer-answer'>Correct Answer</h2>
									<h4 class='answer-title'>-</h4>
								</div>
							</div>										
							<div class='col-md-5 result-your-answer' id='result-your-answer-" . $i . "'>
								<div class='answer-tile'>
									<h2 class='answer-answer'>Your Answer</h2>
									<h4 class='answer-title'>-</h4>
								</div>
							</div>
						</div>
					</div>
				</div>	
			";

			$i ++;
		}
	}

}