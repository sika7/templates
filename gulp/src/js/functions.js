/*スクロール*/
$(document).ready(function() {
	var pagetop = $('.pagetop');
	$(window).scroll(function() {
		if ($(this).scrollTop() > 700) { pagetop.fadeIn(); } else { pagetop.fadeOut(); }
	});
	pagetop.click(function() {
		$('body, html').animate({ scrollTop: 0 }, 500);
		return false;
	});
});

/*スマホメニュー表示*/
/*js判定*/
$("body").addClass("js-on");
$("body").removeClass("js-off");
$("#js-navToggle").click(function() { $("body").toggleClass("gNavOpen"); });
$('.globalNav .js−scrollLink').on('click', function() {
	if (window.innerWidth <= 768) {
		$('#js-navToggle').click();
	}
});
