<div class="container">
	<form class="form-signin" role="form" action="" method="post">
		<h2 class="form-signin-heading">Register</h2>
		<div id="message"></div>
		<input type="text" class="form-control" placeholder="Username" required autofocus id="name" name="name">
		<input type="email" class="form-control" placeholder="Email address" required id="email" name="email">
		<input type="password" class="form-control" placeholder="Password" required id="pass1" name="pass">
		<input type="password" class="form-control" placeholder="Confirm Password" required id="pass2" name="pass2">
		<button class="btn btn-lg btn-primary btn-block" id="btn_submit" type="submit" disabled="disabled">Register</button>
	</form>
</div> <!-- /container -->

<script type="text/javascript">
	$("#pass1").on("keyup", function(){
		if($(this).val().length < 5) {
			$('#message').html('<div class="alert alert-danger">Password cannot be less than 5 characters.</div>');
			$('#btn_submit').addAttr('disabled', 'diabled');
		} else {
			$('#message').html('');
			$('#btn_submit').removeAttr('disabled');
		}
	});

	$("#pass2").on("keyup", function(){
		var pass = $("#pass1").val();

		if($(this).val() == pass) {
			$('#message').html('');
			$('#btn_submit').removeAttr('disabled');
		} else {
			$('#message').html('<div class="alert alert-danger">Password do not match</div>');
			$('#btn_submit').addAttr('disabled', 'diabled');
		}
	});

	$("#name").on("keyup", function(){
		if($(this).val().length > 0) {
			$('#message').html('');
			$('#btn_submit').removeAttr('disabled');
		} else {
			$('#message').html('<div class="alert alert-danger">Name cannot be blank</div>');
			$('#btn_submit').addAttr('disabled', 'diabled');
		}
	});

	$("#email").on("keyup", function(){
		if($(this).val().length > 0) {
			$('#message').html('');
			$('#btn_submit').removeAttr('disabled');
		} else {
			$('#message').html('<div class="alert alert-danger">Email cannot be blank</div>');
			$('#btn_submit').addAttr('disabled', 'diabled');
		}
	});
</script>