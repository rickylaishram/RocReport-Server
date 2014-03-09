		<div class="container">

			<div class="row">

				<div class="col-md-3">
				
				</div>
				
				<div class="col-md-9">
					<div id="map-canvas"></div>
				</div>

			</div>

		</div> <!-- /container -->

		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6x__caSSACAJWV9uoEYA6mcP9J4xdo_c&sensor=false"></script>
		<script type="text/javascript">
			function initialize() {
				// Set map-canvas height
				$('#map-canvas').height($(window).height() - 80);

				var mapOptions = {
					center: new google.maps.LatLng(-34.397, 150.644),
					zoom: 8
				};
				var map = new google.maps.Map(document.getElementById("map-canvas"),
						mapOptions);
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>