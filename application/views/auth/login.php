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

<script type="text/javascript">
	$("#pass").on("keyup", function(){
		if($(this).val().length < 1) {
			$('#btn_submit').addAttr('disabled', 'diabled');
		} else {
			$('#btn_submit').removeAttr('disabled');
		}
	});

	$("#email").on("keyup", function(){
		if($(this).val().length > 0) {
			$('#btn_submit').removeAttr('disabled');
		} else {
			$('#btn_submit').addAttr('disabled', 'diabled');
		}
	});
</script>