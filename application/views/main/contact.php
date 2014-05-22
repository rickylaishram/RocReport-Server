<div class="container">
	<form class="form-signin" role="form" action="" method="post">
		<h2 class="form-signin-heading">Contact Us</h2>
		<input type="email" class="form-control" placeholder="Email address" required id="email" name="email" <?php if($is_logged_in) echo 'value="'.$is_logged_in.'"' ?> />
		<input type="text" class="form-control" placeholder="Message" required id="message" name="message" />
		<button class="btn btn-lg btn-primary btn-block" id="btn_submit" type="submit" >Submit</button>
	</form>
</div> <!-- /container -->

<script type="text/javascript">
	$(document).ready(function() {
		$('.loading-container').hide();
	});
</script>