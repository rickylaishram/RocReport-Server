		<div class="container-fluid">

			<div class="row">

				<div class="col-md-6">
					<form class="form-addr" role="form">
						<h2 class="form-addr-heading">Add A New Report</h2>

		                    <select id="issueCat" class="selectpicker show-tick form-control" required data-live-search="true">
		                        <option value="0">Select a Category		                    
		                        <option value="1">vehicle issue
								<option value="2">street, road, sidewalk
								<option value="3">animal issues
								<option value="4">trash, waste
								<option value="5">street light
								<option value="6">road sign
								<option value="7">traffic light
								<option value="8">plant, tree
		                    </select>

							<input id="issueDesc" type="text" class="form-control" placeholder="Description of Issue" required>
							<input id="issueAddr" type="text" class="form-control" placeholder="Enter the Address" required>
							<input id="issueLat" type="hidden" value="0">
							<input id="issueLong" type="hidden" value="0">
							<input id="locStatus" type="hidden" value="0">
							
						<button id="addReport" class="btn btn-lg btn-warning btn-block" type="submit">Submit Issue</button>
					</form>
				</div>

			</div>
		</div> <!-- /container -->

		<script type="text/javascript">

        	$(window).on('load', function () {

            	$('.selectpicker').selectpicker({
                	'noneSelectedText':'Choose a Category'
            	});

            	// $('.selectpicker').selectpicker('hide');
        	});

			$(document).ready(function() {
				//google.maps.event.addDomListener(window, 'load', admin.map_initialize);
				
				$('form').on('submit', function(e){
 					e.preventDefault();
 					return false;
				});

				

				app_add.base_url = "<?=base_url(); ?>";
				app_add.add_report = "add_report/api/add";
				app_add.browser_id = "<?=$browser['id']; ?>";
				app_add.token = "<?=$browser['id']; ?>";
				app_add.init();

				app_add.processLocation();

			});

		var app_add = {
					base_url: null,
					add_report: null,

					browser_id: null,
					map: null,
					formatted_address: null,

					init: function() {
						$(document).on('click', '#addReport', function() {
							var latitude = $("#issueLat").val();
							var longitude = $("#issueLong").val();
							var category = $("#issueCat").val();
							var description = $("#issueDesc").val();
							var picture = "aa";
							app_add.addIssue(latitude, longitude, category, description, picture);
						});

						app_add.processLocation();
						/*.on('keyup', '#issueAddr', function() {
							app_add.processLocation();
						})
						.on('click', '#issueAddr', function() {
							app_add.processLocation();
						})*/
					},

					addIssue: function(latitude, longitude, category, description, picture) {
						if ($("#locStatus").val() === "2") {
							var params = {id: app_add.browser_id, latitude: latitude, longitude: longitude, category: category, description: description, picture: picture, novote: "TRUE"};
			                $.post(app_add.base_url+app_add.add_report, params, function(data) {
			                        var dataRecv = JSON.parse(data);
			                        if (dataRecv.status === true) {
			                        	alert ("Your report has been added. Thank you :-)");
			                        	top.location.href = app_add.base_url;
			                        } else {
			                        	alert ("There was an error: " + dataRecv.data.reason);
			                        }
			                });
						}
					},

					processLocation: function() {
						if (navigator.geolocation) {
							$("#issueAddr").val("Getting Location...");
							$("#locStatus").val("1");
							navigator.geolocation.getCurrentPosition(function(position){
								$("#locStatus").val("2");
								$("#issueLat").val(position.coords.latitude);
								$("#issueLong").val(position.coords.longitude);
								$("#issueAddr").val("Latitude: " + position.coords.latitude 
								+ " - " + "Longitude: " + position.coords.longitude);
								//console.log(position);
								app_add.fetchAddress(position.coords.latitude, position.coords.longitude);
							});
						} else{
							$(".loading-container").hide();
							$("#issueAddr").val("Geolocation Not supported :(");
							$("#addReport").remove();
							$("#locStatus").val("0");
						}
					},

					fetchAddress: function (latitude, longitude) {
						var url = "https://maps.googleapis.com/maps/api/geocode/json?&sensor=true&key=<?= $this->config->item('googleMaps')?>&latlng=";
						$.get(url+latitude+','+longitude, function(data) {
							//var data = JSON.parse(data);

							console.log(data['results'][1]['formatted_address']);
							$(".loading-container").hide();
						});
					}

				};
</script>