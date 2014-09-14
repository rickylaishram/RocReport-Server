<div class="container-fluid">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-lg-offset-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading panel-header-main">Login</div>
				<div class="panel-body">
					<form class="form-signin" role="form" action="" method="post">
						<div id="message">
							<?php if($error) : ?>
								<div class="alert alert-danger">Invalid login credentials.</div>
							<?php endif; ?>
						</div>
						<input type="email" class="form-control" placeholder="Email address" required id="email" name="email">
						<input type="password" class="form-control" placeholder="Password" required id="pass" name="pass">
						<button class="btn btn-lg btn-primary btn-block" id="btn_submit" type="submit" disabled="disabled">Login</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div> <!-- /container -->

<script src="<?=base_url(); ?>static/js/main.js"></script>
<script type="text/javascript">
	r_login.init();
</script>