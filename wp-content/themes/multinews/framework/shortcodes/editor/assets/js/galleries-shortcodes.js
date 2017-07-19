jQuery(document).ready(function ($) {
	// Prepare items arrays for lightbox
	$('.mom-su-lightbox-gallery').each(function () {
		var slides = [];
		$(this).find('.mom-su-slider-slide, .mom-su-carousel-slide, .mom-su-custom-gallery-slide').each(function (i) {
			$(this).attr('data-index', i);
			slides.push({
				src: $(this).children('a').attr('href')
			});
		});
		$(this).data('slides', slides);
	});
	// Enable sliders
	$('.mom-su-slider').each(function () {
		// Prepare data
		var $slider = $(this);
		// Apply Swiper
		var $swiper = $slider.swiper({
			wrapperClass: 'mom-su-slider-slides',
			slideClass: 'mom-su-slider-slide',
			slideActiveClass: 'mom-su-slider-slide-active',
			slideVisibleClass: 'mom-su-slider-slide-visible',
			pagination: '#' + $slider.attr('id') + ' .mom-su-slider-pagination',
			autoplay: $slider.data('autoplay'),
			paginationClickable: true,
			grabCursor: true,
			mode: 'horizontal',
			mousewheelControl: $slider.data('mousewheel'),
			speed: $slider.data('speed'),
			calculateHeight: $slider.hasClass('mom-su-slider-responsive-yes'),
			loop: true
		});
		// Prev button
		$slider.find('.mom-su-slider-prev').click(function (e) {
			$swiper.swipeNext();
		});
		// Next button
		$slider.find('.mom-su-slider-next').click(function (e) {
			$swiper.swipePrev();
		});
	});
	// Enable carousels
	$('.mom-su-carousel').each(function () {
		// Prepare data
		var $carousel = $(this),
			$slides = $carousel.find('.mom-su-carousel-slide');
		// Apply Swiper
		var $swiper = $carousel.swiper({
			wrapperClass: 'mom-su-carousel-slides',
			slideClass: 'mom-su-carousel-slide',
			slideActiveClass: 'mom-su-carousel-slide-active',
			slideVisibleClass: 'mom-su-carousel-slide-visible',
			pagination: '#' + $carousel.attr('id') + ' .mom-su-carousel-pagination',
			autoplay: $carousel.data('autoplay'),
			paginationClickable: true,
			grabCursor: true,
			mode: 'horizontal',
			mousewheelControl: $carousel.data('mousewheel'),
			speed: $carousel.data('speed'),
			slidesPerView: ($carousel.data('items') > $slides.length) ? $slides.length : $carousel.data('items'),
			slidesPerGroup: $carousel.data('scroll'),
			calculateHeight: $carousel.hasClass('mom-su-carousel-responsive-yes'),
			loop: true
		});
		// Prev button
		$carousel.find('.mom-su-carousel-prev').click(function (e) {
			$swiper.swipeNext();
		});
		// Next button
		$carousel.find('.mom-su-carousel-next').click(function (e) {
			$swiper.swipePrev();
		});
	});
	// Enable lightbox
	$('.mom-su-lightbox-gallery').on('click', '.mom-su-slider-slide, .mom-su-carousel-slide, .mom-su-custom-gallery-slide', function (e) {
		e.preventDefault();
		var slides = $(this).parents('.mom-su-lightbox-gallery').data('slides');
		$.magnificPopup.open({
			items: slides,
			type: 'image',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0, 1],
				tPrev: mom_su_magnific_popup.prev,
				tNext: mom_su_magnific_popup.next,
				tCounter: mom_su_magnific_popup.counter
			},
			tClose: mom_su_magnific_popup.close,
			tLoading: mom_su_magnific_popup.loading
		}, $(this).data('index'));
	});
});