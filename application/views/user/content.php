		<!-- Content -->
		<div class="col-md-10">
			<!-- Overview -->
			<div id="content-overview" class="user-content">
				
			</div>

			<!-- Reports -->
			<div id="content-reports" class="user-content">
				<div class="row">
					<!-- Reports List -->
					<div class="col-md-3">
						<div class="list-group report-list"></div>
					</div>

					<!-- Reports Detail -->
					<div class="col-md-9 report-details">
						<div class="row report-details-big report-details-uppercase">
							<div id="report-details-category" class="col-md-12" ></div>
						</div>
						<div class="row report-details-big">
							<div id="report-details-address" class="col-md-12"></div>
						</div>
						<div class="row" class="report-details-small">
							<div id="report-details-date" class="col-md-4"></div>
							<div id="report-details-score" class="col-md-4"></div>
							<div id="report-details-vote" class="col-md-4"></div>
						</div>
						<div class="row">
							<div id="report-details-map" class="col-md-6" ></div>
							<div class="col-md-6" id="report-details-image-container">
								<img src="" id="report-details-image"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6x__caSSACAJWV9uoEYA6mcP9J4xdo_c&sensor=false"></script>
<script src="<?=base_url(); ?>static/js/user.js"></script>
<script>
	$(document).ready(function() {
		navigator.geolocation.getCurrentPosition(start);
	});

	function start(position) {
		user.base_url = "<?=base_url(); ?>";
		user.ep_reports_nearby = "report/api/fetch_nearby/";
		user.ep_reports_mine = "report/api/fetch_mine/";
		user.latitude = position.coords.latitude;
		user.longitude = position.coords.longitude;

		user.browser_id = "<?=$browser['id']; ?>";
		user.init();
		google.maps.event.addDomListener(window, 'load', user.map_initialize);
	}
</script>