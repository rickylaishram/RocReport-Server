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

			<!-- The details modal -->
			<div class="modal fade details-modal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">

							<div class="row">
								<div id="report-details-image-container">
									<img src="" id="report-details-image"/>
								</div>
							</div>
							<div class="row report-details-big report-details-uppercase">
								<div id="report-details-category" ></div>
							</div>
							<div class="row report-details-medium">
								<div id="report-details-description" ></div>
							</div>
							<div class="row report-details-medium">
								<div id="report-details-address" ></div>
							</div>
							<div class="row report-details-small">
								<div id="report-details-date" ></div>
							</div>
							<div class="row report-details-small">
								<div id="report-details-score" ></div>
							</div>
							<div class="row report-details-small">
								<div id="report-details-votes" ></div>
							</div>
			
						</div>
					</div>
				</div>
			</div>

		</div> <!-- /container -->

		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?= $this->config->item('googleMaps')?>&sensor=false"></script>
		<script type="text/javascript">
			var map = null;
			var markers = [];
			var reports = null;

			function initialize() {
				// Set map-canvas height
				if($(window).width() <= 768) {
					var height = ($(window).height() - 80)/2;
					$('#map-canvas').height(height);
				} else {
					var height = $(window).height() - 80;
					if(height < 200) {
						height = 200;
					}
					$('#map-canvas').height(height);
				}
				

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
										{ saturation: -100 }
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

				/*$(".btnSelector").click(function(){
					$(".btnSelector.active").removeClass("active");
					$(this).addClass("active");

					var type = $(this).data("type");

					var bounds = map.getBounds();

					var location1 = bounds.getCenter();
					var location2 = bounds.getNorthEast();

					fetch_reports(location1.lat(), location1.lng(), calculateRadius(location1, location2)/2, type);
				});*/

				$(document)
					.on("click", ".btnSelector", function(){
						$(".btnSelector.active").removeClass("active");
						$(this).addClass("active");

						var type = $(this).data("type");

						var bounds = map.getBounds();

						var location1 = bounds.getCenter();
						var location2 = bounds.getNorthEast();

						fetch_reports(location1.lat(), location1.lng(), calculateRadius(location1, location2)/2, type);
					})
					.on("click", ".report-item", function() {
						var category = $(this).data('category');
						var description = $(this).data('description');
						var address = $(this).data('address');
						var image = $(this).data('image');
						var score = $(this).data('score');
						var vote = $(this).data('votes');

						display_details(category, description, address, image, score, vote);
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
				var loader = $('.loading-container');
				loader.show();
				
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
							var image = data.data[i]['picture'];
							var votes = data.data[i]['vote_count'];
							var score = data.data[i]['score'];
							var description = data.data[i]['description'];
							var location = new google.maps.LatLng(latitude, longitude);
							
							addMarker(location);

							$('#reports-list').append(generateListItem(category, address, id, image, votes, score, description, latitude, longitude));
						}
						setAllMap(map);
					}

					loader.hide();
				});
			}

			function generateListItem(category, address, id, image, votes, score, description, latitude, longitude) {
				var item ='<a href="#" class="list-group-item report-item" data-id="'+id+'" data-image="'+image+'" data-votes="'+votes+'" data-score="'+score+'" data-category="'+category+'" data-address="'+address+'" data-description="'+description+'" data-latitude="'+latitude+'" data-longitude="'+longitude+'" ><h4 class="list-group-item-heading report-details-uppercase">'+category+'</h4><p class="list-group-item-text">'+address+'</p></a>';
				return item;
			}

			function display_details(category, description, address, image, score, vote) {
				$('#report-details-image').attr('src', image);
				$('#report-details-image').attr('width', $('#report-details-image-container').width());
				$('#report-details-category').html(category);
				$("#report-details-description").html(description);
				$('#report-details-address').html(address);

				$('.details-modal').modal('toggle');
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