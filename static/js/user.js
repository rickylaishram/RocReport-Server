var user = {
	base_url: null,
	ep_reports_nearby: null,
	ep_reports_mine: null,

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
		.on('keyup', '#report-update-area', function() {
			if($(this).val().length > 0) {
				$('#report-btn-update').prop('disabled', false);
			} else {
				$('#report-btn-update').prop('disabled', true);
			}
		})
		.on('click', '#report-btn-update', function() {
			var text = $('#report-update-area').val();
			var reportid = $(this).data('id');
			user.send_update(text, reportid);
		})
		.on('click', '#report-btn-open', function() {
			var reportid = $(this).data('id');
			user.open_report(reportid);
		})
		.on('click', '#report-btn-close', function() {
			var reportid = $(this).data('id');
			user.close_report(reportid);
		});
	},

	fetch_reports_nearby: function() {
		$('.user-content').hide();
		$('.report-details').hide();
		var params = {id: user.browser_id};
		$.post(user.base_url+user.ep_reports_open, params, function(data) {
			var data = JSON.parse(data);
			console.og(data);
			user.reports = data['data'];
			user.populate_reports_list(user.reports);
		});
	},

	fetch_reports_mine: function() {
		$('.user-content').hide();
		$('.report-details').hide();
		var params = {id: user.browser_id};
		$.post(user.base_url+user.ep_reports_closed, params, function(data) {
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
		$('#report-details-address').html(report['formatted_address']);
		$('#report-details-date').html('Added at '+report['added_at']);
		$('#report-details-score').html('Score '+report['score']);
		$('#report-details-vote').html('Votes '+report['vote_count']); // To be added later
		$('#report-details-image').attr('src', report['picture']);
		$('#report-btn-update').data('id', report['report_id']);

		var update_list = $('#report-details-updates');
		update_list.html('');

		for (var i = 0; i < report['updates'].length; i++) {
			console.log(report['updates'][i]);
			update_list.append('<a class="list-group-item">By <b>'+report['updates'][i]['updated_by']+'</b> at '+report['updates'][i]['updated_at']+'<br>'+report['updates'][i]['status']+'<br>'+report['updates'][i]['description']+'</a>');
		};

		if(report['closed'] === '1') {
			$('#report-btn-close').hide();
			$('#report-btn-open').show();
			$('#report-btn-open').data('id', report['report_id']);
			$('#report-btn-close').data('id', '');
		} else {
			$('#report-btn-open').hide();
			$('#report-btn-close').show();
			$('#report-btn-open').data('id', '');
			$('#report-btn-close').data('id', report['report_id']);
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

	send_update: function(text, reportid) {
		var params = {id: user.browser_id, update: text, report_id: reportid};
		$.post(user.base_url+user.ep_report_update, params, function() {
			$('#report-btn-update').prop('disabled', true);
			$('#report-update-area').val('');
			$('#report-details-updates').prepend('<a class="list-group-item">By <b>Me</b> at now<br>open<br>'+text+'</a>')
		});
	},

	populate_reports_list: function(reports) {
		var list = $('.report-list');
		list.html('');
		for (var i = reports.length - 1; i >= 0; i--) {
			list.append('<a href="#" data-id="'+reports[i]['report_id']+'" data-position="'+i+'" class="list-group-item report-item">'+reports[i]['category']+' at '+reports[i]['formatted_address']+'</a>');
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