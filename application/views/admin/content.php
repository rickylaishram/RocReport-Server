		<!-- Content -->
		<div class="col-md-10">
			<!-- Overview -->
			<div id="content-overview"></div>

			<!-- Reports -->
			<div id="content-reports">
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-9"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?=base_url(); ?>static/js/admin.js"></script>
<script>
	$(document).ready(function() {
		admin.base_url = "<?=base_url(); ?>";
		admin.browser_id = "<?=$browser['id']; ?>";
	});
</script>