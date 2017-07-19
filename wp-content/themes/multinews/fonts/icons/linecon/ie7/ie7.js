/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referring to this file must be placed before the ending body tag. */

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'linecon\'">' + entity + '</span>' + html;
	}
	var icons = {
		'linecon-icon-heart': '&#xe600;',
		'linecon-icon-cloud': '&#xe601;',
		'linecon-icon-star': '&#xe602;',
		'linecon-icon-tv': '&#xe603;',
		'linecon-icon-sound': '&#xe604;',
		'linecon-icon-video': '&#xe605;',
		'linecon-icon-trash': '&#xe606;',
		'linecon-icon-user': '&#xe607;',
		'linecon-icon-key': '&#xe608;',
		'linecon-icon-search': '&#xe609;',
		'linecon-icon-settings': '&#xe60a;',
		'linecon-icon-camera': '&#xe60b;',
		'linecon-icon-tag': '&#xe60c;',
		'linecon-icon-lock': '&#xe60d;',
		'linecon-icon-bulb': '&#xe60e;',
		'linecon-icon-pen': '&#xe60f;',
		'linecon-icon-diamond': '&#xe610;',
		'linecon-icon-display': '&#xe611;',
		'linecon-icon-location': '&#xe612;',
		'linecon-icon-eye': '&#xe613;',
		'linecon-icon-bubble': '&#xe614;',
		'linecon-icon-stack': '&#xe615;',
		'linecon-icon-cup': '&#xe616;',
		'linecon-icon-phone': '&#xe617;',
		'linecon-icon-news': '&#xe618;',
		'linecon-icon-mail': '&#xe619;',
		'linecon-icon-like': '&#xe61a;',
		'linecon-icon-photo': '&#xe61b;',
		'linecon-icon-note': '&#xe61c;',
		'linecon-icon-clock': '&#xe61d;',
		'linecon-icon-paperplane': '&#xe61e;',
		'linecon-icon-params': '&#xe61f;',
		'linecon-icon-banknote': '&#xe620;',
		'linecon-icon-data': '&#xe621;',
		'linecon-icon-music': '&#xe622;',
		'linecon-icon-megaphone': '&#xe623;',
		'linecon-icon-study': '&#xe624;',
		'linecon-icon-lab': '&#xe625;',
		'linecon-icon-food': '&#xe626;',
		'linecon-icon-t-shirt': '&#xe627;',
		'linecon-icon-fire': '&#xe628;',
		'linecon-icon-clip': '&#xe629;',
		'linecon-icon-shop': '&#xe62a;',
		'linecon-icon-calendar': '&#xe62b;',
		'linecon-icon-wallet': '&#xe62c;',
		'linecon-icon-vynil': '&#xe62d;',
		'linecon-icon-truck': '&#xe62e;',
		'linecon-icon-world': '&#xe62f;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, attr, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/linecon-icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
