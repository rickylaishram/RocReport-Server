<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title><?=$page_data['page_title']; ?></title>

		<!-- Bootstrap core CSS -->
		<link href="<?=base_url(); ?>static/css/bootstrap.min.css" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>static/css/bootstrap-select.min.css">

		<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700' rel='stylesheet' type='text/css'>
		
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
		
		<!-- Custom styles for this template -->
		<link href="<?=base_url(); ?>static/css/style.css" rel="stylesheet">

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
		<script src="<?=base_url(); ?>static/js/d3.min.js"></script>
		<script src="<?=base_url(); ?>static/js/bootstrap.min.js"></script>
		<script src="<?=base_url(); ?>static/js/theme.js"></script>
		<?php if( $this->router->class == "add_report" ): ?>
			<script type="text/javascript" src="<?=base_url(); ?>static/js/bootstrap-select.min.js"></script>
			<script type="text/javascript" src="<?=base_url(); ?>static/js/SimpleAjaxUploader.js"></script>
		<?php endif; ?>
	</head>
