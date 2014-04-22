var user = {
	base_url: null,
	ep_reports_nearby: null,
	ep_reports_mine: null,
	ep_vote: null,

	latitude: null,
	longitude: null,

	reports: null,
	browser_id: null,
	map: null,
	marker: null,

	init: function() {
		$(document).on('click', '.user-menu-item', function() {
			var id = $(this).data('id');
			$('.user-menu-active').removeClass('user-menu-active');
			$(this).addClass('user-menu-active');

			if (id === 1) {

			} else if (id === 2) {
				user.fetch_reports_nearby();
			} else if (id === 3) {
				user.fetch_reports_mine();
			} else if (id === 4) {

			};
		})
		.on('click', '.report-item', function() {
			$('.report-list-item-active').removeClass('report-list-item-active');
			var reportid = $(this).data('id');
			var position = $(this).data('position');
			user.show_report_details(position);
			$(this).addClass('report-list-item-active');
		})
		.on('click', '#report-btn-vote', function() {
			var reportid = $(this).data('id');
			var position = $(this).data('position');
			user.send_vote(reportid, position);
		});

		user.fetch_reports_nearby();
	},

	send_vote: function(reportid, position) {
		var params = {id: user.browser_id, report: reportid};
		$.post(user.base_url+user.ep_vote, params, function(data) {
			var data = JSON.parse(data);
			console.log(data);
			$('#report-btn-vote').data('id','');
			$('#report-btn-vote').hide();
		});
	},

	fetch_reports_nearby: function() {
		$('.user-content').hide();
		$('.report-details').hide();
		var params = {id: user.browser_id, latitude: user.latitude, longitude: user.longitude};
		$.post(user.base_url+user.ep_reports_nearby, params, function(data) {
			var data = JSON.parse(data);
			console.log(data);
			user.reports = data['data'];
			user.populate_reports_list(user.reports);
		});
	},

	fetch_reports_mine: function() {
		$('.user-content').hide();
		$('.report-details').hide();
		var params = {id: user.browser_id};
		$.post(user.base_url+user.ep_reports_mine, params, function(data) {
			var data = JSON.parse(data);
			console.log(data);
			user.reports = data['data'];
			user.populate_reports_list(user.reports);
		});
	},

	show_report_details: function(position) {
		$('.report-details').show();

		$('#report-details-image').attr('width', $('#report-details-image-container').width());

		var report = user.reports[position];
		$('#report-details-category').html(report['category']);
		$('#report-details-description').html(report['description']);
		$('#report-details-address').html(report['formatted_address']);
		$('#report-details-date').html('Added at '+report['added_at']);
		$('#report-details-score').html('Score '+report['score']);
		$('#report-details-vote').html('Votes '+report['vote_count']); // To be added later
		$('#report-details-image').attr('src', report['picture']);

		if(report['hasVotes']) {
			$('#report-btn-vote').data('id','');
			$('#report-btn-vote').data('position','');
			$('#report-btn-vote').hide();
		} else {
			$('#report-btn-vote').data('id',report['report_id']);
			$('#report-btn-vote').data('position',position);
			$('#report-btn-vote').show();
		}

		// Set map location
		user.map_initialize();
		if(user.marker != null) {
			user.marker.setMap(null);
		}
		
		var location = new google.maps.LatLng(parseFloat(report['latitude']), parseFloat(report['longitude']));
		user.map.panTo(location);
		user.marker = new google.maps.Marker({
					position: location,
					map: user.map
				});
		user.marker.setMap(user.map);
	},

	populate_reports_list: function(reports) {
		var list = $('.report-list');
		list.html('');
		for (var i = reports.length - 1; i >= 0; i--) {
			list.append('<a href="#" data-id="'+reports[i]['report_id']+'" data-position="'+i+'" class="list-group-item report-item"><h4 class="list-group-item-heading report-details-uppercase">'+reports[i]['category']+'</h4><p class="list-group-item-text">'+reports[i]['formatted_address']+'</p></a>');
		};
		$('#content-reports').show();
	},

	map_initialize: function() {
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
			zoom: 18,
			mapTypeControlOptions: {
				mapTypeIds: [google.maps.MapTypeId.SATELLITE, 'map_style']
			},
		};
		user.map = new google.maps.Map(document.getElementById("report-details-map"),
						mapOptions);

		user.map.mapTypes.set('map_style', styledMap);
		//user.map.setMapTypeId('map_style');
		user.map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
	},
}