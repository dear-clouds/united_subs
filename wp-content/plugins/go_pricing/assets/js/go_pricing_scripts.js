/**
 * Go Pricing - WordPress Responsive Pricing Tables
 * 
 * Description: The New Generation Pricing Tables. If you like traditional Pricing Tables, but you would like get much more out of it, then this rodded product is a useful tool for you.
 * Version:     3.3.1
 * Author:      Granth
 * License:		http://codecanyon.net/licenses/
 * 
 * (C) 2016 Granth (http://granthweb.com)
 */
 

(function ($, undefined) {
	"use strict";
		
	$(function () {	
	
		/**
		 * Initialize
		 */
		
		$.GoPricing = {

			/* Init function */
			Init : function () {
				this.$wrap = $('.gw-go');
				this.InitAnim();
				this.equalize = this.$wrap.data('equalize');
				this.InitMediaElementPlayer();
				this.InitGoogleMap();
				this.isIE = document.documentMode != undefined && document.documentMode >5 ? document.documentMode : false;
				if (this.isIE) {
					this.$wrap.addClass('gw-go-ie');
					if (this.isIE < 9) this.$wrap.addClass('gw-go-oldie');
				};
				if ($.GoPricing!=undefined && $.GoPricing.equalize==true) {
					this.EqualizeRows();
				};
				this.eventType = this.detectEvent();
				this.timeout = [];
			},

			InitAnim: function() {
				this.$wrap.each(function( i, obj ) {
					$(obj).css('opacity', 1);
					var $cols = $(".gw-go-col-wrap[data-col-anim]", this);
					if ($cols.length) {
						var tl = new TimelineLite({
							paused: true,
							onStart: function() {
								var tw = this.getChildren(), i = tw.length;
								while (i--) if (tw[i].vars.onUpdate) tw[i].vars.onUpdate();
							}
						});
						$cols.each(function(i, col) {
							var anim = $(col).data('col-anim') || {};
							if (anim.trans) {
								anim.css.opacity /= 100, anim.css.scaleX /= 100, anim.css.scaleY /= 100;
								tl.add( TweenLite.from(col, anim.trans.duration/1000, {css: anim.css, ease: anim.trans.ease}), anim.trans.delay/1000 );
							}
							if (anim.count) {
								var $price = $('[data-id=price]', col),
									counter = { value : (anim.count.from || 0) },
									$amount = $price.find('[data-id=amount]'),
									price = $price.data('price') || 0,
									currency = $price.data('currency') || {},
									decimals = (price || '').toString().split('.')[1] || '',
									decCnt = decimals.length;
								
								tl.add( TweenLite.to(counter, anim.count.duration/1000, {
									value: price,
									ease: anim.count.ease,
									onUpdate: function() {
										var c = counter.value
										$amount.html(function() {
											return parseFloat(c).toFixed(decCnt)
												.replace(".", (currency['decimal-sep'] || '.')) // replace decimal point character with ,
												.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1"+(currency['thousand-sep'] || ' '));
										});											
									}
								}), anim.count.delay/1000 );
							}
						});
						var $this = $(this).data('tl', tl);
						$this.tablespy({offset: $this.data('scroll-offset')});
						TweenLite.set(this, {perspective: '1000px'});
					}
				});
			},

			/* Show Tooltip */
			showTooltip : function ($elem, content, top) {
				
				if ($elem === undefined) return;
				
				var $rowTooltip = $elem.find('.gw-go-tooltip-content'),
					rowTooltipContent = $rowTooltip.length ? $rowTooltip.prop('outerHTML') : '',
					$colWrap = $elem.closest('.gw-go-col-wrap'),
					$col = $colWrap.find('.gw-go-col'),
					$tooltip = $col.find('.gw-go-tooltip'),
					colIndex = $colWrap.data('col-index'),
					rIndex = $elem.data('row-index');	
				
				if (!$tooltip.length ) $tooltip = $('<div class="gw-go-tooltip"></div>').appendTo($col);
								
				if ($tooltip.data('index') != rIndex) {
					$tooltip.removeClass('gw-go-tooltip-visible');
				} else {
					clearTimeout($.GoPricing.timeout[colIndex]);
				}

				if (rowTooltipContent != '') {
					$tooltip.html(rowTooltipContent).data('index', rIndex)
					setTimeout(function() { $tooltip.addClass('gw-go-tooltip-visible').css('top', $col.find('.gw-go-body').position().top + $elem.position().top - $tooltip.outerHeight()); }, 10);
				}

			},

			/* Hide Tooltip */
			hideTooltip : function ($elem) {

				if ($elem === undefined) return;
				
				if ($elem.hasClass('gw-go-tooltip')) {
					$elem.removeClass('gw-go-tooltip-visible');
				} else {
					
					var $colWrap = $elem.closest('.gw-go-col-wrap'),
						$col = $colWrap.find('.gw-go-col'),
						$tooltip = $col.find('.gw-go-tooltip'),
						colIndex = $colWrap.data('col-index');
				
					$.GoPricing.timeout[colIndex] = setTimeout(function() { $tooltip.removeClass('gw-go-tooltip-visible'); }, 10);
				
				}
				
			},

			/* Mediaelement Player init */
			InitMediaElementPlayer : function () {
				
				if (jQuery().mediaelementplayer && $.GoPricing.$wrap.find('audio, video').length) {	
					$.GoPricing.$wrap.find('audio, video').mediaelementplayer({
						audioWidth: '100%',
						videoWidth: '100%'
					});			
				};	

			},
			
			/* Google map init */
			InitGoogleMap : function () {
				
				if (jQuery().goMap && $.GoPricing.$wrap.find('.gw-go-gmap').length) {
					$.GoPricing.$wrap.find('.gw-go-gmap').each(function(index) {
						var $this=$(this);
						$this.goMap($this.data('map'));
					});
				};
				
			},
			
			/* Equalize rows */
			EqualizeRows : function () {
				
				for (var x = 0; x < $.GoPricing.$wrap.length; x++) {
										
					if ($.GoPricing.$wrap.eq(x).is(':hidden') || $.GoPricing.$wrap.eq(x).offset().top>parseInt($(document).scrollTop()+window.innerHeight+500) || $.GoPricing.$wrap.eq(x).data('eq-ready') === true )  continue; 

					var $pricingTable = $.GoPricing.$wrap.eq(x),
						$colWrap = $pricingTable.find('.gw-go-col-wrap:visible'),
						colCnt = $colWrap.length,
						equalizeCnt = colCnt,
						views = $pricingTable.data('views') !== undefined ? $pricingTable.data('views') : {};
					
					for (var key in views) {						
						
						var mqSizes = [], mq = '';
						if (views[key].min !== undefined && views[key].min !== '') mqSizes.push('(min-width:'+views[key].min+'px)');
						if (views[key].max !== undefined && views[key].max !== '') mqSizes.push('(max-width:'+views[key].max+'px)');
						mq = mqSizes.join(' and ');						
						
						if (mq != '') if (window.matchMedia && window.matchMedia(mq).matches) { 
							
							equalizeCnt = views[key].cols !== undefined && views[key].cols !== '' && views[key].cols <= colCnt ? views[key].cols : colCnt;
						}					
						
					}
								
					if (equalizeCnt == 1) {
						$pricingTable.find('.gw-go-body li .gw-go-body-cell').css('height', 'auto');
						$pricingTable.find('.gw-go-col-wrap').css('height', 'auto');
						$pricingTable.find('.gw-go-footer').css('height', 'auto');
						continue;
						
					}
								
					for (var z = 0; z<colCnt/equalizeCnt; z++) {
						
						if (!$pricingTable.is(':hidden')) $pricingTable.data('eq-ready', true);
	
						var rowHeights = [], footerHeights = [], colHeights = [];
							
						/* Body */
						if ($pricingTable.data('equalize').body != undefined) {
						
							for (var i = 0; i < colCnt; i++) {
								if (i >= (z*equalizeCnt) && i <= (z*equalizeCnt)+equalizeCnt-1) {
									var $currentCol = $colWrap.eq(i),
										$row = $currentCol.find('.gw-go-body li .gw-go-body-cell:visible');
										
									for (var rIndex = 0; rIndex < $row.length; rIndex++) {
										
										var $currentRow = $row.eq(rIndex);
										$currentRow.css('height', 'auto');
										
										if (typeof rowHeights[rIndex] !== 'undefined' ) {
											if ($currentRow.height() > rowHeights[rIndex] ) {
												rowHeights[rIndex] = $currentRow.height();
											}
										} else {
											rowHeights[rIndex] = $currentRow.height();
										}
										
									}
									
								}
							
							}
							
							for (var i = 0; i < colCnt; i++) {
								var $currentCol = $colWrap.eq(i),
									$row = $currentCol.find('.gw-go-body li .gw-go-body-cell:visible');
		
								if (i >= (z*equalizeCnt) && i <= (z*equalizeCnt)+equalizeCnt-1) {
									for (var rIndex = 0; rIndex < $row.length; rIndex++) {								
										var $currentRow = $row.eq(rIndex);
										$currentRow.css('height', rowHeights[rIndex]);
									}							
									
								}
								
							
								
							}
						
						}
						
						/* Footer */
						if ($pricingTable.data('equalize').footer != undefined) {
							
							for (var i = 0; i < colCnt; i++) {
								if (i >= (z*equalizeCnt) && i <= (z*equalizeCnt)+equalizeCnt-1) {
									var $currentCol = $colWrap.eq(i),
										$row = $currentCol.find('.gw-go-footer .gw-go-footer-row-inner:visible');
										
									for (var rIndex = 0; rIndex < $row.length; rIndex++) {
										
										var $currentRow = $row.eq(rIndex);
										$currentRow.css('height', 'auto');
										
										if (typeof footerHeights[rIndex] !== 'undefined' ) {
											if ($currentRow.height() > footerHeights[rIndex] ) {
												footerHeights[rIndex] = $currentRow.height();
											}
										} else {
											footerHeights[rIndex] = $currentRow.height();
										}
										
									}
									
								}
							
							}
							
							for (var i = 0; i < colCnt; i++) {
								var $currentCol = $colWrap.eq(i),
									$row = $currentCol.find('.gw-go-footer .gw-go-footer-row-inner:visible');
		
								if (i >= (z*equalizeCnt) && i <= (z*equalizeCnt)+equalizeCnt-1) {
									for (var rIndex = 0; rIndex < $row.length; rIndex++) {								
										var $currentRow = $row.eq(rIndex);
										$currentRow.css('height', footerHeights[rIndex]);
									}							
									
								}
								
							
								
							}							
													
						}
						
						/* Column */
						if ($pricingTable.data('equalize').column != undefined) {						
						
							for (var i = 0; i < colCnt; i++) {
								var $currentCol = $colWrap.eq(i);
								
								if (i >= (z*equalizeCnt) && i <= (z*equalizeCnt)+equalizeCnt-1) {
									$currentCol.css('height', 'auto');
									if (typeof colHeights[z] !== 'undefined' ) {
										if ($currentCol.outerHeight(true) > colHeights[z] ) {
											colHeights[z] = $currentCol.outerHeight(false);
										}
									} else {
										colHeights[z] = $currentCol.outerHeight(false);
									}
								}
								
							}
							
							for (var i = 0; i < colCnt; i++) {
								var $currentCol = $colWrap.eq(i);
								
								if (i >= (z*equalizeCnt) && i <= (z*equalizeCnt)+equalizeCnt-1) {
									$currentCol.css('height', colHeights[z]);
								}
								
							}
						
						}
						
						
					}
					
				}

			},

			/* Detect event type */
			detectEvent : function() {
				var eventType = 'mouseenter mouseleave';
				if ('ontouchstart' in window) {
					eventType = 'touchstart';
				} else if  (window.navigator.pointerEnabled && navigator.msMaxTouchPoints) {
					eventType = "pointerdown";
				} else if (window.navigator.msPointerEnabled && navigator.msMaxTouchPoints) {
					eventType = "MSPointerDown";
				} 
				return eventType;
			}
		
		};
		
		/* Init */
		$.GoPricing.Init();	
		
		$(window).on('scroll', function() { 
		
			$.GoPricing.EqualizeRows();
		
		});
		
		setTimeout(function() {
			$.GoPricing.EqualizeRows();
		}, 10);				
		
		/* Submit button event if form found */
		$.GoPricing.$wrap.delegate('span.gw-go-btn', 'click', function(){	
			var $this=$(this);
			if ($this.find('form').length) { $this.find('form').submit(); };
		});	
			

		/* Show & hide tooltip - Event on tooltip */
		$.GoPricing.$wrap.on( 'mouseenter mouseleave', '.gw-go-tooltip', function(e) {	

			var $this=$(this),
				$colWrap = $this.closest('.gw-go-col-wrap'),
				colIndex = $colWrap.data('col-index');
			
			if (e.type == 'mouseenter') {
				clearTimeout($.GoPricing.timeout[colIndex]);
			} else {
				$.GoPricing.timeout[colIndex] = setTimeout(function() { $.GoPricing.hideTooltip($this); }, 10);
			}
			
		});
		

		/* Show & hide tooltip - Event on row */
		$.GoPricing.$wrap.on( 'mouseenter mouseleave', 'ul.gw-go-body > li', function(e) {
			
			var $this=$(this);
			
			if (e.type == 'mouseenter') {		
				$.GoPricing.showTooltip($this);
			} else {
				$.GoPricing.hideTooltip($this);
			}
			
		});			


		/* Event handling */
		$('body').on($.GoPricing.eventType, '.gw-go-col-wrap', function(e) {
			var $this = $(this);
			
			if (e.type == 'mouseenter') {
				$this.addClass('gw-go-curr');
			} else if (e.type == 'mouseleave') {
				$this.removeClass('gw-go-curr');
			}
			
			if (e.type == 'mouseenter' && !$this.hasClass('gw-go-disable-hover')) {
				$this.addClass('gw-go-hover').siblings(':not(.gw-go-disable-hover)').removeClass('gw-go-hover');
				$this.closest('.gw-go').addClass('gw-go-hover');
			} else if (e.type == 'mouseleave' && !$this.hasClass('gw-go-disable-hover')) {
				$this.removeClass('gw-go-hover');
				$this.closest('.gw-go').find('[data-current="1"]:not(.gw-go-disable-hover)').addClass('gw-go-hover');
				$this.closest('.gw-go').removeClass('gw-go-hover')
			} else if (!$this.hasClass('gw-go-disable-hover')) {
				$this.closest('.gw-go').addClass('gw-go-hover')
				$this.addClass('gw-go-hover').siblings(':not(.gw-go-disable-hover)').removeClass('gw-go-hover');
			};
			
		});
			

		/**
	 	 * Google map
		 */
			
		if (typeof jQuery.goMap !== 'undefined' && $.GoPricing.$wrap.find('.gw-go-gmap').length) {
			var GoPricing_MapResize=false;
			$(window).on('resize', function(e) {
				if (GoPricing_MapResize) { clearTimeout(GoPricing_MapResize); }
				GoPricing_MapResize = setTimeout(function() {
					$.GoPricing.$wrap.find('.gw-go-gmap').each(function(index, element) {
					  //$(this).goMap();
					  //console.log($.goMap.getMarkers('markers')[0].position);
					});
				}, 400);
			});			
		};
		
	
		/* Equalize heights on resize */
		$(window).on('resize', function(e) { 
			
			for (var x = 0; x < $.GoPricing.$wrap.length; x++) {
				$.GoPricing.$wrap.eq(x).data('eq-ready', false);			
			}
			$.GoPricing.EqualizeRows();
			
		});
		
		/* handle animations */
		$(window).on("scrollEnter scrollLeave", function(e, spy) {
			var $target = $(e.target);
			var repeat = $target.data("anim-repeat") || Infinity;
			if (e.type == "scrollEnter") {
				if (spy.enters <= repeat) $target.data("tl").play();
			} else {
				if (spy.enters < repeat) $target.data("tl").stop().seek(0);
			}
		});				

	});
}(jQuery));	

;(function($, window, undefined) {

	var $elems = $();
	var $cont = $(window)
		.on("resize.tablespy", onResize)
		.on("load.tablespy", onResize)
		.on("scroll.tablespy load.tablespy", onScroll);

	function onScroll() {
		if (!$elems.length) return;
		var height = $cont.height();
		var y = $cont.scrollTop();
		$elems.each(function() {
			var $elem = $(this);
			var o = $elem.data('tablespy');
			var offset = o.rowHeight * o.offset / 100;
			
			if (Math.floor((o.rowHeight+height)/2) < offset) offset = Math.floor((o.rowHeight+height)/2)-20;
			
			if (height + y-offset >= o.min && y+offset <= o.max){
				if (!o.inside) {
					o.inside = true;
					o.enters++;
					$elem.trigger("scrollEnter", {scrollTop: y, enters: o.enters, leaves: o.leaves});
				}
				$elem.trigger("scrollTick", {scrollTop: y, enters: o.enters, leaves: o.leaves});
			}
			if (o.inside && !(height + y >= o.min && y <= o.max)) {
				o.inside = false;
				o.leaves++;
				$elem.trigger("scrollLeave", {scrollTop: y, enters: o.enters, leaves: o.leaves});
			}
		});
	}

	function onResize() {
		$elems.each(function() {
			var $elem = $(this);
			var o = $elem.data("tablespy");
			o.min = $elem.offset().top;
			o.max = $elem.outerHeight() + o.min;
			o.rowHeight = $elem.children(":visible:first").outerHeight();
		});
	}

	$.fn.tablespy = function(options) {
		var defaults = {
			offset: 0,
			enters: 0,
			leaves: 0,
			inside: false
		};
		return this.each(function() {
			var $elem = $(this);
			var top = $elem.offset().top;
			$elem.data("tablespy", $.extend({
				min: top,
				max: top + $elem.outerHeight(),
				rowHeight: $elem.children(":visible:first").outerHeight()
			}, defaults, options));
			$elems.push(this);
		});
	};

})(jQuery, window);