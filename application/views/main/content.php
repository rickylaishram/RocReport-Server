		<div class="container-fluid">

			<div class="row">
				
				<div class="col-md-3" id="reports-list-container">
					<div class="list-group" id="reports-list">
						
					</div>
				</div>

				<div class="col-md-9">
					<div id="map-canvas"></div>
				</div>

			</div>

		</div> <!-- /container -->

		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6x__caSSACAJWV9uoEYA6mcP9J4xdo_c&sensor=false"></script>
		<script type="text/javascript">
			var map = null;
			var markers = [];
			var reports = null;

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

			function addMarker(location) {
				var marker = new google.maps.Marker({
					position: location,
					map: map
				});
				marker.setMap(map);
			}

			function update_map(position) {
				var latitude = position.coords.latitude;
				var longitude = position.coords.longitude;

				var location = new google.maps.LatLng(latitude, longitude);
				map.panTo(location);

				fetch_reports(latitude, longitude);
			}

			function fetch_reports(latitude, longitude) {
				var params = {'latitude': latitude, 'longitude': longitude, 'radius': 10000};
				$.post('<?=base_url(); ?>/api/report/fetch_nearby/', params, function(data) {
					data = JSON.parse(data);
					reports = data.data;
					if( data.status ) {
						console.log(data.status);
						for (var i = data.data.length - 1; i >= 0; i--) {
							var id = data.data[i]['report_id'];
							var category = data.data[i]['category'];
							var address = data.data[i]['formatted_address'];
							var latitude = parseFloat(data.data[i]['latitude']);
							var longitude = parseFloat(data.data[i]['longitude']);
							var location = new google.maps.LatLng(latitude, longitude);
							
							addMarker(location);

							$('#reports-list').append(generateListItem(category, address));
						};
					}
				});
			}

			function generateListItem(category, address, id) {
				var item ='<a href="#" class="list-group-item report-item" data-id="'+id+'"><h4 class="list-group-item-heading">'+category+'</h4><p class="list-group-item-text">'+address+'</p></a>';
				return item;
			}
		</script>