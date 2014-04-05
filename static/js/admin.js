var admin = {
	base_url: null,
	ep_reports_closed: null,
	ep_reports_open: null,

	reports: null,
	browser_id: null,

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
		});
	},

	fetch_open_reports: function() {
		var params = {id: admin.browser_id};
		$.post(admin.base_url+admin.ep_reports_open, params, function(data) {
			console.log(data);
		});
	},

	fetch_closed_reports: function() {
		var params = {id: admin.browser_id};
		$.post(admin.base_url+admin.ep_reports_closed, params, function(data) {
			console.log(data);
		});
	},
}