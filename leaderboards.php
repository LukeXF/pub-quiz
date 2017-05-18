<?php require( "assets/header.php" ); ?>
<script src="assets/js/leaderboards.js"></script>

<div class="jumbotron jumbotron-small">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Leaderboards</h1>
			</div>
		</div>
	</div>
</div>

<div class="bg bg-grey">
	<div class="container container-leaderboards">
		<div class="row">
			<div class="col-md-12">
				<div class="bs-example" data-example-id="bordered-table">
					<table class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Rank</th>
							<th>Display Name</th>
							<th>Category</th>
							<th>Time</th>
							<th class="score">Score</th>
						</tr>
						</thead>
						<tbody>
						<tr id="first-tr">
							<th colspan="5">
								<div id="lb-loader">
									<i class="btl bt-spinner bt-5x bt-pulse"></i>
								</div>
							</th>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="bg bg-light-grey">
	<div class="container container-login">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">

					<div class="col-md-6" align="right">
						<h1>Want to get ranked?</h1>
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
