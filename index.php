<?php require( "assets/header.php" ); ?>

<div class="jumbotron">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>The Great British Pub Quiz</h1>
				<h2>The right way to compete against your friends</h2>
				<a class="btn btn-default btn-gold btn-lg" href="create-quiz.php" role="button">Choose a quiz</a>
				<a class="btn btn-default btn-lg" href="leaderboards.php" role="button">Leaderboards</a>

			</div>
		</div>
	</div>
</div>
<div class="bg bg-white">
	<div class="container container-how-it-works">
		<div class="row">
			<div class="col-md-12">
				<h1>How it works</h1>
				<div class="divider"></div>
			</div>
			<div class="col-md-4 step">
				<i class="btl bt-key bt-2x bt-border"></i>
				<h2>Step 1</h2>
				<p>Login with your favourite using your social media account or enter your email address.</p>
			</div>
			<div class="col-md-4 step">
				<i class="btl bt-check-square bt-2x bt-border"></i>
				<h2>Step 2</h2>
				<p>Choose from a wide variety of categories, set your difficulty and question type.</p>
			</div>
			<div class="col-md-4 step">
				<i class="btl bt-trophy bt-2x bt-border"></i>
				<h2>Step 3</h2>
				<p>Finish your quiz and see how you compare again the world, your local pub or your country.</p>
			</div>
		</div>
	</div>
</div>
<div class="bg bg-grey">
	<div class="container container-login">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">

					<div class="col-md-6" align="right">
						<h1>Get Started</h1>
						<div class="divider"></div>
						<p>
							Login via your chosen site or enter your email address.<br>
							Don't worry, we only access your basic information and we can't post through your account.
						</p>
					</div>
					<div class="col-md-6">

						<form>
							<div class="tile">

								<h1>Login</h1>
								<div class="divider"></div>
								<div class="input-group">
									<?php $auth->emailLogin(); ?>
								</div><!-- /input-group -->

								<div class="row social-media-btns">
									<?php $auth->loginButtons(); ?>
								</div>

							</div>
						</form>

					</div>

				</div>
			</div>
		</div>
	</div>
</div>
