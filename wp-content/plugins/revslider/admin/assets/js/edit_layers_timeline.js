
/* perfect-scrollbar v0.6.10 */
!function t(e,n,r){function o(l,s){if(!n[l]){if(!e[l]){var a="function"==typeof require&&require;if(!s&&a)return a(l,!0);if(i)return i(l,!0);var c=new Error("Cannot find module '"+l+"'");throw c.code="MODULE_NOT_FOUND",c}var u=n[l]={exports:{}};e[l][0].call(u.exports,function(t){var n=e[l][1][t];return o(n?n:t)},u,u.exports,t,e,n,r)}return n[l].exports}for(var i="function"==typeof require&&require,l=0;l<r.length;l++)o(r[l]);return o}({1:[function(t,e,n){"use strict";function r(t){t.fn.perfectScrollbar=function(e){return this.each(function(){if("object"==typeof e||"undefined"==typeof e){var n=e;i.get(this)||o.initialize(this,n)}else{var r=e;"update"===r?o.update(this):"destroy"===r&&o.destroy(this)}return t(this)})}}var o=t("../main"),i=t("../plugin/instances");if("function"==typeof define&&define.amd)define(["jquery"],r);else{var l=window.jQuery?window.jQuery:window.$;"undefined"!=typeof l&&r(l)}e.exports=r},{"../main":7,"../plugin/instances":18}],2:[function(t,e,n){"use strict";function r(t,e){var n=t.className.split(" ");n.indexOf(e)<0&&n.push(e),t.className=n.join(" ")}function o(t,e){var n=t.className.split(" "),r=n.indexOf(e);r>=0&&n.splice(r,1),t.className=n.join(" ")}n.add=function(t,e){t.classList?t.classList.add(e):r(t,e)},n.remove=function(t,e){t.classList?t.classList.remove(e):o(t,e)},n.list=function(t){return t.classList?Array.prototype.slice.apply(t.classList):t.className.split(" ")}},{}],3:[function(t,e,n){"use strict";function r(t,e){return window.getComputedStyle(t)[e]}function o(t,e,n){return"number"==typeof n&&(n=n.toString()+"px"),t.style[e]=n,t}function i(t,e){for(var n in e){var r=e[n];"number"==typeof r&&(r=r.toString()+"px"),t.style[n]=r}return t}var l={};l.e=function(t,e){var n=document.createElement(t);return n.className=e,n},l.appendTo=function(t,e){return e.appendChild(t),t},l.css=function(t,e,n){return"object"==typeof e?i(t,e):"undefined"==typeof n?r(t,e):o(t,e,n)},l.matches=function(t,e){return"undefined"!=typeof t.matches?t.matches(e):"undefined"!=typeof t.matchesSelector?t.matchesSelector(e):"undefined"!=typeof t.webkitMatchesSelector?t.webkitMatchesSelector(e):"undefined"!=typeof t.mozMatchesSelector?t.mozMatchesSelector(e):"undefined"!=typeof t.msMatchesSelector?t.msMatchesSelector(e):void 0},l.remove=function(t){"undefined"!=typeof t.remove?t.remove():t.parentNode&&t.parentNode.removeChild(t)},l.queryChildren=function(t,e){return Array.prototype.filter.call(t.childNodes,function(t){return l.matches(t,e)})},e.exports=l},{}],4:[function(t,e,n){"use strict";var r=function(t){this.element=t,this.events={}};r.prototype.bind=function(t,e){"undefined"==typeof this.events[t]&&(this.events[t]=[]),this.events[t].push(e),this.element.addEventListener(t,e,!1)},r.prototype.unbind=function(t,e){var n="undefined"!=typeof e;this.events[t]=this.events[t].filter(function(r){return n&&r!==e?!0:(this.element.removeEventListener(t,r,!1),!1)},this)},r.prototype.unbindAll=function(){for(var t in this.events)this.unbind(t)};var o=function(){this.eventElements=[]};o.prototype.eventElement=function(t){var e=this.eventElements.filter(function(e){return e.element===t})[0];return"undefined"==typeof e&&(e=new r(t),this.eventElements.push(e)),e},o.prototype.bind=function(t,e,n){this.eventElement(t).bind(e,n)},o.prototype.unbind=function(t,e,n){this.eventElement(t).unbind(e,n)},o.prototype.unbindAll=function(){for(var t=0;t<this.eventElements.length;t++)this.eventElements[t].unbindAll()},o.prototype.once=function(t,e,n){var r=this.eventElement(t),o=function(t){r.unbind(e,o),n(t)};r.bind(e,o)},e.exports=o},{}],5:[function(t,e,n){"use strict";e.exports=function(){function t(){return Math.floor(65536*(1+Math.random())).toString(16).substring(1)}return function(){return t()+t()+"-"+t()+"-"+t()+"-"+t()+"-"+t()+t()+t()}}()},{}],6:[function(t,e,n){"use strict";var r=t("./class"),o=t("./dom");n.toInt=function(t){return parseInt(t,10)||0},n.clone=function(t){if(null===t)return null;if("object"==typeof t){var e={};for(var n in t)e[n]=this.clone(t[n]);return e}return t},n.extend=function(t,e){var n=this.clone(t);for(var r in e)n[r]=this.clone(e[r]);return n},n.isEditable=function(t){return o.matches(t,"input,[contenteditable]")||o.matches(t,"select,[contenteditable]")||o.matches(t,"textarea,[contenteditable]")||o.matches(t,"button,[contenteditable]")},n.removePsClasses=function(t){for(var e=r.list(t),n=0;n<e.length;n++){var o=e[n];0===o.indexOf("ps-")&&r.remove(t,o)}},n.outerWidth=function(t){return this.toInt(o.css(t,"width"))+this.toInt(o.css(t,"paddingLeft"))+this.toInt(o.css(t,"paddingRight"))+this.toInt(o.css(t,"borderLeftWidth"))+this.toInt(o.css(t,"borderRightWidth"))},n.startScrolling=function(t,e){r.add(t,"ps-in-scrolling"),"undefined"!=typeof e?r.add(t,"ps-"+e):(r.add(t,"ps-x"),r.add(t,"ps-y"))},n.stopScrolling=function(t,e){r.remove(t,"ps-in-scrolling"),"undefined"!=typeof e?r.remove(t,"ps-"+e):(r.remove(t,"ps-x"),r.remove(t,"ps-y"))},n.env={isWebKit:"WebkitAppearance"in document.documentElement.style,supportsTouch:"ontouchstart"in window||window.DocumentTouch&&document instanceof window.DocumentTouch,supportsIePointer:null!==window.navigator.msMaxTouchPoints}},{"./class":2,"./dom":3}],7:[function(t,e,n){"use strict";var r=t("./plugin/destroy"),o=t("./plugin/initialize"),i=t("./plugin/update");e.exports={initialize:o,update:i,destroy:r}},{"./plugin/destroy":9,"./plugin/initialize":17,"./plugin/update":21}],8:[function(t,e,n){"use strict";e.exports={maxScrollbarLength:null,minScrollbarLength:null,scrollXMarginOffset:0,scrollYMarginOffset:0,stopPropagationOnClick:!0,suppressScrollX:!1,suppressScrollY:!1,swipePropagation:!0,useBothWheelAxes:!1,useKeyboard:!0,useSelectionScroll:!1,wheelPropagation:!1,wheelSpeed:1,theme:"default"}},{}],9:[function(t,e,n){"use strict";var r=t("../lib/dom"),o=t("../lib/helper"),i=t("./instances");e.exports=function(t){var e=i.get(t);e&&(e.event.unbindAll(),r.remove(e.scrollbarX),r.remove(e.scrollbarY),r.remove(e.scrollbarXRail),r.remove(e.scrollbarYRail),o.removePsClasses(t),i.remove(t))}},{"../lib/dom":3,"../lib/helper":6,"./instances":18}],10:[function(t,e,n){"use strict";function r(t,e){function n(t){return t.getBoundingClientRect()}var r=window.Event.prototype.stopPropagation.bind;e.settings.stopPropagationOnClick&&e.event.bind(e.scrollbarY,"click",r),e.event.bind(e.scrollbarYRail,"click",function(r){var i=o.toInt(e.scrollbarYHeight/2),a=e.railYRatio*(r.pageY-window.pageYOffset-n(e.scrollbarYRail).top-i),c=e.railYRatio*(e.railYHeight-e.scrollbarYHeight),u=a/c;0>u?u=0:u>1&&(u=1),s(t,"top",(e.contentHeight-e.containerHeight)*u),l(t),r.stopPropagation()}),e.settings.stopPropagationOnClick&&e.event.bind(e.scrollbarX,"click",r),e.event.bind(e.scrollbarXRail,"click",function(r){var i=o.toInt(e.scrollbarXWidth/2),a=e.railXRatio*(r.pageX-window.pageXOffset-n(e.scrollbarXRail).left-i),c=e.railXRatio*(e.railXWidth-e.scrollbarXWidth),u=a/c;0>u?u=0:u>1&&(u=1),s(t,"left",(e.contentWidth-e.containerWidth)*u-e.negativeScrollAdjustment),l(t),r.stopPropagation()})}var o=t("../../lib/helper"),i=t("../instances"),l=t("../update-geometry"),s=t("../update-scroll");e.exports=function(t){var e=i.get(t);r(t,e)}},{"../../lib/helper":6,"../instances":18,"../update-geometry":19,"../update-scroll":20}],11:[function(t,e,n){"use strict";function r(t,e){function n(n){var o=r+n*e.railXRatio,i=Math.max(0,e.scrollbarXRail.getBoundingClientRect().left)+e.railXRatio*(e.railXWidth-e.scrollbarXWidth);0>o?e.scrollbarXLeft=0:o>i?e.scrollbarXLeft=i:e.scrollbarXLeft=o;var s=l.toInt(e.scrollbarXLeft*(e.contentWidth-e.containerWidth)/(e.containerWidth-e.railXRatio*e.scrollbarXWidth))-e.negativeScrollAdjustment;c(t,"left",s)}var r=null,o=null,s=function(e){n(e.pageX-o),a(t),e.stopPropagation(),e.preventDefault()},u=function(){l.stopScrolling(t,"x"),e.event.unbind(e.ownerDocument,"mousemove",s)};e.event.bind(e.scrollbarX,"mousedown",function(n){o=n.pageX,r=l.toInt(i.css(e.scrollbarX,"left"))*e.railXRatio,l.startScrolling(t,"x"),e.event.bind(e.ownerDocument,"mousemove",s),e.event.once(e.ownerDocument,"mouseup",u),n.stopPropagation(),n.preventDefault()})}function o(t,e){function n(n){var o=r+n*e.railYRatio,i=Math.max(0,e.scrollbarYRail.getBoundingClientRect().top)+e.railYRatio*(e.railYHeight-e.scrollbarYHeight);0>o?e.scrollbarYTop=0:o>i?e.scrollbarYTop=i:e.scrollbarYTop=o;var s=l.toInt(e.scrollbarYTop*(e.contentHeight-e.containerHeight)/(e.containerHeight-e.railYRatio*e.scrollbarYHeight));c(t,"top",s)}var r=null,o=null,s=function(e){n(e.pageY-o),a(t),e.stopPropagation(),e.preventDefault()},u=function(){l.stopScrolling(t,"y"),e.event.unbind(e.ownerDocument,"mousemove",s)};e.event.bind(e.scrollbarY,"mousedown",function(n){o=n.pageY,r=l.toInt(i.css(e.scrollbarY,"top"))*e.railYRatio,l.startScrolling(t,"y"),e.event.bind(e.ownerDocument,"mousemove",s),e.event.once(e.ownerDocument,"mouseup",u),n.stopPropagation(),n.preventDefault()})}var i=t("../../lib/dom"),l=t("../../lib/helper"),s=t("../instances"),a=t("../update-geometry"),c=t("../update-scroll");e.exports=function(t){var e=s.get(t);r(t,e),o(t,e)}},{"../../lib/dom":3,"../../lib/helper":6,"../instances":18,"../update-geometry":19,"../update-scroll":20}],12:[function(t,e,n){"use strict";function r(t,e){function n(n,r){var o=t.scrollTop;if(0===n){if(!e.scrollbarYActive)return!1;if(0===o&&r>0||o>=e.contentHeight-e.containerHeight&&0>r)return!e.settings.wheelPropagation}var i=t.scrollLeft;if(0===r){if(!e.scrollbarXActive)return!1;if(0===i&&0>n||i>=e.contentWidth-e.containerWidth&&n>0)return!e.settings.wheelPropagation}return!0}var r=!1;e.event.bind(t,"mouseenter",function(){r=!0}),e.event.bind(t,"mouseleave",function(){r=!1});var l=!1;e.event.bind(e.ownerDocument,"keydown",function(c){if(!c.isDefaultPrevented||!c.isDefaultPrevented()){var u=i.matches(e.scrollbarX,":focus")||i.matches(e.scrollbarY,":focus");if(r||u){var d=document.activeElement?document.activeElement:e.ownerDocument.activeElement;if(d){for(;d.shadowRoot;)d=d.shadowRoot.activeElement;if(o.isEditable(d))return}var p=0,f=0;switch(c.which){case 37:p=-30;break;case 38:f=30;break;case 39:p=30;break;case 40:f=-30;break;case 33:f=90;break;case 32:f=c.shiftKey?90:-90;break;case 34:f=-90;break;case 35:f=c.ctrlKey?-e.contentHeight:-e.containerHeight;break;case 36:f=c.ctrlKey?t.scrollTop:e.containerHeight;break;default:return}a(t,"top",t.scrollTop-f),a(t,"left",t.scrollLeft+p),s(t),l=n(p,f),l&&c.preventDefault()}}})}var o=t("../../lib/helper"),i=t("../../lib/dom"),l=t("../instances"),s=t("../update-geometry"),a=t("../update-scroll");e.exports=function(t){var e=l.get(t);r(t,e)}},{"../../lib/dom":3,"../../lib/helper":6,"../instances":18,"../update-geometry":19,"../update-scroll":20}],13:[function(t,e,n){"use strict";function r(t,e){function n(n,r){var o=t.scrollTop;if(0===n){if(!e.scrollbarYActive)return!1;if(0===o&&r>0||o>=e.contentHeight-e.containerHeight&&0>r)return!e.settings.wheelPropagation}var i=t.scrollLeft;if(0===r){if(!e.scrollbarXActive)return!1;if(0===i&&0>n||i>=e.contentWidth-e.containerWidth&&n>0)return!e.settings.wheelPropagation}return!0}function r(t){var e=t.deltaX,n=-1*t.deltaY;return("undefined"==typeof e||"undefined"==typeof n)&&(e=-1*t.wheelDeltaX/6,n=t.wheelDeltaY/6),t.deltaMode&&1===t.deltaMode&&(e*=10,n*=10),e!==e&&n!==n&&(e=0,n=t.wheelDelta),[e,n]}function o(e,n){var r=t.querySelector("textarea:hover");if(r){var o=r.scrollHeight-r.clientHeight;if(o>0&&!(0===r.scrollTop&&n>0||r.scrollTop===o&&0>n))return!0;var i=r.scrollLeft-r.clientWidth;if(i>0&&!(0===r.scrollLeft&&0>e||r.scrollLeft===i&&e>0))return!0}return!1}function s(s){var c=r(s),u=c[0],d=c[1];o(u,d)||(a=!1,e.settings.useBothWheelAxes?e.scrollbarYActive&&!e.scrollbarXActive?(d?l(t,"top",t.scrollTop-d*e.settings.wheelSpeed):l(t,"top",t.scrollTop+u*e.settings.wheelSpeed),a=!0):e.scrollbarXActive&&!e.scrollbarYActive&&(u?l(t,"left",t.scrollLeft+u*e.settings.wheelSpeed):l(t,"left",t.scrollLeft-d*e.settings.wheelSpeed),a=!0):(l(t,"top",t.scrollTop-d*e.settings.wheelSpeed),l(t,"left",t.scrollLeft+u*e.settings.wheelSpeed)),i(t),a=a||n(u,d),a&&(s.stopPropagation(),s.preventDefault()))}var a=!1;"undefined"!=typeof window.onwheel?e.event.bind(t,"wheel",s):"undefined"!=typeof window.onmousewheel&&e.event.bind(t,"mousewheel",s)}var o=t("../instances"),i=t("../update-geometry"),l=t("../update-scroll");e.exports=function(t){var e=o.get(t);r(t,e)}},{"../instances":18,"../update-geometry":19,"../update-scroll":20}],14:[function(t,e,n){"use strict";function r(t,e){e.event.bind(t,"scroll",function(){i(t)})}var o=t("../instances"),i=t("../update-geometry");e.exports=function(t){var e=o.get(t);r(t,e)}},{"../instances":18,"../update-geometry":19}],15:[function(t,e,n){"use strict";function r(t,e){function n(){var t=window.getSelection?window.getSelection():document.getSelection?document.getSelection():"";return 0===t.toString().length?null:t.getRangeAt(0).commonAncestorContainer}function r(){c||(c=setInterval(function(){return i.get(t)?(s(t,"top",t.scrollTop+u.top),s(t,"left",t.scrollLeft+u.left),void l(t)):void clearInterval(c)},50))}function a(){c&&(clearInterval(c),c=null),o.stopScrolling(t)}var c=null,u={top:0,left:0},d=!1;e.event.bind(e.ownerDocument,"selectionchange",function(){t.contains(n())?d=!0:(d=!1,a())}),e.event.bind(window,"mouseup",function(){d&&(d=!1,a())}),e.event.bind(window,"mousemove",function(e){if(d){var n={x:e.pageX,y:e.pageY},i={left:t.offsetLeft,right:t.offsetLeft+t.offsetWidth,top:t.offsetTop,bottom:t.offsetTop+t.offsetHeight};n.x<i.left+3?(u.left=-5,o.startScrolling(t,"x")):n.x>i.right-3?(u.left=5,o.startScrolling(t,"x")):u.left=0,n.y<i.top+3?(i.top+3-n.y<5?u.top=-5:u.top=-20,o.startScrolling(t,"y")):n.y>i.bottom-3?(n.y-i.bottom+3<5?u.top=5:u.top=20,o.startScrolling(t,"y")):u.top=0,0===u.top&&0===u.left?a():r()}})}var o=t("../../lib/helper"),i=t("../instances"),l=t("../update-geometry"),s=t("../update-scroll");e.exports=function(t){var e=i.get(t);r(t,e)}},{"../../lib/helper":6,"../instances":18,"../update-geometry":19,"../update-scroll":20}],16:[function(t,e,n){"use strict";function r(t,e,n,r){function s(n,r){var o=t.scrollTop,i=t.scrollLeft,l=Math.abs(n),s=Math.abs(r);if(s>l){if(0>r&&o===e.contentHeight-e.containerHeight||r>0&&0===o)return!e.settings.swipePropagation}else if(l>s&&(0>n&&i===e.contentWidth-e.containerWidth||n>0&&0===i))return!e.settings.swipePropagation;return!0}function a(e,n){l(t,"top",t.scrollTop-n),l(t,"left",t.scrollLeft-e),i(t)}function c(){Y=!0}function u(){Y=!1}function d(t){return t.targetTouches?t.targetTouches[0]:t}function p(t){return t.targetTouches&&1===t.targetTouches.length?!0:t.pointerType&&"mouse"!==t.pointerType&&t.pointerType!==t.MSPOINTER_TYPE_MOUSE?!0:!1}function f(t){if(p(t)){w=!0;var e=d(t);v.pageX=e.pageX,v.pageY=e.pageY,g=(new Date).getTime(),null!==y&&clearInterval(y),t.stopPropagation()}}function h(t){if(!Y&&w&&p(t)){var e=d(t),n={pageX:e.pageX,pageY:e.pageY},r=n.pageX-v.pageX,o=n.pageY-v.pageY;a(r,o),v=n;var i=(new Date).getTime(),l=i-g;l>0&&(m.x=r/l,m.y=o/l,g=i),s(r,o)&&(t.stopPropagation(),t.preventDefault())}}function b(){!Y&&w&&(w=!1,clearInterval(y),y=setInterval(function(){return o.get(t)?Math.abs(m.x)<.01&&Math.abs(m.y)<.01?void clearInterval(y):(a(30*m.x,30*m.y),m.x*=.8,void(m.y*=.8)):void clearInterval(y)},10))}var v={},g=0,m={},y=null,Y=!1,w=!1;n&&(e.event.bind(window,"touchstart",c),e.event.bind(window,"touchend",u),e.event.bind(t,"touchstart",f),e.event.bind(t,"touchmove",h),e.event.bind(t,"touchend",b)),r&&(window.PointerEvent?(e.event.bind(window,"pointerdown",c),e.event.bind(window,"pointerup",u),e.event.bind(t,"pointerdown",f),e.event.bind(t,"pointermove",h),e.event.bind(t,"pointerup",b)):window.MSPointerEvent&&(e.event.bind(window,"MSPointerDown",c),e.event.bind(window,"MSPointerUp",u),e.event.bind(t,"MSPointerDown",f),e.event.bind(t,"MSPointerMove",h),e.event.bind(t,"MSPointerUp",b)))}var o=t("../instances"),i=t("../update-geometry"),l=t("../update-scroll");e.exports=function(t,e,n){var i=o.get(t);r(t,i,e,n)}},{"../instances":18,"../update-geometry":19,"../update-scroll":20}],17:[function(t,e,n){"use strict";var r=t("../lib/class"),o=t("../lib/helper"),i=t("./instances"),l=t("./update-geometry"),s=t("./handler/click-rail"),a=t("./handler/drag-scrollbar"),c=t("./handler/keyboard"),u=t("./handler/mouse-wheel"),d=t("./handler/native-scroll"),p=t("./handler/selection"),f=t("./handler/touch");e.exports=function(t,e){e="object"==typeof e?e:{},r.add(t,"ps-container");var n=i.add(t);n.settings=o.extend(n.settings,e),r.add(t,"ps-theme-"+n.settings.theme),s(t),a(t),u(t),d(t),n.settings.useSelectionScroll&&p(t),(o.env.supportsTouch||o.env.supportsIePointer)&&f(t,o.env.supportsTouch,o.env.supportsIePointer),n.settings.useKeyboard&&c(t),l(t)}},{"../lib/class":2,"../lib/helper":6,"./handler/click-rail":10,"./handler/drag-scrollbar":11,"./handler/keyboard":12,"./handler/mouse-wheel":13,"./handler/native-scroll":14,"./handler/selection":15,"./handler/touch":16,"./instances":18,"./update-geometry":19}],18:[function(t,e,n){"use strict";function r(t){function e(){s.add(t,"ps-focus")}function n(){s.remove(t,"ps-focus")}var r=this;r.settings=p.clone(c),r.containerWidth=null,r.containerHeight=null,r.contentWidth=null,r.contentHeight=null,r.isRtl="rtl"===a.css(t,"direction"),r.isNegativeScroll=function(){var e=t.scrollLeft,n=null;return t.scrollLeft=-1,n=t.scrollLeft<0,t.scrollLeft=e,n}(),r.negativeScrollAdjustment=r.isNegativeScroll?t.scrollWidth-t.clientWidth:0,r.event=new u,r.ownerDocument=t.ownerDocument||document,r.scrollbarXRail=a.appendTo(a.e("div","ps-scrollbar-x-rail"),t),r.scrollbarX=a.appendTo(a.e("div","ps-scrollbar-x"),r.scrollbarXRail),r.scrollbarX.setAttribute("tabindex",0),r.event.bind(r.scrollbarX,"focus",e),r.event.bind(r.scrollbarX,"blur",n),r.scrollbarXActive=null,r.scrollbarXWidth=null,r.scrollbarXLeft=null,r.scrollbarXBottom=p.toInt(a.css(r.scrollbarXRail,"bottom")),r.isScrollbarXUsingBottom=r.scrollbarXBottom===r.scrollbarXBottom,r.scrollbarXTop=r.isScrollbarXUsingBottom?null:p.toInt(a.css(r.scrollbarXRail,"top")),r.railBorderXWidth=p.toInt(a.css(r.scrollbarXRail,"borderLeftWidth"))+p.toInt(a.css(r.scrollbarXRail,"borderRightWidth")),a.css(r.scrollbarXRail,"display","block"),r.railXMarginWidth=p.toInt(a.css(r.scrollbarXRail,"marginLeft"))+p.toInt(a.css(r.scrollbarXRail,"marginRight")),a.css(r.scrollbarXRail,"display",""),r.railXWidth=null,r.railXRatio=null,r.scrollbarYRail=a.appendTo(a.e("div","ps-scrollbar-y-rail"),t),r.scrollbarY=a.appendTo(a.e("div","ps-scrollbar-y"),r.scrollbarYRail),r.scrollbarY.setAttribute("tabindex",0),r.event.bind(r.scrollbarY,"focus",e),r.event.bind(r.scrollbarY,"blur",n),r.scrollbarYActive=null,r.scrollbarYHeight=null,r.scrollbarYTop=null,r.scrollbarYRight=p.toInt(a.css(r.scrollbarYRail,"right")),r.isScrollbarYUsingRight=r.scrollbarYRight===r.scrollbarYRight,r.scrollbarYLeft=r.isScrollbarYUsingRight?null:p.toInt(a.css(r.scrollbarYRail,"left")),r.scrollbarYOuterWidth=r.isRtl?p.outerWidth(r.scrollbarY):null,r.railBorderYWidth=p.toInt(a.css(r.scrollbarYRail,"borderTopWidth"))+p.toInt(a.css(r.scrollbarYRail,"borderBottomWidth")),a.css(r.scrollbarYRail,"display","block"),r.railYMarginHeight=p.toInt(a.css(r.scrollbarYRail,"marginTop"))+p.toInt(a.css(r.scrollbarYRail,"marginBottom")),a.css(r.scrollbarYRail,"display",""),r.railYHeight=null,r.railYRatio=null}function o(t){return"undefined"==typeof t.dataset?t.getAttribute("data-ps-id"):t.dataset.psId}function i(t,e){"undefined"==typeof t.dataset?t.setAttribute("data-ps-id",e):t.dataset.psId=e}function l(t){"undefined"==typeof t.dataset?t.removeAttribute("data-ps-id"):delete t.dataset.psId}var s=t("../lib/class"),a=t("../lib/dom"),c=t("./default-setting"),u=t("../lib/event-manager"),d=t("../lib/guid"),p=t("../lib/helper"),f={};n.add=function(t){var e=d();return i(t,e),f[e]=new r(t),f[e]},n.remove=function(t){delete f[o(t)],l(t)},n.get=function(t){return f[o(t)]}},{"../lib/class":2,"../lib/dom":3,"../lib/event-manager":4,"../lib/guid":5,"../lib/helper":6,"./default-setting":8}],19:[function(t,e,n){"use strict";function r(t,e){return t.settings.minScrollbarLength&&(e=Math.max(e,t.settings.minScrollbarLength)),t.settings.maxScrollbarLength&&(e=Math.min(e,t.settings.maxScrollbarLength)),e}function o(t,e){var n={width:e.railXWidth};e.isRtl?n.left=e.negativeScrollAdjustment+t.scrollLeft+e.containerWidth-e.contentWidth:n.left=t.scrollLeft,e.isScrollbarXUsingBottom?n.bottom=e.scrollbarXBottom-t.scrollTop:n.top=e.scrollbarXTop+t.scrollTop,l.css(e.scrollbarXRail,n);var r={top:t.scrollTop,height:e.railYHeight};e.isScrollbarYUsingRight?e.isRtl?r.right=e.contentWidth-(e.negativeScrollAdjustment+t.scrollLeft)-e.scrollbarYRight-e.scrollbarYOuterWidth:r.right=e.scrollbarYRight-t.scrollLeft:e.isRtl?r.left=e.negativeScrollAdjustment+t.scrollLeft+2*e.containerWidth-e.contentWidth-e.scrollbarYLeft-e.scrollbarYOuterWidth:r.left=e.scrollbarYLeft+t.scrollLeft,l.css(e.scrollbarYRail,r),l.css(e.scrollbarX,{left:e.scrollbarXLeft,width:e.scrollbarXWidth-e.railBorderXWidth}),l.css(e.scrollbarY,{top:e.scrollbarYTop,height:e.scrollbarYHeight-e.railBorderYWidth})}var i=t("../lib/class"),l=t("../lib/dom"),s=t("../lib/helper"),a=t("./instances"),c=t("./update-scroll");e.exports=function(t){var e=a.get(t);e.containerWidth=t.clientWidth,e.containerHeight=t.clientHeight,e.contentWidth=t.scrollWidth,e.contentHeight=t.scrollHeight;var n;t.contains(e.scrollbarXRail)||(n=l.queryChildren(t,".ps-scrollbar-x-rail"),n.length>0&&n.forEach(function(t){l.remove(t)}),l.appendTo(e.scrollbarXRail,t)),t.contains(e.scrollbarYRail)||(n=l.queryChildren(t,".ps-scrollbar-y-rail"),n.length>0&&n.forEach(function(t){l.remove(t)}),l.appendTo(e.scrollbarYRail,t)),!e.settings.suppressScrollX&&e.containerWidth+e.settings.scrollXMarginOffset<e.contentWidth?(e.scrollbarXActive=!0,e.railXWidth=e.containerWidth-e.railXMarginWidth,e.railXRatio=e.containerWidth/e.railXWidth,e.scrollbarXWidth=r(e,s.toInt(e.railXWidth*e.containerWidth/e.contentWidth)),e.scrollbarXLeft=s.toInt((e.negativeScrollAdjustment+t.scrollLeft)*(e.railXWidth-e.scrollbarXWidth)/(e.contentWidth-e.containerWidth))):e.scrollbarXActive=!1,!e.settings.suppressScrollY&&e.containerHeight+e.settings.scrollYMarginOffset<e.contentHeight?(e.scrollbarYActive=!0,e.railYHeight=e.containerHeight-e.railYMarginHeight,e.railYRatio=e.containerHeight/e.railYHeight,e.scrollbarYHeight=r(e,s.toInt(e.railYHeight*e.containerHeight/e.contentHeight)),e.scrollbarYTop=s.toInt(t.scrollTop*(e.railYHeight-e.scrollbarYHeight)/(e.contentHeight-e.containerHeight))):e.scrollbarYActive=!1,e.scrollbarXLeft>=e.railXWidth-e.scrollbarXWidth&&(e.scrollbarXLeft=e.railXWidth-e.scrollbarXWidth),e.scrollbarYTop>=e.railYHeight-e.scrollbarYHeight&&(e.scrollbarYTop=e.railYHeight-e.scrollbarYHeight),o(t,e),e.scrollbarXActive?i.add(t,"ps-active-x"):(i.remove(t,"ps-active-x"),e.scrollbarXWidth=0,e.scrollbarXLeft=0,c(t,"left",0)),e.scrollbarYActive?i.add(t,"ps-active-y"):(i.remove(t,"ps-active-y"),e.scrollbarYHeight=0,e.scrollbarYTop=0,c(t,"top",0))}},{"../lib/class":2,"../lib/dom":3,"../lib/helper":6,"./instances":18,"./update-scroll":20}],20:[function(t,e,n){"use strict";var r,o,i=t("./instances"),l=document.createEvent("Event"),s=document.createEvent("Event"),a=document.createEvent("Event"),c=document.createEvent("Event"),u=document.createEvent("Event"),d=document.createEvent("Event"),p=document.createEvent("Event"),f=document.createEvent("Event"),h=document.createEvent("Event"),b=document.createEvent("Event");l.initEvent("ps-scroll-up",!0,!0),s.initEvent("ps-scroll-down",!0,!0),a.initEvent("ps-scroll-left",!0,!0),c.initEvent("ps-scroll-right",!0,!0),u.initEvent("ps-scroll-y",!0,!0),d.initEvent("ps-scroll-x",!0,!0),p.initEvent("ps-x-reach-start",!0,!0),f.initEvent("ps-x-reach-end",!0,!0),h.initEvent("ps-y-reach-start",!0,!0),b.initEvent("ps-y-reach-end",!0,!0),e.exports=function(t,e,n){if("undefined"==typeof t)throw"You must provide an element to the update-scroll function";if("undefined"==typeof e)throw"You must provide an axis to the update-scroll function";if("undefined"==typeof n)throw"You must provide a value to the update-scroll function";"top"===e&&0>=n&&(t.scrollTop=n=0,t.dispatchEvent(h)),"left"===e&&0>=n&&(t.scrollLeft=n=0,t.dispatchEvent(p));var v=i.get(t);"top"===e&&n>=v.contentHeight-v.containerHeight&&(t.scrollTop=n=v.contentHeight-v.containerHeight,t.dispatchEvent(b)),"left"===e&&n>=v.contentWidth-v.containerWidth&&(t.scrollLeft=n=v.contentWidth-v.containerWidth,t.dispatchEvent(f)),r||(r=t.scrollTop),o||(o=t.scrollLeft),"top"===e&&r>n&&t.dispatchEvent(l),"top"===e&&n>r&&t.dispatchEvent(s),"left"===e&&o>n&&t.dispatchEvent(a),"left"===e&&n>o&&t.dispatchEvent(c),"top"===e&&(t.scrollTop=r=n,t.dispatchEvent(u)),"left"===e&&(t.scrollLeft=o=n,t.dispatchEvent(d))}},{"./instances":18}],21:[function(t,e,n){"use strict";var r=t("../lib/dom"),o=t("../lib/helper"),i=t("./instances"),l=t("./update-geometry"),s=t("./update-scroll");e.exports=function(t){var e=i.get(t);e&&(e.negativeScrollAdjustment=e.isNegativeScroll?t.scrollWidth-t.clientWidth:0,r.css(e.scrollbarXRail,"display","block"),r.css(e.scrollbarYRail,"display","block"),e.railXMarginWidth=o.toInt(r.css(e.scrollbarXRail,"marginLeft"))+o.toInt(r.css(e.scrollbarXRail,"marginRight")),e.railYMarginHeight=o.toInt(r.css(e.scrollbarYRail,"marginTop"))+o.toInt(r.css(e.scrollbarYRail,"marginBottom")),r.css(e.scrollbarXRail,"display","none"),r.css(e.scrollbarYRail,"display","none"),l(t),s(t,"top",t.scrollTop),s(t,"left",t.scrollLeft),r.css(e.scrollbarXRail,"display",""),r.css(e.scrollbarYRail,"display",""))}},{"../lib/dom":3,"../lib/helper":6,"./instances":18,"./update-geometry":19,"./update-scroll":20}]},{},[1]);

// AUDIO CONTEXT
window.AudioContext = window.AudioContext || window.webkitAudioContext ;
if (window.AudioContext) {
	var audioContext = new AudioContext(),
		audiosource = audioContext.createBufferSource(); 	// creates a sound source
} else {
	audiosource = null;
}



/*****************************************************
	-	THE  TIME LINE AND ANIMATION FUNCTIONS 	-
*****************************************************/

var tpLayerTimelinesRev = new function(){
	var t = this,
		u = new Object(),		
		sortMode = "time",
		__ctime,
		__ctimeb,
		__ctimei ,
		__coffset = 0; 

	t.mainMaxTimeLeft = 0;

	/***********************************************************
		-	INITIALISE THE TIMELINE AND ANIMATION ELEMENTS	-
	***********************************************************/

	t.init = function() {
		u = UniteLayersRev;
		g_rebuildTimer =999;
		g_slideTime = u.getMaintime();
		g_keyTimer = 0;
		
		t.mainMaxTimeLeft = jQuery('#mastertimer-maxtime').position().left;
		
		initSlideDuration();
		initSortbox();
		initMasterTimer();
		preparePeviewAnimations();
		prepareLoopAnimations();
		showHideTimeines();
		basicClicksAndHovers();
		addIconFunction();

		t.addToSortbox();
		//jQuery('.master-rightcell .layers-wrapper, .master-leftcell .layers-wrapper, #divLayers-wrapper').perfectScrollbar("update");
		
		jQuery('#slide_transition, #slot_amount, #transition_rotation').change(function() {
			
			setFakeAnim();
		});
		
		
		var timer;
		jQuery(window).resize(function() {
				clearTimeout(timer);
				timer = setTimeout(function(){
					t.resetSlideAnimations(false);
				},250);
			});
		var keyboardallowed = false;
		
		jQuery('#thelayer-editor-wrapper').hover(function() {

			keyboardallowed = true;						
						
		},function() {
			keyboardallowed = false;					
		})


		

		jQuery('.slide-trans-menu-element').each(function() {
			var b = jQuery(this);
			b.text(b.text().toLowerCase());
			b.click(function() {
				var b = jQuery(this);
				jQuery('.slide-trans-menu-element').removeClass("selected");
				b.addClass("selected");
				jQuery('.slide-trans-checkelement').hide();
				jQuery("."+b.data('reference')).show();
			});
		});

		jQuery('.slide-trans-menu-element').first().click();
		
		var createListOfTrans = function() {
			var c = jQuery('.slide-trans-cur-ul');
			for(var key in choosen_slide_transition){
				var data_string = '';
				data_string+= ' data-duration="'+transition_settings['duration'][key]+'"';
				data_string+= ' data-ease_in="'+transition_settings['ease_in'][key]+'"';
				data_string+= ' data-ease_out="'+transition_settings['ease_out'][key]+'"';
				data_string+= ' data-rotation="'+transition_settings['rotation'][key]+'"';
				data_string+= ' data-slot="'+transition_settings['slot'][key]+'"';
				
				c.append('<li value="'+choosen_slide_transition[key]+'"'+data_string+' class="justaddedtrans draggable-trans-element">'+jQuery('input[name="slide_transition[]"][value="'+choosen_slide_transition[key]+'"]').parent().text()+'<i class="remove-trans-from-list eg-icon-cancel"></i></li>');
				jQuery('.justaddedtrans').data('animval',choosen_slide_transition[key]);
				jQuery('.justaddedtrans').removeClass("justaddedtrans");
			}
			
			setFakeAnim();
		};
		
		if(typeof(choosen_slide_transition) !== 'undefined'){ //if not exists, then we are at static slide
			createListOfTrans();
		}
		
		var etl = new punchgs.TimelineLite(),
			ord = 0,
			sto = jQuery('#form_slide_params').offset(),
			tou;

		jQuery('body').on('click','.remove-trans-from-list',function() {
			var t = jQuery(this),
				li = t.parent(),
				v = li.data('animval'),
				found = false;

			jQuery('.slide-trans-checkelement').each(function() {
				var d = jQuery(this),
					inp = d.find('input');
				
				if (inp.val()==v) {
					inp.removeAttr('checked');
					found = true;
				}
			});
			if (found && jQuery('.remove-trans-from-list').length>1) {
				li.remove();
				jQuery('.slide-trans-cur-ul li:first-child').click();
			}else{
				alert(rev_lang.cant_remove_last_transition);
			}
			
			return false;
			
		});

		jQuery('.slide-trans-checkelement').on("mouseover", function(e) {		

			var inp = jQuery(this).find('input[name="slide_transition[]"]'),
				a = jQuery('.slide-trans-example-inner .slotholder'),
				b = jQuery('.slide-trans-example-inner .oldslotholder'),
				examp = jQuery('.slide-trans-example');

			
			
			
				a.find('.slot').each(function() { jQuery(this).remove();});
				b.find('.slot').each(function() { jQuery(this).remove();});
				etl.kill()
				punchgs.TweenLite.set(a,{clearProps:"transform"});
				punchgs.TweenLite.set(b,{clearProps:"transform"});
				punchgs.TweenLite.set(a.find('.defaultimg'),{clearProps:"transform",autoAlpha:1});
				punchgs.TweenLite.set(b.find('.defaultimg'),{clearProps:"transform",autoAlpha:1});
				
				etl = slideAnimation(a, b,inp.val(),etl,true);
				etl.pause(0.001);
				punchgs.TweenLite.to(examp,0.2,{top:(e.pageY - sto.top),overwrite:"all",autoAlpha:1,ease:punchgs.Power3.easeInOut,onComplete:function() {
					setTimeout(function() {
							etl.play();
						},100);
				}});
			

		});

		jQuery('.slide-trans-checkelement').on("mouseleave",function() {
			clearTimeout(tou);
			var inp = jQuery(this).find('input[name="slide_transition[]"]'),
				a = jQuery('.slide-trans-example-inner .slotholder'),
				b = jQuery('.slide-trans-example-inner .oldslotholder');
			
			punchgs.TweenLite.to(jQuery('.slide-trans-example'),0.2,{autoAlpha:0,delay:0.2});
		});

		jQuery('input[name="slide_transition[]"]').on("change",function() {
			if (jQuery(this).is(":checked")) {
				var data_string = '';
				data_string+= ' data-duration="default"';
				data_string+= ' data-ease_in="default"';
				data_string+= ' data-ease_out="default"';
				data_string+= ' data-rotation="0"';
				data_string+= ' data-slot="default"';
				
				jQuery('.slide-trans-cur-ul').append('<li value="'+jQuery(this).val()+'"'+data_string+' class="justaddedtrans draggable-trans-element">'+jQuery(this).parent().text()+'<i class="remove-trans-from-list eg-icon-cancel"></i></li>')					
				jQuery('.justaddedtrans').data('animval',jQuery(this).val());
				jQuery('.justaddedtrans').removeClass("justaddedtrans");
			} else {
				if (jQuery('.remove-trans-from-list').length>1) {
					jQuery('.slide-trans-cur-ul').find('li:data[value='+jQuery(this).val()+']').remove();
					jQuery('.slide-trans-cur-ul li:first-child').click();
				}else{
					jQuery(this).attr('checked', true);
					alert(rev_lang.cant_remove_last_transition);
				}
				
			}
			
			setFakeAnim();
		});
		
		jQuery('body').on('click', '.slide-trans-cur-ul li', function(){
			jQuery('.slide-trans-cur-ul li').each(function(){
				jQuery(this).removeClass('selected');
			});
			
			jQuery(this).addClass('selected');
			
			jQuery('input[name="slot_amount"]').val(jQuery(this).data('slot'));
			jQuery('input[name="transition_rotation"]').val(jQuery(this).data('rotation'));
			jQuery('input[name="transition_duration"]').val(jQuery(this).data('duration'));
			jQuery('select[name="transition_ease_in"] option[value="'+jQuery(this).data('ease_in')+'"]').attr('selected', true);
			jQuery('select[name="transition_ease_out"] option[value="'+jQuery(this).data('ease_out')+'"]').attr('selected', true);
		});
		
		jQuery('.slide-trans-cur-ul li:first-child').click();
		
		jQuery('input[name="slot_amount"]').change(function(){
			jQuery('.slide-trans-cur-ul li.selected').data('slot', jQuery(this).val());
		});
		jQuery('input[name="transition_rotation"]').change(function(){
			jQuery('.slide-trans-cur-ul li.selected').data('rotation', jQuery(this).val());
		});
		jQuery('input[name="transition_duration"]').change(function(){
			jQuery('.slide-trans-cur-ul li.selected').data('duration', jQuery(this).val());
			setSlideTransitionTimerBar();
		});
		jQuery('select[name="transition_ease_in"]').change(function(){
			jQuery('.slide-trans-cur-ul li.selected').data('ease_in', jQuery(this).val());
		});
		jQuery('select[name="transition_ease_out"]').change(function(){
			jQuery('.slide-trans-cur-ul li.selected').data('ease_out', jQuery(this).val());
		});

		jQuery('.slide-trans-cur-ul').sortable({
			containment: ".slide-trans-cur-selected",
			stop:function() {
				setTimeout(function() {					
					setFakeAnim();
				},200);
			}
		})
			

			

		// END OF MAIN TRANSITION SELECTOR 
		jQuery(document).on('keydown', function(event) {	
			 var noinputfocus = jQuery('input:focus').length>0;
			 
			 if (event.ctrlKey || event.metaKey || event.shiftKey) {
		        switch (String.fromCharCode(event.which).toLowerCase()) {
		        	case 's':
		        		if (!event.shiftKey) {
		           			event.preventDefault();
		            		jQuery('#button_save_slide-tb').click();
		            	}
		            break;		      
		            case 'z':
						if ((event.metaKey || event.ctrlKey) && !noinputfocus) { 		            	
			            	event.preventDefault();
			            	if (event.shiftKey)
			            		u.oneStepRedo();
			            	else
			            		u.oneStepUndo();
			            }
		            break;  
		            case 'y':		            
		            	if ((event.ctrlKey || event.metaKey) && !noinputfocus) {
		            		event.preventDefault();
		            		u.oneStepRedo();
		            	}
		            break;  

		    	}
		    }
		    switch (event) {
				
			}
		});

		jQuery("body").on("keydown keyup",function(e) {
			
			
			if (jQuery('#layer_text').is(":focus")) return true;
			if (jQuery('#layer_text_toggle').is(":focus")) return true;
			
			var code = (e.keyCode ? e.keyCode : e.which),
			dist = jQuery(document.activeElement).data('steps')!=undefined ? parseFloat(jQuery(document.activeElement).data('steps')):1,
			x = Number(parseInt(jQuery('#layer_left').val(),0)),
			y = Number(parseInt(jQuery('#layer_top').val(),0));
			
			if (e.shiftKey) dist = dist*10; 

			
			switch (jQuery(document.activeElement).get(0).tagName.toLowerCase()) {
				case "INPUT":
				case "input":				
					var cv = parseFloat(jQuery(document.activeElement).val());
					
					if (jQuery(document.activeElement).data('suffix')!=undefined && !jQuery(document.activeElement).data('suffix').match(/auto/g)) {
						cv=Number(cv);
						if (jQuery.isNumeric(cv)) 
							switch(code) {
								    case 38: 
										if (e.type=="keyup") reBlurFocus(dist,cv,jQuery(document.activeElement));
										return false;
							        break;
							        case 40:									
										if (e.type=="keyup") reBlurFocus(-dist,cv,jQuery(document.activeElement));			 	
										return false;
							        break;
							}
					}							
				break;
				case "textarea":				
					return true;
				break;
				default:
					
					switch(code) {
						case 8:
						case 46:
							e.preventDefault();
							if (e.type=="keydown") {								
								jQuery('#button_delete_layer').click();
								window.deletecalled = true;
							}
						break;
					}

					if (keyboardallowed && !jQuery('#layer_left').hasClass('setting-disabled')) 	

					switch(code) {						
						
					    case 40: 
							if (e.type=="keyup") {
								if (jQuery('#align_bottom').hasClass("selected"))
									y = y -dist;
								else
									y = y +dist;
								
								jQuery('#layer_top').val(y+"px");
								g_rebuildTimer = 0;
								u.updateCurrentLayerPosition();
							}

							return false;
					    break;
					    case 38:
						    if (e.type=="keyup") {
						    	if (jQuery('#align_bottom').hasClass("selected"))
						    		y = y + dist;
						    	else
							 		y = y - dist;
							 	
								jQuery('#layer_top').val(y+"px");
								g_rebuildTimer = 0;	
								u.updateCurrentLayerPosition();															
							}
							return false;
					    break;
					    case 37:
						    if (e.type=="keyup") {
						    	if (jQuery('#align_right').hasClass("selected"))
						    		x = x + dist;
						    	else
						    		x = x - dist;
						    	jQuery('#layer_left').val(x+"px");								
								g_rebuildTimer = 0;			
								u.updateCurrentLayerPosition();					
							}
							return false;
					    break;
					    case 39:
						    if (e.type=="keyup") {
						    	if (jQuery('#align_right').hasClass("selected"))
						    		x = x - dist;
						    	else
						    		x = x + dist;
						    	jQuery('#layer_left').val(x+"px");								
								g_rebuildTimer = 0;	
								u.updateCurrentLayerPosition();							
							}
							return false;
					    break;
					}

				break;
			}
		});


		// DEEP LINK INPUT FIELD ADD ONS
		jQuery('.input-deepselects').each(function() {
			var inp = jQuery(this);
			inp.wrap('<span class="inp-deep-wrapper"></span>');
			inp.parent().append('<div class="inp-deep-list"></div>');
			var dl = inp.parent().find('.inp-deep-list'),
				txt = '<span class="inp-deep-listitems">',
				rev = inp.data('reverse'),
				list = inp.data('selects') != undefined ? inp.data('selects').split("||") : "",
				vals = inp.data('svalues') != undefined ? inp.data('svalues').split("||") : "",
				icos = inp.data('icons') != undefined ? inp.data('icons').split("||") : "",
				id = inp.attr('id');
				
			
			if (rev=="on") {
				txt = txt+"<span class='reverse_input_wrapper'><span class='reverse_input_text'>Direction Auto Reverse</span><input class='reverse_input_check tp-moderncheckbox' name='"+id+"_reverse' id='"+id+"_reverse' type='checkbox'></span>";
			}
			if (list!==undefined && list!="") {							
				jQuery.each(list,function(i){
					var v = vals[i] || "",
						l = list[i] || "",
						i = icos[i] || "";								
					txt = txt + "<span class='inp-deep-prebutton' data-val='"+v+"'><i class='eg-icon-"+i+"'></i>"+l+"</span>";
				});	
			}
			txt = txt + "</span>";
			
			dl.append(txt);
			if (rev=="on") {
				RevSliderSettings.onoffStatus(jQuery('input[name="'+id+'_reverse"]'));
			}
		})

		jQuery('body').on('click','.inp-deep-prebutton',function() {
			var btn = jQuery(this),
				inp = btn.closest('.inp-deep-wrapper').find('input');
			inp.val(btn.data('val'));			
			inp.blur();
			inp.focus();
			inp.trigger("change");						
		});

		jQuery('body').on('click','.input-deepselects',function() {
				jQuery(this).closest('.inp-deep-wrapper').find('.inp-deep-list').addClass("visible");
				jQuery(this).closest('.inp-deep-wrapper').addClass("selected-deep-wrapper");
		})

		jQuery('.inp-deep-wrapper').on('mouseleave',function() {
			jQuery(this).find('.inp-deep-list').removeClass("visible");
			jQuery(this).removeClass("selected-deep-wrapper");
		});


		// SHOW HIDE MASKING PARAMETERS
		jQuery('input[name="masking-start"]').on("change",function() {		
			if (jQuery(this).attr('checked') ==="checked")
			 	jQuery('.mask-start-settings').show();
			 else									
			 	jQuery('.mask-start-settings').hide();
		})	

		jQuery('input[name="masking-end"]').on("change",function() {			
			if (jQuery(this).attr('checked') ==="checked")
			 	jQuery('.mask-end-settings').show();
			 else									
			 	jQuery('.mask-end-settings').hide();
		});


		// AUTO TIMING HELPER FUNCTIONS
		jQuery('body').on('click',".autotiming-action", function() {
			if (jQuery(this).hasClass("notclickable")) return;

			jQuery('.autotiming-action.selected').removeClass("selected");
			jQuery('#timing-helper-dialog').show();
			jQuery('.master-rightcell, .master-leftcell').addClass("unfocused");
			jQuery('#th-start-time-wrapper').hide();
			jQuery('#th-end-time-wrapper').hide();
			jQuery('#th-delay-time-wrapper').hide();
			jQuery('#th-overlap-time-wrapper').hide();
			jQuery('#th-shift-time-wrapper').hide();
			
			jQuery('#th-animend-start-time-wrapper').hide();
			jQuery('#th-animend-end-time-wrapper').hide();
			jQuery('#th-startpos-keep-wrpaper').hide();
			jQuery('#th-endpos-keep-wrpaper').hide();

			switch (jQuery(this).data("ref")) {
				case 0:
					jQuery('#th-shift-time-wrapper').show();
					jQuery('#th-endpos-keep-wrpaper').show();
				break;
				case 7:
					jQuery('#th-start-time-wrapper').show();
					jQuery('#th-endpos-keep-wrpaper').show();
				break;
				case 1:
					jQuery('#th-start-time-wrapper').show();
					jQuery('#th-delay-time-wrapper').show();
					jQuery('#th-endpos-keep-wrpaper').show();
				break;

				case 2:
					jQuery('#th-start-time-wrapper').show();
					jQuery('#th-overlap-time-wrapper').show();
					jQuery('#th-endpos-keep-wrpaper').show();
				break;

				case 5:
					jQuery('#th-start-time-wrapper').show();
					jQuery('#th-endpos-keep-wrpaper').show();
				break;

				case 6:
					jQuery('#th-end-time-wrapper').show();
					jQuery('#th-startpos-keep-wrpaper').show();
				break;

				case 3:					
					jQuery('#th-animend-start-time-wrapper').show();
					jQuery('#th-endpos-keep-wrpaper').show();
				break;

				case 4:					
					jQuery('#th-animend-end-time-wrapper').show();
					jQuery('#th-startpos-keep-wrpaper').show();
				break;
			}

			jQuery(this).addClass("selected")

		});

		// CLOSE AUTO TIMING DIALOG
		jQuery('body').on('click','#timing-helper-closer',function() {
			jQuery('#timing-helper-dialog').hide();
			jQuery('.master-rightcell, .master-leftcell').removeClass("unfocused");
			jQuery('.autotiming-action.selected').removeClass("selected");
		});

		// SELECT / DESELECT ALL LAYERS
		jQuery('body').on('click','.timing-all-checker-wrapper',function() {
			var b = jQuery(this);
			if (b.hasClass("allselected") || jQuery('.mastertimer-timeline-selector-row.selected').length==jQuery('.layer-on-timeline-selector').length) {
				b.removeClass("allselected");
				jQuery('.mastertimer-timeline-selector-row.selected').removeClass("selected");
				jQuery('.layer-on-timeline-selector').removeAttr('checked');
			} else {
				b.addClass("allselected");
				jQuery('.layer-on-timeline-selector').attr('checked','checked');
				jQuery('.sortablelayers .mastertimer-timeline-selector-row').addClass("selected");
			}
			checkAvailableAutoTimes();
		});

		// SELECT THE AUTO TIMING FUNCTION
		jQuery('body').on('change','.layer-on-timeline-selector',function() {

			var cbox = jQuery(this);
			if (cbox.attr('checked')==="checked") 
				cbox.closest('.mastertimer-timeline-selector-row').addClass("selected");
			else
				cbox.closest('.mastertimer-timeline-selector-row').removeClass("selected");
			checkAvailableAutoTimes();
		});


		// SET LAYERS TIMES BASED ON SELECTED AUTO TIMING OPTION
		jQuery('body').on('click','#adjust-timing-helper',function() {

			var layers = [];

			jQuery.each(jQuery('.mastertimer-timeline-selector-row.selected').closest('li'),function(i,li){								
				layers.push(u.getLayer(jQuery(li).attr('id').split('layer_sort_')[1]));
			});

			var nexts = parseInt(jQuery('#atlayer_start_time').val(),0) || 0,
				shift = parseInt(jQuery('#atlayer_shift_time').val(),0) || 0,
				ends = parseInt(jQuery('#atlayer_end_time').val(),0) || 0,
				startat = parseInt(jQuery('#atlayer_animend_start_time').val(),0) || 0,
				endat = parseInt(jQuery('#atlayer_animend_end_time').val(),0) || 0,
				delay = parseInt(jQuery('#atlayer_delays').val(),0) || 0,
				overlaps = parseInt(jQuery('#atlayer_overlaps').val(),0) || 0,
				ref = jQuery('.autotiming-action.selected').data('ref'),
				keepend = jQuery('#th-endpos-keep').attr("checked")=="checked",
				keepstart = jQuery('#th-startpos-keep').attr("checked")=="checked",				
				maxtime = (t.mainMaxTimeLeft-15)*10,
				earliest = maxtime,
				dif = 0;


			if (ref==7) {
				jQuery.each(layers,function(i,objLayer) {					
					if (objLayer.time<earliest) {
						earliest = objLayer.time;
						dif = nexts - objLayer.time;
					}
				});	
				
			}
			jQuery.each(layers,function(i,objLayer) {
							
				
				var startchange = nexts-objLayer.time,
					split_in_extratime = objLayer.split_in_extratime!=undefined ? parseInt(objLayer.split_in_extratime,0)*10 : 0,
					split_out_extratime = objLayer.split_out_extratime!=undefined ? parseInt(objLayer.split_out_extratime,0)*10 : 0,
					
				split_in_extratime = split_in_extratime<0 ? 0 : split_in_extratime;
				split_out_extratime = split_out_extratime<0 ? 0 : split_out_extratime;

				if (ref==0) {
					var temptime = objLayer.time;
					objLayer.time = parseInt(objLayer.time,0) + shift;
					if (objLayer.time<0) objLayer.time = 0;
					startchange =  objLayer.time - temptime;

					if (!keepend)  
						objLayer.endtime = parseInt(objLayer.endtime,0) + startchange;

					if ((objLayer.time+objLayer.speed+split_in_extratime)>=objLayer.endtime-objLayer.endspeed) 
						objLayer.endtime = parseInt(objLayer.endtime,0) + startchange;

				} else
				if (ref==7) {
					objLayer.time = objLayer.time+dif;
					if (!keepend) 
						objLayer.endtime = objLayer.endtime + dif;
					if ((objLayer.time+objLayer.speed+split_in_extratime)>=objLayer.endtime-objLayer.endspeed) 
						objLayer.endtime = parseInt(objLayer.endtime,0) + dif;
					
					
				} else
				if (ref==1) {
					if (!keepend) 
						objLayer.endtime = objLayer.endtime + startchange;						
					if ((objLayer.time+objLayer.speed+split_in_extratime)>=objLayer.endtime-objLayer.endspeed) 
						objLayer.endtime = parseInt(objLayer.endtime,0) + startchange;
					objLayer.time = nexts;						
					nexts = nexts + parseInt(objLayer.speed,0) + delay + split_in_extratime;						
				} else
				if (ref==2) {
					if (!keepend) 
						objLayer.endtime = objLayer.endtime + startchange;
					if ((objLayer.time+objLayer.speed+split_in_extratime)>=objLayer.endtime-objLayer.endspeed) 
						objLayer.endtime = parseInt(objLayer.endtime,0) + startchange;
					objLayer.time = nexts;					
					nexts = nexts + parseInt(objLayer.speed,0) - overlaps + split_in_extratime;					
				} else
				if (ref==3) {
					var temptime = startat -parseInt(objLayer.speed,0) - split_in_extratime;
					startchange = temptime - objLayer.time;
					objLayer.time = temptime;
					if (!keepend) 
						objLayer.endtime = objLayer.endtime + startchange;	
					if ((objLayer.time+objLayer.speed+split_in_extratime)>=objLayer.endtime-objLayer.endspeed) 
						objLayer.endtime = parseInt(objLayer.endtime,0) + startchange;					
				} else
				if (ref==4) {
					var temptime = endat + objLayer.endspeed;
					startchange =  objLayer.endtime - temptime;					
					objLayer.endtime = temptime;
					if (!keepstart)
						objLayer.time = objLayer.time - startchange;
				} else
				if (ref==5) {
					if (!keepend) 
						objLayer.endtime = objLayer.endtime + startchange;
					if ((objLayer.time+objLayer.speed+split_in_extratime)>=objLayer.endtime-objLayer.endspeed) 
						objLayer.endtime = parseInt(objLayer.endtime,0) + startchange;				
					objLayer.time = nexts;											
				} else 
				if (ref==6) {
					
					startchange = objLayer.endtime - ends;
					objLayer.endtime = (ends);
					objLayer.endWithSlide = false;
					if (!keepstart)
						objLayer.time = objLayer.time - startchange;
				}

				
				if (objLayer.time<0) {
					var adjustchange = 0 - objLayer.time;
					objLayer.time = 0;
					if ((objLayer.time+objLayer.speed+split_in_extratime)>=objLayer.endtime-objLayer.endspeed) 
						objLayer.endtime = parseInt(objLayer.endtime,0) + adjustchange;
				}

				
				if (nexts<0) nexts = 0;
				
				
				if ((objLayer.endtime-objLayer.endspeed)>maxtime) {

					var w = ((objLayer.endtime-objLayer.endspeed)/10)+15;
					jQuery('#mastertimer-maxtime').css({left:w});						
					jQuery('#mastertimer-maxcurtime').html(t.convToTime(w-15));
					jQuery('.slide-idle-section').css({left:w});
					jQuery('#delay').val((w-15)*10);
					jQuery('.mastertimer-slide .tl-fullanim').css({width:(w-15)+"px"});
					g_slideTime = (w-15)*10;
					t.mainMaxTimeLeft = w;
					u.setMaintime(g_slideTime);
					objLayer.endtime = objLayer.endWithSlide ? 	(w-15)*10 : objLayer.endtime;
				}
				
				t.updateLayerTimeline(jQuery('#layer_sort_time_'+objLayer.serial+" .timeline .tl-fullanim"));

			});
			
				
			jQuery('#timing-helper-dialog').hide();
			jQuery('.master-rightcell, .master-leftcell').removeClass("unfocused");
			jQuery('.autotiming-action.selected').removeClass("selected");
			t.compareLayerEndsVSSlideEnd();
			u.add_layer_change();
		});
		
	}

	// COMPARE SLIDE LENGTH TO LAYERS END, AND UPDATE THE END OF THE LAYERS AS NEEDED
	t.compareLayerEndsVSSlideEnd = function() {				
		var maxtime = (t.mainMaxTimeLeft-15)*10;		
		jQuery.each(u.arrLayers,function(i,objLayer) {						
			if (objLayer.endWithSlide || maxtime<objLayer.endtime - objLayer.endspeed) {				
				objLayer.endtime = maxtime+objLayer.endspeed;
				//t.updateLayerTimeline(jQuery('#layer_sort_time_'+objLayer.serial+" .timeline .tl-fullanim"));
			}
		});
		t.updateAllLayerTimeline();
	}

	function checkAvailableAutoTimes() {
		var sel = jQuery('.mastertimer-timeline-selector-row.selected').length;				
			jQuery('.autotiming-action').addClass("notclickable");
		
		if (sel>1) {
			jQuery('.autotiming-action').removeClass("notclickable");			
		} else

		if (sel==1) {
			jQuery('.autotiming-action-3').removeClass("notclickable");
			jQuery('.autotiming-action-4').removeClass("notclickable");
			jQuery('.autotiming-action-5').removeClass("notclickable");
			jQuery('.autotiming-action-6').removeClass("notclickable");
		}
	}
	
	function addIconFunction() {
		jQuery('#tp-addiconbutton, .addbutton-icon').click(function() {


			var buttons = {"Close":function(){jQuery("#dialog_insert_button").dialog("close")}}			
			jQuery("#dialog_insert_icon").dialog({
				//buttons:buttons,
				width:491,
				height:500,
				dialogClass:"tpdialogs",
				resize:function() {
						var di = jQuery('#dialog_insert_icon');
						di.css({width:(di.parent().width()-30),height:(di.parent().height()-60)});	
				},
				modal:true,
				create:function(event,ui) {
					var cont = jQuery(event.target),
						sheets = document.styleSheets,
						di = jQuery('#dialog_insert_icon');
					di.parent().css({padding:"0px", border:"none", borderRadius:"0px"});
					di.parent().find('.ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix.ui-draggable-handle').addClass("tp-slider-new-dialog-title");
					//css({fontSize:"14px", fontWeight:"400",lineHeight:"35px"});
					if (sheets)
					jQuery.each(sheets,function(index,sheet) {
						var found = false,
							markup = "";	
						try{
							if (sheet.cssRules !==null & sheet.cssRules!=undefined)									
								jQuery.each(sheet.cssRules, function(index,rule) {
									
									if (rule && rule!==null && rule !=="null" && rule.selectorText!=undefined) {
										jQuery.each(rs_icon_sets,function(j,prefix){
											if (rule.selectorText.split(prefix).length>1 && rule.cssText.split("content").length>1) {																							
												var csname = rule.selectorText.split("::before")[0].split(":before")[0];
												
												if (csname!=undefined)  {
													csname = csname.split(".")[1];	
													if (csname!=undefined) {													
														if (found==false) {
																found=true;
																markup = '<ul class="tp-icon-preview-list lastaddediconset">';
														}
														markup=markup + '<li><i class="'+csname+'"></i></li>';
													}
												}
											}							
										})
									}
								});
						} catch(e) {}
						if (found) {
							markup = markup + '</ul>';
							cont.append(markup);
							var fli = cont.find('.lastaddediconset').find('li').first().find('i');
							cont.find('.lastaddediconset').prepend('<h3>'+fli.css("fontFamily")+'</h3>').removeClass("lastaddediconset");
						}
					})
					cont.on("click","li",function() {

						if (jQuery('#dialog_addbutton').length>0 && jQuery('#dialog_addbutton').closest('.tpdialogs').css('display')!=="none") {
							if (jQuery('.addbutton-icon:visible').length>0) {
								jQuery('.addbutton-icon').html(jQuery(this).html());
								jQuery("#dialog_insert_icon").dialog("close");
								setExampleButtons();
							} else {
								if (jQuery('.lasteditedlayertext').length>0)
									jQuery('.lasteditedlayertext').val(jQuery('.lasteditedlayertext').val()+jQuery(this).html()).blur().focus();	
								else
									jQuery('#layer_text').val(jQuery('#layer_text').val()+jQuery(this).html()).blur().focus();										
								jQuery("#dialog_insert_icon").dialog("close");
							}																												
						} else {
							if (jQuery('.lasteditedlayertext').length>0)
								jQuery('.lasteditedlayertext').val(jQuery('.lasteditedlayertext').val()+jQuery(this).html()).blur().focus();
							else
								jQuery('.layer_text').val(jQuery('#layer_text').val()+jQuery(this).html()).blur().focus();
							jQuery("#dialog_insert_icon").dialog("close");
						}
						
						u.updateLayerFromFields();
						
					});
				}
			});			
		});

	}

	function reBlurFocus(dist,cv,el) {	
		if (!jQuery('#rs-animation-tab-button').hasClass("selected") && !jQuery('#rs-loopanimation-tab-button').hasClass("selected")) {
			cv = Number(cv) +dist;			
			cv=Math.round(cv*100)/100;		
			el.val(cv);	
			/*  PUT THIS IN EDIT_LAYERS.js */
			jQuery(':focus').blur();
			
			el.focus();
		}
	}



	/***********************************************************
		-	INITIALISE CLICK, LOOP, INOUT ANIMATION HANDLERS	-
	***********************************************************/
	function basicClicksAndHovers() {
		// CHANGING ANY STYLE SHOULD REBUILD THE LAYERS
		jQuery('.rs-staticcustomstylechange').change(function() {

			//setTimeout(function() {
					
					t.rebuildLayerIdle(jQuery('.slide_layer.layer_selected'));
			//	},20);
		})


		// HANDLING OF LAYER ANIMATIONS STOP/PLAY OF SINGLE LAYERS
		jQuery('.rs-layer-settings-tabs li').click(function() {

				var li = jQuery(this);
				if ((li.attr('id') != '#rs-animation-tab-button' && li.closest('#rs-animation-tab-button').length==0) &&
					(li.attr('id') != '#rs-loopanimation-tab-button' && li.closest('#rs-loopanimation-tab-button').length==0)) {

						t.stopAllLayerAnimation();
						setTimeout(function() {
							u.removeCurrentLayerRotatable();
							u.makeCurrentLayerRotatable();
							jQuery('#hide_layer_content_editor').click();
						},19);
				} else
				if (!jQuery(this).hasClass("selected")) {
					t.stopAllLayerAnimation();
					if (li.attr('id') == '#rs-animation-tab-button' || li.closest('#rs-animation-tab-button').length!=0) {
						t.animateCurrentSelectedLayer(3);
						u.removeCurrentLayerRotatable();
						jQuery('#hide_layer_content_editor').click();
					} else {
						t.callCaptionLoops();
						u.removeCurrentLayerRotatable();
						jQuery('#hide_layer_content_editor').click();
					}
				}
		});

		// CLICK ON LAYERS ARE SHOULD STOP ANY LAYER ANIMATION OR LOOPS
		jQuery('#divLayers').click(function() {
			

			t.stopAllLayerAnimation();
			u.removeCurrentLayerRotatable();			
			
			setTimeout(function() {
				if (t.checkAnimationTab()) 
					t.animateCurrentSelectedLayer(4);
				
				if (t.checkLoopTab()) 
					t.callCaptionLoops();
			},19);				

		})

		// Click on LayerAnimation Button the current Selected Layer should be Animated
		jQuery('#layeranimation-playpause').click(function() {

				var btn = jQuery(this);
				if (btn.hasClass("inpause")) {
					btn.removeClass("inpause");
					if (t.checkAnimationTab()) {
						t.stopAllLayerAnimation();
						t.animateCurrentSelectedLayer(5);
						u.removeCurrentLayerRotatable();												
					}
				} else {
					btn.addClass("inpause");

					t.stopAllLayerAnimation();
				}
			})

		// Click on LayerAnimation Button the current Selected Layer should be Animated
		jQuery('#loopanimation-playpause').click(function() {

				var btn = jQuery(this);
				if (btn.hasClass("inpause")) { 
					btn.removeClass("inpause");
					if (t.checkLoopTab()) {
						t.stopAllLayerAnimation();						
						t.callCaptionLoops();						
						u.removeCurrentLayerRotatable();						
					}
				} else {
					btn.addClass("inpause");
					t.stopAllLayerAnimation();					
				}
			})
			
				
		jQuery('#rs-style-tab-button').click(function() {
			setTimeout(function() {
					jQuery('.slide_layer').each(function() {
						
						t.rebuildLayerIdle(jQuery(this));	
						var inlayer = jQuery(this).find('.innerslide_layer');
						if (inlayer.length>0 && inlayer.data('hoveranim')!=undefined) {
							var tl = inlayer.data('hoveranim');
							tl.seek(tl.endTime());
						}					
					})
				},19);	
		});
		
		jQuery('#toggle-idle-hover').click(function() {
			setTimeout(function() {					
					t.rebuildLayerIdle(jQuery('.slide_layer.layer_selected'));
			},19);
		})
		

		
		jQuery('#style_form_wrapper').on("colorchanged",function() {			
			t.rebuildLayerIdle(jQuery('.slide_layer.layer_selected'));				
		})
	}

	t.resetIdleSelector = function() {
		var bt = jQuery('#toggle-idle-hover');
		bt.addClass("idleisselected").removeClass("hoverisselected");
		jQuery('#tp-idle-state-advanced-style').show();
		jQuery('#tp-hover-state-advanced-style').hide();
	}

	/************************************************************************************************************************
				-	CHECK IF ANIMATION AND LOOP ANIMATION TABS ARE ACTIVATED AND IN IDLE OR PLAY MODE ARE	-
	**************************************************************************************************************************/

	t.checkAnimationTab = function() {
		return (!jQuery('#layeranimation-playpause').hasClass("inpause") && jQuery('#rs-animation-tab-button').hasClass("selected"));
	}

	t.checkLoopTab = function() {
		return (!jQuery('#loopanimation-playpause').hasClass("inpause") && jQuery('#rs-loopanimation-tab-button').hasClass("selected"));
	}



	/**********************************************************
					-	ANIMATION HANDLING	-
	**********************************************************/

	/*********************************
	-	PREPARE THE ANIMATIONS	-
	********************************/

	function preparePeviewAnimations() {

		// NORMAL FIELDS CHANGED IN IN/OUT ANIMATION
		jQuery('.rs-inoutanimationfield').on("change",
				function() {					
					if (t.checkAnimationTab()) {
						t.stopAllLayerAnimation();
						setTimeout(function() {						
								t.animateCurrentSelectedLayer(50);
						},19);
					}
				});
		// NORMAL FIELDS CHANGED IN LOOP ANIMATIONS
	}

	function prepareLoopAnimations() {

		// NORMAL FIELDS CHANGED IN IN/OUT ANIMATION
		jQuery('.rs-loopanimationfield').on("change",
				function() {
					if (t.checkLoopTab()) {
						t.stopAllLayerAnimation();
						setTimeout(function() {
								t.callCaptionLoops();
						},19);

					}
				});

	}

	/******************************
		-	STOP ALL ANIMATION	-
	********************************/

	t.stopAllLayerAnimation = function() {

		
		
		jQuery('#mastertimer-playpause-wrapper').html('<i class="eg-icon-play"></i><span>PLAY</span>');
		//var nextcaption = jQuery('#preview_caption_animateme');
		punchgs.TweenLite.set(jQuery('.tp-mask-wrap'),{clearProps:"transform",overwrite:"all"});
		jQuery('.tp-showmask').removeClass('tp-showmask');

		jQuery('.innerslide_layer').each(function() {
			var nextcaption = jQuery(this);
				if (nextcaption.closest('.rs-preview-inside-looper').length>0)
					nextcaption.unwrap();

			if (nextcaption.data('tl')!=undefined) {
				var tl = nextcaption.data('tl');
				tl.clear();
				tl.kill();				
				try{
					if (nextcaption.data('mySplitText')) 
							nextcaption.data('mySplitText').revert();
					} catch(e) {}
				punchgs.TweenLite.set(nextcaption.parent(),{autoAlpha:1});
				
				t.rebuildLayerIdle(nextcaption.closest('.slide_layer'));
				u.removeCurrentLayerRotatable();
			}


		});
		punchgs.TweenLite.set(jQuery('#startanim_wrapper'),{autoAlpha:0});
		punchgs.TweenLite.set(jQuery('#endanim_wrapper'),{autoAlpha:0});


	}


	/******************************
		-	LOOP ANIMATIONS	-
	********************************/

	t.callCaptionLoops = function() {
		t.stopAllLayerAnimation();
		
		var caption = jQuery('.slide_layer.layer_selected'),
			el = caption.find('.innerslide_layer');
		if (el.length==0) {
				return false;
			}

		var	id = u.getSerialFromID(caption.attr('id'));
			params=u.getLayer(id),
			loopanim = params["loop_animation"];



		if (el.closest('.rs-preview-inside-looper').length>0) {
			el.unwrap();
		}

		el.wrap('<div class="rs-preview-inside-looper" style="width:100%;height:100%;position:relative"></div>');

		var loopobj =caption.find('.rs-preview-inside-looper'),
			startdeg = params["loop_startdeg"],
			enddeg = params["loop_enddeg"],
			speed = params["loop_speed"],
			origin = ''+params["loop_xorigin"]+'% '+params["loop_yorigin"]+'%',
			easing = params["loop_easing"],
			angle= params["loop_angle"],
			radius = parseInt(params["loop_radius"],0),
			xs = params["loop_xstart"],
			ys = params["loop_ystart"],
			xe = params["loop_xend"],
			ye = params["loop_yend"],
			zoomstart = params["loop_zoomstart"],
			zoomend = params["loop_zoomend"];

		factor = 1;

        

		var tl = new punchgs.TimelineLite();
		tl.pause();


		// SOME LOOPING ANIMATION ON INTERNAL ELEMENTS
		switch (loopanim) {
			case "rs-pendulum":


					//punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",rotation:startdeg,transformOrigin:origin},{rotation:enddeg,ease:easing});
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",rotation:startdeg,transformOrigin:origin},{rotation:enddeg,ease:easing}));
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",rotation:enddeg},{rotation:startdeg,ease:easing,onComplete:function() {
						tl.restart();
					}}));
			break;

			case "rs-rotate":
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",rotation:startdeg,transformOrigin:origin},{rotation:enddeg,ease:easing,onComplete:function() {
						tl.restart();
					}}));
			break;

			case "rs-slideloop":

					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",x:xs,y:ys},{x:xe,y:ye,ease:easing}));
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",x:xe,y:ye},{x:xs,y:ys,onComplete:function() {
						tl.restart();
					}}));
			break;

			case "rs-pulse":
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",scale:zoomstart},{scale:zoomend,ease:easing}));
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",scale:zoomend},{scale:zoomstart,onComplete:function() {
						tl.restart();
					}}));
			break;

			case "rs-wave":
					
					var yo = (0-loopobj.height()/2) + (radius*(-1+(parseInt(params["loop_yorigin"],0)/100))),
						xo = (loopobj.width())*(-0.5+(parseInt(params["loop_xorigin"],0)/100)),
						angobj = {a:0, ang : angle, element:loopobj, unit:radius,xoffset:xo,yoffset:yo};
					tl.add(punchgs.TweenLite.fromTo(angobj,speed,
							{	a:360	},
							{	a:0,
								force3D:"auto",
								ease:punchgs.Linear.easeNone,
								onUpdate:function() {

									var rad = angobj.a * (Math.PI / 180);
						            punchgs.TweenLite.to(angobj.element,0.1,{force3D:"auto",x:angobj.xoffset+Math.cos(rad) * angobj.unit, y:angobj.yoffset+angobj.unit * (1 - Math.sin(rad))});

								},
								onComplete:function() {
									tl.restart();
								}
							}
							));
			break;
		}
		tl.play();
		caption.data('tl',tl);
	}


	/******************************************
		-	REBUILD IDLE STATES OF ITEMS 	-
	******************************************/
	
	t.rebuildLayerIdle = function(caption,timer,isDemo) {
		
		timer = timer == undefined ? 50 : timer;
		isDemo = isDemo == undefined ? false : isDemo;
				
		if (g_rebuildTimer == 0) {
			timer = 0;
			g_rebuildTimer = 999;
		}
		
		
		
		if (caption==undefined || jQuery(caption).length==0) return false;
				
		var cp = jQuery(caption);
		

		clearTimeout(cp.data('idlerebuildtimer'));
		
		
		
		t.rebuildLayerIdleProgress(caption);
		
		
		var id = u.getSerialFromID(caption.attr('id')),
			objLayer = u.getLayer(id,isDemo);
		
		var e_img = caption.find('.tp-caption img');


		u.updateHtmlLayerPosition(false,caption,objLayer,u.getVal(objLayer, 'top'),u.getVal(objLayer, 'left'),u.getVal(objLayer, 'align_hor'),u.getVal(objLayer, 'align_vert'));
		
		if (e_img.length>0 && !jQuery(e_img).hasClass("loaded")) {
			jQuery(e_img).addClass("loaded");
			
			var img = new Image();			
			img.onload = function() {					
							 				
				objLayer.originalWidth = this.width;
				objLayer.originalHeight = this.height;
				u.updateHtmlLayerPosition(false,caption,objLayer,u.getVal(objLayer, 'top'),u.getVal(objLayer, 'left'),u.getVal(objLayer, 'align_hor'),u.getVal(objLayer, 'align_vert'));
			}
			img.onerror = function() {				
				e_img[0].src = objLayer.image_url = g_revslider_url+"/admin/assets/images/tp-brokenimage.png";
				u.updateHtmlLayerPosition(false,caption,objLayer,u.getVal(objLayer, 'top'),u.getVal(objLayer, 'left'),u.getVal(objLayer, 'align_hor'),u.getVal(objLayer, 'align_vert'));
			}
			img.onabort = function() {				
				u.updateHtmlLayerPosition(false,caption,objLayer,u.getVal(objLayer, 'top'),u.getVal(objLayer, 'left'),u.getVal(objLayer, 'align_hor'),u.getVal(objLayer, 'align_vert'));
			}

			img.src = e_img[0].src;
		} else {
			//u.updateHtmlLayerPosition(false,caption,objLayer,u.getVal(objLayer, 'top'),u.getVal(objLayer, 'left'),u.getVal(objLayer, 'align_hor'),u.getVal(objLayer, 'align_vert'));
			//update corners
			u.updateHtmlLayerCorners(caption,objLayer);
			//update cross position
			u.updateCrossIconPosition(caption,objLayer);
		}
		
		return true;
	}
	


	////////////////////////////////
	// REBUILD LAYER CSS FOR IDLE //
	////////////////////////////////
	t.rebuildLayerIdleProgress = function(caption) {

		
		var is_demo = (caption.attr('id') !== caption.attr('id').replace('demo_layer_')) ? true : false;
		
		if (caption==undefined || jQuery(caption).length==0) return false;
		
		var id = u.getSerialFromID(caption.attr('id')),
			params=u.getLayer(id, is_demo);
		if (params==undefined || params==false) return false;

		
		var inlayer = caption.find('.innerslide_layer'),
			deform = params.deformation,
			deformidle = params.deformation,
			ss = params["static_styles"],
			fontcolor = u.getVal(ss,"color"),
			fonttrans = deform["color-transparency"],
			bgcolor = deform["background-color"],
			bgtrans = deform["background-transparency"],
			bordercolor = deform["border-color"],
			bordertrans = deform["border-transparency"];


		if (params.type=="audio") {
			if (params.video_data.video_show_visibility) {
				caption.addClass("invisible-audio");
			} else {
				caption.removeClass("invisible-audio");
			}
			return false;
		}



		if(is_demo && params.alias == 'First'){
			
		}
		
		// REMOVE SPLITS
		if (inlayer.data('mySplitText') != undefined) {
			try{inlayer.data('mySplitText').revert();} catch(e) {}
			if (params.type=="text" || params.type=="button") {
				inlayer.html(params.text);
				u.makeCurrentLayerRotatable();
			}
			inlayer.removeData('mySplitText')
		}

		// BACKGROUND OPACITY
		if (Number(bgtrans)<1) {
			var rgb = UniteAdminRev.convertHexToRGB(bgcolor);
			bgcolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+bgtrans+")";
		}

		// BORDER OPACITY
		if (Number(bordertrans)<1) {
			var rgb = UniteAdminRev.convertHexToRGB(bordercolor);
			bordercolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+bordertrans+")";
		}

		// FONT OPACITY
		if (Number(fonttrans)<1) {
			var rgb = UniteAdminRev.convertHexToRGB(fontcolor);
			fontcolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+fonttrans+")";
		}


		// SET ELEMENT IDLE		
		var mwidth = u.getVal(params,"max_width"),
			mheight = u.getVal(params,"max_height"),
			cmode = u.getVal(params,"cover_mode");
		
		
		switch(params.type){
			case 'image':
				mwidth = u.getVal(params,"scaleX");
				mheight = u.getVal(params,"scaleY"); 
			break;
			case 'video':
				mwidth = params.video_data.cover===true || params.video_data.fullwidth===true ? "100%" : u.getVal(params,"video_width");
				mheight = params.video_data.cover===true || params.video_data.fullwidth===true ? "100%" :  u.getVal(params,"video_height"); 				
				caption.find('.slide_layer_video').css({width:parseInt(mwidth,0)+"px",height:parseInt(mheight,0)+"px"});								
			break;
			
		}
		
		if(mwidth == undefined) mwidth = '';
		if(mheight == undefined) mheight = '';

		

		mwidth = cmode===undefined || cmode==="custom" ?  
				jQuery.isNumeric(mwidth) ? 
					mwidth+"px" : mwidth.match(/px/g) ? 
						parseInt(mwidth,0)+"px" : mwidth.match(/%/g) ? 
							parseInt(mwidth,0)+"%" : mwidth :
								cmode === "fullwidth" || cmode ==="cover"  || cmode ==="cover-proportional" ? "100%" : mwidth;

		mheight = cmode===undefined || cmode==="custom" ?  
				jQuery.isNumeric(mheight) ? 
					mheight+"px" : mheight.match(/px/g) ? 
						parseInt(mheight,0)+"px" : mheight.match(/%/g) ? 
							parseInt(mheight,0)+"%" : mheight :
								cmode === "fullheight" || cmode ==="cover" || cmode ==="cover-proportional"  ? "100%" : mheight;

		

		// SET LAYER WIDTH HEIGHT INNER AND OUTTER
		
		caption.css({width:mwidth, height:mheight});
		
		var fw = parseInt(u.getVal(ss,"font-weight"),0) || 400;

		punchgs.TweenLite.set(caption.find('.tp-mask-wrap'), {	 clearProps:"all", visibility:"visible",opacity:1})
		punchgs.TweenLite.set(inlayer, {	 clearProps:"all", visibility:"visible",opacity:1});
		punchgs.TweenLite.set(inlayer, {	
											 z:deform.z,
										//	 top:parseInt(deform["top"],0)+"px",
										//	 left:parseInt(deform["left"],0)+"px",
											 scaleX:parseFloat(deform.scalex),
											 scaleY:parseFloat(deform.scaley),
											 textAlign:deform["text-align"],
											 rotationX:parseFloat(deform.xrotate),
											 rotationY:parseFloat(deform.yrotate),
											 rotationZ:parseFloat(params["2d_rotation"]),

											 skewX:parseFloat(deform.skewx),
											 skewY:parseFloat(deform.skewy),

											 transformPerspective:parseFloat(deform.pers),
											 transformOrigin:params["layer_2d_origin_x"]+"% "+params["layer_2d_origin_y"]+"%",

											 autoAlpha:deform.opacity,
											 paddingTop:parseInt(deformidle.padding[0],0)+"px",
											 paddingRight:parseInt(deformidle.padding[1],0)+"px",
											 paddingBottom:parseInt(deformidle.padding[2],0)+"px",
											 paddingLeft:parseInt(deformidle.padding[3],0)+"px",
											 fontSize:parseInt(u.getVal(ss,"font-size"),0)+"px",
											 lineHeight:parseInt(u.getVal(ss,"line-height"),0)+"px",		
											 fontWeight:fw,		
											 color:fontcolor,
											 backgroundColor:bgcolor,
						
											 fontFamily:deformidle["font-family"],
											 fontStyle:deformidle["font-style"],
											 textDecoration:deform["text-decoration"],
											 textTransform:deform["text-transform"],
											 borderColor:bordercolor,
											 borderRadius:deform["border-radius"][0]+" "+deform["border-radius"][1]+" "+deform["border-radius"][2]+" "+deform["border-radius"][3],
											 borderWidth:parseInt(deform["border-width"],0)+"px",
											 borderStyle:deform["border-style"],
											 whiteSpace:u.getVal(params,"whitespace"),
											 maxWidth:mwidth,
											 maxHeight:mheight											 
							});
		
		if (params.type==="image") {
			if(params.scaleProportional) {					
				punchgs.TweenLite.set(inlayer.find('img'),{width:mwidth,height:"auto"})
				punchgs.TweenLite.set(inlayer,{width:mwidth,height:"auto"})
			} else {	
				
				punchgs.TweenLite.set(inlayer.find('img'),{width:mwidth,height:mheight})
				punchgs.TweenLite.set(inlayer,{width:mwidth,height:mheight})						
			}		
		}

		if (params.type==="video") {			
				punchgs.TweenLite.set(inlayer.find('.slide_layer_video'),{width:mwidth,height:mheight})
				punchgs.TweenLite.set(inlayer,{width:mwidth,height:mheight})									
		}
		
		if (params.type==="svg" && params.svg!=undefined) {			
				var svgstrokecolor = params.svg["svgstroke-color"] || "transparent",
					svgstroketrans = params.svg["svgstroke-transparency"] || 0,
					svgstrokewidth = params.svg["svgstroke-width"] || 0,
					svgstrokedasharray = params.svg["svgstroke-dasharray"] || 0,
					svgstrokedashoffset = params.svg["svgstroke-dashoffset"] || 0;

				// STROKE OPACITY
				if (Number(svgstroketrans)<1) {
					var rgb = UniteAdminRev.convertHexToRGB(svgstrokecolor);
					svgstrokecolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+svgstroketrans+")";
				}
				
				punchgs.TweenLite.set(inlayer.find('svg'),{
																fill:fontcolor,
																stroke:svgstrokecolor,
																strokeWidth:svgstrokewidth,
																strokeDasharray:svgstrokedasharray,
																strokeDashoffset:svgstrokedashoffset
															});				
		}

		if (params.inline !=undefined && params.inline.idle!=undefined)					
			jQuery.each(params.inline.idle, function(key,value) {

				inlayer.css(key,value);
			})

		
		
		//SET ELEMENT HOVER (IN CASE IT EXISTS)
		
		if (params.hover===true) {
			deform = params["deformation-hover"];
			var fontcolor = deform.color,
				fonttrans = deform["color-transparency"],		
				bgcolor = deform["background-color"],
				bgtrans = deform["background-transparency"],
				bordercolor = deform["border-color"],
				bordertrans = deform["border-transparency"];

			
			// BACKGROUND OPACITY
			if (Number(bgtrans)<1) {
				var rgb = UniteAdminRev.convertHexToRGB(bgcolor);
				bgcolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+bgtrans+")";
			}

			// BORDER OPACITY
			if (Number(bordertrans)<1) {
				var rgb = UniteAdminRev.convertHexToRGB(bordercolor);
				bordercolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+bordertrans+")";
			}

			// FONT OPACITY
			if (Number(fonttrans)<1) {
				var rgb = UniteAdminRev.convertHexToRGB(fontcolor);
				fontcolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+fonttrans+")";
			}
		
			var tl=new punchgs.TimelineLite();				
			tl.pause();
			
			var hoverspeed = parseFloat(deform.speed)/1000;
			hoverspeed = hoverspeed === 0 ? 0.001 : hoverspeed;
			
			tl.add(punchgs.TweenLite.to(inlayer, hoverspeed,{
	
											 scaleX:parseFloat(deform.scalex),
											 scaleY:parseFloat(deform.scaley),
	
											 rotationX:parseFloat(deform.xrotate),
											 rotationY:parseFloat(deform.yrotate),
											 rotationZ:parseFloat(deform["2d_rotation"]),
	
											 skewX:parseFloat(deform.skewx),
											 skewY:parseFloat(deform.skewy),
		
											 autoAlpha:deform.opacity,
											 color:fontcolor,
											 backgroundColor:bgcolor,						
											 textDecoration:deform["text-decoration"],
											 borderColor:bordercolor,
											 borderRadius:parseInt(deform["border-radius"][0],0)+"px "+parseInt(deform["border-radius"][1],0)+"px "+parseInt(deform["border-radius"][2],0)+"px "+parseInt(deform["border-radius"][3],0)+"px",
											 borderWidth:parseInt(deform["border-width"],0)+"px",
											 borderStyle:deform["border-style"],
											 onComplete:function() {
											 	if (params.inline && params.inline.hover!=undefined)					
													jQuery.each(params.inline.hover, function(key,value) {
														inlayer.css(key,value);
													})
											 },
											 ease:deform.easing
							}));
			if (params.type==="svg" && params.svg!=undefined) {					
					var svgstrokecolor = params.svg["svgstroke-hover-color"] || "transparent",
						svgstroketrans = params.svg["svgstroke-hover-transparency"] || 0,
						svgstrokewidth = params.svg["svgstroke-hover-width"] || 0,
						svgstrokedasharray = params.svg["svgstroke-hover-dasharray"] || 0,
						svgstrokedashoffset = params.svg["svgstroke-hover-dashoffset"] || 0;

					// STROKE OPACITY
					if (Number(svgstroketrans)<1) {
						var rgb = UniteAdminRev.convertHexToRGB(svgstrokecolor);
						svgstrokecolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+svgstroketrans+")";
					}
					

					tl.add(punchgs.TweenLite.to(inlayer.find('svg'),hoverspeed,{
																	fill:fontcolor,
																	stroke:svgstrokecolor,
																	strokeWidth:svgstrokewidth,
																	strokeDasharray:svgstrokedasharray,
																	strokeDashoffset:svgstrokedashoffset,
																	ease:deform.easing
																}),0);				
			}

			inlayer.data('hoveranim',tl);
			

			

			// ADD HOVER ON THE ELEMENT
			if (caption.data('hoverexist')===undefined || caption.data('hoverexist')===false)  {
				caption.hover(function() {
				  if (jQuery('#rs-style-tab-button').hasClass("selected")) {
					if (jQuery('#toggle-idle-hover').hasClass("idleisselected")) {
						var inlayer = jQuery(this).find('.innerslide_layer');
						if (inlayer.length>0 && inlayer.data('hoveranim')!=undefined) {
							var tl = inlayer.data('hoveranim');
							tl.play(0);
						}
					}
				  }
				},function() {
					if (jQuery('#rs-style-tab-button').hasClass("selected")) {
						if (jQuery('#toggle-idle-hover').hasClass("idleisselected")) {
							var inlayer = jQuery(this).find('.innerslide_layer');
							if (inlayer.length>0 && inlayer.data('hoveranim')!=undefined) {
								var tl = inlayer.data('hoveranim');
								tl.reverse();
							}
						}
					}
				});
				caption.data('hoverexist',true);
			} 


			
			
			
			if (jQuery('#toggle-idle-hover').hasClass("hoverisselected")) {				
				tl.seek(tl.endTime());
			} else {				
				tl.seek(0);
				tl.pause(0);
				setTimeout(function() {					
					tl.pause(0);
				},109)
			}
		} else {
			caption.unbind("hover");
			caption.data("hoverexist",false);
		}

		/*else {
			if (inlayer.data('hoveranim')!=undefined) {
				var tl = inlayer.data('hoveranim');
				tl.clear();
				tl.kill();
			} 
			caption.unbind("hover");
			caption.data('hoverexist',false);
		}*/

	}

	/******************************************************************************************
			-	ANIMATE CURRENT SELECTED LAYER IN AND OUT ON SHORT TIMEFRAME	-
	********************************************************************************************/

	t.animateCurrentSelectedLayer = function(delay) {
		

		//	if (delay==undefined) delay = 229;
			u.removeCurrentLayerRotatable();
			var nextcaption = jQuery('.slide_layer.layer_selected .innerslide_layer');
			
			if (nextcaption.length==0) {
					return false;
			}
			if (nextcaption.data('tl')==undefined)
				var tl=new punchgs.TimelineLite();
			else
				var tl = nextcaption.data('tl');
			
			tl.clear();
			tl.kill();
			tl.pause();
			
				
	
			nextcaption.data('inanim',theLayerInAnimation(nextcaption));
			nextcaption.data('outanim',theLayerOutAnimation(nextcaption));

			// RUN THE IN ANIMATION
			tl.addLabel("inanimation");
			tl.add(nextcaption.data('inanim'),"=+0.2");

			// ADD SOME ANIMATION ON THE IN/OUT TABS
			tl.addLabel("outanimation");
			tl.add(punchgs.TweenLite.fromTo(jQuery('#startanim_timerunner'),1,{x:0,y:0},{y:41}),"outanimation");
			tl.add(punchgs.TweenLite.fromTo(jQuery('#startanim_timerunnerbox'),1,{x:0,y:0},{y:41}),"outanimation");
			tl.add(punchgs.TweenLite.fromTo(jQuery('#endanim_timerunnerbox'),1,{x:0,y:-41},{x:0,y:0}),"outanimation");
			tl.add(punchgs.TweenLite.fromTo(jQuery('#endanim_timerunner'),1,{x:0,y:-41},{y:0}),"outanimation");
			tl.add(punchgs.TweenLite.set(jQuery('#endanim_wrapper'),{width:67,autoAlpha:1}),"outanimation");

			// RUN THE OUT ANIMATION
			tl.add(nextcaption.data('outanim'));
			tl.eventCallback("onComplete",function() {
				tl.restart();
			})


			tl.play();

			nextcaption.data('tl',tl);
			
		}


	/***************************************
		-	BUILD IN ANIMATION TIMELINE	-
	****************************************/

	var checkAnimValue = function(val,defval,nextcaption,direction) {
		var v = val,
			d = defval;


		if (jQuery.isNumeric(parseFloat(v))) {				
			return parseFloat(v);
		} else 
		if (v===undefined || v==="inherit") {				
			return d;
		} else 
		if (v.split("{").length>1) {
			var min = v.split(",");
				max = min[1].split("}")[0];
			min = min[0].split("{")[1];
			v = Math.random()*(max-min) + min;				
			return v;
		} else {
			var cw = jQuery('#divLayers').width(),
				ch = jQuery('#divLayers').height(),
				el = nextcaption.closest('.slide_layer'),
				elw = el.width(),
				elh = el.height(),
				p = el.position();

			if (v.match(/%]/g)) {
				v = v.split("[")[1].split("]")[0];				
				if (direction=="horizontal")
					v = elw*parseInt(v,0)/100;
				else
				if (direction=="vertical")
					v = elh*parseInt(v,0)/100;
			} else 

			switch (v.toLowerCase()) {
				case "top":
				case "stage_top":
					v = 0-elh-p.top;						
				break;
				case "bottom":						
				case "stage_bottom":						
					v = ch;
				break;
				case "stage_left":
				case "left":
					v = 0-elw-p.left;
				break;
				case "right":
				case "stage_right":
					v = cw;
				break;
				case "center":
				case "stage_center":
					v =  (cw/2 - p.left - elw/2);
				break;
				case "middle":
				case "stage_middle":
					v =  (ch/2 - p.top - elh/2);
				break;


				case "layer_top":
					v = 0-elh;						
				break;
				case "layer_bottom":						
					v = elh;
				break;
				case "layer_left":
					v = 0-elw;
				break;
				case "layer_right":
					v = elw;
				break;
				case "layer_center":					
					v =  elw/2;
				break;
				case "layer_middle":
					v =  elh/2;
				break;
				default:
				break;
			}				
			
			return v;
		}		
		return v;	
	}	


	function theLayerInAnimation(nextcaption) {

		
		var id = u.getSerialFromID(nextcaption.closest('.slide_layer').attr('id')),
			params = new Object();		
		params=jQuery.extend(true,{},params, u.getLayer(id));
		
		
		if (!nextcaption.parent().hasClass("tp-mask-wrap")) 
			nextcaption.wrap('<div style="width:100%;height:100%;position:relative;" class="tp-mask-wrap"></div>');

		
		var	mask = nextcaption.closest('.tp-mask-wrap'),
			anim = params.animation,
			speed = params.speed/1000,
			easedata = params.easing,
			mdelay = params.splitdelay/100,
			$split = params.split,
			$endsplit = params.endsplit, 
			animobject = nextcaption,
			thesource = new Object(),
			theresult = new Object();

		

		thesource.transx = 0;
		thesource.transy = 0;
		thesource.transz = 0;
		thesource.rotatex = 0;
		thesource.rotatey = 0;
		thesource.rotatez = 0;
		thesource.scalex = 1;
		thesource.scaley = 1;
		thesource.skewx = 0;
		thesource.skewy = 0;
		thesource.opac = 0;
		thesource.tper = parseFloat(params.deformation.pers);
		thesource.origin = "center,center",

		
			//parseInt(u.getVal(ss,"font-size"),0)+"px",
		theresult.transx = 0;
		theresult.transy = 0;
		theresult.transz = parseFloat(params.deformation.z);
		theresult.rotatex = parseFloat(params.deformation.xrotate);
		theresult.rotatey = parseFloat(params.deformation.yrotate);
		theresult.rotatez = parseFloat(params["2d_rotation"]);
		theresult.scalex = parseFloat(params.deformation.scalex);
		theresult.scaley = parseFloat(params.deformation.scaley);
		theresult.skewx = parseFloat(params.deformation.skewx);
		theresult.skewy = parseFloat(params.deformation.skewy);
		theresult.opac = parseFloat(params.deformation.opacity);
		theresult.tper = parseFloat(params.deformation.pers);
		

		var originx = params["layer_2d_origin_x"]+"%",
			originy = params["layer_2d_origin_y"]+"%",
			origin = originx+" "+originy;



		if (nextcaption.data('mySplitText') != undefined)
			if ($split !="none" || $endsplit !="none") 
				try{nextcaption.data('mySplitText').revert();} catch(e) {}

		if ($split == "chars" || $split == "words" || $split == "lines" || $endsplit == "chars" || $endsplit == "words" || $endsplit == "lines" ) {
			if (nextcaption.find('a').length>0)
				nextcaption.data('mySplitText',new SplitText(nextcaption.find('a'),{type:"lines,words,chars"}));
			else
				nextcaption.data('mySplitText',new SplitText(nextcaption,{type:"lines,words,chars"}));
		} else {
			nextcaption.data('mySplitText',"none");
		}

		

		
		switch($split) {
			case "chars":
				animobject = nextcaption.data('mySplitText').chars;
			break;
			case "words":
				animobject = nextcaption.data('mySplitText').words;
			break;
			case "lines":
				animobject = nextcaption.data('mySplitText').lines;
			break;
		}

		var timedelay=((animobject.length*mdelay) + speed)*1000;

		punchgs.TweenLite.killTweensOf(nextcaption,false);
		punchgs.TweenLite.killTweensOf(animobject,false);		
		punchgs.TweenLite.set(mask,{clearProps:"transform"});
		punchgs.TweenLite.set(nextcaption,{clearProps:"transform"});
		punchgs.TweenLite.set(animobject,{clearProps:"transform"});


		var tl = new punchgs.TimelineLite(),
			tt = new punchgs.TimelineLite();

		if (animobject != nextcaption) {
			tl.add(punchgs.TweenLite.set(nextcaption, { scaleX:theresult.scalex, scaleY:theresult.scaley,
						  rotationX:theresult.rotatex, rotationY:theresult.rotatey, rotationZ:theresult.rotatez,
						  x:theresult.transx, y:theresult.transy, z:theresult.transz+1,
						  skewX:theresult.skewx, skewY:theresult.skewy,
						  transformPerspective:theresult.tper, transformOrigin:origin,
						  autoAlpha:theresult.opac,overwrite:"all"}));
		}
		

		if (nextcaption.data("timer")) clearTimeout(nextcaption.data('timer'));
		if (nextcaption.data("timera")) clearTimeout(nextcaption.data('timera'));

		
			
		

		thesource.transx = checkAnimValue(params.x_start,theresult.transx,nextcaption,"horizontal");
		thesource.transy = checkAnimValue(params.y_start,theresult.transy,nextcaption,"vertical");
		thesource.transz = checkAnimValue(params.z_start,theresult.transz,nextcaption);
		thesource.rotatex = checkAnimValue(params.x_rotate_start,theresult.rotatex,nextcaption);
		thesource.rotatey = checkAnimValue(params.y_rotate_start,theresult.rotatey,nextcaption);
		thesource.rotatez = checkAnimValue(params.z_rotate_start,theresult.rotatez,nextcaption);
		thesource.scalex = checkAnimValue(params.scale_x_start,theresult.scalex,nextcaption);
		thesource.scaley = checkAnimValue(params.scale_y_start,theresult.scaley,nextcaption);
		thesource.skewx = checkAnimValue(params.skew_x_start,theresult.skewx,nextcaption);
		thesource.skewy =checkAnimValue( params.skew_y_start,theresult.skewy,nextcaption);
		thesource.opac = checkAnimValue(params.opacity_start,theresult.opac,nextcaption);
		thesource.tper = params.deformation.pers;

		
		tl.add(tt.set(animobject,{clearProps:"transform"}),0);
		tl.add(tt.staggerFromTo(animobject,speed,
						{ scaleX:thesource.scalex,
						  scaleY:thesource.scaley,
						  rotationX:thesource.rotatex, rotationY:thesource.rotatey, rotationZ:thesource.rotatez,
						  x:thesource.transx, y:thesource.transy, z:thesource.transz,
						  skewX:thesource.skewx, skewY:thesource.skewy,
						  transformPerspective:thesource.tper, transformOrigin:origin,
						  autoAlpha:thesource.opac

						},
						{ scaleX:theresult.scalex, scaleY:theresult.scaley,
						  rotationX:theresult.rotatex, rotationY:theresult.rotatey, rotationZ:theresult.rotatez,
						  x:theresult.transx, y:theresult.transy, z:theresult.transz,
						  skewX:theresult.skewx, skewY:Number(theresult.skewy),
						  transformPerspective:theresult.tper, transformOrigin:origin,
						  ease:easedata,
						  autoAlpha:theresult.opac,overwrite:"all",
						  force3D:"auto",
						},mdelay
						));

		// MASK ANIMATION
		if (!params.mask_start) tl.add(punchgs.TweenLite.set(mask,{overflow:"visible"}),0);


		// MASK ANIMATION
		if (params.mask_start) {			
			var maskp = new Object();
			maskp.x = checkAnimValue(params.mask_x_start,params.mask_x_start,nextcaption,"horizontal");
			maskp.y = checkAnimValue(params.mask_y_start,params.mask_y_start,nextcaption,"vertical");						
			tl.add(punchgs.TweenLite.fromTo(mask,speed,{overflow:"hidden",x:maskp.x,y:maskp.y},{x:0,y:0,ease:easedata}),0);
		}

		if (params.mask_start || params.mask_end)
			mask.addClass('tp-showmask');
		else
			mask.removeClass('tp-showmask');

		nextcaption.data('startanimobj',thesource);

		tl.add(punchgs.TweenLite.fromTo(jQuery('#startanim_wrapper'),tt.totalDuration(),{autoAlpha:1,width:0},{width:67,ease:easedata}),0);
		if (animobject != nextcaption)
			tl.add(punchgs.TweenLite.fromTo(nextcaption.parent(), 0.2,{autoAlpha:0},{autoAlpha:1}),0);		
		
		return tl;

	}

	/***************************************
		-	BUILD OUT ANIMATION TIMELINE	-
	****************************************/
	function theLayerOutAnimation(nextcaption) {
		var id = u.getSerialFromID(nextcaption.closest('.slide_layer').attr('id')),
				params = new Object();
		
		params=jQuery.extend(true,{},params, u.getLayer(id));


		var	mask = nextcaption.closest('.tp-mask-wrap'),
			anim = params.endanimation,
			speed = params.endspeed/1000,
			easedata = params.endeasing,
			mdelay = params.endsplitdelay/100,
			$split = params.endsplit,
			animobject = nextcaption;
			theanim = new Object(),
			theresult = new Object(),
			originx = params["layer_2d_origin_x"]+"%",
			originy = params["layer_2d_origin_y"]+"%",
			origin = originx+" "+originy;

		easedata = easedata=="nothing" ? params.easing :  easedata;

		theanim.transx = 0;
		theanim.transy = 0;
		theanim.transz = 0;
		theanim.rotatex = 0;
		theanim.rotatey = 0;
		theanim.rotatez = 0;
		theanim.scalex = 1;
		theanim.scaley = 1;
		theanim.skewx = 0;
		theanim.skewy = 0;
		theanim.opac = 0;
		theanim.tper = parseFloat(params.deformation.pers);;


		theresult.transx = 0;
		theresult.transy = 0;
		theresult.transz = parseFloat(params.deformation.z);
		theresult.rotatex = parseFloat(params.deformation.xrotate);
		theresult.rotatey = parseFloat(params.deformation.yrotate);
		theresult.rotatez = parseFloat(params["2d_rotation"]);
		theresult.scalex = parseFloat(params.deformation.scalex);
		theresult.scaley = parseFloat(params.deformation.scaley);
		theresult.skewx = parseFloat(params.deformation.skewx);
		theresult.skewy =parseFloat( params.deformation.skewy);
		theresult.opac = parseFloat(params.deformation.opacity);
		theresult.tper = parseFloat(params.deformation.pers);

		switch($split) {
			case "chars":
				animobject = nextcaption.data('mySplitText').chars;
			break;
			case "words":
				animobject = nextcaption.data('mySplitText').words;
			break;
			case "lines":
				animobject = nextcaption.data('mySplitText').lines;
			break;
		}
			
		  var timedelay=((animobject.length*mdelay) + speed)*1000;

		  var tl = new punchgs.TimelineLite(),
			  tt = new punchgs.TimelineLite();

		
		if (anim == null) anim = "auto";
				
		
		// MASK ANIMATION
		if (!params.mask_end || (anim==="auto" && !params.mask_start)) 			
			tl.add(punchgs.TweenLite.set(mask,{overflow:"visible"}));


		if (anim==="auto") {
			theanim = nextcaption.data('startanimobj');
		} else {		
			var mask_is_on = params.mask_end || (anim==="auto" && params.mask_start) ? true : false;

			theanim.transx = checkAnimValue(params.x_end,theresult.transx,nextcaption,"horizontal");
			theanim.transy = checkAnimValue(params.y_end,theresult.transy,nextcaption,"vertical");
			theanim.transz = checkAnimValue(params.z_end,theresult.transz,nextcaption);
			theanim.rotatex = checkAnimValue(params.x_rotate_end,theresult.rotatex,nextcaption);
			theanim.rotatey = checkAnimValue(params.y_rotate_end,theresult.rotatey,nextcaption);
			theanim.rotatez = checkAnimValue(params.z_rotate_end,theresult.rotatez,nextcaption);
			theanim.scalex = checkAnimValue(params.scale_x_end,theresult.scalex,nextcaption);
			theanim.scaley = checkAnimValue(params.scale_y_end,theresult.scaley,nextcaption);
			theanim.skewx = checkAnimValue(params.skew_x_end,theresult.skewx,nextcaption);
			theanim.skewy =checkAnimValue( params.skew_y_end,theresult.skewy,nextcaption);
			theanim.opac = checkAnimValue(params.opacity_end,theresult.opac,nextcaption);
			theanim.tper = params.deformation.pers;
		}
		
		//	

		
		
		tl.add(tt.staggerTo(animobject,speed,
								{
								  scaleX:theanim.scalex,
								  scaleY:theanim.scaley,
								  rotationX:theanim.rotatex,
								  rotationY:theanim.rotatey,
								  rotationZ:theanim.rotatez,
								  x:theanim.transx,
								  y:theanim.transy,
								  z:theanim.transz+1,
								  skewX:theanim.skewx,
								  skewY:theanim.skewy,
								  opacity:theanim.opac,
								  transformPerspective:theanim.tper,
								  transformOrigin:origin,
								  ease:easedata
								 },mdelay));

		
		// MASK ANIMATION
		if (params.mask_end) {
			var maskp = new Object();					
			maskp.x = checkAnimValue(params.mask_x_end,params.mask_x_end,nextcaption);
			maskp.y = checkAnimValue(params.mask_y_end,params.mask_y_end,nextcaption);					
			tl.add(punchgs.TweenLite.to(mask,speed,{x:maskp.x,y:maskp.y,ease:easedata,overflow:"hidden"},mdelay),0);
		} else 

		if (anim==="auto" && params.mask_start) {
			var maskp = new Object();			
			maskp.x = checkAnimValue(params.mask_x_start,params.mask_x_start,nextcaption);
			maskp.y = checkAnimValue(params.mask_y_start,params.mask_y_start,nextcaption);			
			tl.add(punchgs.TweenLite.to(mask,speed,{x:maskp.x,y:maskp.y,ease:easedata},mdelay),0);
		}

		tl.add(punchgs.TweenLite.fromTo(jQuery('#endanim_timerunnerbox'),tt.totalDuration(),{x:0},{x:-67,ease:easedata}),0);
		tl.add(punchgs.TweenLite.fromTo(jQuery('#endanim_timerunner'),tt.totalDuration(),{x:0},{x:-67,ease:easedata}),0);
		if (animobject != nextcaption)
			tl.add(punchgs.TweenLite.fromTo(nextcaption.parent(), 0.2,{autoAlpha:1},{autoAlpha:0}),(tt.totalDuration()-0.2));		
		return tl;
	}




	/******************************************************************************************
		-	PUT THE BLUE TIMER LINE IN POSITION BASED ON DEFAULT OR PREDEFINED VALUES 	-
	******************************************************************************************/
	var initSlideDuration = function() {

		// SET MAXTIME POSITION
		var duration = jQuery('#delay').val();
		if (duration==undefined || duration==0 || duration=="undefined")
			duration = g_slideTime;
		jQuery('#mastertimer-maxtime').css({left:15 + duration/10});


	}




	/******************************************************************************************
		-	EVENT LISTENER FOR MASTER TIME POSITION CHANGE, ALL ANIMATION MOVE IN POSTION 	-
	********************************************************************************************/

	t.masterTimerPositionChange = function(recreatetimers) {


			var mp = jQuery('#mastertimer-position'),
				tpos = (mp.position().left-15)/100,
				mst = jQuery('#divbgholder').data('slidetimeline');

			mp.addClass("hovering");
			if (tpos<=0 && (mp.data('wasidle')=="wasnotidle" || mp.data('wasidle')==undefined)) {

				t.stopAllLayerAnimation();
				mp.data('wasidle',"wasidle");
				var mp = jQuery('#mastertimer-position');
				if (mp.data('tl')!=undefined) {
					mp.data('tl').kill();
				}
				if (mst!=undefined) {
					mst.stop();
					mst.seek(100000);
				}
					
				t.allLayerToIdle();
			}

			if (tpos>0 && (mp.data('wasidle')=="wasidle" || mp.data('wasidle')==undefined)) {
				mp.data('wasidle','wasnotidle');
				createGlobalTimeline(true);
				jQuery('#mastertimer-playpause-wrapper').html('<i class="eg-icon-play"></i><span>PLAY</span>');
				jQuery('#mastertimer-position').addClass("inaction");
			}

			if (tpos>0 && mp.data('wasidle')=="wasnotidle") {
				if (recreatetimers) createGlobalTimeline(false);
				var mtl = mp.data('tl');
				mtl.stop();
				mst.stop();
				mtl.seek(tpos);
				mst.seek(tpos);
			}
			
			if (tpos>0) {
				jQuery('#mastertimer-poscurtime').addClass("movedalready").html(t.convToTime(tpos*100));
			} else {
				if (jQuery('#mastertimer-poscurtime').hasClass("movedalready"))
					jQuery('#mastertimer-poscurtime').html("Idle");
			}
			mp.trigger('poschanged');
		}

	t.convToTime = function(tpos) {


		
		var min = Math.floor(tpos/6000),
			sec = Math.floor(Math.ceil(tpos - (min*6000))/100),
			ms = Math.round(tpos-(sec*100)-(min*6000));

		if (min==0) min = "00"
		else
		if (min<10) min = "0"+min.toString();

		if (sec==0) sec = "00"
		else
		if (sec<10) sec = "0"+sec.toString();

		if (ms==0) ms = "00"
		else
		if (ms<10) ms = "0"+ms.toString()
		return min.toString()+":"+sec.toString()+"."+ms.toString();

	}
	
	
	t.allLayerToIdle = function(obj) {		
		var search = obj!=undefined && obj.type!=undefined ? '.slide_layer_type_'+obj.type : '.slide_layer';				
		jQuery(search).each(function() {	
			t.rebuildLayerIdle(jQuery(this));
		});
		
	}

	/***********************************
		-	INIT THE MASTER TIMER	-
	************************************/
	var initMasterTimer = function() {
		var mw = jQuery('#master-rightheader');


		// CHANGE THE POSITION OF THE TIME LINE
		jQuery('#mastertimer-position').on("poschanged",function() {
			var mp = jQuery(this),
				tpos = Math.round((mp.position().left-15)),
				str = t.convToTime(tpos);
			if (tpos<0.015) str="IDLE";
			jQuery('#master-timer-time').html(str);
		});


		// BACK TO IDLE
		jQuery('#mastertimer-backtoidle').click(function() {
			jQuery('#mastertimer-position').removeClass("inaction");
			jQuery('#mastertimer-playpause-wrapper').html('<i class="eg-icon-play"></i><span>PLAY</span>');		
			t.stopAllLayerAnimation();
			var mp = jQuery('#mastertimer-position'),
				mst = jQuery('#divbgholder').data('slidetimeline');
			mp.css({left:"7px"});			
			if (mp.data('tl')!=undefined) {
				mp.data('tl').kill();
			}
			if (mst!=undefined) {
				mst.stop();
				mst.seek(100000);
			}


			t.allLayerToIdle();

			
		})
		
		
		// HOVER OUT OF MASTERTIMER SHOULD RESET ANY SETTINGS
		jQuery('#divLayers').hover(function() {

			var mp = jQuery('#mastertimer-position'),
				mpw = jQuery('#mastertimer-playpause-wrapper'),
				mst = jQuery('#divbgholder').data('slidetimeline');
			if (mp.data('tl')!=undefined)
				mp.data('tl').stop();
			
			if (mst!=undefined) {
				mst.stop();
				mst.seek(100000);
			}

			jQuery('#mastertimer-position').removeClass("inaction");
			jQuery('#mastertimer-playpause-wrapper').html('<i class="eg-icon-play"></i><span>PLAY</span>');
			if (mp.hasClass("hovering")) {
				mp.removeClass("hovering");
				t.stopAllLayerAnimation();
				t.allLayerToIdle();

				// Click on LayerAnimation Button the current Selected Layer should be Animated
				if (!jQuery('#layeranimation-playpause').hasClass("inpuase")) {
					if (t.checkAnimationTab())
						t.animateCurrentSelectedLayer(1);
				}

				if (!jQuery('#loopanimation-playpause').hasClass("inpuase")) {
					if (t.checkLoopTab())
						t.animateCurrentSelectedLayer(2);
				}
			}

		});

		// HOVER ON THE ANIMATION PART, SHOULD START THE ANIMATION MODE AGAIN
		jQuery('#mastertimer-wrapper').hover(function() {
			if (!jQuery(this).hasClass("overme")) {
				jQuery(this).addClass("overme");
				t.masterTimerPositionChange(true);
			}
		}, function() {
			jQuery(this).removeClass("overme");

		})


		
		// DRAG THE MASTER TIMER SHOULD ANIMATE THINGS IN POSITION
		jQuery('#mastertimer-position').draggable({
			axis:"x",
			start:function() {
				punchgs.TweenLite.set(jQuery('#mastertimer-poscurtime'),{autoAlpha:1,x:-1,y:0});
			},
			drag:function() {
				t.masterTimerPositionChange(false)
			},
			containment:"#master-rightheader",
			stop:function() {
				punchgs.TweenLite.to(jQuery('#mastertimer-poscurtime'),0.3,{autoAlpha:0,x:-3,y:-10,ease:punchgs.Power2.easeInOut});

			}
		});

		// CLICK SOMEWHERE ON THE LINEAR
		jQuery('#mastertimer-linear').click(function(e) {
			var lo = jQuery('#mastertimer-linear').offset().left,
				sl = jQuery('#master-rightheader').scrollLeft();

			jQuery('#mastertimer-position').css({left:(e.pageX-lo + sl+15)+"px"});
			t.masterTimerPositionChange();
		})
		
		jQuery('#mastertimer-maxtime').draggable({
			axis:"x",			
			containment:"#master-rightheader",
			create:function() {
				t.mainMaxTimeLeft = jQuery('#mastertimer-maxtime').position().left;
				jQuery('#mastertimer-maxcurtime').html(t.convToTime(t.mainMaxTimeLeft-15));
				jQuery('.slide-idle-section').css({left:t.mainMaxTimeLeft});
			},
			start:function() {
				jQuery('#mastertimer-maxcurtime').html(t.convToTime(t.mainMaxTimeLeft-15));
				jQuery('.slide-idle-section').css({left:t.mainMaxTimeLeft});
			},
			drag:function() {
				var w = jQuery('#mastertimer-maxtime').position().left;
				t.mainMaxTimeLeft = w;
				jQuery('#mastertimer-maxcurtime').html(t.convToTime(w-15));
				jQuery('.slide-idle-section').css({left:w});
				jQuery('#delay').val((w-15)*10);
				jQuery('.mastertimer-slide .tl-fullanim').css({width:(w-15)+"px"});
				t.compareLayerEndsVSSlideEnd();
			},
			stop:function() {
				var w = jQuery('#mastertimer-maxtime').position().left;
				t.mainMaxTimeLeft = w;
				jQuery('#mastertimer-maxcurtime').html(t.convToTime(w-15));
				jQuery('.slide-idle-section').css({left:w});
				jQuery('#delay').val((w-15)*10);
				jQuery('.mastertimer-slide .tl-fullanim').css({width:(w-15)+"px"});
				g_slideTime = (w-15)*10;
				u.setMaintime(g_slideTime);
				t.compareLayerEndsVSSlideEnd();
				t.rerenderAllAudioMap();
			}

		});

		
		__ctime = jQuery('#mastertimer-curtime');
		__ctimeb = jQuery('#mastertimer-curtime-b');
		__ctimei = jQuery('#mastertimer-curtimeinner');

		function checklroffset() {
			__coffset = parseInt(jQuery('#layers-right').offset().left,0);
		}

		jQuery(window).resize(function() {
				checklroffset();		
		});

		checklroffset();
		__ctime.data('offset',0);
		
		jQuery('.master-rightcell').on('mousemove',function(e) {
			var x = (e.pageX-__coffset)-jQuery('#master-rightheader').data('left');
			if (__ctime.data('offset') ==0) {				
				punchgs.TweenLite.set(__ctime,{left:x});
				punchgs.TweenLite.set(__ctimeb,{left:x});
				__ctimei.html(t.convToTime(x-15));
			}
		});

		
		// CLICK ON PLAY/PAUSE BUTTON SHOULD PLAY OR RESET THINGS
		jQuery('#mastertimer-playpause-wrapper').click(function() {
			var mpw = jQuery(this);
			punchgs.TweenLite.to(jQuery('#mastertimer-poscurtime'),0.3,{autoAlpha:0,x:-3,y:-10,ease:punchgs.Power2.easeInOut});
			if (mpw.find('.eg-icon-pause').length>0) {

				jQuery('#mastertimer-playpause-wrapper').html('<i class="eg-icon-play"></i><span>PLAY</span>');
				t.stopAllLayerAnimation();
				var mp = jQuery('#mastertimer-position');
				if (mp.data('tl')!=undefined) {
					mp.data('tl').kill();
				}
			} else {
				createGlobalTimeline(true);
				jQuery('#mastertimer-playpause-wrapper').html('<i class="eg-icon-pause"></i><span>PAUSE</span>');
				jQuery('#mastertimer-position').addClass("inaction");
				var mp = jQuery('#mastertimer-position'),
					mtl = mp.data('tl'),
					mst = jQuery('#divbgholder').data('slidetimeline'),
					tpos = (mp.position().left-15)/100;

				mtl.play(tpos);
				mst.play(tpos);
				jQuery('#divbgholder').data('slidetimeline').play(tpos);				
				mtl.eventCallback("onComplete",function() {
					mtl.play(0);
					mst.play(0);
				});
				mtl.eventCallback("onUpdate",function() {
					mp.css({left:(15+(mtl.time()*100))});
					mp.trigger('poschanged');
				})
			}
		})

	}

	/**********************************
		-	BUILD GLOBAL TIMELINE	-
	***********************************/
	function createGlobalTimeline(firsttime,animsaregenerated) {

		if (firsttime) t.stopAllLayerAnimation();
		var mp = jQuery('#mastertimer-position');


		if (mp.data('tl')!=undefined) {
			mp.data('tl').kill();
		}

		var mtl = new punchgs.TimelineLite();
		mtl.pause();
		
		jQuery(' .slide_layer .innerslide_layer').each(function() {
			var nextcaption = jQuery(this);
		
			nextcaption.data('inanim',theLayerInAnimation(nextcaption));
			nextcaption.data('outanim',theLayerOutAnimation(nextcaption));
			var id = u.getSerialFromID(nextcaption.closest('.slide_layer').attr('id'));
				params=u.getLayer(id);

			mtl.add(nextcaption.data('inanim'),params.time/1000);
			var endspeed = params.endspeed;
			if (endspeed==undefined) endspeed = params.speed;
			mtl.add(nextcaption.data('outanim'),(params.endtime/1000 - endspeed/1000));

		});

		mp.data('tl',mtl);
	}
	
	var setFakeAnim = function() {
		
		var found=false,
			li = jQuery('.slide-trans-cur-ul li').first();
		
		var comingtransition = li.data('animval'),
			comingtext = li.text();

		if (comingtransition == "random-selected" || comingtransition == "random" || comingtransition == "random-static" || comingtransition == "random-premium") {
			comingtransition = "fade";
			comingtext = "Fade";
		} 

		
		jQuery('#fake-select-label').html(comingtext);					
		jQuery('#fake-select-label').data('valu',comingtransition);
		
		removeAllSlots();
		
		slideAnimation();
		found=true;
		
		if (found) return false;		
	}
	/**************************************
		-	ADD SLIDE MAIN TO SORTBOX	-
	**************************************/

	var setSlideTransitionTimerBar = function() {
		var cur = jQuery('#slide_in_sort_time'),
			dragspeedin = cur.find('.tl-startanim'),
			dur = jQuery('#transition_duration').val(),
			maxtime = (t.mainMaxTimeLeft)-15;			
		cur.find('.tl-fullanim').css({left:"15px",width:maxtime});
		cur.find('.tl-startanim').css({width:dur/10});
		cur.find('.sortbox_speedin').html(msToSec(dur));
	}


	var addSlideToSortbox = function() {

		
		var htmlSortbox = "";
			
		var cur = jQuery('#slide_in_sort_time'),
			dragspeedin = cur.find('.tl-startanim'),
			dur = jQuery('#transition_duration').val(),
			maxtime = (t.mainMaxTimeLeft)-15;			
		cur.find('.tl-fullanim').css({left:"15px",width:maxtime});
		cur.find('.tl-startanim').css({width:dur/10});
		cur.find('.sortbox_speedin').html(msToSec(dur));
		

		
		
		//setFakeAnim();
		
		
		cur.on('click',function() {
			jQuery('#timline-manual-dialog').hide();
		})
		
		dragspeedin.resizable({
			minWidth:0,
			handles:"e",
			start:function() {
				var w = maxtime,
					spt = cur.find('.tl-startanim').width()*10;
				dragspeedin.resizable("option","maxWidth",(w));
				jQuery(this).closest('li').addClass("showstartspeed");
				dragspeedin.closest('.timeline').addClass("onchange");
				jQuery('#timline-manual-dialog').hide();
				cur.find('.sortbox_speedin').html(msToSec(spt));
			},
			stop:function() {
				jQuery(this).closest('li').removeClass("showstartspeed");
				dragspeedin.closest('.timeline').removeClass("onchange");
				t.resetSlideAnimations(true);

			},
			resize:function() {
				var spt = cur.find('.tl-startanim').width()*10;
				jQuery('#transition_duration').val(spt);
				cur.find('.sortbox_speedin').html(msToSec(spt));
			}
			//snap:".tl-fullanim"
		});
		
		
		
	}

	
	t.resetTimeLineHeight = function() {
		// SET HEIGHT OF MASTERTIMER
		var maxh = jQuery('#layers-right>ul').height();				
		punchgs.TweenLite.set(jQuery('#mastertimer-position'),{height:maxh+40});						
	}


	//////////////////////////////////
	// 		SET AUDIO MAP 			//
	//////////////////////////////////

	t.rerenderAllAudioMap = function() {
		jQuery.each(u.arrLayers,function(i,objLayer) {			
			if (objLayer.type == "audio") {				
				t.drawAudioMap(objLayer);
			}
		});
	};


	t.drawAudioMap = function(objLayer) {
	 	
	 	try {
		 	var li = jQuery('#layer_sort_time_'+objLayer.serial);	 	
		 	if (li.data('lastaudio') == objLayer.video_data.urlAudio && li.data('audiobuffer')!=undefined) {	 		
		 		displayAudioBuffer(li,li.data('audiobuffer'));
		 	} else {
		 		loadMusicTimeLine(li,objLayer.video_data.urlAudio);
		 	}

		 	li.data('lastaudio',objLayer.video_data.urlAudio);
			

			if (!AudioContext) {
				console.log('Audio Map cannot be drawn  in your Browser. Try a recent Chrome or Firefox. ');
				return false;
			}
		} catch(e) { console.log("Drwaring of Audio Map Failer at Initialisation");}
		
	}
	
	

	// MUSIC LOADER + DECODE
	function loadMusicTimeLine(li,url) {   
		if (audioContext === null || !AudioContext) return false;
	    var req = new XMLHttpRequest(),	    	
	    	currentBuffer  = null;
	    
	    req.open( "GET", url, true );
	    req.responseType = "arraybuffer";    
	    
	    req.onreadystatechange = function (e) {
	          if (req.readyState == 4) {
	             if(req.status == 200)
	                  audioContext.decodeAudioData(req.response, 
	                    function(buffer) {
	                             currentBuffer = buffer;
	                             li.data('audiobuffer',buffer);
	                             displayAudioBuffer(li,buffer);
	                    }, onDecodeError);
	             else
	                  console.log('error during the load.Wrong url or cross origin issue');
	          }
	    } ;
	    req.send();
	}	

	function onDecodeError() {  alert('error while decoding your Audio file.');  }

	function getStartSec(st) {						
		return st == undefined ? -1 : st=="" ? -1 : st==" " ? -1 : jQuery.isNumeric(st) ? st : st.split(":").length>1 ? parseInt(st.split(":")[0],0)*60 + parseInt(st.split(":")[1],0) : st;
	};

	function displayAudioBuffer(li,buff) {
		try {
			var leftChannel = buff.getChannelData(0), // Float32Array describing left channel     
				wr = li.find('.tl-fullanim'),
				objLayer = li.data('objref'),
				canvasWidth =buff.duration*100,
			   	canvasHeight = 25,
			   	shift = objLayer.video_data.start_at,		   	
			   	s = getStartSec(objLayer.video_data.start_at),
			   	e = getStartSec(objLayer.video_data.end_at)
			
			s= s==-1 ? 0 : s;
			e= e==-1 ? 999999999 : e;		
			s= s * buff.sampleRate;
			e= e * buff.sampleRate;
			e = e>leftChannel.length ? leftChannel.length : e;
			canvasWidth = ((e-s)/buff.sampleRate)*100;
			
			li.find('canvas').remove();
			
			// CANVAS		
			var newCanvas   = document.createElement('canvas');
			newCanvas.width = ((t.mainMaxTimeLeft)-15);
			newCanvas.height = canvasHeight;			
			li.append(newCanvas);
			
			var jc = li.find('canvas');
			//punchgs.TweenLite.set(wr,{opacity:0.4});
			punchgs.TweenLite.set(jc,{zIndex:2,top:3,left:wr.position().left,position:"absolute"});

			var context = newCanvas.getContext('2d'),
				lineOpacity = canvasWidth / leftChannel.length;

			   
		   context.save();
		   context.fillStyle = 'transparent' ;
		   context.fillRect(0,0,canvasWidth,canvasHeight );
		   context.strokeStyle = '#333';	   
		   context.translate(0,canvasHeight / 2);
		   context.globalAlpha = 0.5 ; // lineOpacity ;
		   
		   var pl = 0,
		   	   seglength = e-s;
		   	   	  
			for (var i=s; i<e; i=i+200) {
			       // on which line do we get ?
			       var x = Math.floor (canvasWidth * i / seglength ) ;
			       
			       var y = leftChannel[i] * canvasHeight  ;
			       context.beginPath();
			       context.moveTo( x  , 0 );
			       context.lineTo( x+1, y );
			       context.stroke();
			       pl++;
			}

			if (objLayer.video_data.videoloop!="none") {
				var imgdata = context.getImageData(0, 0, canvasWidth, canvasHeight),
					lmult = (((t.mainMaxTimeLeft)-15) / canvasWidth);			

				for (var i=0;i<lmult;i++) {
					context.putImageData(imgdata,i*canvasWidth,0);
				}

			}

			//playSound(buff);
			
		   context.restore();	   
		 } catch(e) { console.log("Drawing of Audio Map failed !")}
	}

	



	/******************************
		-	ADD LAYER TO SORTBOX	-
	********************************/
	t.addToSortbox = function(serial,objLayer){

		
		if (jQuery('#layers-right ul li').length==1) 				
				addSlideToSortbox();
		

		if (serial===undefined) return false;

		
		var endslideclass = "",
			isVisible = t.isLayerVisible(serial),
			classLI = "",
			sortboxText = t.getSortboxText(objLayer.alias),
			depth = Number(objLayer.order)+5,
			htmlSortbox = "",
			quicksb  = ""
			visibleclass = "in-on";
			
		
			
		//if(isVisible == false)
		//	classLI = " sortitem-hidden";

		

		htmlSortbox += '<li id="layer_sort_'+serial+'" class="sortablelayers mastertimer-layer ui-state-default'+classLI+'">';
		htmlSortbox += '	<div style="width:5000px;position:absolute;left:0px;top:0px;">';
		htmlSortbox += '		<span class="mastertimer-timeline-selector-row tipsy_enabled_top" title="Select Layer in Timeline">';
		htmlSortbox += '			<input class="layer-on-timeline-selector" style="margin:0px" type="checkbox"/>';		
		htmlSortbox += '		</span>';
		htmlSortbox += '		<span  class="mastertimer-timeline-zindex-row tipsy_enabled_top" title="z-Index">';
		htmlSortbox += '			<i style="margin-left:15px;margin-right:0px;" class="layersortclass eg-icon-sort"></i>';
		htmlSortbox += '			<span class="sortbox_depth" title="z-Index">'+depth+'</span>';
		htmlSortbox += '		</span>';
		htmlSortbox += '		<span style="width:25px;border-right:1px solid #f1f1f1">';
		htmlSortbox += '			<span class="till_slideend tipsy_enabled_top '+endslideclass+'" title="Wait till Slides End / Custom End"><i class="eg-icon-back-in-time"></i><i class="eg-icon-download-2"></i></span>';
		htmlSortbox += '		</span>';
		htmlSortbox += '		<span class="sort-hover-part layer_sort_layer_text_field">';
		htmlSortbox += '			<span class="sortbox_text"><i class="layertypeclass ';		

		
		switch (objLayer.type) {
			case "text":
				htmlSortbox += 'rs-icon-layerfont';
		
			break;
			case "image":
				htmlSortbox += 'rs-icon-layerimage';
		
			break;
			case "video":
				htmlSortbox += 'rs-icon-layervideo';		
			break;

			case "audio":
				htmlSortbox += 'rs-icon-layeraudio';		
			break;
			
			case "button":
				htmlSortbox += 'rs-icon-layerbutton';		
			break;

			case "shape":
				htmlSortbox += 'rs-icon-layershape';		
			break;

			case "svg":
				htmlSortbox += 'rs-icon-layersvg';		
			break;
		}

		htmlSortbox += '"></i>';

		htmlSortbox += '				<input class="timer-layer-text" style="margin-top:-1px !important" type="text" enabled value="'+sortboxText + '">';

		htmlSortbox += '			</span>';
		htmlSortbox += '		</span>';
		htmlSortbox += '		<span class="timer-manual-edit"><i class="eg-icon-pencil"></i></span>'
		htmlSortbox += '	</div>';
		htmlSortbox += '<div class="timeline" style="display:none">';
		htmlSortbox += '<div class="tl-fullanim"><div class="tl-startanim"></div><div class="tl-endanim"></div></div>';
		htmlSortbox += '</div>';

		htmlSortbox += '</li>';

		quicksb += '<li id="layer_quicksort_'+serial+'" data-serial="'+serial+'" class="quicksortlayer ui-state-default layer-toolbar-li">';
		var btlist ='<span class="quick-edit-toolbar-in-list">';

		
		switch (objLayer.type) {
			case "text":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layerfont_n"></i>';
				btlist += '<span id="button_edit_layer_'+serial+'" class="button_edit_layer layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';
				btlist += '<span id="button_reset_size_'+serial+'" class="button_reset_size layer-short-tool revblue"><i class="eg-icon-resize-normal"></i></span>';
			break;	
			case "shape":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layershape_n"></i>';
				btlist += '<span id="button_edit_shape_'+serial+'" class="button_edit_shape layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
			break;
			case "button":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layerbutton_n"></i>';
				btlist += '<span id="button_edit_layer_'+serial+'" class="button_edit_layer layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';
				btlist += '<span id="button_reset_size_'+serial+'" class="button_reset_size layer-short-tool revblue"><i class="eg-icon-resize-normal"></i></span>';
			break;
			case "image":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layerimage_n"></i>';
				btlist += '<span  id="button_change_image_source_'+serial+'" class="button_change_image_source layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';
				btlist += '<span id="button_reset_size_'+serial+'" class="button_reset_size layer-short-tool revblue"><i class="eg-icon-resize-normal"></i></span>';
			break;
			case "video":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layervideo_n"></i>';
				btlist += '<span  id="button_change_video_settings_'+serial+'" class="button_change_video_settings layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';				
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
			break;
			case "audio":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layeraudio_n"></i>';
				btlist += '<span  id="button_changeaudio_settings_'+serial+'" class="button_change_audio_settings layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';				
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
				classLI = " layer-sort-audio-item"
			break;
			case "svg":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layersvg_n"></i>';
				btlist += '<span  id="button_changesvg_settings_'+serial+'" class="button_change_svg_settings layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';				
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
			break;
		}
		
		quicksb += '<input type="text" class="layer-title-in-list" value="'+sortboxText+'"></span>';
		quicksb += btlist;		
		quicksb += '<span id="button_delete_layer_'+serial+'" class="button_delete_layer layer-short-tool revred"><i class="rs-lighttrash"></i></span>';
		quicksb += '<span id="button_duplicate_layer_'+serial+'" class="button_duplicate_layer layer-short-tool revyellow" data-isstatic=""><i class="rs-lightcopy"></i></span>';
		quicksb += '<span style="display:block;float:none;clear:both"></span></span>';
		quicksb += '<span class="quick-layer-view layer-short-tool revdarkgray '+visibleclass+'"><i class="eg-icon-eye"></i></span>';
		quicksb += '<span class="quick-layer-lock layer-short-tool revdarkgray"><i class="eg-icon-lock-open"></i></span>';
		quicksb += '<div style="clear:both;display:block"></div>';
		quicksb +='</li>';

		

		jQuery('#layers-left ul').append(htmlSortbox);
		jQuery('.quick-layers-list').append(quicksb);

		
		
		if (jQuery('.quick-layers-list li').length>1) jQuery('.nolayersavailable').hide();

		htmlSortbox = "";
		htmlSortbox += '<li data-serial="'+serial+'" id="layer_sort_time_'+serial+'" class="sortablelayers mastertimer-layer ui-state-default'+classLI+'">';
		htmlSortbox += '  <div class="timeline">';
		htmlSortbox += '		<div class="tl-fullanim">';
		htmlSortbox += '			<span style="z-index:100!important;" class="sortbox_time">'+msToSec(objLayer.time)+'</span>';
		htmlSortbox += '			<span style="z-index:100!important;" class="sortbox_timeend">'+msToSec(objLayer.endtime)+'</span>';
		htmlSortbox += '			<span class="start-puller"></span>';
		htmlSortbox += '			<div class="tl-startanim"><span class="sortbox_speedin">'+msToSec(objLayer.speed)+'</span><span class="start-anim-puller"></span><div class="splitinextratime"></div></div>';
		htmlSortbox += '			<div class="tl-endanim"><span class="sortbox_speedout">'+msToSec(objLayer.endspeed)+'</span><span class="end-anim-puller"></span><div class="splitoutextratime"></div></div>';
		htmlSortbox += '			<span class="end-puller"></span>';
		htmlSortbox += '		</div>';
		htmlSortbox += '		<div class="slide-idle-section"></div>';
		htmlSortbox += ' </div>';
		htmlSortbox += '</li>';
		jQuery('#layers-right ul').append(htmlSortbox);

		
		jQuery('#layer_quicksort_'+serial).on('mouseenter',function(event) {
			jQuery('.layer_due_list_element_selected').removeClass('layer_due_list_element_selected');
			jQuery('#slide_layer_'+jQuery(this).data('serial')).addClass("layer_due_list_element_selected");
		});

		jQuery('#layer_quicksort_'+serial).on('mouseleave',function(event) {
			jQuery('.layer_due_list_element_selected').removeClass('layer_due_list_element_selected');			
		});

		jQuery("#layers-left .tipsy_enabled_top").tipsy({
  				gravity:"s",
  				delayIn: 70
  		});



		
		var li = jQuery('#layer_sort_time_'+serial),
			cur = li.find(".timeline"),
			qcur = jQuery('#layer_quicksort_'+serial),
			dragfull = cur.find('.tl-fullanim'),
			dragspeedin = cur.find('.tl-startanim'),
			dragspeedout = cur.find('.tl-endanim'),			
			maxtime = (t.mainMaxTimeLeft)-15; //slidemaxtime==undefined || slidemaxtime=="" || slidemaxtime<=0 ? g_slideTime : slidemaxtime;
		
		if (objLayer.type=="audio") {
			li.data('objref',objLayer);			

  			t.drawAudioMap(objLayer);
  			li.on('mousemove',function(e) {  				
  				//try{
	  				var li = jQuery(this),
	  					serial = li.data('serial'),
	  					player = jQuery('#slide_layer_'+serial+" audio")[0];
	  				if (!li.hasClass("ui-state-hover")) return false;
					
					clearTimeout(li.data('audiopreview'));
					li.find('.audio-progress').remove();
					player.pause();
	  				
	  				
	  				li.data('audiopreview',setTimeout(function() {
		  				
		  				var	dragfull = li.find('.tl-fullanim'),
		  					dl = dragfull.position().left,  					
		  					dw = dragfull.width(),
		  					time = (e.pageX-li.offset().left)-dl;

		  				
		  				li.find('.audio-progress').remove();
		  				li.append('<div class="audio-progress"></div>');
		  				var ap = li.find('.audio-progress'),
		  					shift = Math.floor((time / (player.duration*100))); 

		  				if (time>player.duration*100) 
		  					time = time - ((player.duration*100)*shift);

		  					  				
		  				if (time>0) {
		  					restw = (player.duration-time/100) * 100;  					  				
		  					punchgs.TweenLite.fromTo(ap,(player.duration-time/100),{left:(dl+time+(shift*(player.duration*100))),transformOrigin:"0% 50%", width:restw,scaleX:0},{scale:1,ease:punchgs.Linear.easeNone});
		  				}
		  				if (time>0) {
		  					player.play();
		  					player.currentTime = time/100;
		  				}  			
		  			},400));	  				
		  		//} catch(er) {

		  		//}
  			});

  			li.on('mouseleave',function(e) {
  				try {
  					var li = jQuery(this),  					
	  					serial = li.data('serial'),
	  					player = jQuery('#slide_layer_'+serial+" audio")[0];
	  				clearTimeout(li.data('audiopreview'));
	  				li.find('.audio-progress').remove();
  					player.pause();
  				} catch(er) { }
	  		});
  		}

		// SAVE SOME TIME LATER....
		var fobj = {};
		fobj.serial = serial;
		fobj.li = li;		
		fobj.timeline = cur;
		fobj.startanim = dragfull.find('.tl-startanim');
		fobj.endanim = dragfull.find('.tl-endanim');
		dragfull.data('fobj',fobj);

		setCurTimer(dragfull,true);
		cur.parent().find('.slide-idle-section').css({left:(maxtime+15)+"px"});

		t.resetTimeLineHeight();
				
		// DRAG LEFT / RIGHT THE FULL ANIMATION
		dragfull.draggable({
			containment:"parent",

			axis:"x",
			start:function() {
				//dragfull.draggable("option","containment",[215,0,(slidemaxtime/10)+dragspeedout.width()+15,0]);
				dragfull.closest('.timeline').addClass("onchange");
				jQuery(this).closest('li').addClass("showstarttoend");
				jQuery('#timline-manual-dialog').show();
			},
			stop:function() {

				var maxtime = (t.mainMaxTimeLeft)-15,
					l = parseInt(dragfull.position().left),
					w = dragfull.width(),
					speedoutw = dragspeedout.width();

				if (l<15) dragfull.css({left:"15px"});
				if (l>maxtime+speedoutw-w+15) dragfull.css({left:(maxtime+speedoutw-w+15)+"px"});
				if (dragfull.position().left<15) dragfull.css({left:15});
				t.updateCurTimer("dragstop",jQuery(this));
				jQuery(this).closest('li').removeClass("showstarttoend");
				dragfull.closest('.timeline').removeClass("onchange");
				u.add_layer_change();
			},
			drag:function() {
				t.updateCurTimer("drag",jQuery(this));
			}
		})

		
		
		var dsiw = dragspeedin.data('dsw') !=undefined ? dragspeedin.data('dsw')  : dragspeedin.width(),
			dsow = dragspeedout.data('dew') !=undefined ? dragspeedout.data('dew') : dragspeedout.width();

		// CHANGE DURATION OF ELEMENTS
		dragfull.resizable({
			containment:"parent",
			handles:"w,e",
			minWidth: (dsiw+dsow),
			maxWidth: (maxtime+dsow),

			// BASIC SETTINGS FOR THE DRAGBAR
			create:function() {
				
				var maxtime = (t.mainMaxTimeLeft)-15,
					w =dragfull.data('dfw') !=undefined ? dragfull.data('dfw') :  dragfull.width(),					
					speedoutw = dragspeedout.data('dew') != undefined ? dragspeedout.data('dew') : dragspeedout.width(),
					dfl = dragfull.data('dfl') !=undefined ? dragfull.data('dfl') : dragfull.position().left,
					l = parseInt(dfl);
								
				// IF THE TIMELINE TOO LONGTH AT START
				if (w-speedoutw>maxtime) {
					var neww = maxtime-l+ speedoutw;
						newl = maxtime+speedoutw - neww;
					dragfull.css({width:(neww+15)+"px",left:newl+"px"});
				}
			},

			// ON START TO RESIZE, CHANGE SOME IMPORTANT PARAMETERS
			start:function(e,ui) {
					
				// ADD CLASS ONCHANGE
				dragfull.closest('.timeline').addClass("onchange");
				jQuery('#timline-manual-dialog').show();
				

				var maxtime = (t.mainMaxTimeLeft)-15,
					w = dragfull.width(),
					speedinw = dragspeedin.width(),
					speedoutw = dragspeedout.width(),
					l = parseInt(dragfull.position().left),
					minwidth = speedinw+speedoutw,
					maxwidth = maxtime+speedoutw,
					dir = e.toElement ? e.toElement : e.originalEvent.target;


				if (jQuery(dir).hasClass("ui-resizable-e"))
				  	maxwidth = maxwidth - l+15;
				else
					maxwidth = l+w-15; //maxtime>(l+w) ? l+w-15 : maxwidth;
				

				// OVERWRITE THE BASIC OPTIONS
				dragfull.resizable("option","minWidth",minwidth);
				dragfull.resizable("option","maxWidth",maxwidth);
				__ctime.data('offset',1);
				
				if (jQuery(dir).hasClass("ui-resizable-w"))
					jQuery(this).closest('li').addClass("showtlstart");
				else 
					jQuery(this).closest('li').addClass("showtlend");
				
			},


			stop:function() {
				t.updateCurTimer("resizestop",jQuery(this),"start");
				jQuery(this).closest('li').removeClass("showtlstart").removeClass("showtlend");
				dragfull.closest('.timeline').removeClass("onchange");
				__ctime.data('offset',0);
				u.add_layer_change();
			},
			resize:function(event) {
				if (jQuery(event.srcElement).hasClass("ui-resizable-w"))
					t.updateCurTimer("changestart",jQuery(this));
				else
					t.updateCurTimer("changeend",jQuery(this));
			}
			//snap:".tl-fullanim"
		});
		
		dragspeedin.resizable({
			minWidth:0,
			handles:"e",
			start:function() {
				var w = dragfull.width(),
					speedoutw = dragspeedout.width(),
					speedinw = dragspeedin.width(),		
					
					l = parseInt(dragfull.position().left);

				dragspeedin.resizable("option","maxWidth",(w-speedoutw));
				dragfull.closest('.timeline').addClass("onchange");
				jQuery(this).closest('li').addClass("showstartspeed");
				dragfull.closest('.timeline').addClass("onchange");
				jQuery('#timline-manual-dialog').show();
				__ctime.data('offset',1);				
			},
			stop:function() {
				var dragfull = jQuery(this).closest('li').find('.tl-fullanim');
				jQuery(this).closest('li').removeClass("showstartspeed");
				t.updateCurTimer("speedinstop",dragfull);
				dragfull.closest('.timeline').removeClass("onchange");
				__ctime.data('offset',0);
				u.add_layer_change();
			},
			resize:function() {

				var dragfull = jQuery(this).closest('li').find('.tl-fullanim');
				t.updateCurTimer("speedin",dragfull);
			}
			//snap:".tl-fullanim"
		});

		
		dragspeedout.resizable({
			minWidth:1,
			handles:"w",
			start:function() {
				var maxtime = (t.mainMaxTimeLeft)-15,
					w = dragfull.width(),
					speedinw = dragspeedin.width(),
					speedoutw = dragspeedout.width(),
					l = parseInt(dragfull.position().left),
					minwidth = speedinw+speedoutw,					
					maxwidth = maxtime+speedoutw;
				dragspeedout.resizable("option","minWidth",(l+w-maxtime-15));
				dragspeedout.resizable("option","maxWidth",(w-speedinw));
				dragfull.closest('.timeline').addClass("onchange");
				jQuery(this).closest('li').addClass("showendspeed");
				jQuery('#timline-manual-dialog').show();				
				__ctime.data('offset',1);			
			},
			stop:function() {
				var dragfull = jQuery(this).closest('li').find('.tl-fullanim');
				t.updateCurTimer("speedoutstop",dragfull);
				jQuery(this).closest('li').removeClass("showendspeed");
				dragfull.closest('.timeline').removeClass("onchange");
				__ctime.data('offset',0);
				u.add_layer_change();
			},
			resize:function() {
				var dragfull = jQuery(this).closest('li').find('.tl-fullanim');
				t.updateCurTimer("speedout",dragfull);
			}
			//snap:".tl-fullanim"
		});
		
	}

	/**
	 check if the Layer should go till Slide End, or should animate our before.
	 if objLayer.endWithSlide == true -> the Layer should not get any "data-end" output !!
	*/
	var checkTillSlideEnd = function(serial,objLayer) {

		
		var maxtime = ((t.mainMaxTimeLeft)-15)*10,
			li = jQuery('#layer_sort_'+serial);
			
		if ( objLayer.endtime-objLayer.endspeed >= maxtime) {
			objLayer.endWithSlide = true;
			li.find('.till_slideend').addClass("tillendon");
		} else {
			objLayer.endWithSlide = false;
			li.find('.till_slideend').removeClass("tillendon");

		}	
	}


	/**
	 * update timeline of current layer
	 */
	t.updateCurrentLayerTimeline = function(){				
		var timer = jQuery('#layers-right').find('.ui-state-hover .timeline .tl-fullanim');
		
		setTimeout(function() {					
			setCurTimer(timer);					
			t.updateCurTimer("",timer);
		},20);
	}

	t.updateAllLayerTimeline = function() {
		jQuery('#layers-right').find('.sortablelayers.mastertimer-layer').each(function(i) {
			var timer = jQuery(this).find('.timeline .tl-fullanim');			
			
			setCurTimer(timer);
			t.updateCurTimer("",timer,true)
		})
	}

	/**
	 * update timeline of one layer
	 */
	t.updateLayerTimeline = function(timer){						
		
		setTimeout(function() {					
			setCurTimer(timer);					
			t.updateCurTimer("",timer);
		},20);
	}




	var setCurTimer = function(timer) {
		
		
		var fobj = timer.data('fobj'),
			li = fobj.li			
			serial = fobj.serial,
			objLayer = u.getLayer(serial);
				
		var tl = fobj.timeline,			
			dragfull = timer,
			dragstart =fobj.startanim, 			
			dragend = fobj.endanim,
			ft = ((t.mainMaxTimeLeft)-15)*10,
			ietime = tl.find('.splitinextratime'),
			oetime = tl.find('.splitoutextratime'),
			fromreal = false;		
				
		if (objLayer.realEndTime && objLayer.realEndTime!="undefined" && objLayer.realEndTime!=undefined) {				
			 objLayer.endtime = objLayer.realEndTime;
			 if (objLayer.endWithSlide) objLayer.endtime = 	(parseInt(ft,0)+parseInt(objLayer.endspeed,0));			
			 delete objLayer.realEndTime;
			 delete objLayer.endTimeFinal;
			 delete objLayer.endSpeedFinal;			 
		}
		
		
		if (objLayer.endtime=="undefined" || objLayer.endtime==undefined) {
			objLayer.endtime = ft;
		}
		
		
		if (objLayer.endspeed==undefined || objLayer.endspeed=="undefined")
			objLayer.endspeed = objLayer.speed;
		

		var isw = getSplitCounts(objLayer.text,objLayer.split,objLayer.splitdelay),
			osw = getSplitCounts(objLayer.text,objLayer.endsplit,objLayer.endsplitdelay);
			
		if (objLayer.endspeed<=0) objLayer.endspeed = 2;
		if (objLayer.speed<=0) objLayer.speed = 2;		

		

		ietime.css({width:isw+"px"});
		oetime.css({width:osw+"px"});
		objLayer.split_in_extratime = isw;
		objLayer.split_out_extratime = osw;

		var result = objLayer.endtime - objLayer.time,
			dfw = result/10,
			dfl = 15+(objLayer.time/10),
			dew = objLayer.endspeed/10,
			dsw = objLayer.speed/10;

		
		
		dragfull.css({width:dfw+"px",
					  left: dfl+"px"});
		
		dragstart.css({width:dsw +"px" });
		dragend.css({right:"0px",width:dew+"px" });

		dragfull.data('dfw',dfw);
		dragfull.data('dfl',dfl);
		dragend.data('dew',dew);
		dragstart.data('dsw',dsw);

		var canvas = li.find('canvas');
		if (canvas)
			punchgs.TweenLite.set(canvas,{left:dfl+15});
		

		checkTillSlideEnd(serial,objLayer);
	}


	/**
		CALCULATE WIDTH TO TIME
	*/
	var msToSec = function(ms) {
		var s = Math.floor(ms / 1000);
		ms = ms - (s*1000);
		var str = s+".";
		if (ms<100)
			str=str+"0";
		str = str+Math.round(ms/10);
		return str;
	}

	// COUNT THE AMOUNT OF CHARS, WORDS, LINES IN A TEXT
	var getSplitCounts = function(txt,split,splitdelay) {
		if (txt==undefined) return 0;
		var splitted = new Object();
			ht = jQuery('<div>'+txt+'</div>'),
			w = 0;

		splitted.c = ht.text().replace(/ /g, "").length;
		splitted.w = txt.split(" ").length;
		splitted.l = txt.split('<br').length;


		switch (split) {
			case "chars":
				w = splitted.c;
			break;
			case "words":
				w = splitted.w;
			break;
			case "lines":
				w = splitted.l;
			break;
		}

		return (w -1) * splitdelay;
	}


	/**
		Update the Current Timelines
	*/
	t.updateCurTimer = function(event,timer,onlydraw) {		

		var fobj = timer.data('fobj'),
			li = fobj.li			
			serial = fobj.serial,
			objLayer = u.getLayer(serial);
				
		var tl = fobj.timeline,			
			dragfull = timer,
			dragstart =fobj.startanim, 			
			dragend = fobj.endanim,			
			l = timer.position().left,
			w = parseInt(timer.width(),0),
			tl = li.find('.timeline'),
			tw = tl.width(),			
			inspeedw = dragstart.width(),			
			outspeedw = dragend.width(),
			startspeed = inspeedw*10,
			endspeed = outspeedw*10,
			starttime = (l-15)*10,
			endtime = 	(l-15 + w)*10,
			slidemaxtime = ((t.mainMaxTimeLeft)-15)*10,
			ietime = li.find('.splitinextratime'),
			oetime = li.find('.splitoutextratime');


		if (__ctime.data('offset')===1) {
			var x =0;
			switch (event) {
				case "changestart":
					x = l;
				break;
				case "changeend":
					x = l+w;
				break;
				case "speedin":
				case "speedinstop":
					x = l + inspeedw;
				break;
				case "speedout":
				case "speedoutstop":
					x = l + w - outspeedw;
				break;
			}
			punchgs.TweenLite.set(__ctime,{left:x});
			punchgs.TweenLite.set(__ctimeb,{left:x});
			__ctimei.html(t.convToTime(x-15));
		}

		var isw = getSplitCounts(objLayer.text,objLayer.split,objLayer.splitdelay),
			osw = getSplitCounts(objLayer.text,objLayer.endsplit,objLayer.endsplitdelay);

		ietime.css({width:isw+"px"});
		oetime.css({width:osw+"px"});

		
		if (onlydraw!==true) {
			jQuery('#layer_sort_time_'+serial).find('.sortbox_time').html(msToSec(starttime));
			jQuery('#layer_sort_time_'+serial).find('.sortbox_timeend').html(msToSec(endtime));
			jQuery('#layer_sort_time_'+serial).find('.sortbox_speedin').html(msToSec(startspeed));
			jQuery('#layer_sort_time_'+serial).find('.sortbox_speedout').html(msToSec(endspeed));
					
			if (selectedLayerSerial == serial) {
				jQuery('#layer_speed').val(startspeed);
				jQuery('#layer_endspeed').val(endspeed);
			}
		}

		dragstart.css({ left:"0px" });
		dragend.css({ left:"auto", right:"0px" });

		var canvas = li.find('canvas');
		if (canvas)
			punchgs.TweenLite.set(canvas,{left:15+starttime/10});

		if (onlydraw!==true) {
			objLayer.speed = startspeed;
			objLayer.endspeed = endspeed;
			objLayer.time = starttime;
			objLayer.endtime = endtime;
			objLayer.split_in_extratime = isw;
			objLayer.split_out_extratime = osw;

			jQuery('#clayer_start_time').val(starttime);
			jQuery('#clayer_end_time').val(endtime);
			jQuery('#clayer_start_speed').val(startspeed);
			jQuery('#clayer_end_speed').val(endspeed);
		}

		checkTillSlideEnd(serial,objLayer);

		t.masterTimerPositionChange(true);
	}

	/**
		Show / HIde The Timelines
	*/
	var showHideTimeines = function() {
		/* HIDE / SHOW  TIMELINES */

		jQuery('#button_sort_timing').click(function() {
			var bst = jQuery(this);
			if (bst.hasClass("off")) {
				bst.removeClass("off");
				bst.find('.onoff').html('- on');
				punchgs.TweenLite.to(jQuery('.sortlist .timeline'),0.5,{autoAlpha:0.5,overwrite:"auto"});
			} else {
				punchgs.TweenLite.to(jQuery('.sortlist .timeline'),0.5,{autoAlpha:0,overwrite:"auto"});
				bst.addClass("off");
				bst.find('.onoff').html('- off');
			}
		})
	}


	/**
	 *
	 * delete layer from sortbox
	 */
	t.deleteLayerFromSortbox = function(serial){

		var sortboxLayer = t.getHtmlSortItemFromSerial(serial),
			sortboxTimeLayer = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);
		try{
			sortboxLayer.remove();
			sortboxTimeLayer.remove();
			quickItem.remove();
		} catch(e) {

		}

		if (jQuery('.quick-layers-list li').length<2) jQuery('.nolayersavailable').show();

	}

	/**
	 *
	 * unselect all items in sortbox
	 */
	t.unselectSortboxItems = function(){

		jQuery(".sortlist li,#layers-right li, .quick-layers-list li").removeClass("ui-state-hover").addClass("ui-state-default");

	}



	/**
	 * update layers order from sortbox elements
	 */
	var updateOrderFromSortbox = function(){
		
		var arrSortLayers = jQuery( ".sortlist ul" ).sortable("toArray");

		for(var i=0;i<arrSortLayers.length;i++){
			var sortID = arrSortLayers[i];
			var serial = u.getSerialFromSortID(sortID);
			var objUpdate = {order:i};
			u.updateLayer(serial,objUpdate);

			
			//update sortbox order input
			var depth = i+5;	
			jQuery("#"+sortID+" .sortbox_depth").text(depth);
			// Change Right Side Of Layer Container Also.
			jQuery('#layer_sort_time_'+serial).appendTo(jQuery('#layers-right ul'));
			jQuery('#layer_quicksort_'+serial).appendTo(jQuery('.quick-layers-list'));
		}

		//update z-index of the html window by order
		updateZIndexByOrder();

	}


	/**
	 * update z-index of the layers by order value
	 */
	var updateZIndexByOrder = function(){
		var l = u.getLayers()		
		for(var key in u.getLayers()){
			var layer = l[key];			
			if(layer.order !== undefined){
				var zindex = Number(layer.order)+100;
				jQuery("#slide_layer_"+key).css("z-index",zindex);
			}
		};

	}

	/**
	 * shift order among all the layers, push down all order num beyong the given
	 * need to redraw after this function
	 */
	var shiftOrder = function(orderToFree){

		for(key in u.arrLayers){
			var obj = u.arrLayers[key];
			if(obj.order >= orderToFree){
				obj.order = Number(obj.order)+1;
				u.arrLayers[key] = obj;
			}
		}
	}


	/**
	 * get sortbox text from layer html
	 */
	t.getSortboxText = function(text){
		sorboxTextSize = 20;
		var textSortbox = UniteAdminRev.stripTags(text);

		//if no content - escape html
		if(textSortbox.length < 2)
			textSortbox = UniteAdminRev.htmlspecialchars(text);

		//short text
		if(textSortbox.length > sorboxTextSize)
			textSortbox = textSortbox.slice(0,sorboxTextSize)+"...";

		return(textSortbox);
	}

	/**
	 *
	 * redraw the sortbox
	 */
	t.redrawSortbox = function(mode){


		if(mode == undefined)
			mode = sortMode;

		emptySortbox();

		var layers_array = getLayersSorted("depth");


		if(layers_array.length == 0) {
			return(false);
		}

		
		for(var i=0; i<layers_array.length;i++){
			var objLayer = layers_array[i];
			t.addToSortbox(objLayer.serial,objLayer);
		}

				

		if(selectedLayerSerial != -1)
			t.setSortboxItemSelected(selectedLayerSerial);





	}


	//======================================================
	//			Sortbox Functions
	//======================================================
	var initSortbox = function(){

		t.redrawSortbox();

		//set the sortlist sortable
		jQuery( ".sortlist ul" ).sortable({
			axis:'y',
			cancel:"#slide_in_sort, input",
			items:".sortablelayers",
			connectWith:"#layers-right ul",
			update: function(){
				onSortboxSorted();
			}
		});

		//set click event
		jQuery(".sortlist, #layers-right").delegate("li","mousedown",function(){
			
			if (jQuery(this).hasClass("ui-state-hover")) return true;
			if (jQuery(this).hasClass("mastertimer-slide")) {
				// SELECT THE SLIDE IN SORTS
			} else {
				var serial = u.getSerialFromSortID(this.id);
				u.setLayerSelected(serial);
			}
			
		});



		jQuery('.quick-layer-all-lock').click(function() {
			var b = jQuery(this),
				i = b.find('i');
			if (i.hasClass("eg-icon-lock")) {
				jQuery('.quick-layer-lock i').each(function() {
					jQuery(this).removeClass("eg-icon-lock-open").addClass("eg-icon-lock");
				});
				i.addClass("eg-icon-lock-open").removeClass("eg-icon-lock");
				u.lockAllLayers();
			} else {
				jQuery('.quick-layer-lock i').each(function() {
					jQuery(this).removeClass("eg-icon-lock").addClass("eg-icon-lock-open");
				});
				i.removeClass("eg-icon-lock-open").addClass("eg-icon-lock");
				
				u.unlockAllLayers();
			}
		})

		jQuery('.quick-layer-all-view').click(function() {
			var b = jQuery(this),
				i = b.find('i');
			if (i.hasClass("eg-icon-eye")) {
				jQuery('.quick-layer-view i').each(function() {
					jQuery(this).addClass("eg-icon-eye").removeClass("eg-icon-eye-off");
				});
				i.removeClass("eg-icon-eye").addClass("eg-icon-eye-off");				
				u.showAllLayers();
			} else {
				jQuery('.quick-layer-view i').each(function() {
					jQuery(this).removeClass("eg-icon-eye").addClass("eg-icon-eye-off");
				});
				i.addClass("eg-icon-eye").removeClass("eg-icon-eye-off");
				u.hideAllLayers();
			}
		})



		//on show / hide layer icon click - show / hide layer
		jQuery(".sortlist").delegate(".till_slideend","mousedown",function(event){
			var sortboxID = jQuery(this).parent().parent().parent().attr("id"),
				serial = u.getSerialFromSortID(sortboxID),
				objLayer = u.getLayer(serial),
				button = jQuery(this),
				maxtime = (t.mainMaxTimeLeft-15)*10;

			if (button.hasClass("tillendon")) {
				button.removeClass("tillendon")

				if (objLayer.endtime-objLayer.endspeed >= maxtime) {					
					objLayer.endtime = maxtime + objLayer.endspeed - 100;

					jQuery('#layer_sort_time_'+serial).find('.sortbox_timeend').html(msToSec(maxtime+objLayer.endspeed-100));		
					jQuery('#clayer_end_time').val((maxtime+objLayer.endspeed-100));

					
					setCurTimer(jQuery('#layer_sort_time_'+serial).find('.timeline .tl-fullanim'));
				}
			} else {
				button.addClass("tillendon");

				objLayer.endtime =  maxtime + objLayer.endspeed;
				jQuery('#layer_sort_time_'+serial).find('.sortbox_timeend').html(msToSec(maxtime + objLayer.endspeed));
				jQuery('#clayer_end_time').val((maxtime + objLayer.endspeed));


				setCurTimer(jQuery('#layer_sort_time_'+serial).find('.timeline .tl-fullanim'));

			}

		});

	}




	/***********************************
		order layers by time
		type can be [time] or [order]
	************************************/
	var getLayersSorted = function(type){

		if(type == undefined)
			type = "time";

		//convert to array
		var layers_array = [];
		for(key in u.arrLayers){
			var obj = u.arrLayers[key];
			obj.serial = key;
			layers_array.push(obj);
		}

		if(layers_array.length == 0)
			return(layers_array);

		//sort layers array
		layers_array.sort(function(layer1,layer2){

			switch(type){
				case "time":

					if(Number(layer1.time) == Number(layer2.time)){
						if(layer1.order == layer2.order)
							return(0);

						if(layer1.order > layer2.order)
							return(1);

						return(-1);
					}

					if(Number(layer1.time) > Number(layer2.time))
						return(1);
				break;
				case "depth":
					if(layer1.order == layer2.order)
						return(0);

					if(layer1.order > layer2.order)
						return(1);
				break;
				default:
					trace("wrong sort type: "+type);
				break;
			}

			return(-1);
		});

		return(layers_array);
	}


	/**
	 * hide in html and sortbox
	 */
	t.hideLayer = function(serial,skipGlobalButton){
		var htmlLayer = jQuery("#slide_layer_"+serial);
		htmlLayer.hide();
		htmlLayer.addClass("currently_not_visible");
		setSortboxItemHidden(serial);
		
		if(skipGlobalButton != true){
			if(t.isAllLayersHidden())
				jQuery("#button_sort_visibility").addClass("e-disabled");
		}
	}


	/**
	 * show layer in html and sortbox
	 */
	t.showLayer = function(serial,skipGlobalButton){
		var htmlLayer = jQuery("#slide_layer_"+serial);
		htmlLayer.show();
		htmlLayer.removeClass("currently_not_visible");
		setSortboxItemVisible(serial);

		if(skipGlobalButton != true)
			jQuery("#button_sort_visibility").removeClass("e-disabled");
	}


	

	


	/**
	 * get true / false if the layer is hidden
	 */
	t.isLayerVisible = function(serial){
		var htmlLayer = jQuery("#slide_layer_"+serial),
		isVisible = true;
		if (htmlLayer.hasClass("currently_not_visible"))
			isVisible = false;
		return(isVisible);
	}

	/**
	 * get true / false if all layers hidden
	 */
	t.isAllLayersHidden = function(){
		for(serial in u.arrLayers){
			if(t.isLayerVisible(serial) == true) {
				return(false);
			}
		}
		return(true);
	}


	/**
	 * get true / false if the layer can be moved
	 */
	t.isLayerLocked = function(serial){
		var htmlLayer = jQuery("#slide_layer_"+serial),
			isLocked = htmlLayer.hasClass("layer_on_lock");
		
		return htmlLayer.hasClass("layer_on_lock");

	}


	/**
	 * hide in html and sortbox
	 */
	t.lockLayer = function(serial){
		setSortboxItemLocked(serial);

		var layer = u.getHtmlLayerFromSerial(serial);


		layer.addClass("layer_on_lock");
	
	}


	/**
	 * show layer in html and sortbox
	 */
	t.unlockLayer = function(serial){
		setSortboxItemUnlocked(serial);
		var layer = u.getHtmlLayerFromSerial(serial);		
		layer.removeClass("layer_on_lock");
	}


	/**
	 * set sortbox items selected
	 */
	t.setSortboxItemSelected = function(serial){
		var sortItem = t.getHtmlSortItemFromSerial(serial),
			sortTimeItem = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);
		
		t.unselectSortboxItems();
		if (sortItem)
			sortItem.removeClass("ui-state-default").addClass("ui-state-hover");
		if (sortTimeItem)
			sortTimeItem.removeClass("ui-state-default").addClass("ui-state-hover");
		if (quickItem)
			quickItem.removeClass("ui-state-default").addClass("ui-state-hover");
	}


	/**
	 * set sortbox item hidden mode
	 */
	var setSortboxItemHidden = function(serial){
		var sortItem = t.getHtmlSortItemFromSerial(serial),
			sortTimeItem = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);

		if (sortItem)
			sortItem.addClass("sortitem-hidden");
		if (sortTimeItem)
			sortTimeItem.addClass("sortitem-hidden");
		if (quickItem) {
			quickItem.addClass("sortitem-hidden");
			quickItem.find('.eg-icon-eye').addClass("eg-icon-eye-off").removeClass('eg-icon-eye');
			quickItem.find('.quick-layer-view').addClass("in-off");
		}
	}

	/**
	 * set sortbox item visible mode
	 */
	var setSortboxItemVisible = function(serial){
		var sortItem = t.getHtmlSortItemFromSerial(serial),
			sortTimeItem = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);
		if (sortItem)
			sortItem.removeClass("sortitem-hidden");
		if (sortTimeItem)
			sortTimeItem.removeClass("sortitem-hidden");
		if (quickItem) 
			quickItem.removeClass("sortitem-hidden");
	}

	/**
	 * set sortbox item locked mode
	 */
	var setSortboxItemLocked = function(serial){
		var sortItem = t.getHtmlSortItemFromSerial(serial),
			sortTimeItem = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);
		
		if (sortItem)
			sortItem.addClass("sortitem-locked");
		if (sortTimeItem)
			sortTimeItem.addClass("sortitem-locked");
		if (quickItem)
			quickItem.addClass("sortitem-locked");
	}

	/**
	 * set sortbox item unlocked mode
	 */
	var setSortboxItemUnlocked = function(serial){
		var sortItem = t.getHtmlSortItemFromSerial(serial),
			sortTimeItem = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);
		
		if (sortItem)
			sortItem.removeClass("sortitem-locked");
		if (sortTimeItem)
			sortTimeItem.removeClass("sortitem-locked");
		if (quickItem)
			quickItem.removeClass("sortitem-locked");
	}

	/**
	 * get sort field element from serial
	 */
	t.getHtmlSortItemFromSerial = function(serial){
		var htmlSortItem = jQuery("#layer_sort_"+serial);
		if(htmlSortItem.length == 0){
			UniteAdminRev.showErrorMessage("Html sort field with serial: "+serial+" not found!");
			return(false);
		}
		return(htmlSortItem);
	}

	t.getHtmlSortTimeItemFromSerial = function(serial){
		var htmlSortItem = jQuery("#layer_sort_time_"+serial);
		if(htmlSortItem.length == 0){
			UniteAdminRev.showErrorMessage("Html sort field with serial: "+serial+" not found!");
			return(false);
		}
		return(htmlSortItem);
	}

	t.getHtmlQuickTimeItemFromSerial = function(serial){
		var htmlSortItem = jQuery("#layer_quicksort_"+serial);
		if(htmlSortItem.length == 0){
			UniteAdminRev.showErrorMessage("Html sort field with serial: "+serial+" not found!");
			return(false);
		}
		return(htmlSortItem);
	}



	/**
	 * remove all from sortbox
	 */
	var emptySortbox = function(){
		jQuery(".sortlist ul").find('.sortablelayers').remove();
		jQuery('#layers-right ul').find('.sortablelayers').remove();
	}


	/**
	 * on sortbox sorted event.
	 */
	var onSortboxSorted = function(){
		updateOrderFromSortbox();
	}
	//======================================================
	//			Sortbox Functions End
	//======================================================
	
	
	
	///////////////////////
	// PREPARE THE SLIDE //
	//////////////////////
	var prepareOneSlide = function(slotholder,opt,visible,vorh,w,h) {

				var sh=slotholder,
					img = sh.find('.defaultimg'),
					scalestart = sh.data('zoomstart'),
					rotatestart = sh.data('rotationstart'),
					src = sh.find('.defaultimg').css("backgroundImage"),
					bgcolor=sh.find('.defaultimg').css('backgroundColor'),
					off=0,
					bgfit = sh.find('.defaultimg').css("backgroundSize"),
					bgrepeat = sh.find('.defaultimg').css("backgroundRepeat"),
					bgposition = sh.find('.defaultimg').css("backgroundPosition");
				

				src=src.replace('"','');
				src=src.replace('"','');				


				if (bgfit==undefined) bgfit="cover";
				if (bgrepeat==undefined) bgrepeat="no-repeat";
				if (bgposition==undefined) bgposition="center center";
				

				var w= w !=undefined ? w : jQuery('#divbgholder').width(),
					h= h !=undefined ? h : jQuery('#divbgholder').height();
				opt.slotw=Math.ceil(w/opt.slots),
				opt.sloth=Math.ceil(h/opt.slots);
				
				// SET THE MINIMAL SIZE OF A BOX
				var basicsize = 0,
					x = 0,
					y = 0;

				if (opt.sloth>opt.slotw)
					basicsize=opt.sloth
				else
					basicsize=opt.slotw;

				opt.slotw = basicsize;
				opt.sloth = basicsize;
				

				var x=0,
					y=0,
					fulloff = 0,
					fullyoff = 0;
							
									
	
				switch (vorh) {
					// BOX ANIMATION PREPARING
					case "box":
						
						
						for (var j=0;j<opt.slots;j++) {

							y=0;
							for (var i=0;i<opt.slots;i++) 	{


								sh.append('<div class="slot" '+
										  'style="position:absolute;'+
													'top:'+(fullyoff+y)+'px;'+
													'left:'+(fulloff+x)+'px;'+
													'width:'+basicsize+'px;'+
													'height:'+basicsize+'px;'+
													'overflow:hidden;">'+

										  '<div class="slotslide" data-x="'+x+'" data-y="'+y+'" '+
										  			'style="position:absolute;'+
													'top:'+(0)+'px;'+
													'left:'+(0)+'px;'+
													'width:'+basicsize+'px;'+
													'height:'+basicsize+'px;'+
													'overflow:hidden;">'+

										  '<div class="slotslidebg" style="position:absolute;'+
													'top:'+(0-y)+'px;'+
													'left:'+(0-x)+'px;'+
													'width:'+w+'px;'+
													'height:'+h+'px;'+
													'background-color:'+bgcolor+';'+
													'background-image:'+src+';'+
													'background-repeat:'+bgrepeat+';'+
													'background-size:'+bgfit+';background-position:'+bgposition+';">'+
										  '</div></div></div>');
								y=y+basicsize;								
							}
							x=x+basicsize;
						}
					break;

					// SLOT ANIMATION PREPARING
					case "vertical":
					case "horizontal":		
					
				
						 if (vorh == "horizontal") {
							if (!visible) var off=0-opt.slotw;
																											
							for (var i=0;i<opt.slots;i++) {
									
									sh.append('<div class="slot" style="position:absolute;'+
																	'top:'+(0+fullyoff)+'px;'+
																	'left:'+(fulloff+(i*opt.slotw))+'px;'+
																	'overflow:hidden;width:'+(opt.slotw+0.6)+'px;'+
																	'height:'+h+'px">'+
									'<div class="slotslide" style="position:absolute;'+
																	'top:0px;left:'+off+'px;'+
																	'width:'+(opt.slotw+0.6)+'px;'+
																	'height:'+h+'px;overflow:hidden;">'+
									'<div class="slotslidebg" style="background-color:'+bgcolor+';'+
																	'position:absolute;top:0px;'+
																	'left:'+(0-(i*opt.slotw))+'px;'+
																	'width:'+w+'px;height:'+h+'px;'+
																	'background-image:'+src+';'+
																	'background-repeat:'+bgrepeat+';'+
																	'background-size:'+bgfit+';background-position:'+bgposition+';">'+
									'</div></div></div>');									
							}

						} else {
							if (!visible) var off=0-opt.sloth;
						
							for (var i=0;i<opt.slots+2;i++) {
								sh.append('<div class="slot" style="position:absolute;'+
														 'top:'+(fullyoff+(i*opt.sloth))+'px;'+
														 'left:'+(fulloff)+'px;'+
														 'overflow:hidden;'+
														 'width:'+w+'px;'+
														 'height:'+(opt.sloth)+'px">'+

											 '<div class="slotslide" style="position:absolute;'+
																 'top:'+(off)+'px;'+
																 'left:0px;width:'+w+'px;'+
																 'height:'+opt.sloth+'px;'+
																 'overflow:hidden;">'+
											'<div class="slotslidebg" style="background-color:'+bgcolor+';'+
																	'position:absolute;'+
																	'top:'+(0-(i*opt.sloth))+'px;'+
																	'left:0px;'+
																	'width:'+w+'px;height:'+h+'px;'+
																	'background-image:'+src+';'+
																	'background-repeat:'+bgrepeat+';'+
																	'background-size:'+bgfit+';background-position:'+bgposition+';">'+

											'</div></div></div>');
							}
						}
					break;
				}
		}
		
		
		
	//////////////////////////////
	//	SWAP SLIDE PROGRESS		//
	//////////////////////////////
	var slideAnimation = function(nextsh,actsh,comingtransition,givebackmtl,smallpreview) {

		
			if (nextsh!=undefined) {
				var nextli = nextsh,
					actli = actsh,
					container = new Object(),					
					opt = new Object();
					opt.width = nextsh.width();
					opt.height = nextsh.height();
			} else {
				var nextsh = nextli = jQuery('#divbgholder').find('.slotholder'),
					actsh = actli = jQuery('#divbgholder').find('.oldslotholder'), 
					container = new Object(),
					comingtransition = jQuery('#fake-select-label').data('valu'),
					opt = new Object();
					opt.width = jQuery('#divbgholder').width();
					opt.height = jQuery('#divbgholder').height();

					
			}

			if (comingtransition=="slidingoverlayvertical") 
						comingtransition = "slidingoverlayup"	

			if (comingtransition=="slidingoverlayhorizontal") 
						comingtransition = "slidingoverlayleft"	
		
			if (comingtransition=="slideoverhorizontal") 
						comingtransition = "slideoverleft"
			
			if (comingtransition=="slideoververtical") 
						comingtransition = "slideoverup"

			if (comingtransition=="slideremovehorizontal") 
						comingtransition = "slideremoveleft"
			
			if (comingtransition=="slideremovevertical") 
						comingtransition = "slideremoveup"

			if (comingtransition=="slidehorizontal") 
						comingtransition = "slideleft"

			if (comingtransition=="slidevertical") 
						comingtransition = "slideup"

			if (comingtransition=="parallaxhorizontal") 
						comingtransition = "parallaxtoleft"


			if (comingtransition=="parallaxvertical") 
						comingtransition = "parallaxtotop"

			var p1i = punchgs.Power1.easeIn, 
				p1o = punchgs.Power1.easeOut,
				p1io = punchgs.Power1.easeInOut,
				p2i = punchgs.Power2.easeIn,
				p2o = punchgs.Power2.easeOut,
				p2io = punchgs.Power2.easeInOut,
				p3i = punchgs.Power3.easeIn, 
				p3o = punchgs.Power3.easeOut, 
				p3io = punchgs.Power3.easeInOut,
				flatTransitions = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45],
				premiumTransitions = [16,17,18,19,20,21,22,23,24,25,27],
				nexttrans =0,
				specials = 1,
				STAindex = 0,
				indexcounter =0,
				STA = new Array,
				transitionsArray = [['boxslide' , 0, 1, 10, 0,'box',false,null,0,p1o,p1o,500,6],
							 ['boxfade', 1, 0, 10, 0,'box',false,null,1,p1io,p1io,700,5],
							 ['slotslide-horizontal', 2, 0, 0, 200,'horizontal',true,false,2,p2io,p2io,700,3],
							 ['slotslide-vertical', 3, 0,0,200,'vertical',true,false,3,p2io,p2io,700,3],
							 ['curtain-1', 4, 3,0,0,'horizontal',true,true,4,p1o,p1o,300,5],
							 ['curtain-2', 5, 3,0,0,'horizontal',true,true,5,p1o,p1o,300,5],
							 ['curtain-3', 6, 3,25,0,'horizontal',true,true,6,p1o,p1o,300,5],
							 ['slotzoom-horizontal', 7, 0,0,400,'horizontal',true,true,7,p1o,p1o,300,7],
							 ['slotzoom-vertical', 8, 0,0,0,'vertical',true,true,8,p2o,p2o,500,8],
							 ['slotfade-horizontal', 9, 0,0,500,'horizontal',true,null,9,p2o,p2o,500,25],
							 ['slotfade-vertical', 10, 0,0 ,500,'vertical',true,null,10,p2o,p2o,500,25],
							 ['fade', 11, 0, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['crossfade', 11, 1, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['fadethroughdark', 11, 2, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['fadethroughlight', 11, 3, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['fadethroughtransparent', 11, 4, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['slideleft', 12, 0,1,0,'horizontal',true,true,12,p3io,p3io,1000,1],
							 ['slideup', 13, 0,1,0,'horizontal',true,true,13,p3io,p3io,1000,1],
							 ['slidedown', 14, 0,1,0,'horizontal',true,true,14,p3io,p3io,1000,1],
							 ['slideright', 15, 0,1,0,'horizontal',true,true,15,p3io,p3io,1000,1],
							 ['slideoverleft', 12, 7,1,0,'horizontal',true,true,12,p3io,p3io,1000,1],
							 ['slideoverup', 13, 7,1,0,'horizontal',true,true,13,p3io,p3io,1000,1],
							 ['slideoverdown', 14, 7,1,0,'horizontal',true,true,14,p3io,p3io,1000,1],
							 ['slideoverright', 15, 7,1,0,'horizontal',true,true,15,p3io,p3io,1000,1],
							 ['slideremoveleft', 12, 8,1,0,'horizontal',true,true,12,p3io,p3io,1000,1],
							 ['slideremoveup', 13, 8,1,0,'horizontal',true,true,13,p3io,p3io,1000,1],
							 ['slideremovedown', 14, 8,1,0,'horizontal',true,true,14,p3io,p3io,1000,1],
							 ['slideremoveright', 15, 8,1,0,'horizontal',true,true,15,p3io,p3io,1000,1],
							 ['papercut', 16, 0,0,600,'',null,null,16,p3io,p3io,1000,2],
							 ['3dcurtain-horizontal', 17, 0,20,100,'vertical',false,true,17,p1io,p1io,500,7],
							 ['3dcurtain-vertical', 18, 0,10,100,'horizontal',false,true,18,p1io,p1io,500,5],
							 ['cubic', 19, 0,20,600,'horizontal',false,true,19,p3io,p3io,500,1],
							 ['cube',19,0,20,600,'horizontal',false,true,20,p3io,p3io,500,1],
							 ['flyin', 20, 0,4,600,'vertical',false,true,21,p3o,p3io,500,1],
							 ['turnoff', 21, 0,1,500,'horizontal',false,true,22,p3io,p3io,500,1],
							 ['incube', 22, 0,20,200,'horizontal',false,true,23,p2io,p2io,500,1],
							 ['cubic-horizontal', 23, 0,20,500,'vertical',false,true,24,p2o,p2o,500,1],
							 ['cube-horizontal', 23, 0,20,500,'vertical',false,true,25,p2o,p2o,500,1],
							 ['incube-horizontal', 24, 0,20,500,'vertical',false,true,26,p2io,p2io,500,1],
							 ['turnoff-vertical', 25, 0,1,200,'horizontal',false,true,27,p2io,p2io,500,1],
							 ['fadefromright', 12, 1,1,0,'horizontal',true,true,28,p2io,p2io,1000,1],
							 ['fadefromleft', 15, 1,1,0,'horizontal',true,true,29,p2io,p2io,1000,1],
							 ['fadefromtop', 14, 1,1,0,'horizontal',true,true,30,p2io,p2io,1000,1],
							 ['fadefrombottom', 13, 1,1,0,'horizontal',true,true,31,p2io,p2io,1000,1],
							 ['fadetoleftfadefromright', 12, 2,1,0,'horizontal',true,true,32,p2io,p2io,1000,1],
							 ['fadetorightfadefromleft', 15, 2,1,0,'horizontal',true,true,33,p2io,p2io,1000,1],
							 ['fadetobottomfadefromtop', 14, 2,1,0,'horizontal',true,true,34,p2io,p2io,1000,1],
							 ['fadetotopfadefrombottom', 13, 2,1,0,'horizontal',true,true,35,p2io,p2io,1000,1],
							 ['parallaxtoright', 12, 3,1,0,'horizontal',true,true,36,p2io,p2i,1500,1],
							 ['parallaxtoleft', 15, 3,1,0,'horizontal',true,true,37,p2io,p2i,1500,1],
							 ['parallaxtotop', 14, 3,1,0,'horizontal',true,true,38,p2io,p1i,1500,1],
							 ['parallaxtobottom', 13, 3,1,0,'horizontal',true,true,39,p2io,p1i,1500,1],
							 ['scaledownfromright', 12, 4,1,0,'horizontal',true,true,40,p2io,p2i,1000,1],
							 ['scaledownfromleft', 15, 4,1,0,'horizontal',true,true,41,p2io,p2i,1000,1],
							 ['scaledownfromtop', 14, 4,1,0,'horizontal',true,true,42,p2io,p2i,1000,1],
							 ['scaledownfrombottom', 13, 4,1,0,'horizontal',true,true,43,p2io,p2i,1000,1],
							 ['zoomout', 13, 5,1,0,'horizontal',true,true,44,p2io,p2i,1000,1],
							 ['zoomin', 13, 6,1,0,'horizontal',true,true,45,p2io,p2i,1000,1],
							 ['slidingoverlayup', 27, 0,1,0,'horizontal',true,true,47,p1io,p1o,2000,1],
							 ['slidingoverlaydown', 28, 0,1,0,'horizontal',true,true,48,p1io,p1o,2000,1],
							 ['slidingoverlayright', 30, 0,1,0,'horizontal',true,true,49,p1io,p1o,2000,1],
							 ['slidingoverlayleft', 29, 0,1,0,'horizontal',true,true,50,p1io,p1o,2000,1],
							 ['notransition',26,0,1,0,'horizontal',true,null,46,p2io,p2i,1000,1],							 
						   ];



			

			// RANDOM TRANSITIONS
			if (comingtransition == "random-selected" || comingtransition == "random" || comingtransition == "random-static" || comingtransition == "random-premium") 
				comingtransition = 11;				


			function findTransition() {
				// FIND THE RIGHT TRANSITION PARAMETERS HERE
				if (transitionsArray)
				jQuery.each(transitionsArray,function(inde,trans) {
					if (trans[0] == comingtransition || trans[8] == comingtransition) {
						nexttrans = trans[1];
						specials = trans[2];
						STAindex = indexcounter;
					}
					indexcounter = indexcounter+1;
				})
			}

			findTransition();

			var direction = -1,
				masterspeed = jQuery('#transition_duration').val();
				



			if (nexttrans>30) nexttrans = 30;
			if (nexttrans<0) nexttrans = 0;

			// PREPARED DEFAULT SETTINGS PER TRANSITION
			STA = transitionsArray[STAindex];


			///////////////////////////////
			//	MAIN TIMELINE DEFINITION //
			///////////////////////////////

			var mtl = new punchgs.TimelineLite();
						
			//SET DEFAULT IMG UNVISIBLE AT START
			mtl.add(punchgs.TweenLite.set(nextsh.find('.defaultimg'),{autoAlpha:0}));
			mtl.pause();

			mtl.add(punchgs.TweenLite.set(actsh,{autoAlpha:1,force3D:"auto",zIndex:0}),0);
			mtl.add(punchgs.TweenLite.set(nextsh,{autoAlpha:1,force3D:"auto",zIndex:1}),0);
			


			// ADJUST MASTERSPEED
			/*masterspeed = masterspeed + STA[4];

			if ((nexttrans==4 || nexttrans==5 || nexttrans==6) && opt.slots<3 ) opt.slots=3;

			// ADJUST SLOTS
			if (STA[3] != 0) opt.slots = Math.min(opt.slots,STA[3]);
			if (nexttrans==9) opt.slots = opt.width/20;
			if (nexttrans==10) opt.slots = opt.height/20;*/

			opt.slots = jQuery('#slot_amount').val();
			opt.rotate = jQuery('#transition_rotation').val();

			

			masterspeed = masterspeed==="default" ? STA[11] : masterspeed==="random" ? Math.round(Math.random()*1000+300) : masterspeed!=undefined ? parseInt(masterspeed,0) : STA[11];
			masterspeed = masterspeed > opt.delay ? opt.delay : masterspeed;

			// ADJUST MASTERSPEED
			masterspeed = masterspeed + STA[4];
			
			
			
			///////////////////////
			//	ADJUST SLOTS     //	
			///////////////////////
			
			opt.slots = opt.slots==undefined || opt.slots=="default" ? STA[12] : opt.slots=="random" ? Math.round(Math.random()*12+4) : STA[12];
			opt.slots = opt.slots < 1 ? comingtransition=="boxslide" ? Math.round(Math.random()*6+3) : comingtransition=="flyin" ? Math.round(Math.random()*4+1) : opt.slots : opt.slots;
			opt.slots = (nexttrans==4 || nexttrans==5 || nexttrans==6) && opt.slots<3 ? 3 : opt.slots;
			opt.slots = STA[3] != 0 ? Math.min(opt.slots,STA[3]) : opt.slots;
			opt.slots = nexttrans==9 ? opt.width/20 : nexttrans==10 ? opt.height/20 : opt.slots;
			

			/////////////////////////////////////////////
			//	SET THE ACTUAL AMOUNT OF SLIDES !!     //
			//  SET A RANDOM AMOUNT OF SLOTS          //
			///////////////////////////////////////////
			
			opt.rotate = opt.rotate==undefined || opt.rotate=="default" ? 0 : opt.rotate==999 || opt.rotate=="random" ? Math.round(Math.random()*360) : opt.rotate;
			opt.rotate = (!jQuery.support.transition  || opt.ie || opt.ie9) ? 0 : opt.rotate;
									
			
			opt.slotw=Math.ceil(opt.width/jQuery('#slot_amount').val()),
			opt.sloth=Math.ceil(opt.height/jQuery('#slot_amount').val());

			if (STA[7] !=null) prepareOneSlide(actsh,opt,STA[7],STA[5],opt.width,opt.height);
			if (STA[6] !=null) prepareOneSlide(nextsh,opt,STA[6],STA[5],opt.width,opt.height);			

			var ei= jQuery('select[name=transition_ease_in]').val(),
				eo =jQuery('select[name=transition_ease_out]').val(),
				slidedirection = 1;



			ei = ei==="default" ? STA[9] || punchgs.Power2.easeInOut : ei || STA[9] || punchgs.Power2.easeInOut;
			eo = eo==="default" ? STA[10] || punchgs.Power2.easeInOut : eo || STA[10] || punchgs.Power2.easeInOut;



	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==0) {								// BOXSLIDE


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				var maxz = Math.ceil(opt.height/opt.sloth);
				var curz = 0;
				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);
					curz=curz+1;
					if (curz==maxz) curz=0;

					mtl.add(punchgs.TweenLite.from(ss,(masterspeed)/600,
										{opacity:0,top:(0-opt.sloth),left:(0-opt.slotw),rotation:opt.rotate,force3D:"auto",ease:ei}),((j*15) + ((curz)*30))/1500);
				});
	}
	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==1) {

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				var maxtime,
					maxj = 0;

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						rand=Math.random()*masterspeed+300,
						rand2=Math.random()*500+200;
					if (rand+rand2>maxtime) {
						maxtime = rand2+rand2;
						maxj = j;
					}
					mtl.add(punchgs.TweenLite.from(ss,rand/1000,
								{autoAlpha:0, force3D:"auto",rotation:opt.rotate,ease:ei}),rand2/1000);
				});
	}


	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==2) {

				var subtl = new punchgs.TimelineLite();
				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,{left:opt.slotw,ease:ei, force3D:"auto",rotation:(0-opt.rotate)}),0);
					mtl.add(subtl,0);
				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.from(ss,masterspeed/1000,{left:0-opt.slotw,ease:ei, force3D:"auto",rotation:opt.rotate}),0);
					mtl.add(subtl,0);
				});
	}



	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==3) {
				var subtl = new punchgs.TimelineLite();

				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,{top:opt.sloth,ease:ei,rotation:opt.rotate,force3D:"auto",transformPerspective:600}),0);
					mtl.add(subtl,0);

				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.from(ss,masterspeed/1000,{top:0-opt.sloth,rotation:opt.rotate,ease:eo,force3D:"auto",transformPerspective:600}),0);
					mtl.add(subtl,0);
				});
	}



	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==4 || nexttrans==5) {

				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				var cspeed = (masterspeed)/1000,
					ticker = cspeed,
					subtl = new punchgs.TimelineLite();

				actsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					var del = (i*cspeed)/opt.slots;
					if (nexttrans==5) del = ((opt.slots-i-1)*cspeed)/(opt.slots)/1.5;
					subtl.add(punchgs.TweenLite.to(ss,cspeed*3,{transformPerspective:600,force3D:"auto",top:0+opt.height,opacity:0.5,rotation:opt.rotate,ease:ei,delay:del}),0);
					mtl.add(subtl,0);
				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					var del = (i*cspeed)/opt.slots;
					if (nexttrans==5) del = ((opt.slots-i-1)*cspeed)/(opt.slots)/1.5;
					subtl.add(punchgs.TweenLite.from(ss,cspeed*3,
									{top:(0-opt.height),opacity:0.5,rotation:opt.rotate,force3D:"auto",ease:punchgs.eo,delay:del}),0);
					mtl.add(subtl,0);

				});


	}

	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==6) {


				if (opt.slots<2) opt.slots=2;
				if (opt.slots % 2) opt.slots = opt.slots+1;

				var subtl = new punchgs.TimelineLite();

				//SET DEFAULT IMG UNVISIBLE
				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);

				actsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					if (i+1<opt.slots/2)
						var tempo = (i+2)*90;
					else
						var tempo = (2+opt.slots-i)*90;

					subtl.add(punchgs.TweenLite.to(ss,(masterspeed+tempo)/1000,{top:0+opt.height,opacity:1,force3D:"auto",rotation:opt.rotate,ease:ei}),0);
					mtl.add(subtl,0);
				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);

					if (i+1<opt.slots/2)
						var tempo = (i+2)*90;
					else
						var tempo = (2+opt.slots-i)*90;

					subtl.add(punchgs.TweenLite.from(ss,(masterspeed+tempo)/1000,
											{top:(0-opt.height),opacity:1,force3D:"auto",rotation:opt.rotate,ease:eo}),0);
					mtl.add(subtl,0);
				});
	}


	////////////////////////////////////
	// THE SLOTSZOOM - TRANSITION II. //
	////////////////////////////////////
	if (nexttrans==7) {

				masterspeed = masterspeed *2;
				if (masterspeed>opt.delay) masterspeed=opt.delay;
				var subtl = new punchgs.TimelineLite();

				//SET DEFAULT IMG UNVISIBLE
				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);

				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this).find('div');
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,{
							left:(0-opt.slotw/2)+'px',
							top:(0-opt.height/2)+'px',
							width:(opt.slotw*2)+"px",
							height:(opt.height*2)+"px",
							opacity:0,
							rotation:opt.rotate,
							force3D:"auto",
							ease:ei}),0);
					mtl.add(subtl,0);

				});

				//////////////////////////////////////////////////////////////
				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT //
				///////////////////////////////////////////////////////////////
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this).find('div');

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
								{left:0,top:0,opacity:0,transformPerspective:600},
								{left:(0-i*opt.slotw)+'px',
								 ease:eo,
								 force3D:"auto",
							     top:(0)+'px',
							     width:opt.width,
							     height:opt.height,
								 opacity:1,rotation:0,
								 delay:0.1}),0);
					mtl.add(subtl,0);
				});
	}




	////////////////////////////////////
	// THE SLOTSZOOM - TRANSITION II. //
	////////////////////////////////////
	if (nexttrans==8) {

				masterspeed = masterspeed * 3;
				if (masterspeed>opt.delay) masterspeed=opt.delay;
				var subtl = new punchgs.TimelineLite();



				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this).find('div');
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,
								  {left:(0-opt.width/2)+'px',
								   top:(0-opt.sloth/2)+'px',
								   width:(opt.width*2)+"px",
								   height:(opt.sloth*2)+"px",
								   force3D:"auto",
								   ease:ei,
								   opacity:0,rotation:opt.rotate}),0);
					mtl.add(subtl,0);

				});


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT //
				///////////////////////////////////////////////////////////////
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this).find('div');

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
								  {left:0, top:0,opacity:0,force3D:"auto"},
								  {'left':(0)+'px',
								   'top':(0-i*opt.sloth)+'px',
								   'width':(nextsh.find('.defaultimg').data('neww'))+"px",
								   'height':(nextsh.find('.defaultimg').data('newh'))+"px",
								   opacity:1,
								   ease:eo,rotation:0,
								   }),0);
					mtl.add(subtl,0);
				});
	}


	////////////////////////////////////////
	// THE SLOTSFADE - TRANSITION III.   //
	//////////////////////////////////////
	if (nexttrans==9 || nexttrans==10) {
				var ssamount=0;
				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					ssamount++;
					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,{autoAlpha:0,force3D:"auto",transformPerspective:600},
																		 {autoAlpha:1,ease:ei,delay:(i*5)/1000}),0);

				});
	}

	///////////////////////////
	// SIMPLE FADE ANIMATION //
	///////////////////////////
	if (nexttrans==11 || nexttrans==26) {
				var ssamount=0,
					bgcol = specials == 2 ? "#000000" : specials == 3 ? "#ffffff" : "transparent";
				if (nexttrans==26) masterspeed=0;

				if (smallpreview) {
					mtl.add(punchgs.TweenLite.set(nextsh.parent(),{backgroundColor:bgcol,force3D:"auto"}),0);
					switch (specials) {
						case 0: 
							mtl.add(punchgs.TweenLite.fromTo(actsh,masterspeed/1000,{autoAlpha:0,zIndex:1},{autoAlpha:1,zIndex:1,force3D:"auto",ease:ei}),0);
							mtl.add(punchgs.TweenLite.set(nextsh,{autoAlpha:1,force3D:"auto",zIndex:0}),0);
						break;

						case 1:
							mtl.add(punchgs.TweenLite.fromTo(actsh,masterspeed/1000,{autoAlpha:0},{autoAlpha:1,force3D:"auto",ease:ei}),0);
							mtl.add(punchgs.TweenLite.fromTo(nextsh,masterspeed/1000,{autoAlpha:1},{autoAlpha:0,force3D:"auto",ease:ei}),0);
						break;

						case 2:
						case 3:
						case 4:
							mtl.add(punchgs.TweenLite.fromTo(nextsh,masterspeed/2000,{autoAlpha:1},{autoAlpha:0,force3D:"auto",ease:ei}),0);
							mtl.add(punchgs.TweenLite.set(actsh,{autoAlpha:0,force3D:"auto"}),0);
							mtl.add(punchgs.TweenLite.fromTo(actsh,masterspeed/2000,{autoAlpha:0},{autoAlpha:1,force3D:"auto",ease:ei}),masterspeed/2000);							
						break;
					}
				} else {				
					nextsh.find('.slotslide').each(function(i) {
						var ss=jQuery(this);
						mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,{autoAlpha:0},{autoAlpha:1,force3D:"auto",ease:ei}),0);
					});
				}
	}

	//////////////////////
	// SLIDING OVERLAYS //
	//////////////////////
		
	if (nexttrans==27||nexttrans==28||nexttrans==29||nexttrans==30) {

		var slot = nextsh.find('.slot'),		
			nd = nexttrans==27 || nexttrans==28 ? 1 : 2,
			mhp = nexttrans==27 || nexttrans==29 ? "-100%" : "+100%",
			php = nexttrans==27 || nexttrans==29 ? "+100%" : "-100%",
			mep = nexttrans==27 || nexttrans==29 ? "-80%" : "80%",
			pep = nexttrans==27 || nexttrans==29 ? "80%" : "-80%",
			ptp = nexttrans==27 || nexttrans==29 ? "10%" : "-10%",
			fa = {overwrite:"all"},
			ta = {autoAlpha:0,zIndex:1,force3D:"auto",ease:punchgs.Power1.easeInOut},
			fb = {position:"inherit",autoAlpha:0,overwrite:"all"},
			tb = {autoAlpha:1,force3D:"auto",ease:punchgs.Power1.easeOut},
			fc = {overwrite:"all",zIndex:2},
			tc = {autoAlpha:1,force3D:"auto",overwrite:"all",ease:punchgs.Power1.easeInOut},
			fd = {overwrite:"all",zIndex:2},
			td = {autoAlpha:1,force3D:"auto",ease:punchgs.Power1.easeInOut},
			at = nd==1 ? "y" : "x";

		fa[at] = "0px";
		ta[at] = mhp;
		fb[at] = ptp;
		tb[at] = "0%";
		fc[at] = php;
		tc[at] = mhp;
		fd[at] = mep;
		td[at] = pep;

		slot.append('<span style="background-color:rgba(0,0,0,0.6);width:100%;height:100%;position:absolute;top:0px;left:0px;display:block;z-index:2"></span>');
		
		
		mtl.add(punchgs.TweenLite.fromTo(actsh,masterspeed/1000,fa,ta),0);						
		mtl.add(punchgs.TweenLite.fromTo(nextsh.find('.defaultimg'),masterspeed/2000,fb,tb),masterspeed/2000);				
		mtl.add(punchgs.TweenLite.fromTo(slot,masterspeed/1000,fc,tc),0);	
		mtl.add(punchgs.TweenLite.fromTo(slot.find('.slotslide div'),masterspeed/1000,fd,td),0);			
	}



	if (nexttrans==12 || nexttrans==13 || nexttrans==14 || nexttrans==15) {
				masterspeed = masterspeed;
				if (masterspeed>opt.delay) masterspeed=opt.delay;
				//masterspeed = 1000;

				setTimeout(function() {
					punchgs.TweenLite.set(actsh.find('.defaultimg'),{autoAlpha:0});

				},100);

				var oow = opt.width,
					ooh = opt.height,
					ssn=nextsh.find('.slotslide'),
					twx = 0,
					twy = 0,
					op = 1,
					scal = 1,
					fromscale = 1,					
					speedy = masterspeed/1000,
					speedy2 = speedy;


				if (opt.sliderLayout=="fullwidth" || opt.sliderLayout=="fullscreen") {
					oow=ssn.width();
					ooh=ssn.height();
				}



				if (nexttrans==12)
					twx = oow;
				else
				if (nexttrans==15)
					twx = 0-oow;
				else
				if (nexttrans==13)
					twy = ooh;
				else
				if (nexttrans==14)
					twy = 0-ooh;


				// DEPENDING ON EXTENDED SPECIALS, DIFFERENT SCALE AND OPACITY FUNCTIONS NEED TO BE ADDED
				if (specials == 1) op = 0;
				if (specials == 2) op = 0;
				if (specials == 3) speedy = masterspeed / 1300;				

				if (specials==4 || specials==5)
					scal=0.6;
				if (specials==6 )
					scal=1.4;


				if (specials==5 || specials==6) {
				    fromscale=1.4;
				    op=0;
				    oow=0;
				    ooh=0;twx=0;twy=0;
				 }
				if (specials==6) fromscale=0.6;
				var dd = 0;

				if (specials==7) {
					oow = 0;
					ooh = 0;
				}

				var inc = nextsh.find('.slotslide'),
					outc = actsh.find('.slotslide');

				mtl.add(punchgs.TweenLite.set(actli,{zIndex:15}),0);
				mtl.add(punchgs.TweenLite.set(nextli,{zIndex:20}),0);

				if (specials==8) {
										
					mtl.add(punchgs.TweenLite.set(actli,{zIndex:20}),0);
					mtl.add(punchgs.TweenLite.set(nextli,{zIndex:15}),0);					
					mtl.add(punchgs.TweenLite.set(inc,{left:0, top:0, scale:1, opacity:1,rotation:0,ease:ei,force3D:"auto"}),0);
				} else {

					mtl.add(punchgs.TweenLite.from(inc,speedy,{left:twx, top:twy, scale:fromscale, opacity:op,rotation:opt.rotate,ease:ei,force3D:"auto"}),0);
				}
				
				if (specials==4 || specials==5) {
					oow = 0; ooh=0;
				}

				if (specials!=1)
					switch (nexttrans) {
						case 12:
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'left':(0-oow)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
						case 15:
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'left':(oow)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
						case 13:						
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'top':(0-ooh)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
						case 14:
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'top':(ooh)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
					}
	
	}

	//////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XVI.  //
	//////////////////////////////////////
	if (nexttrans==16) {						// PAPERCUT


			var subtl = new punchgs.TimelineLite();
			mtl.add(punchgs.TweenLite.set(actli,{'position':'absolute','z-index':20}),0);
			mtl.add(punchgs.TweenLite.set(nextli,{'position':'absolute','z-index':15}),0);


			// PREPARE THE CUTS
			actli.wrapInner('<div class="tp-half-one" style="position:relative; width:100%;height:100%"></div>');

			actli.find('.tp-half-one').clone(true).appendTo(actli).addClass("tp-half-two");
			actli.find('.tp-half-two').removeClass('tp-half-one');

			var oow = opt.width,
				ooh = opt.height;
			if (opt.autoHeight=="on")
				ooh = container.height();


			actli.find('.tp-half-one .defaultimg').wrap('<div class="tp-papercut" style="width:'+oow+'px;height:'+ooh+'px;"></div>')
			actli.find('.tp-half-two .defaultimg').wrap('<div class="tp-papercut" style="width:'+oow+'px;height:'+ooh+'px;"></div>')
			actli.find('.tp-half-two .defaultimg').css({position:'absolute',top:'-50%'});
			actli.find('.tp-half-two .tp-caption').wrapAll('<div style="position:absolute;top:-50%;left:0px;"></div>');

			mtl.add(punchgs.TweenLite.set(actli.find('.tp-half-two'),
			                 {width:oow,height:ooh,overflow:'hidden',zIndex:15,position:'absolute',top:ooh/2,left:'0px',transformPerspective:600,transformOrigin:"center bottom"}),0);

			mtl.add(punchgs.TweenLite.set(actli.find('.tp-half-one'),
			                 {width:oow,height:ooh/2,overflow:'visible',zIndex:10,position:'absolute',top:'0px',left:'0px',transformPerspective:600,transformOrigin:"center top"}),0);

			// ANIMATE THE CUTS
			var img=actli.find('.defaultimg'),
				ro1=Math.round(Math.random()*20-10),
				ro2=Math.round(Math.random()*20-10),
				ro3=Math.round(Math.random()*20-10),
				xof = Math.random()*0.4-0.2,
				yof = Math.random()*0.4-0.2,
				sc1=Math.random()*1+1,
				sc2=Math.random()*1+1,
				sc3=Math.random()*0.3+0.3;

			mtl.add(punchgs.TweenLite.set(actli.find('.tp-half-one'),{overflow:'hidden'}),0);
			mtl.add(punchgs.TweenLite.fromTo(actli.find('.tp-half-one'),masterspeed/800,
			                 {width:oow,height:ooh/2,position:'absolute',top:'0px',left:'0px',force3D:"auto",transformOrigin:"center top"},
			                 {scale:sc1,rotation:ro1,y:(0-ooh-ooh/4),autoAlpha:0,ease:ei}),0);
			mtl.add(punchgs.TweenLite.fromTo(actli.find('.tp-half-two'),masterspeed/800,
			                 {width:oow,height:ooh,overflow:'hidden',position:'absolute',top:ooh/2,left:'0px',force3D:"auto",transformOrigin:"center bottom"},
			                 {scale:sc2,rotation:ro2,y:ooh+ooh/4,ease:ei,autoAlpha:0,onComplete:function() {
				                // CLEAN UP
								punchgs.TweenLite.set(actli,{'position':'absolute','z-index':15});
								punchgs.TweenLite.set(nextli,{'position':'absolute','z-index':20});
								if (actli.find('.tp-half-one').length>0)  {
									actli.find('.tp-half-one .defaultimg').unwrap();
									actli.find('.tp-half-one .slotholder').unwrap();
								}
								actli.find('.tp-half-two').remove();
			                 }}),0);

			subtl.add(punchgs.TweenLite.set(nextsh.find('.defaultimg'),{autoAlpha:1}),0);

			if (actli.html()!=null)
				mtl.add(punchgs.TweenLite.fromTo(nextli,(masterspeed-200)/1000,
												{scale:sc3,x:(opt.width/4)*xof, y:(ooh/4)*yof,rotation:ro3,force3D:"auto",transformOrigin:"center center",ease:eo},
												{autoAlpha:1,scale:1,x:0,y:0,rotation:0}),0);

			mtl.add(subtl,0);


	}

	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XVII.  //
	///////////////////////////////////////
	if (nexttrans==17) {								// 3D CURTAIN HORIZONTAL


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);

					mtl.add(punchgs.TweenLite.fromTo(ss,(masterspeed)/800,
									{opacity:0,rotationY:0,scale:0.9,rotationX:-110,force3D:"auto",transformPerspective:600,transformOrigin:"center center"},
									{opacity:1,top:0,left:0,scale:1,rotation:0,rotationX:0,force3D:"auto",rotationY:0,ease:ei,delay:j*0.06}),0);

				});
	}



	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XVIII.  //
	///////////////////////////////////////
	if (nexttrans==18) {								// 3D CURTAIN VERTICAL

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);

					mtl.add(punchgs.TweenLite.fromTo(ss,(masterspeed)/500,
									{autoAlpha:0,rotationY:110,scale:0.9,rotationX:10,force3D:"auto",transformPerspective:600,transformOrigin:"center center"},
									{autoAlpha:1,top:0,left:0,scale:1,rotation:0,rotationX:0,force3D:"auto",rotationY:0,ease:ei,delay:j*0.06}),0);
				});



	}


	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XIX.  //
	///////////////////////////////////////
	if (nexttrans==19 || nexttrans==22) {								// IN CUBE

				var subtl = new punchgs.TimelineLite();
				//SET DEFAULT IMG UNVISIBLE

				mtl.add(punchgs.TweenLite.set(actli,{zIndex:20}),0);
				mtl.add(punchgs.TweenLite.set(nextli,{zIndex:20}),0);
				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);
				var rot = 90,
					op = 1,
					torig ="center center ";

				if (slidedirection==1) rot = -90;

				if (nexttrans==19) {
					torig = torig+"-"+opt.height/2;
					op=0;

				} else {
					torig = torig+opt.height/2;
				}

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				punchgs.TweenLite.set(container,{transformStyle:"flat",backfaceVisibility:"hidden",transformPerspective:600});

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{transformStyle:"flat",backfaceVisibility:"hidden",left:0,rotationY:opt.rotate,z:10,top:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:torig,rotationX:rot},
									{left:0,rotationY:0,top:0,z:0, scale:1,force3D:"auto",rotationX:0, delay:(j*50)/1000,ease:ei}),0);
					subtl.add(punchgs.TweenLite.to(ss,0.1,{autoAlpha:1,delay:(j*50)/1000}),0);
					mtl.add(subtl);
				});

				actsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);
					var rot = -90;
					if (slidedirection==1) rot = 90;

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{transformStyle:"flat",backfaceVisibility:"hidden",autoAlpha:1,rotationY:0,top:0,z:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:torig, rotationX:0},
									{autoAlpha:1,rotationY:opt.rotate,top:0,z:10, scale:1,rotationX:rot, delay:(j*50)/1000,force3D:"auto",ease:eo}),0);

					mtl.add(subtl);					
				});
				mtl.add(punchgs.TweenLite.set(actli,{zIndex:18}),0);
	}




	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XX.  //
	///////////////////////////////////////
	if (nexttrans==20 ) {								// FLYIN


				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);
				
				if (slidedirection==1) {
				   var ofx = -opt.width
				   var rot  =80;
				   var torig = "20% 70% -"+opt.height/2;
				} else {
					var ofx = opt.width;
					var rot = -80;
					var torig = "80% 70% -"+opt.height/2;
				}


				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						d = (j*50)/1000;

					

					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{left:ofx,rotationX:40,z:-600, opacity:op,top:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:torig,transformStyle:"flat",rotationY:rot},
									{left:0,rotationX:0,opacity:1,top:0,z:0, scale:1,rotationY:0, delay:d,ease:ei}),0);
				

				});
				actsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						d = (j*50)/1000;
						d = j>0 ?  d + masterspeed/9000 : 0;

					if (slidedirection!=1) {
					   var ofx = -opt.width/2
					   var rot  =30;
					   var torig = "20% 70% -"+opt.height/2;
					} else {
						var ofx = opt.width/2;
						var rot = -30;
						var torig = "80% 70% -"+opt.height/2;
					}
					eo=punchgs.Power2.easeInOut;

					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{opacity:1,rotationX:0,top:0,z:0,scale:1,left:0, force3D:"auto",transformPerspective:600,transformOrigin:torig, transformStyle:"flat",rotationY:0},
									{opacity:1,rotationX:20,top:0, z:-600, left:ofx, force3D:"auto",rotationY:rot, delay:d,ease:eo}),0);
					
					
				});
	}

	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XX.  //
	///////////////////////////////////////
	if (nexttrans==21 || nexttrans==25) {								// TURNOFF


				//SET DEFAULT IMG UNVISIBLE

				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);
				var rot = 90,
					ofx = -opt.width,
					rot2 = -rot;

				if (slidedirection==1) {
				   if (nexttrans==25) {
				   	 var torig = "center top 0";
				   	 rot = opt.rotate;
				   } else {
				     var torig = "left center 0";
				     rot2 = opt.rotate;
				   }

				} else {
					ofx = opt.width;
					rot = -90;
					if (nexttrans==25) {
				   	 var torig = "center bottom 0"
				   	 rot2 = -rot;
				   	 rot = opt.rotate;
				   } else {
				     var torig = "right center 0";
				     rot2 = opt.rotate;
				   }
				}

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						ms2 = ((masterspeed/1.5)/3);


					mtl.add(punchgs.TweenLite.fromTo(ss,(ms2*2)/1000,
									{left:0,transformStyle:"flat",rotationX:rot2,z:0, autoAlpha:0,top:0,scale:1,force3D:"auto",transformPerspective:1200,transformOrigin:torig,rotationY:rot},
									{left:0,rotationX:0,top:0,z:0, autoAlpha:1,scale:1,rotationY:0,force3D:"auto",delay:ms2/1000, ease:ei}),0);
				});


				if (slidedirection!=1) {
				   	ofx = -opt.width
				   	rot  = 90;

				   if (nexttrans==25) {
				   	 torig = "center top 0"
				   	 rot2 = -rot;
				   	 rot = opt.rotate;
				   } else {
				     torig = "left center 0";
				     rot2 = opt.rotate;
				   }

				} else {
					ofx = opt.width;
					rot = -90;
					if (nexttrans==25) {
				   	 torig = "center bottom 0"
				   	 rot2 = -rot;
				   	 rot = opt.rotate;
				   } else {
				     torig = "right center 0";
				     rot2 = opt.rotate;
				   }
				}

				actsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);
					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{left:0,transformStyle:"flat",rotationX:0,z:0, autoAlpha:1,top:0,scale:1,force3D:"auto",transformPerspective:1200,transformOrigin:torig,rotationY:0},
									{left:0,rotationX:rot2,top:0,z:0,autoAlpha:1,force3D:"auto", scale:1,rotationY:rot,ease:eo}),0);
				});
	}



	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XX.  //
	///////////////////////////////////////
	if (nexttrans==23 || nexttrans == 24) {								// cube-horizontal - inboxhorizontal

		//SET DEFAULT IMG UNVISIBLE
		setTimeout(function() {
			actsh.find('.defaultimg').css({opacity:0});
		},100);
		var rot = -90,
			op = 1,
			opx=0;

		if (slidedirection==1) rot = 90;
		if (nexttrans==23) {
			var torig = "center center -"+opt.width/2;
			op=0;
		} else
			var torig = "center center "+opt.width/2;

		punchgs.TweenLite.set(container,{transformStyle:"preserve-3d",backfaceVisibility:"hidden",perspective:2500});
						nextsh.find('.slotslide').each(function(j) {
			var ss=jQuery(this);
			mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
							{left:opx,rotationX:opt.rotate,force3D:"auto",opacity:op,top:0,scale:1,transformPerspective:1200,transformOrigin:torig,rotationY:rot},
							{left:0,rotationX:0,autoAlpha:1,top:0,z:0, scale:1,rotationY:0, delay:(j*50)/500,ease:ei}),0);
		});

		rot = 90;
		if (slidedirection==1) rot = -90;

		actsh.find('.slotslide').each(function(j) {
			var ss=jQuery(this);
			mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
							{left:0,rotationX:0,top:0,z:0,scale:1,force3D:"auto",transformStyle:"flat",transformPerspective:1200,transformOrigin:torig, rotationY:0},
							{left:opx,rotationX:opt.rotate,top:0, scale:1,rotationY:rot, delay:(j*50)/500,ease:eo}),0);
			if (nexttrans==23) mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/2000,{autoAlpha:1},{autoAlpha:0,delay:(j*50)/500 + masterspeed/3000,ease:eo}),0);

		});
	}	

	

			// SHOW FIRST LI && ANIMATE THE CAPTIONS
			mtl.add(punchgs.TweenLite.set(nextsh.find('.defaultimg'),{autoAlpha:1}));
			mtl.add(punchgs.TweenLite.set(nextsh.find('.slot'),{autoAlpha:0}));		

			mtl.seek(100000);
	
			if (givebackmtl!=undefined)
				return mtl;
			else
				jQuery('#divbgholder').data('slidetimeline',mtl);
			
		}
	

	


	///////////////////////
	//	REMOVE SLOTS	//
	/////////////////////
	var removeAllSlots = function() {
				if (jQuery('#divbgholder').data('slidetimeline')!=undefined) {
					jQuery('#divbgholder').data('slidetimeline').kill();
					jQuery('#divbgholder').find('.slot').each(function() {
						jQuery(this).remove();
					});
				}
				
		}
	
	t.resetSlideAnimations = function(seekinpos) {
		removeAllSlots();
		slideAnimation();
		var mst = jQuery('#divbgholder').data('slidetimeline'),
			mp = jQuery('#mastertimer-position'),
			tpos = (mp.position().left-15)/100;
		if (mst!=undefined) {
			mst.stop();
			if (seekinpos) mst.seek(tpos);
		}
	}
	
}