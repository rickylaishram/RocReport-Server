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
						<li class="front-nav" data-content="front-what">What is Rocreport?</li>
						<li class="front-nav" data-content="front-signup">How do I sign up?</li>
						<li class="front-nav" data-content="front-app">Mobile App</li>
						<li class="front-nav" data-content="front-api">API</li>
					</ul>
					<!--<ul class="nav navbar-nav navbar-right">
						<?php if($is_logged_in): ?>
							<li><a><?=$user_data->name; ?></a></li>
						<?php endif; ?>
						<?php if(!$is_logged_in): ?>
							<li><a href="<?=base_url(); ?>auth/login/">Login</a></li>
							<li><a href="<?=base_url(); ?>auth/register/">Register</a></li>
						<?php endif; ?>
					</ul>-->
				</div><!--/.nav-collapse -->
			</div>
		</div>