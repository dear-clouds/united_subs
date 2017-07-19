/* 
	prevent dom flickering for elements hidden with js
*/
"use strict"

document.documentElement.className += ' js-active ';
document.documentElement.className += 'ontouchstart' in document.documentElement ? ' kleo-mobile ' : ' kleo-desktop ';

var prefix = ['-webkit-','-o-','-moz-', '-ms-', ""];
for (var i in prefix)
{
	if(prefix[i]+'transform' in document.documentElement.style) document.documentElement.className += " kleo-transform "; 
}
