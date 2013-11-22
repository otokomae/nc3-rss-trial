/**
 *
 *
 */
 ;(function($) {
	$.fn.Rss = function(id)
	{
		$('.rss-headline h2', $('#' + id)).click(function() {
			$('.rss-lists', $('#' + id)).toggle();
		});

		$('.rss-head', $('#' + id)).click(function() {
			$(this).next('.rss-detail').toggle();
		});
	};
 })(jQuery);