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
			var map = null;

			function initialize() {
				// Set map-canvas height
				var height = $(window).height() - 80;
				if(height < 200) {
					height = 200;
				}
				$('#map-canvas').height(height);


				var styles = [
								{
									featureType: "all",
									stylers: [
										{ saturation: -80 },
									]
								},
								{
									featureType: "road",
									elementType: "geometry",
									stylers: [
										{ hue: "#00ffee" },
										{ saturation: 100 }
									]
								},
							];

				var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});

				var mapOptions = {
					center: new google.maps.LatLng(47.397, 78.644), // random default value
					zoom: 12,
					mapTypeControlOptions: {
						mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
					},
				};
				map = new google.maps.Map(document.getElementById("map-canvas"),
						mapOptions);

				map.mapTypes.set('map_style', styledMap);
				map.setMapTypeId('map_style');
			}
			google.maps.event.addDomListener(window, 'load', initialize);


			$(window).load(function(){
				navigator.geolocation.getCurrentPosition(update_map);
			});

			function update_map(position) {
				var latitude = position.coords.latitude;
				var longitude = position.coords.longitude;

				var location = new google.maps.LatLng(latitude, longitude);
				map.panTo(location);

				fetch_reports(latitude, longitude);
			}

			function fetch_reports(latitude, longitude) {
				var params = {'latitude': latitude, 'longitude': longitude, 'radius': 10};
				$.post('<?=base_url(); ?>/api/report/fetch_nearby/', params, function(data) {
					console.log(data);
				});
			}
		</script>