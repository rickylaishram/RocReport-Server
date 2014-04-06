$(document).ready(function() {
	set_height();
});

$(window).resize(function() {
	set_height();
});

function set_height() {
	if($(window).width() > 768) {
		var height = $(window).height() - 50;
		$('.admin-menu').height(height);
		$('.admin-menu').css({position: 'fixed'});
		$('.user-menu').height(height);
		$('.user-menu').css({position: 'fixed'});
		$('.report-details').height(height);
		$('.report-list').height(height);
	} else {
		$('.admin-menu').height('auto');
		$('.admin-menu').css({position: 'relative'});
		$('.user-menu').height(height);
		$('.user-menu').css({position: 'fixed'});
		$('.report-list').height('auto');
		$('.report-details').height('auto');
	}
}