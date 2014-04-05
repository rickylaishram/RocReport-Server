$(document).ready(function() {
	set_admin_nav_height();
});

$(document).resize(function() {
	set_admin_nav_height();
});

function set_admin_nav_height() {
	if($(window).width() > 768) {
		$('.admin-menu').height($(window).height() - 50);
		$('.admin-menu').css({position: 'fixed'});
	} else {
		$('.admin-menu').height('auto');
		$('.admin-menu').css({position: 'relative'});
	}
}