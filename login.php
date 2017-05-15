<?php require( "assets/header.php" );

if (isset($_GET['social'])) {
	$auth->handleLogin($_GET['social']);
} else { ?>


<div class="bg bg-login">
	<div class="container container-login">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">

				<form>
					<div class="tile">

						<h1 class="white">Select a profile</h1>
						<div class="divider"></div>
						<div class="input-group">
							<input type="email" class="form-control" title="email" placeholder="your email">
							<div class="input-group-btn">
								<button type="button" class="btn btn-gold">next</button>
							</div><!-- /btn-group -->
						</div><!-- /input-group -->

						<div class="row social-media-btns">
							<div class="col-xs-4">
								<a class="btn btn-default btn-facebook btn-block" href="login.php?social=facebook" role="button">
									<i class="fab fab-facebook"></i>Facebook
								</a>
							</div>
							<div class="col-xs-4">
								<a class="btn btn-default btn-twitter btn-block" href="login.php?social=twitter" role="button">
									<i class="fab fab-twitter"></i>Twitter
								</a>
							</div>
							<div class="col-xs-4">
								<a class="btn btn-default btn-google btn-block" href="login.php?social=google" role="button">
									<i class="fab fab-google"></i>Google
								</a>
							</div>
							<div class="col-xs-4">
								<a class="btn btn-default btn-instagram btn-block" href="login.php?social=instagram" role="button">
									<i class="fab fab-instagram"></i>Instagram
								</a>
							</div>
							<div class="col-xs-4">
								<a class="btn btn-default btn-tumblr btn-block" href="login.php?social=tumblr" role="button">
									<i class="fab fab-tumblr"></i>Tumblr
								</a>
							</div>
							<div class="col-xs-4">
								<a class="btn btn-default btn-reddit btn-block" href="login.php?social=reddit" role="button">
									<i class="fab fab-reddit"></i>Reddit
								</a>
							</div>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php }

?>