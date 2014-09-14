<div class="container-fluid">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-lg-offset-4 col-md-offset-4">
			<div class="panel panel-default panel-animated">
				<div class="panel-heading panel-header-main">Login</div>
				
				<div class="panel-body">
					<div id="message">
						<?php if($error) : ?>
							<div class="alert alert-danger">Invalid login credentials.</div>
						<?php endif; ?>
					</div>

					<form class="form-horizontal" role="form" action="" method="post">
						<div class="form-group form-big">
							<label for="email" class="col-lg-3 control-label">Email</label>
							<div class="col-lg-9">
								<input type="email" class="form-control" placeholder="Email" required id="email" name="email">
							</div>
						</div>

						<div class="form-group form-big">
							<label for="pass" class="col-lg-3 control-label">Password</label>
							<div class="col-lg-9">
								<input type="password" class="form-control" placeholder="Password" required id="pass" name="pass">
							</div>
						</div>

						<div class="form-group form-big">
							<label for="inputEmail" class="col-lg-4 control-label"></label>
							<div class="col-lg-4">
								<button class="btn btn-primary btn-block" id="btn_submit" type="submit" disabled="disabled">Login</button>
							</div>
						</div>
						
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