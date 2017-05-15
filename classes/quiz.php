<?php

class Quiz extends Core
{
	var $quizConfig;

	function __construct()
	{
		global $config;

		$this->quizConfig = $config['quiz'];

	}

	public function displayCategories()
	{
		foreach ($this->quizConfig['categories'] as $category => $id) {
			echo "
				<div class='col-md-3'>
					<div class='box box-category' id='" . $id . "'>
						" . $category . "
					</div>
				</div>";
		}
	}
	public function displayDifficulties()
	{
		foreach ($this->quizConfig['difficulty'] as $difficulty => $multiplier) {
			echo "
				<div class='col-md-3'>
					<div class='box box-difficulty' id='" . $difficulty . "'>
						" . $difficulty . "<br>
						<h5>" . $multiplier . "x multiplier</h5>
					</div>
				</div>";
		}
	}
	public function displayTypes()
	{
		foreach ($this->quizConfig['types'] as $types => $textType) {
			echo "
				<div class='col-md-6'>
					<div class='box box-type' id='" . $types . "'>
						" . $textType . "<br>
					</div>
				</div>";
		}
	}

}