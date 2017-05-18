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
<?php }

?>