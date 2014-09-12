<div class="container">
	<form class="form-signin" role="form" action="" method="post">
		<h2 class="form-signin-heading">Register</h2>
		<div id="message">
			<div class="alert alert-danger"></div>
		</div>
		<input type="text" class="form-control" placeholder="Username" required autofocus id="name" name="name">
		<input type="email" class="form-control" placeholder="Email address" required id="email" name="email">
		<input type="password" class="form-control" placeholder="Password" required id="pass1" name="pass">
		<input type="password" class="form-control" placeholder="Confirm Password" required id="pass2" name="pass2">
		<button class="btn btn-lg btn-primary btn-block" id="btn_submit" type="submit" disabled="disabled">Register</button>
	</form>
</div> <!-- /container -->

<script src="<?=base_url(); ?>static/js/main.js"></script>
<script type="text/javascript">
	register.init();
</script>