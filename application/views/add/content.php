		<div class="container-fluid">

			<div class="row">

				<div class="col-md-6">
					<form id="fileUploadForm" class="form-addr" role="form" method="post" enctype="multipart/formdata">
						<h2 class="form-addr-heading">Add A New Report</h2>

		                    <select id="issueCat" class="selectpicker show-tick form-control" required data-live-search="true" required>
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
							<input id="issueFormattedAddress" class="form-control" type="text" disabled>
							<input id="issueLat" type="hidden" value="0">
							<input id="issueLong" type="hidden" value="0">
							<input id="locStatus" type="hidden" value="0">
							<input id="picUrl" type="hidden" value="0">
							<!--<input type="file" name="image" id="issueImage" class="form-control" required>-->
							<input type="button" id="upload-btn" class="btn btn-primary btn-large clearfix" value="Choose an Image">
							<img id="uploadedImg" src="" style="width: 150px; height: 150px; border-radius: 5px; display: none; margin-left: 10px;" />  
							<button id="addReport" class="btn btn-lg btn-warning btn-block" type="submit" style="margin-top: 10px;">Submit Issue</button>
					</form>

					<div id="errormsg" class="clearfix redtext">
					</div>	              
					<div id="pic-progress-wrap" class="progress-wrap" style="margin-top:10px;margin-bottom:10px;">
					</div>	
					
					<div id="picbox" class="clear" style="padding-top:0px;padding-bottom:10px;">
					</div>



				</div>

			</div>
		</div> <!-- /container -->

		<script type="text/javascript">

			function safe_tags( str ) {
			  return String( str )
			           .replace( /&/g, '&amp;' )
			           .replace( /"/g, '&quot;' )
			           .replace( /'/g, '&#39;' )
			           .replace( /</g, '&lt;' )
			           .replace( />/g, '&gt;' );
			}


			window.onload = function() {
			  
				var uploader = new ss.SimpleUpload({
				      	button: 'upload-btn', // HTML element used as upload button
				      	url: '/add_report/api/image', // URL of server-side upload handler
				      	name: 'image', // Parameter name of the uploaded file
				      	data: {id:"<?=$browser['id']; ?>"},
				      	method:"POST",
						onComplete: function(filename, response) {
							console.log(response + "-" + filename);
				          	if (!response) {
				            	alert('Upload Failed - '+response+'. Please try again!');
				            	return false;            
				          	} else {
				          		responseFinal = JSON.parse(response);
				          		$("#picUrl").val(responseFinal.file);
				          		$("#uploadedImg").attr("src", responseFinal.file).show();
				          	}
        				}
				});
			};


        	$(window).on('load', function () {

            	$('.selectpicker').selectpicker({
                	'noneSelectedText':'Choose a Category'
            	});

            	// $('.selectpicker').selectpicker('hide');
        	});

			$(document).ready(function() {
				//google.maps.event.addDomListener(window, 'load', admin.map_initialize);
				var interval;
				$('form').on('submit', function(e){
 					e.preventDefault();
 					return false;
				});

				app_add.base_url = "<?=base_url(); ?>";
				app_add.add_report = "add_report/api/add";
				app_add.add_image = "add_report/api/image";
				app_add.browser_id = "<?=$browser['id']; ?>";
				app_add.token = "<?=$browser['id']; ?>";
				app_add.init();
				app_add.processLocation();

			});

			var app_add = {
					base_url: null,
					add_report: null,
					add_image: null,
					
					browser_id: null,
					map: null,
					formatted_address: null,

					init: function() {
						$(document).on('click', '#addReport', function() {
							var latitude = $("#issueLat").val();
							var longitude = $("#issueLong").val();
							var category = $("#issueCat").val();
							var description = $("#issueDesc").val();
							var picture = $("#picUrl").val();
							app_add.addIssue(latitude, longitude, category, description, picture);
						});
						app_add.processLocation();
					},

					addIssue: function(latitude, longitude, category, description, picture) {
						if ($("#locStatus").val() === "2" && category != "0" && description != "" && picture != "0") {
							var params = {id: app_add.browser_id, picture: picture, latitude: latitude, longitude: longitude, category: category, description: description, picture: picture, novote: "TRUE", formatted_address: app_add.formatted_address};
			                $.post(app_add.base_url+app_add.add_report, params, function(data) {
			                        var dataRecv = JSON.parse(data);
			                        if (dataRecv.status === true) {
			                        	alert ("Your report has been added. Thank you :-)");
			                        	top.location.href = app_add.base_url;
			                        } else {
			                        	alert ("There was an error: " + dataRecv.data.reason);
			                        }
			                });		
						} else if (category == "0") {
							alert("Please select a Category");
						} else if (description == "") {
							alert("Please add a description");
						} else if (picture == "0") {
							alert("Please choose a picture");
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

							app_add.formatted_address = data['results'][1]['formatted_address'];
							$("#issueFormattedAddress").val(app_add.formatted_address);
							$(".loading-container").hide();
						});
					}

				};
</script>