	<body>
	<!-- Fixed navbar -->
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">RocReport</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li <?php if($page_id == 0) echo 'class="active"'; ?>><a href="<?=base_url(); ?>">Home</a></li>

						<?php if($is_logged_in): ?>
							<!--<li <?php if($page_id == 1) echo 'class="active"'; ?> ><a href="<?=base_url(); ?>report/add/">Report Issue</a></li>-->
							<li <?php if($page_id == 2) echo 'class="active"'; ?>> <a href="<?=base_url(); ?>report/">Reports</a></li>
						<?php endif; ?>
						<?php if($is_admin): ?>
							<li <?php if($page_id == 3) echo 'class="active"'; ?>><a href="<?=base_url(); ?>admin/">Admin</a></li>
						<?php endif; ?>
						<?php if($is_super_admin): ?>
							<li <?php if($page_id == 4) echo 'class="active"'; ?>><a href="<?=base_url(); ?>superadmin/">Super Admin</a></li>
						<?php endif; ?>
						<li <?php if($page_id == 5) echo 'class="active"'; ?>><a href="<?=base_url(); ?>about/">About</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php if($is_logged_in): ?>
							<li><a><?=$is_logged_in; ?></a></li>
						<?php endif; ?>
						<?php if(!$is_logged_in): ?>
							<li><a href="<?=base_url(); ?>auth/login/">Login</a></li>
							<li><a href="<?=base_url(); ?>auth/register/">Register</a></li>
						<?php endif; ?>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>