var admin = {
	base_url: null,
	ep_reports_closed: null,
	ep_reports_open: null,

	reports: null,
	browser_id: null,
	map: null,
	marker: null,

	init: function() {
		$(document).on('click', '.admin-menu-item', function() {
			var id = $(this).data('id');
			$('.admin-menu-active').removeClass('admin-menu-active');
			$(this).addClass('admin-menu-active');

			if (id === 1) {

			} else if (id === 2) {
				admin.fetch_open_reports();
			} else if (id === 3) {
				admin.fetch_closed_reports();
			} else if (id === 4) {

			};
		})
		.on('click', '.report-item', function() {
			$('.report-list-item-active').removeClass('report-list-item-active');
			var reportid = $(this).data('id');
			var position = $(this).data('position');
			admin.show_report_details(position);
			$(this).addClass('report-list-item-active');
		});
	},

	fetch_open_reports: function() {
		$('.admin-content').hide();
		$('.report-details').hide();
		var params = {id: admin.browser_id};
		$.post(admin.base_url+admin.ep_reports_open, params, function(data) {
			var data = JSON.parse(data);
			admin.reports = data['data'];
			admin.populate_reports_list(admin.reports);
		});
	},

	fetch_closed_reports: function() {
		$('.admin-content').hide();
		$('.report-details').hide();
		var params = {id: admin.browser_id};
		$.post(admin.base_url+admin.ep_reports_closed, params, function(data) {
			var data = JSON.parse(data);
			admin.reports = data['data'];
			admin.populate_reports_list(admin.reports);
		});
	},

	show_report_details: function(position) {
		$('.report-details').show();

		$('#report-details-image').attr('width', $('#report-details-image-container').width());

		var report = admin.reports[position];
		$('#report-details-category').html(report['category']);
		$('#report-details-address').html(report['formatted_address']);
		$('#report-details-date').html('Added at '+report['added_at']);
		$('#report-details-score').html('Score '+report['score']);
		$('#report-details-vote').html('Votes '+report['vote_count']); // To be added later
		$('#report-details-image').attr('src', report['picture']);

		var update_list = $('.report-details-updates');
		update_list.html('');

		for (var i = 0; i < report['updates'].length; i++) {
			update_list.append('<a class="list-group-item">By <b>'+report['updates'][i]['updated_by']+'</b> at '+report['updates'][i]['updated_at']+'<br>'+report['updates'][i]['status']+'<br>'+report['updates'][i]['description']+'</a>');
		};

		if(report['closed'] === '1') {
			$('#report-btn-close').hide();
			$('#report-btn-open').show();
			$('#report-btn-open').data('id', report['report_id']);
			$('#report-btn-open').data('id', '');
		} else {
			$('#report-btn-open').hide();
			$('#report-btn-close').show();
			$('#report-btn-open').data('id', '');
			$('#report-btn-open').data('id', report['report_id']);
		}

		// Set map location
		admin.map_initialize();
		if(admin.marker != null) {
			admin.marker.setMap(null);
		}
		
		var location = new google.maps.LatLng(parseFloat(report['latitude']), parseFloat(report['longitude']));
		admin.map.panTo(location);
		admin.marker = new google.maps.Marker({
					position: location,
					map: admin.map
				});
		admin.marker.setMap(admin.map);
	},

	fetch_report_details: function(reportid) {

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
				mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
			},
		};
		admin.map = new google.maps.Map(document.getElementById("report-details-map"),
						mapOptions);

		admin.map.mapTypes.set('map_style', styledMap);
		admin.map.setMapTypeId('map_style');
	},
}