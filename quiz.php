<?php require( "assets/header.php" ); ?>

<div class="jumbotron jumbotron-small">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 id="quiz-title"><?= $quiz->getQuizTitle(); ?></h1>
			</div>
		</div>
	</div>
</div>


<div class="bg bg-grey">
	<div class="container container-questions">
		<div class="row">
			<div class="col-md-12">
				<div id="loader">
					<i class="btl bt-spinner bt-5x bt-pulse"></i>
				</div>

				<div class="progress skill-bar" style='display: none'>
					<div class="progress-bar progress-bar-success progress-bar-animation" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="30" style="width: 100%;">
					</div>
				</div>
				<?php $quiz->buildQuizQuestions(); ?>
				<?php $quiz->buildQuizResults(); ?>
			</div>
		</div>
	</div>
</div>