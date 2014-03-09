		<div class="container">

			<div class="row">

				<div class="col-xs-3">
				
				</div>
				
				<div class="col-xs-9">
					<div id="map-canvas"></div>
				</div>

			</div>

		</div> <!-- /container -->

		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=API_KEY&sensor=FALSE"></script>
		<script type="text/javascript">
			function initialize() {
				// Set map-canvas height
				$('#map-canvas').height($(window).height() - 70);

				var mapOptions = {
					center: new google.maps.LatLng(-34.397, 150.644),
					zoom: 8
				};
				var map = new google.maps.Map(document.getElementById("map-canvas"),
						mapOptions);
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>