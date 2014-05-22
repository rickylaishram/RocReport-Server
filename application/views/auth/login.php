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
	$(window).load(function(){
		if(($('#pass').val().length > 0) && ($('#email').val().length > 0)) {
			$('#btn_submit').prop('disabled', false);
		} else {
			$('#btn_submit').prop('disabled', true);
		}
	});

	$("#pass").on("keyup", function(){
		if($(this).val().length < 1) {
			$('#btn_submit').prop('disabled', true);
		} else {
			$('#btn_submit').prop('disabled', false);
		}
	});

	$("#email").on("keyup", function(){
		if($(this).val().length > 0) {
			$('#btn_submit').prop('disabled', false);
		} else {
			$('#btn_submit').prop('disabled', true);
		}
	});
</script>