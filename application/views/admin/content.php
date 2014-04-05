		<!-- Content -->
		<div class="col-md-10">
			<!-- Overview -->
			<div id="content-overview" class="admin-content"></div>

			<!-- Reports -->
			<div id="content-reports" class="admin-content">
				<div class="row">
					<!-- Reports List -->
					<div class="col-md-3">
						<div class="list-group report-list"></div>
					</div>

					<!-- Reports Detail -->
					<div class="col-md-9 report-details">
						<div id="report-details-category" class="row report-details-big"></div>
						<div id="report-details-address" class="row"></div>
						<div class="row" class="report-details-small">
							<div id="report-details-date" class="col-md-4"></div>
							<div id="report-details-score" class="col-md-4"></div>
							<div id="report-details-vote" class="col-md-4"></div>
						</div>
						<div id="report-details-map" class="row"></div>
						<div id="report-details-updates" class="row"></div>
						<div id="report-details-buttons" class="row">
							<button type="button" class="btn btn-success" id="report-btn-open">Open Report</button>
							<button type="button" class="btn btn-danger" id="report-btn-close">Close Report</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?=base_url(); ?>static/js/admin.js"></script>
<script>
	$(document).ready(function() {
		admin.base_url = "<?=base_url(); ?>";
		admin.ep_reports_open = "admin/api/get_reports";
		admin.ep_reports_closed = "admin/api/get_reports_closed";
		admin.browser_id = "<?=$browser['id']; ?>";
		
		admin.init();
	});
</script>