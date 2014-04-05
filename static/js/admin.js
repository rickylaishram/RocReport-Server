var admin = {
	base_url: null,
	reports: null,
	browser_id: null;

	init: function() {
		$(document).on('click', '.admin-menu-item', function() {
			var id = $(this).data('id');
			$('.admin-menu-active').removeClass('admin-menu-active');
			$(this).addClass('admin-menu-item');
		});
	},
}