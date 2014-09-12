<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title><?=$page_title; ?></title>

		<!-- Bootstrap core CSS -->
		<link href="<?=base_url(); ?>static/css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="<?=base_url(); ?>static/css/style.css" rel="stylesheet">

		<link href='//fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
		<script src="<?=base_url(); ?>static/js/d3.min.js"></script>
		<script src="<?=base_url(); ?>static/js/bootstrap.min.js"></script>
		<script src="<?=base_url(); ?>static/js/theme.js"></script>
		<?php if( $this->router->class == "add_report" ) { ?>
		<script type="text/javascript" src="<?=base_url(); ?>static/js/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>static/js/SimpleAjaxUploader.js"></script>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>static/css/bootstrap-select.min.css">
		<?php } ?>
		<script src="<?=base_url(); ?>static/js/main.js"></script>
	</head>
