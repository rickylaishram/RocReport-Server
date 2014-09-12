<div class="container">
	<form class="form-signin" role="form" action="" method="post">
		<h2 class="form-signin-heading">Login</h2>
		<div id="message">
			<?php if($error) : ?>
				<div class="alert alert-danger">Invalid login credentials.</div>
			<?php endif; ?>
		</div>
		<input type="email" class="form-control" placeholder="Email address" required id="email" name="email">
		<input type="password" class="form-control" placeholder="Password" required id="pass" name="pass">
		<button class="btn btn-lg btn-primary btn-block" id="btn_submit" type="submit" disabled="disabled">Login</button>
	</form>
</div> <!-- /container -->

<script src="<?=base_url(); ?>static/js/main.js"></script>
<script type="text/javascript">
	r_login.init();
</script>