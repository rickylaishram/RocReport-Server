$(document).ready(function() {
	set_admin_nav_height();
});

$(window).resize(function() {
	set_admin_nav_height();
});

function set_admin_nav_height() {
	if($(window).width() > 768) {
		var height = $(window).height() - 50;
		$('.admin-menu').height(height);
		$('.admin-menu').css({position: 'fixed'});
		$('.report-details').height(height);
		$('.report-list').height(height);

	} else {
		$('.admin-menu').height('auto');
		$('.admin-menu').css({position: 'relative'});
		$('.report-list').height('auto');
	}
}