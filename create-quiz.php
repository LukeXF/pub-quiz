<?php require("assets/header.php"); ?>

<div class="jumbotron">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Create Your Quiz</h1>
			</div>
		</div>
	</div>
</div>

<div class="bg bg-white">
	<div class="container container-category">
		<div class="row">
			<div class="col-md-12">
				<h1>Choose a Category</h1>
				<div class="divider"></div>
			</div>
			<?php $quiz->displayCategories(); ?>
		</div>
	</div>
</div>
<div class="bg bg-grey">
	<div class="container container-category">
		<div class="row">
			<div class="col-md-12">
				<h1>Choose a Difficulty</h1>
				<div class="divider"></div>
			</div>
			<?php $quiz->displayDifficulties(); ?>
		</div>
	</div>
</div>
<div class="bg bg-white">
	<div class="container container-category">
		<div class="row">
			<div class="col-md-12">
				<h1>Choose a Play Style</h1>
				<div class="divider"></div>
			</div>
			<?php $quiz->displayTypes(); ?>
		</div>
	</div>
</div>
<div class="bg bg-light-grey">
	<div class="container container-category">
		<div class="row">
			<div class="col-md-12">
				<h1>You've Chosen:</h1>
				<div class="divider"></div>
			</div>
			<div class="col-md-4">
				<div class="box box-final" id="final-category">
					<span>Any</span>
					<h5>Category</h5>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-final" id="final-difficulty">
					<span>Medium</span>
					<h5>Difficulty</h5>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-final" id="final-type">
					<span>Multiple Choice</span>
					<h5>Questions</h5>
				</div>
			</div>
			<div class="col-md-12">
				<div class="box box-final" id="begin">
					<span>Begin</span>
				</div>
			</div>
		</div>
	</div>
</div>