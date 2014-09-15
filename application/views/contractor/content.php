<div class="container-fluid">
	<div class="row">
		
		<!-- Search Panel -->
		<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
			<div class="panel panel-default panel-animated-slight">
				<div class="panel-heading panel-header-main">Search</div>
				<div class="panel-body">
					
					<!-- Forn Starts -->
					<div class="form-horizontal" role="form">
						
						<div class="form-group form-big">
							<label for="category" class="col-md-2 control-label">Category</label>
							<div class="col-lg-10">
								<select class="form-control" id="category"></select>
							</div>
						</div>

						<div class="form-group form-big">
							<label for="latitude" class="col-lg-2 control-label">Address</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" placeholder="Address" d="address" name="address">
							</div>
							<div class="col-lg-2">
								<span class="glyphicon glyphicon-map-marker" id="map-marker"></span>
							</div>
						</div>

						<div class="form-group form-big">
							<label for="latitude" class="col-lg-2 control-label"></label>
							<div class="col-lg-4">
								<input type="number" class="form-control" placeholder="Latitude" id="latitude" name="latitude">
							</div>
							<div class="col-lg-4">
								<input type="number" class="form-control" placeholder="Longitude" id="longitude" name="longitude">
							</div>
						</div>

						<div class="form-group form-big">
							<label for="pass1" class="col-lg-2 control-label">Radius</label>
							<div class="col-lg-10">
								<input type="number" class="form-control" placeholder="Radius" required id="radius" name="radius">
							</div>
						</div>

						<div class="form-group form-big">
							<label for="" class="col-lg-2 control-label"></label>
							<div class="col-lg-4">
								<button class="btn btn-primary btn-block" id="btn_search_job" type="submit" >Search</button>
							</div>
						</div>
						
					</div><!-- /Form Starts -->

					<div class="contractor-search-results"></div>

				</div>
			</div>
		</div><!-- /Search Panel -->

		<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
			<div class="panel panel-default panel-animated-slight">
				<div class="panel-heading panel-header-main">Bids</div>
				<div class="panel-body">
					Basic panel example
				</div>
			</div>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="panel panel-default panel-animated-slight">
				<div class="panel-heading panel-header-main">Profile</div>
				<div class="panel-body">
					Basic panel example
				</div>
			</div>
		</div>
	</div>
</div> <!-- /container -->

<script src="<?=base_url(); ?>static/js/main.js"></script>
<script type="text/javascript">
	r.contractor.data.token = <?=json_encode($auth['token']); ?>;
	r.contractor.data.id = <?=json_encode($auth['id']); ?>;
	r.contractor.data.nonce = <?=json_encode($auth['nonce']); ?>;

	r.contractor.url.fetchCategories = <?=json_encode(base_url().'private_api/category/fetch'); ?>;
	r.contractor.url.fetchJobs = <?=json_encode(base_url().'private_api/contractor/job/fetch'); ?>;
	r.contractor.url.fetchBids = <?=json_encode(base_url().'private_api/contractor/bid/fetch'); ?>;

	r.contractor.init();
</script>