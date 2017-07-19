jQuery(document).ready(function ($) {
	$('#wpwrap').before($('.mom-su-vote').slideDown());
	$('.mom-su-vote-action').on('click', function (e) {
		var $this = $(this);
		e.preventDefault();
		$.ajax({
			type: 'get',
			url: $this.attr('href'),
			beforeSend: function () {
				$('.mom-su-vote').slideUp();
				if (typeof $this.data('action') !== 'undefined') window.open($this.data('action'));
			},
			success: function (data) {}
		});
	});
});