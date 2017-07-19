/**
 * Javascript logic
 *
 * SCRIPTS
 * SHORTCODES
 * THEME LOGIC
 */



/*--------------------------------------------------

 LOADING SCRIPTS
 ---------------------------------------------------*/

/* matchmedia*/
window.matchMedia=window.matchMedia||function(a){"use strict";var c,d=a.documentElement,e=d.firstElementChild||d.firstChild,f=a.createElement("body"),g=a.createElement("div");return g.id="mq-test-1",g.style.cssText="position:absolute;top:-100em",f.style.background="none",f.appendChild(g),function(a){return g.innerHTML='&shy;<style media="'+a+'"> #mq-test-1 { width: 42px; }</style>',d.insertBefore(f,e),c=42===g.offsetWidth,d.removeChild(f),{matches:c,media:a}}}(document);



/* Respond.js v1.1.0: min/max-width media query polyfill. (c) Scott Jehl. MIT/GPLv2 Lic. j.mp/respondjs  */
(function(a){"use strict";function x(){u(!0)}var b={};if(a.respond=b,b.update=function(){},b.mediaQueriesSupported=a.matchMedia&&a.matchMedia("only all").matches,!b.mediaQueriesSupported){var q,r,t,c=a.document,d=c.documentElement,e=[],f=[],g=[],h={},i=30,j=c.getElementsByTagName("head")[0]||d,k=c.getElementsByTagName("base")[0],l=j.getElementsByTagName("link"),m=[],n=function(){for(var b=0;l.length>b;b++){var c=l[b],d=c.href,e=c.media,f=c.rel&&"stylesheet"===c.rel.toLowerCase();d&&f&&!h[d]&&(c.styleSheet&&c.styleSheet.rawCssText?(p(c.styleSheet.rawCssText,d,e),h[d]=!0):(!/^([a-zA-Z:]*\/\/)/.test(d)&&!k||d.replace(RegExp.$1,"").split("/")[0]===a.location.host)&&m.push({href:d,media:e}))}o()},o=function(){if(m.length){var b=m.shift();v(b.href,function(c){p(c,b.href,b.media),h[b.href]=!0,a.setTimeout(function(){o()},0)})}},p=function(a,b,c){var d=a.match(/@media[^\{]+\{([^\{\}]*\{[^\}\{]*\})+/gi),g=d&&d.length||0;b=b.substring(0,b.lastIndexOf("/"));var h=function(a){return a.replace(/(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g,"$1"+b+"$2$3")},i=!g&&c;b.length&&(b+="/"),i&&(g=1);for(var j=0;g>j;j++){var k,l,m,n;i?(k=c,f.push(h(a))):(k=d[j].match(/@media *([^\{]+)\{([\S\s]+?)$/)&&RegExp.$1,f.push(RegExp.$2&&h(RegExp.$2))),m=k.split(","),n=m.length;for(var o=0;n>o;o++)l=m[o],e.push({media:l.split("(")[0].match(/(only\s+)?([a-zA-Z]+)\s?/)&&RegExp.$2||"all",rules:f.length-1,hasquery:l.indexOf("(")>-1,minw:l.match(/\(\s*min\-width\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/)&&parseFloat(RegExp.$1)+(RegExp.$2||""),maxw:l.match(/\(\s*max\-width\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/)&&parseFloat(RegExp.$1)+(RegExp.$2||"")})}u()},s=function(){var a,b=c.createElement("div"),e=c.body,f=!1;return b.style.cssText="position:absolute;font-size:1em;width:1em",e||(e=f=c.createElement("body"),e.style.background="none"),e.appendChild(b),d.insertBefore(e,d.firstChild),a=b.offsetWidth,f?d.removeChild(e):e.removeChild(b),a=t=parseFloat(a)},u=function(b){var h="clientWidth",k=d[h],m="CSS1Compat"===c.compatMode&&k||c.body[h]||k,n={},o=l[l.length-1],p=(new Date).getTime();if(b&&q&&i>p-q)return a.clearTimeout(r),r=a.setTimeout(u,i),void 0;q=p;for(var v in e)if(e.hasOwnProperty(v)){var w=e[v],x=w.minw,y=w.maxw,z=null===x,A=null===y,B="em";x&&(x=parseFloat(x)*(x.indexOf(B)>-1?t||s():1)),y&&(y=parseFloat(y)*(y.indexOf(B)>-1?t||s():1)),w.hasquery&&(z&&A||!(z||m>=x)||!(A||y>=m))||(n[w.media]||(n[w.media]=[]),n[w.media].push(f[w.rules]))}for(var C in g)g.hasOwnProperty(C)&&g[C]&&g[C].parentNode===j&&j.removeChild(g[C]);for(var D in n)if(n.hasOwnProperty(D)){var E=c.createElement("style"),F=n[D].join("\n");E.type="text/css",E.media=D,j.insertBefore(E,o.nextSibling),E.styleSheet?E.styleSheet.cssText=F:E.appendChild(c.createTextNode(F)),g.push(E)}},v=function(a,b){var c=w();c&&(c.open("GET",a,!0),c.onreadystatechange=function(){4!==c.readyState||200!==c.status&&304!==c.status||b(c.responseText)},4!==c.readyState&&c.send(null))},w=function(){var b=!1;try{b=new a.XMLHttpRequest}catch(c){b=new a.ActiveXObject("Microsoft.XMLHTTP")}return function(){return b}}();n(),b.update=n,a.addEventListener?a.addEventListener("resize",x,!1):a.attachEvent&&a.attachEvent("onresize",x)}})(this);



/*
 * Project: Twitter Bootstrap Hover Dropdown
 * Author: Cameron Spear
 * Contributors: Mattia Larentis
 * Dependencies: Twitter Bootstrap's Dropdown plugin
 * A simple plugin to enable twitter bootstrap dropdowns to active on hover and provide a nice user experience.
 * No license, do what you want. I'd love credit or a shoutout, though.
 * http://cameronspear.com/blog/twitter-bootstrap-dropdown-on-hover-plugin/
 */
(function(b,a,c){var d=b();b.fn.dropdownHover=function(e){d=d.add(this.parent());return this.each(function(){var k=b(this),j=k.parent(),i={delay:200,instantlyCloseOthers:true},h={delay:b(this).data("delay"),instantlyCloseOthers:b(this).data("close-others")},f=b.extend(true,{},i,e,h),g;j.hover(function(l){if(!j.hasClass("open")&&!k.is(l.target)){return true}if(f.instantlyCloseOthers===true){d.removeClass("open")}a.clearTimeout(g);j.addClass("open")},function(){g=a.setTimeout(function(){j.removeClass("open")},f.delay)});k.hover(function(){if(f.instantlyCloseOthers===true){d.removeClass("open")}a.clearTimeout(g);j.addClass("open")});j.find(".dropdown-submenu").each(function(){var m=b(this);var l;m.hover(function(){a.clearTimeout(l);m.children(".dropdown-menu").show();m.siblings().children(".dropdown-menu").hide()},function(){var n=m.children(".dropdown-menu");l=a.setTimeout(function(){n.hide()},f.delay)})})})};})(jQuery,this);



/* =========================================================
 * bootstrap-tabdrop.js
 * http://www.eyecon.ro/bootstrap-tabdrop
 * =========================================================
 * Copyright 2012 Stefan Petre
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

!function(c){var b=(function(){var h=[];var d=false;var g;var e=function(i){clearTimeout(g);g=setTimeout(f,100)};var f=function(){for(var k=0,j=h.length;k<j;k++){h[k].apply()}};return{register:function(i){h.push(i);if(d===false){c(window).bind("resize",e);d=true}},unregister:function(l){for(var k=0,j=h.length;k<j;k++){if(h[k]==l){delete h[k];break}}}}}());var a=function(e,d){this.element=c(e);this.dropdown=c('<li class="dropdown hide pull-right tabdrop"><a class="dropdown-toggle" data-toggle="dropdown" href="#">'+d.text+'</a><ul class="dropdown-menu"></ul></li>').prependTo(this.element);if(this.element.parent().is(".tabs-below")){this.dropdown.addClass("dropup")}b.register(c.proxy(this.layout,this));this.layout()};a.prototype={constructor:a,layout:function(){var d=[];this.dropdown.removeClass("hide");this.element.append(this.dropdown.find("li")).find(">li").not(".tabdrop").each(function(){if(this.offsetTop>0){d.push(this)}});if(d.length>0){d=c(d);this.dropdown.find("ul").empty().append(d);if(this.dropdown.find(".active").length==1){this.dropdown.addClass("active")}else{this.dropdown.removeClass("active")}}else{this.dropdown.addClass("hide")}}};c.fn.tabdrop=function(d){return this.each(function(){var g=c(this),f=g.data("tabdrop"),e=typeof d==="object"&&d;if(!f){g.data("tabdrop",(f=new a(this,c.extend({},c.fn.tabdrop.defaults,e))))}if(typeof d=="string"){f[d]()}})};c.fn.tabdrop.defaults={text:"&nbsp;"};c.fn.tabdrop.Constructor=a}(window.jQuery);



/* ======================= Sticky Plugin =============================== */
// // // Sticky Plugin v1.0.0 for jQuery
// =============
// Author: Anthony Garand
// Improvements by German M. Bravo (Kronuz) and Ruud Kamphuis (ruudk)
// Improvements by Leonardo C. Daronco (daronco)
// Created: 2/14/2011
// Date: 2/12/2012
// Website: http://labs.anthonygarand.com/sticky
// Description: Makes an element on the page stick on the screen as you scroll
//       It will only set the 'top' and 'position' of your element, you
//       might need to adjust the width in some cases.
(function(f){var e={topSpacing:0,bottomSpacing:0,className:"is-sticky",wrapperClassName:"sticky-wrapper",center:false,getWidthFrom:""},b=f(window),d=f(document),i=[],a=b.height(),g=function(){var j=b.scrollTop(),q=d.height(),p=q-a,l=(j>p)?p-j:0;for(var m=0;m<i.length;m++){var r=i[m],k=r.stickyWrapper.offset().top,n=k-r.topSpacing-l;if(j<=n){if(r.currentTop!==null){r.stickyElement.css("position","").css("top","");r.stickyElement.parent().removeClass(r.className);r.currentTop=null}}else{var o=q-r.stickyElement.outerHeight()-r.topSpacing-r.bottomSpacing-j-l;if(o<0){o=o+r.topSpacing}else{o=r.topSpacing}if(r.currentTop!=o){r.stickyElement.css("position","fixed").css("top",o);if(typeof r.getWidthFrom!=="undefined"){r.stickyElement.css("width",f(r.getWidthFrom).width())}r.stickyElement.parent().addClass(r.className);r.currentTop=o}}}},h=function(){a=b.height()},c={init:function(j){var k=f.extend(e,j);return this.each(function(){var l=f(this);var m=l.attr("id");var o=f("<div></div>").attr("id",m+"-sticky-wrapper").addClass(k.wrapperClassName);l.wrapAll(o);if(k.center){l.parent().css({width:l.outerWidth(),marginLeft:"auto",marginRight:"auto"})}if(l.css("float")=="right"){l.css({"float":"none"}).parent().css({"float":"right"})}var n=l.parent();n.css("height",l.outerHeight());i.push({topSpacing:k.topSpacing,bottomSpacing:k.bottomSpacing,stickyElement:l,currentTop:null,stickyWrapper:n,className:k.className,getWidthFrom:k.getWidthFrom})})},update:g};if(window.addEventListener){window.addEventListener("scroll",g,false);window.addEventListener("resize",h,false)}else{if(window.attachEvent){window.attachEvent("onscroll",g);window.attachEvent("onresize",h)}}f.fn.sticky=function(j){if(c[j]){return c[j].apply(this,Array.prototype.slice.call(arguments,1))}else{if(typeof j==="object"||!j){return c.init.apply(this,arguments)}else{f.error("Method "+j+" does not exist on jQuery.sticky")}}};f(function(){setTimeout(g,0)})})(jQuery);



/* ======================= fitVids Plugin =============================== */
/**
 * FitVids 1.0.3
 *
 * Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 */
(function(a){a.fn.fitVids=function(b){var c={customSelector:null};if(!document.getElementById("fit-vids-style")){var f=document.createElement("div"),d=document.getElementsByTagName("base")[0]||document.getElementsByTagName("script")[0],e="&shy;<style>.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style>";f.className="fit-vids-style";f.id="fit-vids-style";f.style.display="none";f.innerHTML=e;d.parentNode.insertBefore(f,d)}if(b){a.extend(c,b)}return this.each(function(){var g=["iframe[src*='player.vimeo.com']","iframe[src*='youtube.com']","iframe[src*='youtube-nocookie.com']","iframe[src*='kickstarter.com'][src*='video.html']","iframe[src*='embed.spotify.com']","object","embed:not(.mejs-shim)"];if(c.customSelector){g.push(c.customSelector)}var h=a(this).find(g.join(","));h=h.not("object object");h.each(function(){var m=a(this);if(this.tagName.toLowerCase()==="embed"&&m.parent("object").length||m.parent(".fluid-width-video-wrapper").length){return}var i=(this.tagName.toLowerCase()==="object"||(m.attr("height")&&!isNaN(parseInt(m.attr("height"),10))))?parseInt(m.attr("height"),10):m.height(),j=!isNaN(parseInt(m.attr("width"),10))?parseInt(m.attr("width"),10):m.width(),k=i/j;if(!m.attr("id")){var l="fitvid"+Math.floor(Math.random()*999999);m.attr("id",l)}m.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",(k*100)+"%");m.removeAttr("height").removeAttr("width")})})}})(window.jQuery);



/* ======================= jQuery Easing Plugin =============================== */
/* jQuery Easing Plugin, v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/ */
jQuery.easing.jswing=jQuery.easing.swing;jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,f,a,h,g){return jQuery.easing[jQuery.easing.def](e,f,a,h,g)},easeInQuad:function(e,f,a,h,g){return h*(f/=g)*f+a},easeOutQuad:function(e,f,a,h,g){return -h*(f/=g)*(f-2)+a},easeInOutQuad:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f+a}return -h/2*((--f)*(f-2)-1)+a},easeInCubic:function(e,f,a,h,g){return h*(f/=g)*f*f+a},easeOutCubic:function(e,f,a,h,g){return h*((f=f/g-1)*f*f+1)+a},easeInOutCubic:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f+a}return h/2*((f-=2)*f*f+2)+a},easeInQuart:function(e,f,a,h,g){return h*(f/=g)*f*f*f+a},easeOutQuart:function(e,f,a,h,g){return -h*((f=f/g-1)*f*f*f-1)+a},easeInOutQuart:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f*f+a}return -h/2*((f-=2)*f*f*f-2)+a},easeInQuint:function(e,f,a,h,g){return h*(f/=g)*f*f*f*f+a},easeOutQuint:function(e,f,a,h,g){return h*((f=f/g-1)*f*f*f*f+1)+a},easeInOutQuint:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f*f*f+a}return h/2*((f-=2)*f*f*f*f+2)+a},easeInSine:function(e,f,a,h,g){return -h*Math.cos(f/g*(Math.PI/2))+h+a},easeOutSine:function(e,f,a,h,g){return h*Math.sin(f/g*(Math.PI/2))+a},easeInOutSine:function(e,f,a,h,g){return -h/2*(Math.cos(Math.PI*f/g)-1)+a},easeInExpo:function(e,f,a,h,g){return(f==0)?a:h*Math.pow(2,10*(f/g-1))+a},easeOutExpo:function(e,f,a,h,g){return(f==g)?a+h:h*(-Math.pow(2,-10*f/g)+1)+a},easeInOutExpo:function(e,f,a,h,g){if(f==0){return a}if(f==g){return a+h}if((f/=g/2)<1){return h/2*Math.pow(2,10*(f-1))+a}return h/2*(-Math.pow(2,-10*--f)+2)+a},easeInCirc:function(e,f,a,h,g){return -h*(Math.sqrt(1-(f/=g)*f)-1)+a},easeOutCirc:function(e,f,a,h,g){return h*Math.sqrt(1-(f=f/g-1)*f)+a},easeInOutCirc:function(e,f,a,h,g){if((f/=g/2)<1){return -h/2*(Math.sqrt(1-f*f)-1)+a}return h/2*(Math.sqrt(1-(f-=2)*f)+1)+a},easeInElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k)==1){return e+l}if(!j){j=k*0.3}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}return -(g*Math.pow(2,10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j))+e},easeOutElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k)==1){return e+l}if(!j){j=k*0.3}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}return g*Math.pow(2,-10*h)*Math.sin((h*k-i)*(2*Math.PI)/j)+l+e},easeInOutElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k/2)==2){return e+l}if(!j){j=k*(0.3*1.5)}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}if(h<1){return -0.5*(g*Math.pow(2,10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j))+e}return g*Math.pow(2,-10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j)*0.5+l+e},easeInBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*(f/=h)*f*((g+1)*f-g)+a},easeOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*((f=f/h-1)*f*((g+1)*f+g)+1)+a},easeInOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}if((f/=h/2)<1){return i/2*(f*f*(((g*=(1.525))+1)*f-g))+a}return i/2*((f-=2)*f*(((g*=(1.525))+1)*f+g)+2)+a},easeInBounce:function(e,f,a,h,g){return h-jQuery.easing.easeOutBounce(e,g-f,0,h,g)+a},easeOutBounce:function(e,f,a,h,g){if((f/=g)<(1/2.75)){return h*(7.5625*f*f)+a}else{if(f<(2/2.75)){return h*(7.5625*(f-=(1.5/2.75))*f+0.75)+a}else{if(f<(2.5/2.75)){return h*(7.5625*(f-=(2.25/2.75))*f+0.9375)+a}else{return h*(7.5625*(f-=(2.625/2.75))*f+0.984375)+a}}}},easeInOutBounce:function(e,f,a,h,g){if(f<g/2){return jQuery.easing.easeInBounce(e,f*2,0,h,g)*0.5+a}return jQuery.easing.easeOutBounce(e,f*2-g,0,h,g)*0.5+h*0.5+a}});



/* ======================= debouncedresize Plugin =============================== */
/*
 * debouncedresize: special jQuery event that happens once after a window resize
 *
 * latest version and complete README available on Github:
 * https://github.com/louisremi/jquery-smartresize/blob/master/jquery.debouncedresize.js
 *
 * Copyright 2011 @louis_remi
 * Licensed under the MIT license.
 */
(function(d){var b=d.event,a,c;a=b.special.debouncedresize={setup:function(){d(this).on("resize",a.handler)},teardown:function(){d(this).off("resize",a.handler)},handler:function(i,e){var h=this,g=arguments,f=function(){i.type="debouncedresize";b.dispatch.apply(h,g)};if(c){clearTimeout(c)}e?f():c=setTimeout(f,a.threshold)},threshold:150}})(jQuery);



/* ======================= imagesLoaded Plugin =============================== */
/**
 * imagesLoaded PACKAGED v3.1.8
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */

(function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("wolfy87-eventemitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function f(e){this.img=e}function c(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var f=r[o];this.addImage(f)}}},s.prototype.addImage=function(e){var t=new f(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),f.prototype=new t,f.prototype.check=function(){var e=v[this.img.src]||new c(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},f.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return c.prototype=new t,c.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},c.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});


/* ======================= imgpreload Plugin =============================== */
/**
 * jquery.imgpreload 1.6.2 <https://github.com/farinspace/jquery.imgpreload>
 * Copyright 2009-2014 Dimas Begunoff <http://farinspace.com>
 * License MIT <http://opensource.org/licenses/MIT>
 */
"undefined"!=typeof jQuery&&!function(a){"use strict";a.imgpreload=function(b,c){c=a.extend({},a.fn.imgpreload.defaults,c instanceof Function?{all:c}:c),"string"==typeof b&&(b=[b]);var d=[];a.each(b,function(e,f){var g=new Image,h=f,i=g;"string"!=typeof f&&(h=a(f).attr("src")||a(f).css("background-image").replace(/^url\((?:"|')?(.*)(?:'|")?\)$/gm,"$1"),i=f),a(g).bind("load error",function(e){d.push(i),a.data(i,"loaded","error"==e.type?!1:!0),c.each instanceof Function&&c.each.call(i,d.slice(0)),d.length>=b.length&&c.all instanceof Function&&c.all.call(d),a(this).unbind("load error")}),g.src=h})},a.fn.imgpreload=function(b){return a.imgpreload(this,b),this},a.fn.imgpreload.defaults={each:null,all:null}}(jQuery);


/**
 * Variations Plugin
 */(function(e,t,n,r){e.fn.wc_variation_form=function(){e.fn.wc_variation_form.find_matching_variations=function(t,n){var r=[];for(var i=0;i<t.length;i++){var s=t[i],o=s.variation_id;e.fn.wc_variation_form.variations_match(s.attributes,n)&&r.push(s)}return r};e.fn.wc_variation_form.variations_match=function(e,t){var n=!0;for(attr_name in e){var i=e[attr_name],s=t[attr_name];i!==r&&s!==r&&i.length!=0&&s.length!=0&&i!=s&&(n=!1)}return n};this.unbind("check_variations update_variation_values found_variation");this.find(".reset_variations").unbind("click");this.find(".variations select").unbind("change focusin");$form=this.on("click",".reset_variations",function(t){e(this).closest(".variations_form").find(".variations select").val("").change();var n=e(this).closest(".product").find(".sku"),r=e(this).closest(".product").find(".product_weight"),i=e(this).closest(".product").find(".product_dimensions");n.attr("data-o_sku")&&n.text(n.attr("data-o_sku"));r.attr("data-o_weight")&&r.text(r.attr("data-o_weight"));i.attr("data-o_dimensions")&&i.text(i.attr("data-o_dimensions"));return!1}).on("change",".variations select",function(t){$variation_form=e(this).closest(".variations_form");$variation_form.find("input[name=variation_id]").val("").change();$variation_form.trigger("woocommerce_variation_select_change").trigger("check_variations",["",!1]);e(this).blur();e().uniform&&e.isFunction(e.uniform.update)&&e.uniform.update()}).on("focusin touchstart",".variations select",function(t){$variation_form=e(this).closest(".variations_form");$variation_form.trigger("woocommerce_variation_select_focusin").trigger("check_variations",[e(this).attr("name"),!0])}).on("check_variations",function(n,r,i){var s=!0,o=!1,u=!1,a={},f=e(this),l=f.find(".reset_variations");f.find(".variations select").each(function(){e(this).val().length==0?s=!1:o=!0;if(r&&e(this).attr("name")==r){s=!1;a[e(this).attr("name")]=""}else{value=e(this).val();a[e(this).attr("name")]=value}});var c=parseInt(f.data("product_id")),h=f.data("product_variations");h||(h=t.product_variations[c]);h||(h=t.product_variations);h||(h=t["product_variations_"+c]);var p=e.fn.wc_variation_form.find_matching_variations(h,a);if(s){var d=p.shift();if(d){f.find("input[name=variation_id]").val(d.variation_id).change();f.trigger("found_variation",[d])}else{f.find(".variations select").val("");i||f.trigger("reset_image");alert(woocommerce_params.i18n_no_matching_variations_text)}}else{f.trigger("update_variation_values",[p]);i||f.trigger("reset_image");r||f.find(".single_variation_wrap").slideUp("200")}o?l.css("visibility")=="hidden"&&l.css("visibility","visible").hide().fadeIn():l.css("visibility","hidden")}).on("reset_image",function(t){var n=e(this).closest(".product"),i=n.find("div.images img:eq(0)"),s=n.find("div.images a.zoom:eq(0)"),o=i.attr("data-o_src"),u=i.attr("data-o_title"),a=i.attr("data-o_alt"),f=s.attr("data-o_href");o!=r&&i.attr("src",o);f!=r&&s.attr("href",f);if(u!=r){i.attr("title",u);s.attr("title",u)}a!=r&&i.attr("alt",a)}).on("update_variation_values",function(t,n){$variation_form=e(this).closest(".variations_form");$variation_form.find(".variations select").each(function(t,r){current_attr_select=e(r);current_attr_select.data("attribute_options")||current_attr_select.data("attribute_options",current_attr_select.find("option:gt(0)").get());current_attr_select.find("option:gt(0)").remove();current_attr_select.append(current_attr_select.data("attribute_options"));current_attr_select.find("option:gt(0)").removeClass("active");var i=current_attr_select.attr("name");for(num in n)if(typeof n[num]!="undefined"){var s=n[num].attributes;for(attr_name in s){var o=s[attr_name];if(attr_name==i)if(o){o=e("<div/>").html(o).text();o=o.replace(/'/g,"\\'");o=o.replace(/"/g,'\\"');current_attr_select.find('option[value="'+o+'"]').addClass("active")}else current_attr_select.find("option:gt(0)").addClass("active")}}current_attr_select.find("option:gt(0):not(.active)").remove()});$variation_form.trigger("woocommerce_update_variation_values")}).on("found_variation",function(t,n){var i=e(this),s=e(this).closest(".product"),o=s.find("div.images img:eq(0)"),u=s.find("div.images a.zoom:eq(0)"),a=o.attr("data-o_src"),f=o.attr("data-o_title"),l=o.attr("data-o_alt"),c=u.attr("data-o_href"),h=n.image_src,p=n.image_link,d=n.image_title,v=n.image_alt;i.find(".variations_button").show();i.find(".single_variation").html(n.price_html+n.availability_html);if(a==r){a=o.attr("src")?o.attr("src"):"";o.attr("data-o_src",a)}if(c==r){c=u.attr("href")?u.attr("href"):"";u.attr("data-o_href",c)}if(f==r){f=o.attr("title")?o.attr("title"):"";o.attr("data-o_title",f)}if(l==r){l=o.attr("alt")?o.attr("alt"):"";o.attr("data-o_alt",l)}if(h&&h.length>1){o.attr("src",h).attr("alt",v).attr("title",d);u.attr("href",p).attr("title",d)}else{o.attr("src",a).attr("alt",l).attr("title",f);u.attr("href",c).attr("title",f)}var m=i.find(".single_variation_wrap"),g=s.find(".product_meta").find(".sku"),y=s.find(".product_weight"),b=s.find(".product_dimensions");g.attr("data-o_sku")||g.attr("data-o_sku",g.text());y.attr("data-o_weight")||y.attr("data-o_weight",y.text());b.attr("data-o_dimensions")||b.attr("data-o_dimensions",b.text());n.sku?g.text(n.sku):g.text(g.attr("data-o_sku"));n.weight?y.text(n.weight):y.text(y.attr("data-o_weight"));n.dimensions?b.text(n.dimensions):b.text(b.attr("data-o_dimensions"));m.find(".quantity").show();!n.is_in_stock&&!n.backorders_allowed&&i.find(".variations_button").hide();n.min_qty?m.find("input[name=quantity]").attr("min",n.min_qty).val(n.min_qty):m.find("input[name=quantity]").removeAttr("min");n.max_qty?m.find("input[name=quantity]").attr("max",n.max_qty):m.find("input[name=quantity]").removeAttr("max");if(n.is_sold_individually=="yes"){m.find("input[name=quantity]").val("1");m.find(".quantity").hide()}m.slideDown("200").trigger("show_variation",[n])});$form.trigger("wc_variation_form");return $form};e(function(){e(".variations_form").wc_variation_form();e(".variations_form .variations select").change()})})(jQuery,window,document);



/*--------------------------------------------------

 SHORTCODES

 Animations
 Shortcodes
 ---------------------------------------------------*/


function activate_waypoints(container)
{
    //activates simple css animations of the content once the user scrolls to an elements
    if(jQuery.fn.kleo_waypoints)
    {
        if(typeof container == 'undefined'){ container = 'body';};

        jQuery('.animate-when-visible', container).kleo_waypoints();
        jQuery('.animate-when-almost-visible', container).kleo_waypoints({ offset: '90%'});
    }
}


function activate_shortcode_scripts(container)
{
    if(typeof container == 'undefined'){ container = 'body';};

//activates behavior and animation for gallery
    if(jQuery.fn.kleo_sc_gallery)
    {
        jQuery('.kleo-gallery', container).kleo_sc_gallery();
    }

//activates behavior and animation for one by one general
    if(jQuery.fn.kleo_general_onebyone)
    {
        jQuery('.one-by-one-general', container).kleo_general_onebyone();
    }

    if(jQuery.fn.kleo_animate_number)
    {
        jQuery('.kleo-animate-number', container).kleo_animate_number();
    }

//activates animation for elements
    if(jQuery.fn.one_by_one_animated)
    {
        jQuery('.one-by-one-animated', container).one_by_one_animated();
    }

//activates animation for progress bar
    if(jQuery.fn.kleo_sc_progressbar)
    {
        jQuery('.progress-bar-container', container).kleo_sc_progressbar();
    }

//activates animation for testimonial
    if(jQuery.fn.kleo_sc_testimonial)
    {
        jQuery('.kleo-testimonial-wrapper', container).kleo_sc_testimonial();
    }

}


(function($){

    "use strict";

// -------------------------------------------------------------------------------------------
// testimonial shortcode javascript
// -------------------------------------------------------------------------------------------

    $.fn.kleo_sc_testimonial = function(options)
    {
        return this.each(function()
        {
            var container = $(this), elements = container.find('.kleo-testimonial');


            //trigger displaying of thumbnails
            container.on('kleo-start-animation', function()
            {
                elements.each(function(i)
                {
                    var element = $(this);
                    setTimeout(function(){ element.addClass('kleo-start-animation') }, (i * 150));
                });
            });
        });
    }



// -------------------------------------------------------------------------------------------
// Progress bar shortcode javascript
// -------------------------------------------------------------------------------------------

    $.fn.kleo_sc_progressbar = function(options)
    {
        return this.each(function()
        {
            var container = $(this), elements = container.find('.progress');


            //trigger displaying of thumbnails
            container.on('start-animation', function()
            {
                elements.each(function(i)
                {
                    var element = $(this);
                    setTimeout(function(){
                        $('.bar strong').css('opacity', 1);
                        //$('.bar strong').css('left', -30 + 'px');
                        element.addClass('start-animation') }, (i * 250));
                });
            });
        });
    }



// -------------------------------------------------------------------------------------------
// Iconlist shortcode javascript
// -------------------------------------------------------------------------------------------

    $.fn.one_by_one_animated = function(options)
    {
        return this.each(function()
        {
            var listicons = $(this), elements = listicons.find('.list-el-animated');

            listicons.on('start-animation', function()
            {
                elements.each(function(i)
                {
                    var element = $(this);
                    setTimeout(function(){ element.addClass('start-animation') }, (i * 350));
                });
            });
        });
    }


// -------------------------------------------------------------------------------------------
// Big Number animation shortcode javascript
// -------------------------------------------------------------------------------------------

//http://codetheory.in/controlling-the-frame-rate-with-requestanimationframe/ (improve it with framerate in the future?)

    $.fn.kleo_animate_number = function(options)
    {
        var start_count = function(element, countTo, increment, current)
        {

            //calculate the new number
            var newCount = current + increment;

            //if the number is bigger than our final number set the number and finish
            if(newCount >= countTo)
            {
                element.text(countTo);
                //exit
            }
            else
            {
                var prepend = "", addZeros = countTo.toString().length - newCount.toString().length

                //if the number has less digits than the final number some zeros where omitted. add them to the front
                for(var i = addZeros; i > 0; i--){ prepend += "0"; }

                element.text(prepend + newCount);
                window.kleoAnimFrame(function(){ start_count(element, countTo, increment, newCount) });
            }
        };

        $(this).each(function(i)
        {
            //prepare elements
            var element = $(this), text = element.text();
            element.text( text.replace(/./g, "0"));

            var countTimer = element.data('timer') || 3000;

            //trigger number animation
            element.addClass('number_prepared').on('start-animation', function()
            {
                var element = $(this), countTo = element.data('number'), current = parseInt(element.text(),10), increment = Math.round( countTo * 30 / countTimer);
                if(increment == 0 || increment % 10 == 0) increment += 1;

                setTimeout(function(){ start_count(element, countTo, increment, current);}, 300);
            });

        });

    }

    window.kleoAnimFrame = (function(){
        return  window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function( callback ){ window.setTimeout(callback, 1000 / 60); };
    })();



// -------------------------------------------------------------------------------------------
// Gallery shortcode javascript
// -------------------------------------------------------------------------------------------

    $.fn.kleo_sc_gallery = function(options)
    {
        return this.each(function()
        {
            var gallery = $(this), images = gallery.find('img'), big_prev = gallery.find('.kleo-gallery-big');


            //trigger displaying of thumbnails
            gallery.on('start-animation', function()
            {
                images.each(function(i)
                {
                    var image = $(this);
                    setTimeout(function(){ image.addClass('start-animation') }, (i * 150));
                    //alert('test');
                });
            });




        });
    }


// -------------------------------------------------------------------------------------------
// One by one general shortcode javascript
// -------------------------------------------------------------------------------------------

    $.fn.kleo_general_onebyone = function(options)
    {
        return this.each(function()
        {
            var container = $(this), items = container.children();

            //trigger displaying of items
            container.on('start-animation', function()
            {
                items.each(function(i)
                {
                    var item = $(this);
                    setTimeout(function(){ item.addClass('start-animation') }, (i * 150));
                });
            });
        });
    }



// -------------------------------------------------------------------------------------------
// HELPER FUNCTIONS
// -------------------------------------------------------------------------------------------


//waipoint script when something comes into viewport
    $.fn.kleo_waypoints = function(options_passed)
    {
        if(! $('html').is('.kleo-transform')) return;

        var defaults = { offset: 'bottom-in-view' , triggerOnce: true},
            options  = $.extend({}, defaults, options_passed);

        return this.each(function()
        {
            var element = $(this);

            setTimeout(function()
            {
                element.waypoint(function(direction)
                {
                    $(this).addClass('start-animation').trigger('start-animation');

                }, options );

            },100)
        });
    };

})( jQuery );



/*--------------------------------------------------

THEME LOGIC

Page scripts
Header scripts
Isotope scripts
---------------------------------------------------*/

(function($){
	
"use strict";

/***************************************************
 Site functions
***************************************************/
var kleoPage = {
	
	init: function() {
			
		//remove overflow hidden
		kleoPage.removeOverflowHidden();
		
		//image sliders
        if( $.fn.carouFredSel ) {
            kleoPage.carouselItems();
            kleoPage.bannerSlider();
            kleoPage.rtMediaslider();
            kleoPage.newsTicker();
            $(document).on('click', '.news-focus .nav-tabs a', function(){
                kleoPage.bannerSlider();
            });
        }

		//activate magnificPopup
        if( $.fn.magnificPopup ) {
            kleoPage.magnificPopupModals();
            if(! kleoFramework.hasOwnProperty('DisableMagnificGallery') || kleoFramework.DisableMagnificGallery === '0') {
                kleoPage.magnificPopupGallery();
            }
        }

		//activate html5 video/audio player
		if($.fn.kleo_enable_media && $.fn.mediaelementplayer) {
			$(".kleo-video, .kleo-audio, .video-wrap video", "body").kleo_enable_media();
		}
	
		//initialize Pins
		kleoPage.initPins();
		
		if(kleoFramework.goTop == 1) {
			kleoPage.goTop();
		}

		kleoPage.likes();
        kleoPage.progressBar();
        kleoPage.kleoAjaxLogin();
        kleoPage.kleoAjaxLostPass();
		
		//Fit videos
		$(".post-content, .activity-inner, .article-media, .kleo-video-embed, .wpb_video_widget").fitVids();

		// Sidebar menu toggle
		//if (!isMobile || kleoIsotope.viewport().width > 992) {
			kleoPage.kleoMenuWidget();
		//}

		//Accordion/toggle icons
		$('.panel-collapse').on('show.bs.collapse', function () {
			$(".panel-heading a[href='#"+$(this).attr('id')+"'] span.icon-opened").removeClass("hide");
			$(".panel-heading a[href='#"+$(this).attr('id')+"'] span.icon-closed").addClass("hide");
		});
		$('.panel-collapse').on('hide.bs.collapse', function () {
			$(".panel-heading a[href='#"+$(this).attr('id')+"'] span.icon-opened").addClass("hide");
			$(".panel-heading a[href='#"+$(this).attr('id')+"'] span.icon-closed").removeClass("hide");
		});
				
		//Tabs and accordions triggers
		$('a[data-toggle="tab"]').on('shown.bs.tab', function () {
            var contentEl = $(this).attr("href");
            kleoPage.refreshContentTabs(contentEl);
		});
		$('.panel-collapse').on('shown.bs.collapse', function () {
			kleoPage.refreshContentTabs(this);
		});

        /* for VC tabs */
        $( document ).on( 'show.vc.tab', function() {
            kleoPage.refreshContentTabs(this);
        } );

        /* Open tab or accordion by hash url */
        kleoPage.openTabHash();

        //tours
        if ($('.wpb_tour').length) {
            $('.tour_next_slide').click(function() {
                var tabs = $(this).closest('.wpb_tour').find('li');
                var active = tabs.filter('.active');
                var next = active.next('li').length? active.next('li').find('a') : tabs.filter(':first-child').find('a');
                next.tab('show');
                return false;
            });
            $('.tour_prev_slide').click(function() {
                var tabs = $(this).closest('.wpb_tour').find('li');
                var active = tabs.filter('.active');
                var prev = active.prev('li').length? active.prev('li').find('a') : tabs.filter(':last-child').find('a');
                prev.tab('show');
                return false;
            });

            $('.wpb_tour').each(function() {
                var $this = $(this);
                var tourChange = function() {
                    var tabs = $this.find('li');
                    var active = tabs.filter('.active');
                    var next = active.next('li').length? active.next('li').find('a') : tabs.filter(':first-child').find('a');
                    next.tab('show');
                };
                if ($this.data("interval") != 0) {
                    var interval = $this.data("interval");
                    var tabCycle = setInterval( tourChange, interval * 1000 )

                    $(this).find('li').hover(function(){
                        clearInterval(tabCycle);
                    });
                }
            });
        }


		// Popover profile
		$('.click-pop').popover({
			trigger: "click"
		}).on('click',  function(e) {e.preventDefault; return false;});
	
		$('.hover-pop').popover({
			trigger: "hover focus",
			html: true
		});
		
		// Tooltip
		$('.hover-tip').tooltip({
			trigger: "hover",
            container: "body"
		});
		$('.click-tip').tooltip({
			trigger: "click",
            container: "body"
		});

        /* submit form using an anchor element */
        $("a.form-submit").on("click", function() {
            $(this).closest("form").submit();
            return false;
        });

        /* Feature items open link */
        $(document).on('click', '.kleo-open-href', function(e) {
            if( $(this).attr('data-href') != '' ){
                window.location.href = $(this).attr('data-href');
            }
        });

        /* Portfolio */
        if (($(".porto-video").length || $(".porto-hosted_video").length)) {
            $(".portfolio-items").imagesLoaded(function() {
                kleoPage.portfolioVideo();
            });
            $window.on("debouncedresize", kleoPage.portfolioVideo);
        }
        /* remove embed video titles */
        if ($(".porto-video").length) {
            $('iframe').each(function() {
                var video = $(this);
                var vidSrc = "";
                vidSrc = video.attr('src');
                if(vidSrc.indexOf("//www.youtube.com/embed/") > -1){
                    video.attr('src', vidSrc + '&autohide=1');
                }
                if(vidSrc.indexOf("//player.vimeo.com/") > -1) {
                    if(vidSrc.indexOf("?") > -1) {
                        video.attr('src', vidSrc + '&title=0&byline=0&portrait=0');
                    } else {
                        video.attr('src', vidSrc + '?title=0&byline=0&portrait=0');
                    }

                }

            });
        }

        $('a.kleo-login-switch').on('click', function(){
            var thisParent = $(this).parent().parent().parent();
            thisParent.find('.lostpass-form-inline').slideUp(100, function(){
                thisParent.find('.login-form-inline').slideDown(400);
            });
            return false;
        });

        $('a.kleo-lostpass-switch').on('click', function(){
            var thisParent = $(this).parent().parent().parent();
            thisParent.find('.login-form-inline').slideUp(100, function(){
                thisParent.find('.lostpass-form-inline').slideDown(400)
            });
            return false;
        });

        /* Equal column heights fallback */
        kleoPage.flexFallback();
	},
    refreshContentTabs: function(el) {
        //carousels
        $('.kleo-carousel, .kleo-banner-items').trigger('updateSizes');
        //masonry
        kleoIsotope.init();
        //google maps
        var $google_maps = $(el).find(".wpb_gmaps_widget");
        if ($google_maps.length && !$google_maps.is('.map_ready')) {
            var $google_maps_frame = $google_maps.find('iframe');
            $google_maps_frame.attr('src', $google_maps_frame.attr('src'));
            $google_maps.addClass('map_ready');
        }
    },
    openTabHash: function () {
        /* Open the tab or accordion */
        var hash = location.hash,
            hashPieces = hash.split('?'),
            prefix = "link_";

        if (hash && hash != '') {
            var activeTab = $('.nav-tabs a[href="' + hashPieces[0].replace(prefix,"") + '"]');
            var activeTour = $('.nav-tab a[href="' + hashPieces[0].replace(prefix,"") + '"]');
            var activeToggle = $('.panel-group a[href="' + hashPieces[0].replace(prefix,"") + '"]');

            if (activeTab.length) {
                activeTab.tab('show');
            }
            if (activeTour.length) {
                activeTour.tab('show');
            }
            if (activeToggle.length) {
                if (! activeToggle.hasClass("collapsed")) {
                    activeToggle.trigger('click');
                }
            }
        }

        /* Change the hash on tab/accordion open */

        var tabs = $('.nav-tabs a, .nav-tab a'),
            panels = $('.panel-group .panel-collapse');

        // for tabs
        tabs.on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash.replace("#", "#" + prefix);
        });
        tabs.on('hidden.bs.tab', function (e) {
            history.pushState("", document.title, window.location.pathname + window.location.search);
        });
        // for accordion
        panels.on('shown.bs.collapse', function (e) {
            if ($(this).attr('id')) {
                window.location.hash = "#" + prefix + $(this).attr('id');
            }
        });
        panels.on('hidden.bs.collapse', function (e) {
            history.pushState("", document.title, window.location.pathname + window.location.search);
        });
    },

    portfolioVideo: function() {
        var elements  = $(".porto-video .kleo-video-embed");
        elements.height(function () {
            var elHeight = 160;
            console.log(kleoFramework.portfolioVideoHeight);
            if( kleoFramework.hasOwnProperty('portfolioVideoHeight') && kleoFramework.portfolioVideoHeight != 0) {
                elHeight = kleoFramework.portfolioVideoHeight;
            }
            var image = $(this).closest(".portfolio-items").find('.portfolio-image img, .kleo-banner-slider img').eq(0);
            return image.length && image.height() > 50 ? image.height() : elHeight;
        });
    },
	
	notReadyInit: function() {
		//Preload logo
        kleoHeader.loadLogoImg();

		$('.responsive-tabs, .nav-pills, .top-menu > ul, #top-social > ul').tabdrop();
		
	},
	
	// Sidebar menu toggle
	kleoMenuWidget: function() {
			var submenuParent = jQuery(".widget_nav_menu ul.sub-menu").parent('li');
			submenuParent.addClass('parent');
			submenuParent.children("a").append('<span class="caret"></span>');
			submenuParent.find(".caret").click( function() {
				jQuery(this).closest(".parent").children('.sub-menu').stop(true,true).slideToggle('fast');
				jQuery(this).toggleClass('active');
				return false;
			});
		},
	
	adjustHeights: function(elem) {
      var fontstep = 2;
      if ($(elem).height()>$(elem).parent().height() || $(elem).width()>$(elem).parent().width()) {
        $(elem).css('font-size',(($(elem).css('font-size').substr(0,2)-fontstep)) + 'px').css('line-height',(($(elem).css('font-size').substr(0,2))) + 'px');
        adjustHeights(elem);
      }
    },
	
	removeOverflowHidden: function() {
		
		$('body').on('click', function() {
			if ($('#buddypress .tabdrop').hasClass('open'))
			{
				$('#buddypress div#item-nav').css('overflow','hidden');
			}
		});
		
		$('.item-list-tabs .dropdown-toggle').on('click', function() {
			if ($('#buddypress .tabdrop').hasClass('open'))
			{
				$('#buddypress div#item-nav').css('overflow','hidden');
			}
			else {
				$('#buddypress div#item-nav').css('overflow','visible');
			}
		});
		
	},
	
	bannerSlider: function() {
		
		$('.kleo-banner-slider').animate({"opacity": "1"}, 700);
		
		$('.kleo-banner-slider').each(function() {
			var thisSliderItems = $(this).find('.kleo-banner-items');
			var $prev = $(this).find(".kleo-banner-prev");
			var $next = $(this).find(".kleo-banner-next");
            var $duration = 2000;

            if (thisSliderItems.data("speed") ) {
                $duration = parseInt(thisSliderItems.data("speed"));
            }

			thisSliderItems.imagesLoaded(function() {
				thisSliderItems.carouFredSel({
						//auto: false,
						responsive: true,
						circular: false,
						infinite: true,
						auto: {
							play : true,
							pauseDuration: 0,
							duration: $duration
						},
						scroll: {
							items: 1,
							duration: 600,
							//fx: "crossfade",
							easing: "easeInOutExpo",
							wipe: true
						},
						//padding: 0,
						prev: $prev,
						next: $next,
						items: {
							height : 'variable',
							visible: 1
						}
				});
                thisSliderItems.swipe({
                    excludedElements: "",
                    threshold: 40,
                    swipeLeft: function() {
                        thisSliderItems.trigger('next', 1);
                        setTimeout(function(){ thisSliderItems.trigger('updateSizes'); }, 600);
                },
                    swipeRight: function() {
                        thisSliderItems.trigger('prev', 1);
                        setTimeout(function(){ thisSliderItems.trigger('updateSizes'); }, 600);
                    },
                });
			});
		});

	},
	
	carouselItems: function() {
		
		$('.kleo-carousel-items').each(function() {
			// Load Carousel options into variables
			var $currentCrslPrnt = $(this);
			var $currentCrsl = $currentCrslPrnt.children('.kleo-carousel');
			var $prev = $currentCrslPrnt.closest('.kleo-carousel-container').find(".carousel-arrow .carousel-prev");
			var $next = $currentCrslPrnt.closest('.kleo-carousel-container').find(".carousel-arrow .carousel-next");
			var $pagination = $currentCrslPrnt.closest('.kleo-carousel-container').find(".kleo-carousel-pager");

			var $visible,
			$items_height = 'auto',
			$items_width = null,
			$auto_play = false,
			$auto_pauseOnHover = 'resume',
			$scroll_fx = 'scroll',
			$duration = 2000;

			if ($currentCrslPrnt.data("pager")) {
				$pagination = $currentCrslPrnt.closest('.kleo-carousel-container').find($currentCrslPrnt.data("pager"));
			}
			if ($currentCrslPrnt.data("autoplay")) {
				$auto_play = true;
			}
			if ($currentCrslPrnt.data("speed") ) {
				$duration = parseInt($currentCrslPrnt.data("speed"));
			}
			if ($currentCrslPrnt.data("items-height") ) {
				$items_height = $currentCrslPrnt.data("items-height");
			}
			if ($currentCrslPrnt.data("items-width") ) {
				$items_width = $currentCrslPrnt.data("items-width");
			}
			if ($currentCrslPrnt.data("scroll-fx") ) {
				$scroll_fx = $currentCrslPrnt.data("scroll-fx");
			}
			
			if ($currentCrslPrnt.data("min-items") && $currentCrslPrnt.data("max-items")) {
				$visible = {
						min: $currentCrslPrnt.data("min-items"),
						max: $currentCrslPrnt.data("max-items")
					};
			}
			// Apply common carousel options
			$currentCrsl.imagesLoaded( function() {
				$currentCrsl.carouFredSel({
						responsive: true,
						width: '100%',
						pagination: $pagination,
						prev: $prev,
						next: $next,
						auto: {
							play : $auto_play,
							pauseOnHover: $auto_pauseOnHover
						},
						scroll: {
							items: 1,
							duration: 600,
							fx: $scroll_fx,
							easing: "swing",
							timeoutDuration: $duration,
                            wipe: true
						},
						items: {
							width: $items_width,
							height: $items_height,
							visible: $visible
						}
				}).visible();
                $currentCrsl.swipe({
                    excludedElements: "",
                    threshold: 40,
                    swipeLeft: function() {
                        $currentCrsl.trigger('next', 1);
                        setTimeout(function(){ $currentCrsl.trigger('updateSizes'); }, 600);
                    },
                    swipeRight: function() {
                        $currentCrsl.trigger('prev', 1);
                        setTimeout(function(){ $currentCrsl.trigger('updateSizes'); }, 600);

                    },
                });
			});
		});

		if($(".kleo-thumbs-carousel").length) {
			$(".kleo-thumbs-carousel").each(function() {
				var $thumbsCarousel = $(this), 
						$thumbsVisible = 6,
						$circular = false;

				if ($thumbsCarousel.data("min-items") && $thumbsCarousel.data("max-items")) {
					$thumbsVisible = {
						min: $thumbsCarousel.data("min-items"),
						max: $thumbsCarousel.data("max-items")
					};
				}
				if ($thumbsCarousel.data("circular")) {
					$circular = true;
				}
				
				$thumbsCarousel.imagesLoaded( function() {
					$thumbsCarousel.carouFredSel({
						responsive: true,
						circular: $circular,
						infinite: true,
						auto: false,
						prev: {
							button : function(){
								return $(this).parents('.kleo-gallery').find('.kleo-thumbs-prev');
							}
						},
						next:{
							button : function(){
								return $(this).parents('.kleo-gallery').find('.kleo-thumbs-next');
							}
						},
						scroll: {
							items: 1
						},
						items: {
							height: 'auto',
							visible: $thumbsVisible
						}
					});
                    $thumbsCarousel.swipe({
                        excludedElements: "",
                        threshold: 40,
                        swipeLeft: function() {
                            $thumbsCarousel.trigger('next', 1);
                            setTimeout(function(){ $thumbsCarousel.trigger('updateSizes'); }, 600);
                        },
                        swipeRight: function() {
                            $thumbsCarousel.trigger('prev', 1);
                            setTimeout(function(){ $thumbsCarousel.trigger('updateSizes'); }, 600);
                        },
                    });
				});
			});
		}

		$('.kleo-thumbs-carousel a').click(function() {
			$(this).closest('.kleo-gallery-container').find('.kleo-gallery-image').trigger('slideTo', '#' + this.href.split('#').pop() );
			$('.kleo-thumbs-carousel a').removeClass('selected');
			$(this).addClass('selected');
			return false;
		});

		if($(".kleo-gallery-image").length) {
            $('.kleo-gallery-image').imagesLoaded( function() {
                $('.kleo-gallery-image').carouFredSel({
                    responsive: true,
                    circular: false,
                    auto: false,
                    items: {
                        height: 'variable',
                        visible: 1
                    },
                    scroll: {
                        items: 1,
                        fx: 'crossfade'
                    }
                });
                $('.kleo-gallery-image').swipe({
                    excludedElements: "",
                    threshold: 40,
                    swipeLeft: function() {
                        $('.kleo-gallery-image').trigger('next', 1);
                        setTimeout(function(){ $('.kleo-gallery-image').trigger('updateSizes'); }, 600);
                    },
                    swipeRight: function() {
                        $('.kleo-gallery-image').trigger('prev', 1);
                        setTimeout(function(){ $('.kleo-gallery-image').trigger('updateSizes'); }, 600);
                    },
                });
            });
		}
		
	},

	rtMediaslider: function() {

		//jQuery('.rtmedia-activity-container').animate({"opacity": "1"}, 700);
		$('.rtmedia-activity-container').each(function() {

            if ( $(this).find(".rtmedia-list .media-type-photo").length < 1) {
                return true;
            }
            $(this).append('<div class="activity-feed-prev">&nbsp;</div><div class="activity-feed-next">&nbsp;</div>');

			var $prev = $(this).find(".activity-feed-prev");
			var $next = $(this).find(".activity-feed-next");
			var thisSliderItems = $(this).find('.rtmedia-list');
			
			thisSliderItems.imagesLoaded( function() {
				thisSliderItems.carouFredSel({
						//auto: false,
						responsive: true,
						circular: false,
						auto: {
							play : true,
							pauseDuration: 0,
							duration: 2000
						},
						scroll: {
							items: 1,
							duration: 600,
							//fx: "crossfade",
							easing: "easeInOutExpo",
							wipe: true
						},
						//padding: 0,
						prev: $prev,
						next: $next,
						items: {
							height : 'auto',
							visible: {
										min: 1,
										max: 4
								}
						}
				});
                thisSliderItems.swipe({
                    excludedElements: "",
                    threshold: 40,
                    swipeLeft: function() {
                        thisSliderItems.trigger('next', 1);
                        setTimeout(function(){ thisSliderItems.trigger('updateSizes'); }, 600);
                    },
                    swipeRight: function() {
                        thisSliderItems.trigger('prev', 1);
                        setTimeout(function(){ thisSliderItems.trigger('updateSizes'); }, 600);
                    },
                });
			});
		});

	},

    newsTicker: function() {

        var _newsScroll = {
            delay: 1000,
            easing: 'linear',
            items: 1,
            duration: 0.07,
            timeoutDuration: 0,
            pauseOnHover: 'immediate'
        };
        $('.news-ticker').each(function() {
            $(this).carouFredSel({
                width: 1000,
                align: false,
                items: {
                    width: 'variable',
                    /*height: 35,*/
                    visible: 1
                },
                scroll: _newsScroll
            });
            $(this).closest('.caroufredsel_wrapper').css('width', '100%');
        });

    },
	
	initPins: function() {
		
		$( ".kleo-pin-circle, .kleo-pin-poi, .kleo-pin-icon" ).each(function() {
			var $length = "";

			if ($(this).is('[data-top]')) {
				$( this ).css({ "top": $(this).attr('data-top')+$length});
			}
			if ($(this).is('[data-left]')) {
				$( this ).css({ "left": $(this).attr('data-left')+$length});
			}
			if ($(this).is('[data-right]')) {
				$( this ).css({ "right": $(this).attr('data-right')+$length});
			}
			if ($(this).is('[data-bottom]')) {
				$( this ).css({ "bottom": $(this).attr('data-bottom')+$length});
			}

		});
		
	},
	
	/***************************************************
	 Go To Top Link
	***************************************************/
	goTop: function() {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 500) {
					$('.kleo-go-top, .kleo-quick-contact-wrapper').removeClass('off').addClass('on');
			}
			else {
					$('.kleo-go-top, .kleo-quick-contact-wrapper').removeClass('on').addClass('off');
			}
		});

		$('.kleo-go-top, .divider-go-top').click(function () {
				$("html, body").animate({
						scrollTop: 0
				}, 800);
				return false;
		});

		$('.kleo-classic-comments').click(function () {
				$("html, body").animate({
						scrollTop: $('#comments').offset().top
				}, 800);

		});
	 },


	magnificPopupModals: function() {

        /* Login modal */

        /* On specific URL*/
        if (window.location.hash) {
            var myHash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
            if (myHash == 'show-login' && !$("body").hasClass('logged-in')) {
                $.magnificPopup.open({
                    items: {
                        src: '#kleo-login-modal',
                        type: 'inline',
                        focus: '#username'
                    },
                    preloader: false,
                    mainClass: 'kleo-mfp-zoom'

                });
            }
        }


        $('.kleo-show-login, .bp-menu.bp-login-nav a, .must-log-in > a').magnificPopup({
            items: {
                src: '#kleo-login-modal',
                type: 'inline',
                focus: '#username'
            },
            preloader: false,
            mainClass: 'kleo-mfp-zoom',

            // When element is focused, some mobile browsers in some cases zoom in
            // It looks not nice, so we disable it:
            callbacks: {
                beforeOpen: function () {
                    if ($(window).width() < 700) {
                        this.st.focus = false;
                    } else {
                        this.st.focus = '#username';
                    }
                }
            }
        });

        /* Lost Pass modal */
        $('.kleo-show-lostpass').magnificPopup({
            items: {
                src: '#kleo-lostpass-modal',
                type: 'inline',
                focus: '#forgot-email'
            },
            preloader: false,
            mainClass: 'kleo-mfp-zoom',

            // When elemened is focused, some mobile browsers in some cases zoom in
            // It looks not nice, so we disable it:
            callbacks: {
                beforeOpen: function () {
                    if ($(window).width() < 700) {
                        this.st.focus = false;
                    } else {
                        this.st.focus = '#forgot-email';
                    }
                }
            }
        });

        /* Register modal */
        $('.kleo-show-register').magnificPopup({
            items: {
                src: '#kleo-register-modal',
                type: 'inline',
                focus: '#reg-username'
            },
            preloader: false,
            mainClass: 'kleo-mfp-zoom',

            // When elemened is focused, some mobile browsers in some cases zoom in
            // It looks not nice, so we disable it:
            callbacks: {
                beforeOpen: function () {
                    if ($(window).width() < 700) {
                        this.st.focus = false;
                    } else {
                        this.st.focus = '#reg-username';
                    }
                }
            }
        });
    },
    magnificPopupGallery: function() {

		/* Regular popup images */
		$("a[data-rel^='prettyPhoto'], a[rel^='prettyPhoto'], a[rel^='modalPhoto'], a[data-rel^='modalPhoto'], .article-content a[href$=jpg]:has(img), .article-content a[href$=JPG]:has(img), .article-content a[href$=jpeg]:has(img), .article-content a[href$=JPEG]:has(img), .article-content a[href$=gif]:has(img), .article-content a[href$=GIF]:has(img), .article-content a[href$=bmp]:has(img), .article-content a[href$=BMP]:has(img), .article-content a[href$=png]:has(img), .article-content a[href$=PNG]:has(img)").magnificPopup({
			type: 'image',
			mainClass: 'mfp-img-pop',
			gallery:{
				enabled: true
			}
		});

        /* Galleries */
        $('.gallery, .modal-gallery').each(function() { 
            $(this).magnificPopup({
                delegate: $(this).find("a[href$=jpg], a[href$=JPG], a[href$=jpeg], a[href$=JPEG], a[href$=png], a[href$=PNG], a[href$=gif], a[href$=GIF], a[href$=bmp], a[href$=BMP]").has('img'),
                type: 'image',
                mainClass: 'mfp-gallery-pop',
                navigateByImgClick: true,
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1]
                }
            });
        });
	},

    doingLikesRequest: false,
	likes: function() {
		$('.item-likes').on('click', function() {
            var link = $(this);

            if(link.hasClass('liked') || kleoPage.doingLikesRequest === true)  {
                return false;
            }

            var id = $(this).attr('id'),
                postfix = link.find('.item-likes-postfix').text();

            $.ajax({
                type: 'POST',
                url: kleoFramework.ajaxurl,
                data: {
                    action:'item-likes',
                    likes_id:id,
                    postfix:postfix
                },
                beforeSend: function()
                {
                    kleoPage.doingLikesRequest = true;
                },
                success: function (data) {
                    link.html(data).addClass('liked').attr('title',kleoFramework.alreadyLiked);
                },
                complete: function() {
                    kleoPage.doingLikesRequest = false;
                }
            });

            return false;
        });

        if( $('body.ajax-item-likes').length ) {
            $('.item-likes').each(function(){
                var id = $(this).attr('id');
                $(this).load(kleoFramework.ajaxurl, { action:'item-likes', post_id:id });
            });
        }
	},
	getURLParameters: function(url) {

    var result = {};
    var searchIndex = url.indexOf("?");
    if (searchIndex == -1 ) return result;
    var sPageURL = url.substring(searchIndex +1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
      var sParameterName = sURLVariables[i].split('=');
      result[sParameterName[0]] = sParameterName[1];
    }
    return result;
	},

    /* Progress bar */
    progressBar: function () {

        if (typeof jQuery.fn.waypoint !== 'undefined') {
            $('.vc_progress_bar').waypoint(function () {
                $(this).find('.vc_single_bar').each(function (index) {
                    var $this = $(this),
                        bar = $this.find('.vc_bar'),
                        val = bar.data('percentage-value');

                    setTimeout(function () {
                        bar.css({"width": val + '%'});
                    }, index * 200);
                });
            }, {offset: '85%'});
        }
    },
    kleoAjaxLogin: function () {
        $('form#login_form').on('submit', function (e) {
            $('#kleo-login-result').show().html(kleoFramework.loadingmessage);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: kleoFramework.loginUrl,
                data: {
                    action: 'kleoajaxlogin',
                    log: $('form#login_form #username').val(),
                    pwd: $('form#login_form #password').val(),
                    rememberme: ($('form#login_form #rememberme').is(':checked') ? true : false),
                    security: $('form#login_form #security').val()
                },
                success: function (data) {
                    $('#kleo-login-result').html(data.message);
                    if (data.loggedin == true) {
                        if (data.redirecturl == null) {
                            document.location.reload();
                        }
                        else {
                            document.location.href = data.redirecturl;
                        }
                    }
                },
                complete: function () {

                },
                error: function () {
                    $('form#login_form, #login_panel').off('submit');
                    $("#login_form").submit();
                }
            });
            e.preventDefault();
        });
    },

    kleoAjaxLostPass: function () {
        $("#forgot_form").on("submit", function () {
            $('#kleo-lost-result').show().html(kleoFramework.loadingmessage);
            $.ajax({
                url: kleoFramework.ajaxurl,
                type: 'POST',
                data: {
                    action: 'kleo_lost_password',
                    user_login: $("#forgot-email").val()
                },
                success: function (data) {
                    $('#kleo-lost-result').html(data);
                },
                error: function () {
                    $('#kleo-lost-result').html('Sorry, an error occurred.').css('color', 'red');
                }

            });
            return false;
        });
    },
    flexFallback: function() {
        var s = document.body || document.documentElement, s = s.style;
        if( s.webkitFlexWrap == '' || s.msFlexWrap == '' || s.flexWrap == '' ) return true;

        var $list		= $( '#main-container > .row' ),
            $items		= $list.find( '.template-page, .sidebar' ),
            setHeights	= function()
            {
                $items.css( 'height', 'auto' );

                var perRow = Math.floor( $list.width() / $items.width() );
                if( perRow == null || perRow < 2 ) return true;

                for( var i = 0, j = $items.length; i < j; i += perRow )
                {
                    var maxHeight	= 0,
                        $row		= $items.slice( i, i + perRow );

                    $row.each( function()
                    {
                        var itemHeight = parseInt( $( this ).outerHeight() );
                        if ( itemHeight > maxHeight ) maxHeight = itemHeight;
                    });
                    $row.css( 'height', maxHeight );
                }
            };

        setHeights();
        $( window ).on( 'resize', setHeights );
        $list.find( 'img' ).on( 'load', setHeights );
    }
  

};


/***************************************************
 Buddypress
***************************************************/
var bP = {
	rehreshID: null,
  
	init: function() {
		//$("#buddypress div#item-nav .responsive-tabs").css('visibility', 'visible');
		$("#buddypress div#item-nav").css('background-image', 'none');

		//Enable masonry isotope
		$("body").on('gridloaded', function() {
			kleoIsotope.applyGridIsotpe(".kleo-isotope");
			$('.animate-when-almost-visible').kleo_waypoints({ offset: '90%'});
		});
		
		//Activity on change events
		$("body").on('bpActivityLoaded', function() {
			//Init animation
			$('.animate-when-almost-visible').kleo_waypoints({ offset: '90%'});
			
			//Init slider
			kleoPage.rtMediaslider();

			//Init fitVids
			$(".activity-inner").fitVids();
		});
    if (typeof(rtMediaHook) != "undefined") {
      rtMediaHook.register( 'rtmedia_after_gallery_load', function() {
        $('.el-zero-fade').kleo_waypoints({ offset: '90%'});
      });
    }
    
    if ($(".kleo-notifications-nav").length) {
      $(".navbar").on("click", ".kleo-notifications-nav a.mark-as-read", function(e) {
        bP.notificationsRead($(this));
        e.preventDefault();
      });
      if (kleoFramework.hasOwnProperty('bpNotificationsRefresh') && kleoFramework.bpNotificationsRefresh != '0') {
        bP.notificationsRefresh();
      }
    }
    
	},
  
  notificationsRefresh: function() {
    
    bP.rehreshID = setInterval(function() {
      
      var values = { 
        action: "kleo_bp_notifications_refresh",
        current: $(".kleo-notifications-nav .kleo-notifications").first().text()
      };
 
      $.ajax({
        url: kleoFramework.ajaxurl,
        type: "GET",
        dataType: "json",
        data: values,
        success: function(response)
        {
          if (response.status == 'success') {
            if(response.count == '0') {
                $('.kleo-notifications-nav .minicart-buttons').hide();
                $(".kleo-notifications-nav .kleo-notifications").removeClass("new-alert").addClass("no-alert");
                $(".kleo-notifications-nav .submenu-inner").removeClass("has-notif");
            } else {
                $(".kleo-notifications-nav").addClass("kleo-loading");
                $(".kleo-notifications-nav .kleo-notifications").removeClass("no-alert").addClass("new-alert");
                $(".kleo-notifications-nav .submenu-inner").addClass("has-notif");
                $('.kleo-notifications-nav .minicart-buttons').show();
            }
            
            $(".kleo-notifications-nav .kleo-notifications").text(response.count);
            $('.kleo-notifications-nav .submenu-inner').html(response.data);
          } else {
            //
          }

        },
        complete: function()
        {
          $(".kleo-notifications-nav").removeClass("kleo-loading");
        }
      });
 
    }, kleoFramework.bpNotificationsRefresh);
    
    
  },
  
  notificationsRead: function(e) {
    
    var values = { action: "kleo_bp_notification_mark_read" };

    $.ajax({
        url: kleoFramework.ajaxurl,
        type: "GET",
        dataType: "json",
        data: values,
        beforeSend: function()
        {
          $(".kleo-notifications-nav").addClass("kleo-loading");
        },
        success: function(response)
        {
          if (response.status == 'success') {
            if(response.count == '0') {
                $('.kleo-notifications-nav .submenu-inner').html(response.empty);
                $('.kleo-notifications-nav .minicart-buttons').hide();
                $(".kleo-notifications-nav .kleo-notifications").removeClass("new-alert").addClass("no-alert");
                $(".kleo-notifications-nav .submenu-inner").removeClass("has-notif");
            } else {
                $(".kleo-notifications-nav .kleo-notifications").removeClass("no-alert").addClass("new-alert");
                $(".kleo-notifications-nav .submenu-inner").addClass("has-notif");
                $('.kleo-notifications-nav .minicart-buttons').show();
            }
            $(".kleo-notifications-nav .kleo-notifications").text(response.count);
          } else {
            //
          }

        },
        complete: function()
        {
          $(".kleo-notifications-nav").removeClass("kleo-loading");
        }
    });
      
  
  }
	
};

/***************************************************
 Woocommerce
***************************************************/
var kleoShop = {
	
	wooGalItems: [],
	wooMainImg: $(".woocommerce-main-image"),
	
	init: function() {
		
		kleoShop.productQuickView();
		kleoShop.removeCartProduct();
		
		if ($(".kleo-woo-gallery a.zoom").length < 2) {
			$(".woo-main-image-nav").hide();
		}
		
		if ($(".kleo-woo-gallery a.zoom").length) {
			kleoShop.startMultiGallery();
			
			$(".kleo-woo-next").on('click', function(e) {
				
				e.preventDefault();
				$('.kleo-thumbs-carousel').trigger('next');
				
				if ($(".kleo-woo-gallery a.zoom.selected").nextAll("a.zoom:eq(0)").length ) {

					var nextElem = $(".kleo-woo-gallery a.zoom.selected").nextAll("a.zoom:eq(0)");
					kleoShop.setSelected(nextElem);

				}
			});

			$(".kleo-woo-prev").on('click', function(e) {

				e.preventDefault();
				$('.kleo-thumbs-carousel').trigger('prev');
				
				if ($(".kleo-woo-gallery a.zoom.selected").prevAll("a.zoom:eq(0)").length) {

					var prevElem = $(".kleo-woo-gallery a.zoom.selected").prevAll("a.zoom:eq(0)");
					kleoShop.setSelected(prevElem);

				}
			});
			
		} else {
			kleoShop.startSingleGallery();
		}
		
	},
	
	setSelected: function(element) {
		$(".woocommerce-main-image img").attr('src', element.attr('href')).parent("a").attr("href", element.attr('data-big-img'));
		$(".kleo-woo-gallery a.zoom").removeClass('selected');
		element.addClass('selected');
		kleoShop.updateGalleryItems(element);
	},
	
	startSingleGallery: function() {
		
		kleoShop.wooMainImg.magnificPopup({
			type: 'image',
      mainClass: 'kleo-mfp-zoom',
      removalDelay: 300,
      closeOnContentClick: true,
			image: {
				verticalFit: false
			}
		});
		
	},
	
	startMultiGallery: function() {
		
		//update images array
		kleoShop.updateGalleryItems($(".kleo-woo-gallery a.zoom.selected"));
		//disable click
		kleoShop.wooMainImg.on('click', function(e) {
			e.preventDefault();
		});
		
		//enable gallery lightbox
		kleoShop.wooMainImg.magnificPopup({
			items: kleoShop.wooGalItems,
			type: 'image',
      mainClass: 'kleo-mfp-zoom',
      removalDelay: 300,
      closeOnContentClick: true,
			gallery: {
				enabled: true
			},
			image: {
				verticalFit: false
			}
		});
		kleoShop.wooMainImg.on('mfpBeforeOpen', function() {
			$.magnificPopup.instance.items = kleoShop.wooGalItems;
			$.magnificPopup.instance.updateItemHTML();
		});
		
		$(".kleo-woo-gallery a.zoom").on('click', function(e) {
			e.preventDefault();
			kleoShop.setSelected($(this));
			
			return false;
		});
		
	},
	
	updateGalleryItems: function(elem) {
		
		kleoShop.wooGalItems = [{src: elem.attr('href')}];
		var tmp;
		$(".kleo-woo-gallery a.zoom:not(.selected)").each(function() {
			tmp = {
				src: $(this).attr('href')
			};
			kleoShop.wooGalItems.push(tmp);
		});
		
	},
	
	productQuickView: function() {
		$('.navbar, #main').on('click', '.quick-view', function(e) {
			
			var thiss = $(this);			
			var product_id = $(this).attr('data-prod');
			var data = { action: 'woo_quickview', product: product_id};
			
			$.ajax({
					url: kleoFramework.ajaxurl,
					type: "POST",
					data: data,
					beforeSend: function()
					{
						thiss.addClass('kleo-loading');
					},
					success: function(response)
					{
						
						$.magnificPopup.open({
							 mainClass: 'kleo-mfp-zoom',
							 items: {
								 src: '<div id="productModal" class="product-modal main-color">'+response+'</div>',
								 type: 'inline'
							 }
						 });
						
						setTimeout(function() {
							//init slider
							kleoPage.carouselItems();
							
							$('.product-modal form').wc_variation_form();
							$('.product-modal form select').change();

						}, 500);
						
					},
					complete: function()
					{
						thiss.removeClass('kleo-loading');
					}
			});
			
			e.preventDefault();
		}); // productQuickView	
	},
	
	removeCartProduct: function() {
		$(".navbar").on("click", ".kleo-minicart a.remove", function(e) {
			
			var thiss = $(this), 
			values = {action: "kleo_woo_rem_item"},
			queryParams = kleoPage.getURLParameters(thiss.attr('href'));
			
			$.extend( values, queryParams );
			//rename product param name
			var newVar = { kleo_item : values.remove_item };
			delete values.remove_item;
			$.extend( values, newVar );

			$.ajax({
					url: kleoFramework.ajaxurl,
					type: "GET",
					dataType: "json",
					data: values,
					beforeSend: function()
					{
						$(".shop-drop").addClass('kleo-loading');
					},
					success: function(response)
					{
                        if( response.hasOwnProperty("cart") && response.hasOwnProperty("count") ) {
                            
                            $(".kleo-toggle-menu.shop-drop .kleo-toggle-submenu").html(response.cart);
                            $(".kleo-toggle-menu.shop-drop .cart-items > span, .mheader .cart-items > span").html(response.count);

                            if (response.count == '') {
                                $(".kleo-toggle-menu.shop-drop .cart-items").removeClass('has-products');
                                $(".kleo-toggle-menu.shop-drop .kleo-notifications").removeClass('new-alert');
                                $(".kleo-toggle-menu.shop-drop .kleo-notifications").addClass('no-alert');
                            } else {
                                $(".kleo-toggle-menu.shop-drop .cart-items").addClass('has-products');
                                $(".kleo-toggle-menu.shop-drop .kleo-notifications").addClass('new-alert');
                                $(".kleo-toggle-menu.shop-drop .kleo-notifications").removeClass('no-alert');
                            }
                        }
						
						/* widget cart */
						if ($('.widget_shopping_cart_content').length && response.hasOwnProperty('widget')) {
							$('.widget_shopping_cart_content').replaceWith(response.widget)
						}
						
					},
					complete: function()
					{
                        $(".shop-drop").removeClass('kleo-loading');
					}
			});
			e.preventDefault();
		});
	}
	
};


/***************************************************
 Isotope
***************************************************/
var kleoIsotope = {
	
	container: '.kleo-isotope, .kleo-masonry',
	elContainer: $('.kleo-isotope, .kleo-masonry'),
	
	init: function() {

		if (kleoIsotope.elContainer.length > 0) {
			kleoIsotope.applyGridIsotpe(kleoIsotope.container);
		}
		
	},

	applyGridIsotpe: function(container, atts) {
		var $container = $(container);
		$container.each(function() {
			var $isoItem = $(this);
			var $isoAtts;
			if($isoItem.data('layout') == 'fitRows') {
				$isoAtts = { layoutMode : 'fitRows' };
			}
      
			atts = typeof atts !== 'undefined' ? true : false;
			if (atts == false) {
				$isoAtts = {};
			}

            if (kleoIsotope.elContainer.length > 0 && kleoIsotope.viewport().width >= 480) {
                $isoItem.imagesLoaded(function () {
                    $isoItem.isotope($isoAtts);
                });
            }

            $(window).on("debouncedresize", function() {
                // reinit isotope
                $isoItem.isotope($isoAtts);
            });

            /* filter items on button click */
            if ($isoItem.prev(".filter-wrap").length) {
                var filterButton = $isoItem.prev(".filter-wrap");
                filterButton.on( 'click', "a", function() {
                    var filterValue = $(this).data('filter');
                    $(this).closest('ul').find('li').removeClass('selected');
                    $(this).parent('li').addClass('selected');
                    $isoItem.isotope({ filter: filterValue });
                    $isoItem.find('li:visible').children('div.animate-when-almost-visible').addClass('start-animation');
                    return false;
                });
            }

		});

	},
	getWidth: function(item){
		var $isoWidth;

		if(kleoIsotope.viewport().width < 480) {
			$isoWidth = item.width() / 1;
			
		} else if(kleoIsotope.viewport().width < 768) {
			$isoWidth = item.width() / 2;
			
		} else if(kleoIsotope.viewport().width < 992) {
			$isoWidth = item.width() / 2;
			
		} else if(kleoIsotope.viewport().width < 1200) {
			if (item.closest(".template-page").hasClass('col-sm-12') ) {
				$isoWidth = item.width() / 3;
			} else {
				$isoWidth = item.width() / 2;
			}
					
		} else if(kleoIsotope.viewport().width < 1440) {
			if (item.closest(".template-page").hasClass('col-sm-12')) {

				$isoWidth = item.width() / 4;
		
			} else {
				$isoWidth = item.width() / 3;
			}
		} else {
			if (item.closest(".template-page").hasClass('col-sm-12')) {
				if (item.closest(".section-container").hasClass('container-full')) {
					$isoWidth = item.width() / 6;
				} else {
					$isoWidth = item.width() / 4;
				}
			} else {
				$isoWidth = item.width() / 3;
			}
		}
		return $isoWidth;
	},
	
	viewport: function() {
    var e = window, a = 'inner';
    if (!('innerWidth' in window )) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
	}	
	
};


/***************************************************
 Site Header
***************************************************/
var kleoHeader = {
	spacing: 0,
	initialPos:				($('.kleo-main-header').length && ! $("body").hasClass('navbar-transparent')) ? $('.kleo-main-header').offset().top : 0,
	initialSize:			88,
    isLogo:                 kleoFramework.logo == '' ? false : true,
    logoSize:               88,
    logoImg:                null,
    header:				    $('.kleo-main-header'),
	logo:					$('.navbar-header .logo img'),
	elements:				$('.navbar-header, .kleo-main-header .navbar-collapse > ul > li > a, .header-banner'),

    init: function() {

        //set logo size
        if (kleoHeader.isLogo) {

            kleoHeader.loadLogoImg();
            $(kleoHeader.logoImg).imagesLoaded( function () {
                kleoHeader.updateLogoSize(kleoHeader.logoImg.height);
            }, false);
        }


        if ($('#wpadminbar').length > 0 && parseInt($window.width()) > 584) {
            kleoHeader.spacing = $('#wpadminbar').height();
        }

        //check for custom header size set
        if ( ! kleoFramework.headerHeight ) {

            //init based on logo
            //kleoHeader.initialSize = kleoHeader.elements.filter(':first').height();
            kleoHeader.initialSize = ($('.kleo-main-header #logo_img').length && $('.kleo-main-header #logo_img').height() > 10) ? $('.kleo-main-header #logo_img').height() : 88;

        } else {
            kleoHeader.initialSize = kleoFramework.headerHeight;
        }

        //continue only if the header element exists in the page
		if( kleoHeader.header.length ) {

			/* Activate logo resizing */
			if ($("body.kleo-navbar-fixed.navbar-resize").length && ! kleoHeader.header.hasClass("header-left")) {

                if (kleoHeader.isLogo) {
                    kleoHeader.loadLogoImg();
                    $(kleoHeader.logoImg).imagesLoaded( function () {
                        kleoHeader.resizeLogo();
                    }, false);
                } else {
                    kleoHeader.resizeLogo();
                }

                $window.scroll(kleoHeader.resizeLogo);
                $(window).on("debouncedresize", kleoHeader.resizeLogo);

			} else if (kleoHeader.header.hasClass("header-left")) {

                /* Set initial line height */
                kleoHeader.initialLineHeight();

                if ($("body.kleo-navbar-fixed").length) {

                    if ($("body.navbar-resize").length) {
                        $(window).on("debouncedresize", kleoHeader.resizeLogo);

                        var st = $window.scrollTop();
                        if (st > 200) {
                            kleoHeader.resizeLogo(100);
                            if (! $("body").hasClass("navbar-transparent")) {
                                kleoHeader.header.css({top: kleoHeader.spacing, position: 'fixed'});
                            }
                        }
                    }

                    $window.scroll(function () {
                        var st = $window.scrollTop();
                        if (st > 200) {
                            if ($("body.navbar-resize").length) {
                                kleoHeader.resizeLogo(100);
                            }
                            if (! $("body").hasClass("navbar-transparent")) {
                                kleoHeader.header.css({top: kleoHeader.spacing, position: 'fixed'});
                            }
                        } else {
                            kleoHeader.header.css({top: 'auto', position: 'static'});
                            kleoHeader.resizeLogo(200);
                        }
                    });
                }

            } else {
                /* Set initial line height */
				kleoHeader.initialLineHeight();

                /* Apply background to non-resizing sticky menu when transparent */
                if ($("body.kleo-navbar-fixed.navbar-transparent").length) {
                    var st = $window.scrollTop();

                    if (st > 50) {
                        kleoHeader.header.addClass('header-scrolled');
                    } else {
                        kleoHeader.header.removeClass('header-scrolled');
                    }

                    $window.scroll(function() {
                        var st = $window.scrollTop();
                        if (st > 50) {
                            kleoHeader.header.addClass('header-scrolled');
                        } else {
                            kleoHeader.header.removeClass('header-scrolled');
                        }
                    });
                }
			}
		}
    
		//activate sticky main menu
		if (body.hasClass("kleo-navbar-fixed") && ! kleoHeader.header.hasClass("header-left")) {
			kleoHeader.enable_sticky();
		}

		//activate retina logo
		kleoHeader.enableRetinaLogo();
		
		//activate social icons expand effect
		kleoHeader.topSocialExpander();
		
		//enable menu Ajax search button
		if($('.kleo_ajax_results').length) {
			kleoHeader.toggleAjaxSearch();
			kleoHeader.doAjaxSearch();
		}
		
		// Activate Hover menu
		if (kleoIsotope.viewport().width > 992) {
			$('#header .js-activated').dropdownHover({delay: 100}).dropdown();
		}
		$('.js-activated').off('click');
		
		//Expand dropdown on caret click
		$('#header .caret').on('click', function() {
			var liItem = $(this).closest(".dropdown, .dropdown-submenu");
			if (liItem.hasClass("open")) {
				liItem.removeClass("open");
			} else {
				liItem.addClass("open");
			}
			return false;
		});
    
        kleoHeader.dropdownToggle();

        kleoHeader.scrollTo();

        kleoHeader.sideMenu();
		
	},

    loadLogoImg: function() {
        if (kleoHeader.isLogo && ! kleoHeader.logoImg) {
            kleoHeader.logoImg = new Image();
            kleoHeader.logoImg.src = kleoFramework.logo;
        }
    },

    sideMenu: function() {
        $('.open-sidebar').on('click', function() {
            $('body').toggleClass('offcanvas-open');
            $('.offcanvas-sidebar').toggleClass('is-open');
            return false;
        });

        $(".kleo-page").on('click', function(e) {

            if ($(e.target).hasClass("open-sidebar") || $(e.target).closest(".open-sidebar").length > 0 ) {
                return;
            }

            $('body').removeClass('offcanvas-open');
            $('.offcanvas-sidebar').removeClass('is-open');
        });
    },

    scrollTo: function() {
        $('.kleo-main-header .nav > li a[href^="#"], .kleo-scroll-to').on('click', function(event) {

            var target = '';
            var speed = 1000;
            if ($(this).attr('data-speed') && $(this).data('speed') != '') {
                speed = $(this).data('speed');
            }

            if ($(this).is("a")) {
                 target = kleoHeader.getRelatedContent(this);
            } else {
                target = kleoHeader.getRelatedContent($(this).find('a[href^="#"]'));
            }

            var topHeight = 0;

            if ($("body").hasClass("kleo-navbar-fixed")) {
                topHeight += kleoHeader.initialSize;

                if ($("body").hasClass("navbar-resize")) {
                    topHeight = topHeight / 2 ;
                }
            }

            if ($("#wpadminbar").length) {
                topHeight += $("#wpadminbar").height();
            }

            if( target.length ) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - topHeight
                }, speed);
            }
        });
        if ( kleoHeader.getRelatedNavigation(this) ) {
            $('section')
                .waypoint(function (direction) {
                    // Highlight element when related content
                    // is 10% percent from the bottom...
                    // remove if below
                    kleoHeader.getRelatedNavigation(this).parents('li').toggleClass('active', direction === 'down');
                }, {
                    offset: 150 //
                })
                .waypoint(function (direction) {
                    // Highlight element when bottom of related content
                    // is 100px from the top - remove if less
                    kleoHeader.getRelatedNavigation(this).parents('li').toggleClass('active', direction === 'up');
                }, {
                    offset: function () {
                        return -$(this).height() + 100;
                    }
                });
        }
    },
    /* Get section or article by href */
    getRelatedContent: function(el){
        return $($(el).attr('href'));
    },
    /* Get link by section or article id */
    getRelatedNavigation: function(el){
        if ($(el).attr('id')) {
            return $('.kleo-main-header .nav > li a[href=#' + $(el).attr('id') + ']');
        } else {
            return false;
        }
    },


    initialLineHeight: function() {
		kleoHeader.elements.css({
			'lineHeight': kleoHeader.initialSize + 'px'
		});
        kleoHeader.elements.filter(':first').css({'height' :  kleoHeader.initialSize + 'px'});

        if (kleoFramework.retinaLogo != '') {
            kleoHeader.loadLogoImg();
            $(kleoHeader.logoImg).imagesLoaded( function () {
                kleoHeader.logo.css({'maxHeight': kleoHeader.logoSize + 'px'});
            }, false);
        }
	},

	/* Decreases header size when user scrolls down */
	resizeLogo: function(scrollPoint) {

        if (kleoIsotope.viewport().width < 992) {
            kleoHeader.initialLineHeight();
            return;
        }

        if (typeof scrollPoint === 'undefined' || typeof scrollPoint === 'object') {
            scrollPoint = parseInt(kleoHeader.initialPos);
        }

        kleoHeader.elements = $('.navbar-header, .kleo-main-header .navbar-collapse > ul > li > a, .header-banner');
        var st = $window.scrollTop(), newH = 0, minHeight = kleoHeader.initialSize /2;
        if(st > scrollPoint) {

            if(st < (scrollPoint + kleoHeader.initialSize /2))
            {
                newH = kleoHeader.initialSize - st + scrollPoint;
                kleoHeader.header.removeClass('header-scrolled');
                $('.btn-buy').removeClass('btn-default');
            }
            else
            {
                newH = kleoHeader.initialSize /2;
                kleoHeader.header.addClass('header-scrolled');
                $('.btn-buy').addClass('btn-default');
            }
            if (newH < minHeight) {
                newH = minHeight;
            }

            kleoHeader.elements.css({
                'lineHeight': newH + 'px'
            });
            kleoHeader.elements.filter(':first').css({'height' :  newH + 'px'});

            if (kleoFramework.retinaLogo != '') {
                kleoHeader.logo.css({'maxHeight': (newH / kleoHeader.initialSize * kleoHeader.logoSize) + 'px'});
            }

        } else {

            newH = kleoHeader.initialSize;
            kleoHeader.elements.filter(':first').css({'height' :  newH + 'px'});

            if (kleoFramework.retinaLogo != '') {
                kleoHeader.logo.css({'maxHeight': kleoHeader.logoSize + 'px'});
            }

            kleoHeader.elements.css({
                'lineHeight': newH + 'px'
            });
            $('.btn-buy').removeClass('btn-default');
            kleoHeader.header.removeClass('header-scrolled');

        }
	},
	
	enable_sticky: function() {
		$(".kleo-main-header").sticky({topSpacing:kleoHeader.spacing});
	},

    updateLogoSize: function(size) {
        if (size < kleoHeader.initialSize) {
            kleoHeader.logoSize = size;
        } else {
            kleoHeader.logoSize = kleoHeader.initialSize;
        }
    },
	
	enableRetinaLogo: function() {
		if ($("#logo_img").length && window.devicePixelRatio > 1 && kleoFramework.retinaLogo != '') {
            var image = $("#logo_img"),
                imageName = kleoFramework.retinaLogo,
                imageHeight;

            kleoHeader.loadLogoImg();
            $(kleoHeader.logoImg).imagesLoaded( function() {

                //rename image
                image.attr('src', imageName);

                imageHeight = kleoHeader.logoSize;

                if ($(".kleo-main-header").hasClass("header-scrolled")) {
                    imageHeight = imageHeight / 2;
                }

                image.css({"max-height": imageHeight + "px"});

                //add specific class
                image.closest('.logo').addClass('retina-logo');
            }, false);

		}
	},
	
	/* Top Social Bar -  Small slide effect for social icons  */
	topSocialExpander: function(){
		
		$("#top-social li a").hover(function() {
			if ( !$("#top-social .tabdrop").length || $("#top-social .tabdrop").hasClass("hide")) {
				var tsTextWidth = $(this).children('.ts-text').outerWidth() + 52;
				$(this).stop().animate({width: tsTextWidth}, 250, '');
			}
		}, function() {
			if ( $("#top-social .tabdrop").length || $("#top-social .tabdrop").hasClass("hide")) {
				$(this).stop().animate({width: 33}, 250, '');
			}
		});

	},
	
	toggleAjaxSearch: function() {
        $('.search-trigger').click(function() {
            if ($('#ajax_search_container').hasClass('searchHidden'))
            {
                $('#ajax_search_container').removeClass('searchHidden').addClass('show_search_pop');
                $(this).next().find(".ajax_s").focus();
            }
            return false;
        });
	},
	
	doAjaxSearch: function(options)
	{
        var defaults = {
            delay: 350,                //delay in ms for typing
            minChars: 3,               //no. of characters after we start the search
            scope: 'body'
        }

        this.options = $.extend({}, defaults, options);
        this.scope   = $(this.options.scope);
        this.body = $("body");
        this.timer   = false;
        this.doingSearch = false;
        this.lastVal = "";
        this.request = "";
        this.bind_ev = function() {
            this.scope.on('keyup', '.ajax_s' , $.proxy( this.test_search, this));
            this.body.on('mousedown', $.proxy( this.hide_search, this) );

            /* Show the results on input click */
            $(".ajax_s").on('click focus', function() {
                var res = $(this).closest(".kleo-search-form").find(".kleo_ajax_results");

                if ( ! res.is(":empty") && $.trim($(this).val()) != '' ) {
                    res.slideDown('slow');
                }
                res.css("opacity", "1");
                $(this).css("opacity", "1");
            } );

            /* Hide the results on outside click */
            this.body.on('mousedown', function(e) {
                var element = $(e.target);
                if(!element.is('.kleo_ajax_results, .ajax_s') && element.closest('.kleo_ajax_results').length == 0) {
                    $(".kleo-search-form .kleo_ajax_results").css("opacity", "0.5").slideUp('slow');
                    $(".kleo-search-form .ajax_s").css("opacity", "0.5");
                }
            } );

        };
        this.test_search = function(e) {
            clearTimeout(this.timer);
            if( $.trim(e.currentTarget.value) == '' || $.trim(e.currentTarget.value.length) >= this.options.minChars)
            {
                this.timer = setTimeout($.proxy( this.search, this, e), this.options.delay);
            }
        };
        this.hide_search = function(e) {
            var element = $(e.target);
            if(!element.is('#ajax_search_container') && element.parents('#ajax_search_container').length == 0) {
                $('#ajax_search_container').addClass('searchHidden').removeClass('show_search_pop');
            }
        };
        this.search = function(e) {
            var element = e.currentTarget;

            var $this = this,
                form        = $(element).closest("form"),
                wrap        = $(element).closest(".kleo-search-wrap"),
                results     = wrap.find(".kleo_ajax_results"),
                loading     = wrap.find(".kleo-ajax-search-loading"),
                values      = form.serialize();

            values += "&action=kleo_ajax_search";

            if ( form.data('context') ) {
                values += "&context="+form.data('context');
            }

            //if it is not ajax search, bail out
            if ( ! results.length ) {
                return;
            }

            //if it is another search in place
            if( $this.doingSearch === true ) {
                //return;
                this.request.abort();
            }

            //if current valuer matches last search value
            if( this.lastVal == $.trim(element.value) ) {
                results.slideDown();
                return;
            }

            //if current value is blank
            if ($.trim(element.value)  == '') {
                results.slideUp('fast');
                return;
            }


            this.lastVal = $.trim(element.value);

            this.request = $.ajax({
                url: kleoFramework.ajaxurl,
                type: "POST",
                data:values,
                beforeSend: function()
                {
                    loading.css('display', 'inline-block');
                    //results.slideUp();
                    $this.doingSearch = true;
                },
                success: function(response)
                {
                    if(response == 0) { response = ""; };
                    if(results.is(":empty")) {
                        results.hide().html(response).slideDown('slow');
                    } else {
                        results.html(response).slideDown('slow');
                    }
                },
                complete: function()
                {
                    /*$("#kleo_ajaxsearch").html(icon);*/
                    loading.css('display', 'none');
                    $this.doingSearch = false;
                    clearTimeout($this.timer);
                }
            });
        };

        //do search...
        this.bind_ev();
	},
  
	dropdownToggle: function() {

		$(".navbar").on("mouseenter", ".kleo-toggle-menu", function() {
            clearTimeout($(this).data('timeout'));
            $('.kleo-toggle-submenu').fadeOut(50);

			$(this).find('.kleo-toggle-submenu').fadeIn(50);

		});
		$(".navbar").on("mouseleave", ".kleo-toggle-menu", function() {
            var $this = $(this);
            var t = setTimeout(function() {
                $this.find('.kleo-toggle-submenu').fadeOut(50);
            }, 400);
            $(this).attr('data-timeout', t);
		});
		
	}
};


/***************************************************
 Parallax
***************************************************/
var parallax = {
		init: function() {

            if($window.width() > 1024) {

                $('.bg-parallax').each(function () {
                    // assigning the object
                    var $bgobj = $(this);

                    $window.scroll(function () {
                        // Scroll the background at var speed
                        // the yPos is a negative value because we're scrolling it UP!
                        var yPos = -(($window.scrollTop() - $bgobj.offset().top) / ($bgobj.data('prlx-speed') * 100 ) );

                        // Put together our final background position
                        var coords = '50% ' + yPos + 'px';

                        // Move the background
                        $bgobj.css({backgroundPosition: coords});
                    });
                    // window scroll Ends
                });

                parallax.changeSizes();
            }
		},
		
		changeSizes: function() {

            // Wait until the video meta data has loaded
            $('.bg-full-video video').on('loadedmetadata', function() {

                var adjSize, $width, $height, // Width and height of screen
                    $this = $(this),
                    $content = $this.closest(".bg-full-video").find(".section-container"),
                    $vidwidth = this.videoWidth, // Width of video (actual width)
                    $vidheight = this.videoHeight, // Height of video (actual height)
                    $aspectRatio = $vidwidth / $vidheight; // The ratio the video's height and width are in

                (adjSize = function() { // Create function called adjSize

                    var $width = $content.width(); // Width of the screen
                    var $height = $content.height(); // Height of the screen

                    var $boxRatio = $width / $height; // The ratio the screen is in

                    var $adjRatio = $aspectRatio / $boxRatio; // The ratio of the video divided by the screen size

                    if($boxRatio < $aspectRatio) { // If the screen ratio is less than the aspect ratio..
                        // Set the width of the video to the screen size multiplied by $adjRatio
                        $this.css({'width' : $width*$adjRatio+'px'});
                    } else {
                        // Else just set the video to the width of the screen/container
                        $this.css({'width' : $width+'px'});
                    }

                })(); // Run function immediately

                // Run function also on window resize.
                $window.on("debouncedresize", adjSize);

            });


		}
};


/***************************************************
 Quick Contact Form
***************************************************/
$(".kleo-quick-contact-wrapper").click(function (event) {
    if (event.stopPropagation) {
        event.stopPropagation();
    }
    else if (window.event) {
        window.event.cancelBubble = true;
    }
});
$("html").click(function () {
    $(this).find("#kleo-quick-contact").fadeOut(300);
    $('.kleo-quick-contact-link').removeClass('quick-contact-active');
});

$('.kleo-quick-contact-link').on('click', function () {
    if (!$(this).hasClass('quick-contact-active')) {
        $('#kleo-quick-contact').fadeIn(300);
        $(this).addClass('quick-contact-active');
    } else {
        $('#kleo-quick-contact').fadeOut(300);
        $(this).removeClass('quick-contact-active');
    }
    return false;
});

$('.kleo-contact-form').submit(ajaxSubmit);
function ajaxSubmit() {
    var thiss = $(this);
    var customerForm = thiss.serialize();
    thiss.find(".kleo-contact-success").html('');
    thiss.find(".kleo-contact-loading").show();

    $.ajax({
        type: "POST",
        url: kleoFramework.ajaxurl,
        data: customerForm,
        success: function (data) {
            thiss.find(".kleo-contact-loading").hide();
            thiss.find(".kleo-contact-success").html(data);
            if (thiss.find(".mail-success").length) {
                thiss.find("input[type=text], input[type=email], textarea").val('');
            }
        },
        error: function (errorThrown) {
            alert(errorThrown);
        }
    });
    return false;

}


$.fn.kleo_enable_media = function(options) {
	var defaults = {};
	var options = $.extend(defaults, options);

	return this.each(function() {
		var el				= $(this);

		el.mediaelementplayer({
	    // if the <video width> is not specified, this is the default
			defaultVideoWidth: 480,
			// if the <video height> is not specified, this is the default
			defaultVideoHeight: 270,
			// if set, overrides <video width>
			videoWidth: -1,
			// if set, overrides <video height>
			videoHeight: -1,
			// width of audio player
			audioWidth: "100%",
			// height of audio player
			audioHeight: 30,
			// initial volume when the player starts
			startVolume: 0.8,
			// useful for <audio> player loops
			loop: false,
			// enables Flash and Silverlight to resize to content size
			enableAutosize: true,
			// the order of controls you want on the control bar (and other plugins below)
			features: ['playpause','progress','duration','volume','fullscreen'],
			// Hide controls when playing and mouse is not over the video
			alwaysShowControls: false,
			// force iPad's native controls
			iPadUseNativeControls: false,
			// force iPhone's native controls
			iPhoneUseNativeControls: false,
			// force Android's native controls
			AndroidUseNativeControls: false,
			// forces the hour marker (##:00:00)
			alwaysShowHours: false,
			// show framecount in timecode (##:00:00:00)
			showTimecodeFrameCount: false,
			// used when showTimecodeFrameCount is set to true
			framesPerSecond: 25,
			// turns keyboard support on and off for this instance
			enableKeyboard: true,
			// when this player starts, it will pause other players
			pauseOtherPlayers: true,
			// array of keyboard commands
			keyActions: [],
			/*mode: 'shim'*/
            success: function (mediaElement, domObject) {

                // add event listener
                mediaElement.addEventListener('loadedmetadata', function(e) {

                    if ($(domObject).closest(".kleo-masonry").length) {
                        kleoIsotope.applyGridIsotpe(kleoIsotope.container);
                    }
                }, false);

            }


        });
	});
};

$.fn.visible = function() {
	return this.css('visibility', 'visible');
};

$.fn.invisible = function() {
	return this.css('visibility', 'hidden');
};

$.fn.visibilityToggle = function() {
	return this.css('visibility', function(i, visibility) {
			return (visibility == 'visible') ? 'hidden' : 'visible';
	});
};

	/***************************************************
	GLOBAL VARIABLES
	***************************************************/
	var $window = jQuery(window),
		body = jQuery('body'),
		deviceAgent = navigator.userAgent.toLowerCase(),
		isMobile = deviceAgent.match(/(iphone|ipod|ipad|android|iemobile)/);
	
	
	/***************************************************
	LOAD AND READY FUNCTION
	***************************************************/
	var onReady = {
		init: function(){
			kleoPage.init();
			kleoHeader.init();
			
			parallax.init();
		
			kleoIsotope.init();
			bP.init();
			kleoShop.init();

			activate_waypoints();
			activate_shortcode_scripts();
			
			
			/* Focus search Bp directory*/
			
			$( "#buddypress div#group-dir-search input[type=text], #buddypress div#members-dir-search input[type=text]" )
					.focusin(function() {
						$( this ).closest( "form" ).css( "min-width", "90%" );
					});
			$( "#buddypress div#group-dir-search input[type=text], #buddypress div#members-dir-search input[type=text]" )
				.focusout(function() {
					$( this ).closest( "form" ).css( "min-width", "60%" );
				});


		}
	};
	
	var onLoad = {
		init: function(){

		}
	};
	
	kleoPage.notReadyInit();
	jQuery(document).ready(onReady.init);
	jQuery(window).load(onLoad.init);
	
})( jQuery );

function kleoSetCookie(cname, cvalue, path, exdays) {
    if (typeof path === 'undefined') {
        path = '/';
    }
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=" + path;
}
