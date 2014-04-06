		<div class="container-fluid">

			<div class="row">

				<div class="col-md-9">
					<div id="map-canvas"></div>
				</div>

				<div class="col-md-3">
					
					<ul class="nav nav-pills nav-justified repSelector">
						<li class="btnSelector active" data-type="score"><a href="#">Important</a></li>
						<li class="btnSelector" data-type="new"><a href="#">New</a></li>
					</ul>

					<div class="list-group" id="reports-list">
					</div>
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
										{ hue: "#CDCDCD" },
										{ saturation: 100 }
									]
								},
							];

				var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});

				var mapOptions = {
					center: new google.maps.LatLng(47.397, 78.644), // random default value
					zoom: 12,
					mapTypeControlOptions: {
						mapTypeIds: [google.maps.MapTypeId.SATELLITE, 'map_style']
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
				left_col_height();

				$(".btnSelector").click(function(){
					$(".btnSelector.active").removeClass("active");
					$(this).addClass("active");

					var type = $(this).data("type");

					var bounds = map.getBounds();

					var location1 = bounds.getCenter();
					var location2 = bounds.getNorthEast();

					fetch_reports(location1.lat(), location1.lng(), calculateRadius(location1, location2)/2, type);
				});
			});

			function addMarker(location) {
				var marker = new google.maps.Marker({
					position: location,
					map: map
				});
				markers.push(marker);
			}

			function clearMarkers() {
				setAllMap(null);
			}

			// Shows any markers currently in the array.
			function showMarkers() {
				setAllMap(map);
			}

			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
				clearMarkers();
				markers = [];
			}

			function setAllMap(map) {
				for (var i = 0; i < markers.length; i++) {
					markers[i].setMap(map);
				}
			}

			function update_map(position) {
				var latitude = position.coords.latitude;
				var longitude = position.coords.longitude;

				var location = new google.maps.LatLng(latitude, longitude);
				map.panTo(location);

				var bounds = map.getBounds();

				var location1 = bounds.getCenter();
				var location2 = bounds.getNorthEast();

				fetch_reports(latitude, longitude, calculateRadius(location1, location2)/2, 'score');
			}

			function fetch_reports(latitude, longitude, radius, type) {
				var params = {'latitude': latitude, 'longitude': longitude, 'radius': radius, 'orderby': type, 'id': '<?=$browser["id"]; ?>'};
				console.log(params);
				$.post('<?=base_url(); ?>api/report/fetch_nearby/', params, function(data) {
					data = JSON.parse(data);
					reports = data.data;
					
					deleteMarkers();
					$('#reports-list').html("");

					if( data.status ) {
						for (var i = 0; i < data.data.length; i++) {
							var id = data.data[i]['report_id'];
							var category = data.data[i]['category'];
							var address = data.data[i]['formatted_address'];
							var latitude = parseFloat(data.data[i]['latitude']);
							var longitude = parseFloat(data.data[i]['longitude']);
							var location = new google.maps.LatLng(latitude, longitude);
							
							addMarker(location);

							$('#reports-list').append(generateListItem(category, address));
						}
						setAllMap(map);
					}
				});
			}

			function generateListItem(category, address, id) {
				var item ='<a href="#" class="list-group-item report-item" data-id="'+id+'"><h4 class="list-group-item-heading">'+category+'</h4><p class="list-group-item-text">'+address+'</p></a>';
				return item;
			}

			function left_col_height() {
				var height = $(window).height() - 135;
				$('#reports-list').height(height);
				$('#reports-list').css({'overflow-y': 'scroll'});
			}

			function calculateRadius(location1, location2) {
				var lat1 = radian(location1.lat()); 
				var lon1 = radian(location1.lng()); 
				var lat2 = radian(location2.lat()); 
				var lon2 = radian(location2.lng()); 

				var R = 6371000; // in meters

				var dLat = (lat2-lat1);
				var dLon = (lon2-lon1);

				var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
				var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
				var d = R * c; 

				return d;
			}

			function radian(val) {
				return val*Math.PI/180;
			}
		</script>