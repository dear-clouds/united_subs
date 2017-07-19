
/* SOURCE: js/visibility_check.js */
;;/* when calendar is rendered on a container that is not visible, it doesnt gets the correct height calculated.*/
function _rhc_check_visibility(){
	jQuery(document).ready(function($){
		var recheck = false;
		$('.fullCalendar').each(function(i,c){
			if( $(c).is(':visible') && $(c).find('.fc-content').height()<10 ){
				$(c).fullCalendar('render');
			}else if( $(c).find('.fc-content').height()<10 ){
				recheck = true;
			}		
		});
		
		if( recheck ){
			setTimeout('_rhc_check_visibility()',300);
		}
	});
}

function _rhc_check_init_rhc(){
	jQuery('.rhc_holder').each(function(i,c){
		if( jQuery(this).data('Calendarize') ) return true;
		init_rhc();	
		return false;	
	});
	setTimeout('_rhc_check_init_rhc()',1000);	
}

jQuery(document).ready(function($){
	if( RHC.visibility_check ){
		if( jQuery('.fullCalendar').length>0 )setTimeout('_rhc_check_visibility()',200);
		setTimeout('_rhc_check_init_rhc()',500);
	}else{

	}
});

/* SOURCE: js/jquery.easing.1.3.js */
;;/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});

/*
 *
 * TERMS OF USE - EASING EQUATIONS
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2001 Robert Penner
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 */
/* SOURCE: js/rrule.js */
;;/*!
 * rrule.js - Library for working with recurrence rules for calendar dates.
 * https://github.com/jkbrzt/rrule
 *
 * Copyright 2010, Jakub Roztocil and Lars Schoning
 * Licenced under the BSD licence.
 * https://github.com/jkbrzt/rrule/blob/master/LICENCE
 *
 * Based on:
 * python-dateutil - Extensions to the standard Python datetime module.
 * Copyright (c) 2003-2011 - Gustavo Niemeyer <gustavo@niemeyer.net>
 * Copyright (c) 2012 - Tomi Pieviläinen <tomi.pievilainen@iki.fi>
 * https://github.com/jkbrzt/rrule/blob/master/LICENCE
 *
 */
(function(root){

var serverSide = typeof module !== 'undefined' && module.exports;


var getnlp = function() {
    if (!getnlp._nlp) {
        if (serverSide) {
            // Lazy, runtime import to avoid circular refs.
            getnlp._nlp = require('./nlp')
        } else if (!(getnlp._nlp = root._RRuleNLP)) {
            throw new Error(
                'You need to include rrule/nlp.js for fromText/toText to work.'
            )
        }
    }
    return getnlp._nlp;
};


//=============================================================================
// Date utilities
//=============================================================================

/**
 * General date-related utilities.
 * Also handles several incompatibilities between JavaScript and Python
 *
 */
var dateutil = {

    MONTH_DAYS: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],

    /**
     * Number of milliseconds of one day
     */
    ONE_DAY: 1000 * 60 * 60 * 24,

    /**
     * @see: <http://docs.python.org/library/datetime.html#datetime.MAXYEAR>
     */
    MAXYEAR: 9999,

    /**
     * Python uses 1-Jan-1 as the base for calculating ordinals but we don't
     * want to confuse the JS engine with milliseconds > Number.MAX_NUMBER,
     * therefore we use 1-Jan-1970 instead
     */
    ORDINAL_BASE: new Date(1970, 0, 1),

    /**
     * Python: MO-SU: 0 - 6
     * JS: SU-SAT 0 - 6
     */
    PY_WEEKDAYS: [6, 0, 1, 2, 3, 4, 5],

    /**
     * py_date.timetuple()[7]
     */
    getYearDay: function(date) {
        var dateNoTime = new Date(
            date.getFullYear(), date.getMonth(), date.getDate());
        return Math.ceil(
            (dateNoTime - new Date(date.getFullYear(), 0, 1))
            / dateutil.ONE_DAY) + 1;
    },

    isLeapYear: function(year) {
        if (year instanceof Date) {
            year = year.getFullYear();
        }
        return ((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0);
    },

    /**
     * @return {Number} the date's timezone offset in ms
     */
    tzOffset: function(date) {
         return date.getTimezoneOffset() * 60 * 1000
    },

    /**
     * @see: <http://www.mcfedries.com/JavaScript/DaysBetween.asp>
     */
    daysBetween: function(date1, date2) {
        // The number of milliseconds in one day
        // Convert both dates to milliseconds
        var date1_ms = date1.getTime() - dateutil.tzOffset(date1);
        var date2_ms = date2.getTime() - dateutil.tzOffset(date2);
        // Calculate the difference in milliseconds
        var difference_ms = Math.abs(date1_ms - date2_ms);
        // Convert back to days and return
        return Math.round(difference_ms / dateutil.ONE_DAY);
    },

    /**
     * @see: <http://docs.python.org/library/datetime.html#datetime.date.toordinal>
     */
    toOrdinal: function(date) {
        return dateutil.daysBetween(date, dateutil.ORDINAL_BASE);
    },

    /**
     * @see - <http://docs.python.org/library/datetime.html#datetime.date.fromordinal>
     */
    fromOrdinal: function(ordinal) {
        var millisecsFromBase = ordinal * dateutil.ONE_DAY;
        return new Date(dateutil.ORDINAL_BASE.getTime()
                        - dateutil.tzOffset(dateutil.ORDINAL_BASE)
                        +  millisecsFromBase
                        + dateutil.tzOffset(new Date(millisecsFromBase)));
    },

    /**
     * @see: <http://docs.python.org/library/calendar.html#calendar.monthrange>
     */
    monthRange: function(year, month) {
        var date = new Date(year, month, 1);
        return [dateutil.getWeekday(date), dateutil.getMonthDays(date)];
    },

    getMonthDays: function(date) {
        var month = date.getMonth();
        return month == 1 && dateutil.isLeapYear(date)
            ? 29
            : dateutil.MONTH_DAYS[month];
    },

    /**
     * @return {Number} python-like weekday
     */
    getWeekday: function(date) {
        return dateutil.PY_WEEKDAYS[date.getDay()];
    },

    /**
     * @see: <http://docs.python.org/library/datetime.html#datetime.datetime.combine>
     */
    combine: function(date, time) {
        time = time || date;
        return new Date(
            date.getFullYear(), date.getMonth(), date.getDate(),
            time.getHours(), time.getMinutes(), time.getSeconds()
        );
    },

    clone: function(date) {
        var dolly = new Date(date.getTime());
        dolly.setMilliseconds(0);
        return dolly;
    },

    cloneDates: function(dates) {
        var clones = [];
        for (var i = 0; i < dates.length; i++) {
            clones.push(dateutil.clone(dates[i]));
        }
        return clones;
    },

    /**
     * Sorts an array of Date or dateutil.Time objects
     */
    sort: function(dates) {
        dates.sort(function(a, b){
            return a.getTime() - b.getTime();
        });
    },

    timeToUntilString: function(time) {
        var date = new Date(time);
        var comp, comps = [
            date.getUTCFullYear(),
            date.getUTCMonth() + 1,
            date.getUTCDate(),
            'T',
            date.getUTCHours(),
            date.getUTCMinutes(),
            date.getUTCSeconds(),
            'Z'
        ];
        for (var i = 0; i < comps.length; i++) {
            comp = comps[i];
            if (!/[TZ]/.test(comp) && comp < 10) {
                comps[i] = '0' + String(comp);
            }
        }
        return comps.join('');
    },

    untilStringToDate: function(until) {
        var re = /^(\d{4})(\d{2})(\d{2})(T(\d{2})(\d{2})(\d{2})Z)?$/;
        var bits = re.exec(until);
        if (!bits) {
            throw new Error('Invalid UNTIL value: ' + until)
        }
        return new Date(
            Date.UTC(bits[1],
            bits[2] - 1,
            bits[3],
            bits[5] || 0,
            bits[6] || 0,
            bits[7] || 0
        ));
    }

};

dateutil.Time = function(hour, minute, second) {
    this.hour = hour;
    this.minute = minute;
    this.second = second;
};

dateutil.Time.prototype = {
    getHours: function() {
        return this.hour;
    },
    getMinutes: function() {
        return this.minute;
    },
    getSeconds: function() {
        return this.second;
    },
    getTime: function() {
        return ((this.hour * 60 * 60)
                 + (this.minute * 60)
                 + this.second)
               * 1000;
    }
};


//=============================================================================
// Helper functions
//=============================================================================


/**
 * Simplified version of python's range()
 */
var range = function(start, end) {
    if (arguments.length === 1) {
        end = start;
        start = 0;
    }
    var rang = [];
    for (var i = start; i < end; i++) {
        rang.push(i);
    }
    return rang;
};
var repeat = function(value, times) {
    var i = 0, array = [];
    if (value instanceof Array) {
        for (; i < times; i++) {
            array[i] = [].concat(value);
        }
    } else {
        for (; i < times; i++) {
            array[i] = value;
        }
    }
    return array;
};


/**
 * closure/goog/math/math.js:modulo
 * Copyright 2006 The Closure Library Authors.
 * The % operator in JavaScript returns the remainder of a / b, but differs from
 * some other languages in that the result will have the same sign as the
 * dividend. For example, -1 % 8 == -1, whereas in some other languages
 * (such as Python) the result would be 7. This function emulates the more
 * correct modulo behavior, which is useful for certain applications such as
 * calculating an offset index in a circular list.
 *
 * @param {number} a The dividend.
 * @param {number} b The divisor.
 * @return {number} a % b where the result is between 0 and b (either 0 <= x < b
 *     or b < x <= 0, depending on the sign of b).
 */
var pymod = function(a, b) {
  var r = a % b;
  // If r and b differ in sign, add b to wrap the result to the correct sign.
  return (r * b < 0) ? r + b : r;
};


/**
 * @see: <http://docs.python.org/library/functions.html#divmod>
 */
var divmod = function(a, b) {
    return {div: Math.floor(a / b), mod: pymod(a, b)};
};


/**
 * Python-like boolean
 * @return {Boolean} value of an object/primitive, taking into account
 * the fact that in Python an empty list's/tuple's
 * boolean value is False, whereas in JS it's true
 */
var plb = function(obj) {
    return (obj instanceof Array && obj.length == 0)
        ? false
        : Boolean(obj);
};


/**
 * Return true if a value is in an array
 */
var contains = function(arr, val) {
    return arr.indexOf(val) != -1;
};


//=============================================================================
// Date masks
//=============================================================================

// Every mask is 7 days longer to handle cross-year weekly periods.

var M365MASK = [].concat(
    repeat(1, 31),  repeat(2, 28),  repeat(3, 31),
    repeat(4, 30),  repeat(5, 31),  repeat(6, 30),
    repeat(7, 31),  repeat(8, 31),  repeat(9, 30),
    repeat(10, 31), repeat(11, 30), repeat(12, 31),
    repeat(1, 7)
);
var M366MASK = [].concat(
    repeat(1, 31),  repeat(2, 29),  repeat(3, 31),
    repeat(4, 30),  repeat(5, 31),  repeat(6, 30),
    repeat(7, 31),  repeat(8, 31),  repeat(9, 30),
    repeat(10, 31), repeat(11, 30), repeat(12, 31),
    repeat(1, 7)
);

var
    M28 = range(1, 29),
    M29 = range(1, 30),
    M30 = range(1, 31),
    M31 = range(1, 32);
var MDAY366MASK = [].concat(
    M31, M29, M31,
    M30, M31, M30,
    M31, M31, M30,
    M31, M30, M31,
    M31.slice(0, 7)
);
var MDAY365MASK = [].concat(
    M31, M28, M31,
    M30, M31, M30,
    M31, M31, M30,
    M31, M30, M31,
    M31.slice(0, 7)
);

M28 = range(-28, 0);
M29 = range(-29, 0);
M30 = range(-30, 0);
M31 = range(-31, 0);
var NMDAY366MASK = [].concat(
    M31, M29, M31,
    M30, M31, M30,
    M31, M31, M30,
    M31, M30, M31,
    M31.slice(0, 7)
);
var NMDAY365MASK = [].concat(
    M31, M28, M31,
    M30, M31, M30,
    M31, M31, M30,
    M31, M30, M31,
    M31.slice(0, 7)
);

var M366RANGE = [0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335, 366];
var M365RANGE = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365];

var WDAYMASK = (function() {
    for (var wdaymask = [], i = 0; i < 55; i++) {
        wdaymask = wdaymask.concat(range(7));
    }
    return wdaymask;
}());


//=============================================================================
// Weekday
//=============================================================================

var Weekday = function(weekday, n) {
    if (n === 0) {
        throw new Error('Can\'t create weekday with n == 0');
    }
    this.weekday = weekday;
    this.n = n;
};

Weekday.prototype = {

    // __call__ - Cannot call the object directly, do it through
    // e.g. RRule.TH.nth(-1) instead,
    nth: function(n) {
        return this.n == n ? this : new Weekday(this.weekday, n);
    },

    // __eq__
    equals: function(other) {
        return this.weekday == other.weekday && this.n == other.n;
    },

    // __repr__
    toString: function() {
        var s = ['MO', 'TU', 'WE', 'TH', 'FR', 'SA', 'SU'][this.weekday];
        if (this.n) {
            s = (this.n > 0 ? '+' : '') + String(this.n) + s;
        }
        return s;
    },

    getJsWeekday: function() {
        return this.weekday == 6 ? 0 : this.weekday + 1;
    }

};


//=============================================================================
// RRule
//=============================================================================

/**
 *
 * @param {Object?} options - see <http://labix.org/python-dateutil/#head-cf004ee9a75592797e076752b2a889c10f445418>
 *        The only required option is `freq`, one of RRule.YEARLY, RRule.MONTHLY, ...
 * @constructor
 */
var RRule = function(options, noCache) {

    // RFC string
    this._string = null;

    options = options || {};

    this._cache = noCache ? null : {
        all: false,
        before: [],
        after: [],
        between: []
    };

    // used by toString()
    this.origOptions = {};

    var invalid = [],
        keys = Object.keys(options),
        defaultKeys = Object.keys(RRule.DEFAULT_OPTIONS);

    // Shallow copy for origOptions and check for invalid
    keys.forEach(function(key) {
        this.origOptions[key] = options[key];
        if (!contains(defaultKeys, key)) invalid.push(key);
    }, this);

    if (invalid.length) {
        throw new Error('Invalid options: ' + invalid.join(', '))
    }

    if (!RRule.FREQUENCIES[options.freq] && options.byeaster === null) {
        throw new Error('Invalid frequency: ' + String(options.freq))
    }

    // Merge in default options
    defaultKeys.forEach(function(key) {
        if (!contains(keys, key)) options[key] = RRule.DEFAULT_OPTIONS[key];
    });

    var opts = this.options = options;

    if (opts.byeaster !== null) {
        opts.freq = RRule.YEARLY;
    }

    if (!opts.dtstart) {
        opts.dtstart = new Date();
        opts.dtstart.setMilliseconds(0);
    }

    if (opts.wkst === null) {
        opts.wkst = RRule.MO.weekday;
    } else if (typeof opts.wkst == 'number') {
        // cool, just keep it like that
    } else {
        opts.wkst = opts.wkst.weekday;
    }

    if (opts.bysetpos !== null) {
        if (typeof opts.bysetpos == 'number') {
            opts.bysetpos = [opts.bysetpos];
        }
        for (var i = 0; i < opts.bysetpos.length; i++) {
            var v = opts.bysetpos[i];
            if (v == 0 || !(-366 <= v && v <= 366)) {
                throw new Error(
                    'bysetpos must be between 1 and 366,' +
                        ' or between -366 and -1'
                );
            }
        }
    }

    if (!(plb(opts.byweekno) || plb(opts.byyearday)
        || plb(opts.bymonthday) || opts.byweekday !== null
        || opts.byeaster !== null))
    {
        switch (opts.freq) {
            case RRule.YEARLY:
                if (!opts.bymonth) {
                    opts.bymonth = opts.dtstart.getMonth() + 1;
                }
                opts.bymonthday = opts.dtstart.getDate();
                break;
            case RRule.MONTHLY:
                opts.bymonthday = opts.dtstart.getDate();
                break;
            case RRule.WEEKLY:
                opts.byweekday = dateutil.getWeekday(
                                            opts.dtstart);
                break;
        }
    }

    // bymonth
    if (opts.bymonth !== null
        && !(opts.bymonth instanceof Array)) {
        opts.bymonth = [opts.bymonth];
    }

    // byyearday
    if (opts.byyearday !== null
        && !(opts.byyearday instanceof Array)) {
        opts.byyearday = [opts.byyearday];
    }

    // bymonthday
    if (opts.bymonthday === null) {
        opts.bymonthday = [];
        opts.bynmonthday = [];
    } else if (opts.bymonthday instanceof Array) {
        var bymonthday = [], bynmonthday = [];

        for (i = 0; i < opts.bymonthday.length; i++) {
            var v = opts.bymonthday[i];
            if (v > 0) {
                bymonthday.push(v);
            } else if (v < 0) {
                bynmonthday.push(v);
            }
        }
        opts.bymonthday = bymonthday;
        opts.bynmonthday = bynmonthday;
    } else {
        if (opts.bymonthday < 0) {
            opts.bynmonthday = [opts.bymonthday];
            opts.bymonthday = [];
        } else {
            opts.bynmonthday = [];
            opts.bymonthday = [opts.bymonthday];
        }
    }

    // byweekno
    if (opts.byweekno !== null
        && !(opts.byweekno instanceof Array)) {
        opts.byweekno = [opts.byweekno];
    }

    // byweekday / bynweekday
    if (opts.byweekday === null) {
        opts.bynweekday = null;
    } else if (typeof opts.byweekday == 'number') {
        opts.byweekday = [opts.byweekday];
        opts.bynweekday = null;

    } else if (opts.byweekday instanceof Weekday) {

        if (!opts.byweekday.n || opts.freq > RRule.MONTHLY) {
            opts.byweekday = [opts.byweekday.weekday];
            opts.bynweekday = null;
        } else {
            opts.bynweekday = [
                [opts.byweekday.weekday,
                 opts.byweekday.n]
            ];
            opts.byweekday = null;
        }

    } else {
        var byweekday = [], bynweekday = [];

        for (i = 0; i < opts.byweekday.length; i++) {
            var wday = opts.byweekday[i];

            if (typeof wday == 'number') {
                byweekday.push(wday);
            } else if (!wday.n || opts.freq > RRule.MONTHLY) {
                byweekday.push(wday.weekday);
            } else {
                bynweekday.push([wday.weekday, wday.n]);
            }
        }
        opts.byweekday = plb(byweekday) ? byweekday : null;
        opts.bynweekday = plb(bynweekday) ? bynweekday : null;
    }

    // byhour
    if (opts.byhour === null) {
        opts.byhour = (opts.freq < RRule.HOURLY)
            ? [opts.dtstart.getHours()]
            : null;
    } else if (typeof opts.byhour == 'number') {
        opts.byhour = [opts.byhour];
    }

    // byminute
    if (opts.byminute === null) {
        opts.byminute = (opts.freq < RRule.MINUTELY)
            ? [opts.dtstart.getMinutes()]
            : null;
    } else if (typeof opts.byminute == 'number') {
        opts.byminute = [opts.byminute];
    }

    // bysecond
    if (opts.bysecond === null) {
        opts.bysecond = (opts.freq < RRule.SECONDLY)
            ? [opts.dtstart.getSeconds()]
            : null;
    } else if (typeof opts.bysecond == 'number') {
        opts.bysecond = [opts.bysecond];
    }

    if (opts.freq >= RRule.HOURLY) {
        this.timeset = null;
    } else {
        this.timeset = [];
        for (i = 0; i < opts.byhour.length; i++) {
            var hour = opts.byhour[i];
            for (var j = 0; j < opts.byminute.length; j++) {
                var minute = opts.byminute[j];
                for (var k = 0; k < opts.bysecond.length; k++) {
                    var second = opts.bysecond[k];
                    // python:
                    // datetime.time(hour, minute, second,
                    // tzinfo=self._tzinfo))
                    this.timeset.push(new dateutil.Time(hour, minute, second));
                }
            }
        }
        dateutil.sort(this.timeset);
    }

};
//}}}

// RRule class 'constants'

RRule.FREQUENCIES = [
    'YEARLY', 'MONTHLY', 'WEEKLY', 'DAILY',
    'HOURLY', 'MINUTELY', 'SECONDLY'
];

RRule.YEARLY   = 0;
RRule.MONTHLY  = 1;
RRule.WEEKLY   = 2;
RRule.DAILY    = 3;
RRule.HOURLY   = 4;
RRule.MINUTELY = 5;
RRule.SECONDLY = 6;

RRule.MO = new Weekday(0);
RRule.TU = new Weekday(1);
RRule.WE = new Weekday(2);
RRule.TH = new Weekday(3);
RRule.FR = new Weekday(4);
RRule.SA = new Weekday(5);
RRule.SU = new Weekday(6);

RRule.DEFAULT_OPTIONS = {
    freq:        null,
    dtstart:     null,
    interval:    1,
    wkst:        RRule.MO,
    count:       null,
    until:       null,
    bysetpos:    null,
    bymonth:     null,
    bymonthday:  null,
    bynmonthday: null,
    byyearday:   null,
    byweekno:    null,
    byweekday:   null,
    bynweekday:  null,
    byhour:      null,
    byminute:    null,
    bysecond:    null,
    byeaster:    null
};



RRule.parseText = function(text, language) {
    return getnlp().parseText(text, language)
};

RRule.fromText = function(text, language) {
    return getnlp().fromText(text, language)
};

RRule.optionsToString = function(options) {
    var key, keys, defaultKeys, value, strValues, pairs = [];

    keys = Object.keys(options);
    defaultKeys = Object.keys(RRule.DEFAULT_OPTIONS);

    for (var i = 0; i < keys.length; i++) {

        if (!contains(defaultKeys, keys[i])) continue;

        key = keys[i].toUpperCase();
        value = options[keys[i]];
        strValues = [];

        if (value === null || value instanceof Array && !value.length) {
            continue;
        }

        switch (key) {
            case 'FREQ':
                value = RRule.FREQUENCIES[options.freq];
                break;
            case 'WKST':
                value = value.toString();
                break;
            case 'BYWEEKDAY':
                /*
                NOTE: BYWEEKDAY is a special case.
                RRule() deconstructs the rule.options.byweekday array
                into an array of Weekday arguments.
                On the other hand, rule.origOptions is an array of Weekdays.
                We need to handle both cases here.
                It might be worth change RRule to keep the Weekdays.

                Also, BYWEEKDAY (used by RRule) vs. BYDAY (RFC)

                */
                key = 'BYDAY';
                if (!(value instanceof Array)) {
                    value = [value];
                }
                for (var wday, j = 0; j < value.length; j++) {
                    wday = value[j];
                    if (wday instanceof Weekday) {
                        // good
                    } else if (wday instanceof Array) {
                        wday = new Weekday(wday[0], wday[1]);
                    } else {
                        wday = new Weekday(wday);
                    }
                    strValues[j] = wday.toString();
                }
                value = strValues;
                break;
            case'DTSTART':
            case'UNTIL':
                value = dateutil.timeToUntilString(value);
                break;
            default:
                if (value instanceof Array) {
                    for (var j = 0; j < value.length; j++) {
                        strValues[j] = String(value[j]);
                    }
                    value = strValues;
                } else {
                    value = String(value);
                }

        }
        pairs.push([key, value]);
    }

    var strings = [];
    for (var i = 0; i < pairs.length; i++) {
        var attr = pairs[i];
        strings.push(attr[0] + '=' + attr[1].toString());
    }
    return strings.join(';');

};

RRule.prototype = {

    /**
     * @param {Function} iterator - optional function that will be called
     *                   on each date that is added. It can return false
     *                   to stop the iteration.
     * @return Array containing all recurrences.
     */
    all: function(iterator) {
        if (iterator) {
            return this._iter(new CallbackIterResult('all', {}, iterator));
        } else {
            var result = this._cacheGet('all');
            if (result === false) {
                result = this._iter(new IterResult('all', {}));
                this._cacheAdd('all', result);
            }
            return result;
        }
    },

    /**
     * Returns all the occurrences of the rrule between after and before.
     * The inc keyword defines what happens if after and/or before are
     * themselves occurrences. With inc == True, they will be included in the
     * list, if they are found in the recurrence set.
     * @return Array
     */
    between: function(after, before, inc, iterator) {
        var args = {
                before: before,
                after: after,
                inc: inc
            }

        if (iterator) {
            return this._iter(
                new CallbackIterResult('between', args, iterator));
        } else {
            var result = this._cacheGet('between', args);
            if (result === false) {
                result = this._iter(new IterResult('between', args));
                this._cacheAdd('between', result, args);
            }
            return result;
        }
    },

    /**
     * Returns the last recurrence before the given datetime instance.
     * The inc keyword defines what happens if dt is an occurrence.
     * With inc == True, if dt itself is an occurrence, it will be returned.
     * @return Date or null
     */
    before: function(dt, inc) {
        var args = {
                dt: dt,
                inc: inc
            },
            result = this._cacheGet('before', args);
        if (result === false) {
            result = this._iter(new IterResult('before', args));
            this._cacheAdd('before', result, args);
        }
        return result;
    },

    /**
     * Returns the first recurrence after the given datetime instance.
     * The inc keyword defines what happens if dt is an occurrence.
     * With inc == True, if dt itself is an occurrence, it will be returned.
     * @return Date or null
     */
    after: function(dt, inc) {
        var args = {
                dt: dt,
                inc: inc
            },
            result = this._cacheGet('after', args);
        if (result === false) {
            result = this._iter(new IterResult('after', args));
            this._cacheAdd('after', result, args);
        }
        return result;
    },

    /**
     * Returns the number of recurrences in this set. It will have go trough
     * the whole recurrence, if this hasn't been done before.
     */
    count: function() {
        return this.all().length;
    },

    /**
     * Converts the rrule into its string representation
     * @see <http://www.ietf.org/rfc/rfc2445.txt>
     * @return String
     */
    toString: function() {
        return RRule.optionsToString(this.origOptions);
    },

	/**
	* Will convert all rules described in nlp:ToText
	* to text.
	*/
	toText: function(gettext, language) {
        return getnlp().toText(this, gettext, language);
	},

    isFullyConvertibleToText: function() {
        return getnlp().isFullyConvertible(this)
    },

    /**
     * @param {String} what - all/before/after/between
     * @param {Array,Date} value - an array of dates, one date, or null
     * @param {Object?} args - _iter arguments
     */
    _cacheAdd: function(what, value, args) {

        if (!this._cache) return;

        if (value) {
            value = (value instanceof Date)
                        ? dateutil.clone(value)
                        : dateutil.cloneDates(value);
        }

        if (what == 'all') {
                this._cache.all = value;
        } else {
            args._value = value;
            this._cache[what].push(args);
        }

    },

    /**
     * @return false - not in the cache
     *         null  - cached, but zero occurrences (before/after)
     *         Date  - cached (before/after)
     *         []    - cached, but zero occurrences (all/between)
     *         [Date1, DateN] - cached (all/between)
     */
    _cacheGet: function(what, args) {

        if (!this._cache) {
            return false;
        }

        var cached = false;

        if (what == 'all') {
            cached = this._cache.all;
        } else {
            // Let's see whether we've already called the
            // 'what' method with the same 'args'
            loopItems:
            for (var item, i = 0; i < this._cache[what].length; i++) {
                item = this._cache[what][i];
                for (var k in args) {
                    if (args.hasOwnProperty(k)
                        && String(args[k]) != String(item[k])) {
                        continue loopItems;
                    }
                }
                cached = item._value;
                break;
            }
        }

        if (!cached && this._cache.all) {
            // Not in the cache, but we already know all the occurrences,
            // so we can find the correct dates from the cached ones.
            var iterResult = new IterResult(what, args);
            for (var i = 0; i < this._cache.all.length; i++) {
                if (!iterResult.accept(this._cache.all[i])) {
                    break;
                }
            }
            cached = iterResult.getValue();
            this._cacheAdd(what, cached, args);
        }

        return cached instanceof Array
            ? dateutil.cloneDates(cached)
            : (cached instanceof Date
                ? dateutil.clone(cached)
                : cached);
    },

    /**
     * @return a RRule instance with the same freq and options
     *          as this one (cache is not cloned)
     */
    clone: function() {
        return new RRule(this.origOptions);
    },

    _iter: function(iterResult) {

        /* Since JavaScript doesn't have the python's yield operator (<1.7),
           we use the IterResult object that tells us when to stop iterating.

        */

        var dtstart = this.options.dtstart;

        var
            year = dtstart.getFullYear(),
            month = dtstart.getMonth() + 1,
            day = dtstart.getDate(),
            hour = dtstart.getHours(),
            minute = dtstart.getMinutes(),
            second = dtstart.getSeconds(),
            weekday = dateutil.getWeekday(dtstart),
            yearday = dateutil.getYearDay(dtstart);

        // Some local variables to speed things up a bit
        var
            freq = this.options.freq,
            interval = this.options.interval,
            wkst = this.options.wkst,
            until = this.options.until,
            bymonth = this.options.bymonth,
            byweekno = this.options.byweekno,
            byyearday = this.options.byyearday,
            byweekday = this.options.byweekday,
            byeaster = this.options.byeaster,
            bymonthday = this.options.bymonthday,
            bynmonthday = this.options.bynmonthday,
            bysetpos = this.options.bysetpos,
            byhour = this.options.byhour,
            byminute = this.options.byminute,
            bysecond = this.options.bysecond;

        var ii = new Iterinfo(this);
        ii.rebuild(year, month);

        var getdayset = {};
        getdayset[RRule.YEARLY]   = ii.ydayset;
        getdayset[RRule.MONTHLY]  = ii.mdayset;
        getdayset[RRule.WEEKLY]   = ii.wdayset;
        getdayset[RRule.DAILY]    = ii.ddayset;
        getdayset[RRule.HOURLY]   = ii.ddayset;
        getdayset[RRule.MINUTELY] = ii.ddayset;
        getdayset[RRule.SECONDLY] = ii.ddayset;

        getdayset = getdayset[freq];

        var timeset;
        if (freq < RRule.HOURLY) {
            timeset = this.timeset;
        } else {
            var gettimeset = {};
            gettimeset[RRule.HOURLY]   = ii.htimeset;
            gettimeset[RRule.MINUTELY] = ii.mtimeset;
            gettimeset[RRule.SECONDLY] = ii.stimeset;
            gettimeset = gettimeset[freq];
            if ((freq >= RRule.HOURLY   && plb(byhour)   && !contains(byhour, hour)) ||
                (freq >= RRule.MINUTELY && plb(byminute) && !contains(byminute, minute)) ||
                (freq >= RRule.SECONDLY && plb(bysecond) && !contains(bysecond, minute)))
            {
                timeset = [];
            } else {
                timeset = gettimeset.call(ii, hour, minute, second);
            }
        }

        var filtered, total = 0, count = this.options.count;

        var iterNo = 0;

        var i, j, k, dm, div, mod, tmp, pos, dayset, start, end, fixday;

        while (true) {

            // Get dayset with the right frequency
            tmp = getdayset.call(ii, year, month, day);
            dayset = tmp[0]; start = tmp[1]; end = tmp[2];

            // Do the "hard" work ;-)
            filtered = false;
            for (j = start; j < end; j++) {

                i = dayset[j];

                if ((plb(bymonth) && !contains(bymonth, ii.mmask[i])) ||
                    (plb(byweekno) && !ii.wnomask[i]) ||
                    (plb(byweekday) && !contains(byweekday, ii.wdaymask[i])) ||
                    (plb(ii.nwdaymask) && !ii.nwdaymask[i]) ||
                    (byeaster !== null && !contains(ii.eastermask, i)) ||
                    (
                        (plb(bymonthday) || plb(bynmonthday)) &&
                        !contains(bymonthday, ii.mdaymask[i]) &&
                        !contains(bynmonthday, ii.nmdaymask[i])
                    )
                    ||
                    (
                        plb(byyearday)
                        &&
                        (
                            (
                                i < ii.yearlen &&
                                !contains(byyearday, i + 1) &&
                                !contains(byyearday, -ii.yearlen + i)
                            )
                            ||
                            (
                                i >= ii.yearlen &&
                                !contains(byyearday, i + 1 - ii.yearlen) &&
                                !contains(byyearday, -ii.nextyearlen + i - ii.yearlen)
                            )
                        )
                    )
                )
                {
                    dayset[i] = null;
                    filtered = true;
                }
            }

            // Output results
            if (plb(bysetpos) && plb(timeset)) {

                var daypos, timepos, poslist = [];

                for (i, j = 0; j < bysetpos.length; j++) {
                    var pos = bysetpos[j];
                    if (pos < 0) {
                        daypos = Math.floor(pos / timeset.length);
                        timepos = pymod(pos, timeset.length);
                    } else {
                        daypos = Math.floor((pos - 1) / timeset.length);
                        timepos = pymod((pos - 1), timeset.length);
                    }

                    try {
                        tmp = [];
                        for (k = start; k < end; k++) {
                            var val = dayset[k];
                            if (val === null) {
                                continue;
                            }
                            tmp.push(val);
                        }
                        if (daypos < 0) {
                            // we're trying to emulate python's aList[-n]
                            i = tmp.slice(daypos)[0];
                        } else {
                            i = tmp[daypos];
                        }

                        var time = timeset[timepos];

                        var date = dateutil.fromOrdinal(ii.yearordinal + i);
                        var res = dateutil.combine(date, time);
                        // XXX: can this ever be in the array?
                        // - compare the actual date instead?
                        if (!contains(poslist, res)) {
                            poslist.push(res);
                        }
                    } catch (e) {}
                }

                dateutil.sort(poslist);

                for (j = 0; j < poslist.length; j++) {
                    var res = poslist[j];
                    if (until && res > until) {
                        this._len = total;
                        return iterResult.getValue();
                    } else if (res >= dtstart) {
                        ++total;
                        if (!iterResult.accept(res)) {
                            return iterResult.getValue();
                        }
                        if (count) {
                            --count;
                            if (!count) {
                                this._len = total;
                                return iterResult.getValue();
                            }
                        }
                    }
                }

            } else {
                for (j = start; j < end; j++) {
                    i = dayset[j];
                    if (i !== null) {
                        var date = dateutil.fromOrdinal(ii.yearordinal + i);
                        for (k = 0; k < timeset.length; k++) {
                            var time = timeset[k];
                            var res = dateutil.combine(date, time);
                            if (until && res > until) {
                                this._len = total;
                                return iterResult.getValue();
                            } else if (res >= dtstart) {
                                ++total;
                                if (!iterResult.accept(res)) {
                                    return iterResult.getValue();
                                }
                                if (count) {
                                    --count;
                                    if (!count) {
                                        this._len = total;
                                        return iterResult.getValue();
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // Handle frequency and interval
            fixday = false;
            if (freq == RRule.YEARLY) {
                year += interval;
                if (year > dateutil.MAXYEAR) {
                    this._len = total;
                    return iterResult.getValue();
                }
                ii.rebuild(year, month);
            } else if (freq == RRule.MONTHLY) {
                month += interval;
                if (month > 12) {
                    div = Math.floor(month / 12);
                    mod = pymod(month, 12);
                    month = mod;
                    year += div;
                    if (month == 0) {
                        month = 12;
                        --year;
                    }
                    if (year > dateutil.MAXYEAR) {
                        this._len = total;
                        return iterResult.getValue();
                    }
                }
                ii.rebuild(year, month);
            } else if (freq == RRule.WEEKLY) {
                if (wkst > weekday) {
                    day += -(weekday + 1 + (6 - wkst)) + interval * 7;
                } else {
                    day += -(weekday - wkst) + interval * 7;
                }
                weekday = wkst;
                fixday = true;
            } else if (freq == RRule.DAILY) {
                day += interval;
                fixday = true;
            } else if (freq == RRule.HOURLY) {
                if (filtered) {
                    // Jump to one iteration before next day
                    hour += Math.floor((23 - hour) / interval) * interval;
                }
                while (true) {
                    hour += interval;
                    dm = divmod(hour, 24);
                    div = dm.div;
                    mod = dm.mod;
                    if (div) {
                        hour = mod;
                        day += div;
                        fixday = true;
                    }
                    if (!plb(byhour) || contains(byhour, hour)) {
                        break;
                    }
                }
                timeset = gettimeset.call(ii, hour, minute, second);
            } else if (freq == RRule.MINUTELY) {
                if (filtered) {
                    // Jump to one iteration before next day
                    minute += Math.floor(
                        (1439 - (hour * 60 + minute)) / interval) * interval;
                }
                while(true) {
                    minute += interval;
                    dm = divmod(minute, 60);
                    div = dm.div;
                    mod = dm.mod;
                    if (div) {
                        minute = mod;
                        hour += div;
                        dm = divmod(hour, 24);
                        div = dm.div;
                        mod = dm.mod;
                        if (div) {
                            hour = mod;
                            day += div;
                            fixday = true;
                            filtered = false;
                        }
                    }
                    if ((!plb(byhour) || contains(byhour, hour)) &&
                        (!plb(byminute) || contains(byminute, minute))) {
                        break;
                    }
                }
                timeset = gettimeset.call(ii, hour, minute, second);
            } else if (freq == RRule.SECONDLY) {
                if (filtered) {
                    // Jump to one iteration before next day
                    second += Math.floor(
                        (86399 - (hour * 3600 + minute * 60 + second))
                        / interval) * interval;
                }
                while (true) {
                    second += interval;
                    dm = divmod(second, 60);
                    div = dm.div;
                    mod = dm.mod;
                    if (div) {
                        second = mod;
                        minute += div;
                        dm = divmod(minute, 60);
                        div = dm.div;
                        mod = dm.mod;
                        if (div) {
                            minute = mod;
                            hour += div;
                            dm = divmod(hour, 24);
                            div = dm.div;
                            mod = dm.mod;
                            if (div) {
                                hour = mod;
                                day += div;
                                fixday = true;
                            }
                        }
                    }
                    if ((!plb(byhour) || contains(byhour, hour)) &&
                        (!plb(byminute) || contains(byminute, minute)) &&
                        (!plb(bysecond) || contains(bysecond, second)))
                    {
                        break;
                    }
                }
                timeset = gettimeset.call(ii, hour, minute, second);
            }

            if (fixday && day > 28) {
                var daysinmonth = dateutil.monthRange(year, month - 1)[1];
                if (day > daysinmonth) {
                    while (day > daysinmonth) {
                        day -= daysinmonth;
                        ++month;
                        if (month == 13) {
                            month = 1;
                            ++year;
                            if (year > dateutil.MAXYEAR) {
                                this._len = total;
                                return iterResult.getValue();
                            }
                        }
                        daysinmonth = dateutil.monthRange(year, month - 1)[1];
                    }
                    ii.rebuild(year, month);
                }
            }
        }
    }

};


RRule.parseString = function(rfcString) {
    rfcString = rfcString.replace(/^\s+|\s+$/, '');
    if (!rfcString.length) {
        return null;
    }

    var i, j, key, value, attr,
        attrs = rfcString.split(';'),
        options = {};

    for (i = 0; i < attrs.length; i++) {
        attr = attrs[i].split('=');
        key = attr[0];
        value = attr[1];
        switch (key) {
            case 'FREQ':
                options.freq = RRule[value];
                break;
            case 'WKST':
                options.wkst = RRule[value];
                break;
            case 'COUNT':
            case 'INTERVAL':
            case 'BYSETPOS':
            case 'BYMONTH':
            case 'BYMONTHDAY':
            case 'BYYEARDAY':
            case 'BYWEEKNO':
            case 'BYHOUR':
            case 'BYMINUTE':
            case 'BYSECOND':
                if (value.indexOf(',') != -1) {
                    value = value.split(',');
                    for (j = 0; j < value.length; j++) {
                        if (/^[+-]?\d+$/.test(value[j])) {
                            value[j] = Number(value[j]);
                        }
                    }
                } else if (/^[+-]?\d+$/.test(value)) {
                    value = Number(value);
                }
                key = key.toLowerCase();
                options[key] = value;
                break;
            case 'BYDAY': // => byweekday
                var n, wday, day, days = value.split(',');
                options.byweekday = [];
                for (j = 0; j < days.length; j++) {
                    day = days[j];
                    if (day.length == 2) { // MO, TU, ...
                        wday = RRule[day]; // wday instanceof Weekday
                        options.byweekday.push(wday);
                    } else { // -1MO, +3FR, 1SO, ...
                        day = day.match(/^([+-]?\d)([A-Z]{2})$/);
                        n = Number(day[1]);
                        wday = day[2];
                        wday = RRule[wday].weekday;
                        options.byweekday.push(new Weekday(wday, n));
                    }
                }
                break;
            case 'DTSTART':
                options.dtstart = dateutil.untilStringToDate(value);
                break;
            case 'UNTIL':
                options.until = dateutil.untilStringToDate(value);
                break;
            case 'BYEASTER':
                options.byeaster = Number(value);
                break;
            default:
                throw new Error("Unknown RRULE property '" + key + "'");
        }
    }
    return options;
};


RRule.fromString = function(string) {
    return new RRule(RRule.parseString(string));
};


//=============================================================================
// Iterinfo
//=============================================================================

var Iterinfo = function(rrule) {
    this.rrule = rrule;
    this.lastyear = null;
    this.lastmonth = null;
    this.yearlen = null;
    this.nextyearlen = null;
    this.yearordinal = null;
    this.yearweekday = null;
    this.mmask = null;
    this.mrange = null;
    this.mdaymask = null;
    this.nmdaymask = null;
    this.wdaymask = null;
    this.wnomask = null;
    this.nwdaymask = null;
    this.eastermask = null;
};

Iterinfo.prototype.easter = function(y, offset) {
    offset = offset || 0;

    var a = y % 19,
        b = Math.floor(y / 100),
        c = y % 100,
        d = Math.floor(b / 4),
        e = b % 4,
        f = Math.floor((b + 8) / 25),
        g = Math.floor((b - f + 1) / 3),
        h = Math.floor(19 * a + b - d - g + 15) % 30,
        i = Math.floor(c / 4),
        k = c % 4,
        l = Math.floor(32 + 2 * e + 2 * i - h - k) % 7,
        m = Math.floor((a + 11 * h + 22 * l) / 451),
        month = Math.floor((h + l - 7 * m + 114) / 31),
        day = (h + l - 7 * m + 114) % 31 + 1,
        date = Date.UTC(y, month - 1, day + offset),
        yearStart = Date.UTC(y, 0, 1);

    return [ Math.ceil((date - yearStart) / (1000 * 60 * 60 * 24)) ];
}

Iterinfo.prototype.rebuild = function(year, month) {

    var rr = this.rrule;

    if (year != this.lastyear) {

        this.yearlen = dateutil.isLeapYear(year) ? 366 : 365;
        this.nextyearlen = dateutil.isLeapYear(year + 1) ? 366 : 365;
        var firstyday = new Date(year, 0, 1);

        this.yearordinal = dateutil.toOrdinal(firstyday);
        this.yearweekday = dateutil.getWeekday(firstyday);

        var wday = dateutil.getWeekday(new Date(year, 0, 1));

        if (this.yearlen == 365) {
            this.mmask = [].concat(M365MASK);
            this.mdaymask = [].concat(MDAY365MASK);
            this.nmdaymask = [].concat(NMDAY365MASK);
            this.wdaymask = WDAYMASK.slice(wday);
            this.mrange = [].concat(M365RANGE);
        } else {
            this.mmask = [].concat(M366MASK);
            this.mdaymask = [].concat(MDAY366MASK);
            this.nmdaymask = [].concat(NMDAY366MASK);
            this.wdaymask = WDAYMASK.slice(wday);
            this.mrange = [].concat(M366RANGE);
        }

        if (!plb(rr.options.byweekno)) {
            this.wnomask = null;
        } else {
            this.wnomask = repeat(0, this.yearlen + 7);
            var no1wkst, firstwkst, wyearlen;
            no1wkst = firstwkst = pymod(
                7 - this.yearweekday + rr.options.wkst, 7);
            if (no1wkst >= 4) {
                no1wkst = 0;
                // Number of days in the year, plus the days we got
                // from last year.
                wyearlen = this.yearlen + pymod(
                    this.yearweekday - rr.options.wkst, 7);
            } else {
                // Number of days in the year, minus the days we
                // left in last year.
                wyearlen = this.yearlen - no1wkst;
            }
            var div = Math.floor(wyearlen / 7);
            var mod = pymod(wyearlen, 7);
            var numweeks = Math.floor(div + (mod / 4));
            for (var n, i, j = 0; j < rr.options.byweekno.length; j++) {
                n = rr.options.byweekno[j];
                if (n < 0) {
                    n += numweeks + 1;
                } if (!(0 < n && n <= numweeks)) {
                    continue;
                } if (n > 1) {
                    i = no1wkst + (n - 1) * 7;
                    if (no1wkst != firstwkst) {
                        i -= 7-firstwkst;
                    }
                } else {
                    i = no1wkst;
                }
                for (var k = 0; k < 7; k++) {
                    this.wnomask[i] = 1;
                    i++;
                    if (this.wdaymask[i] == rr.options.wkst) {
                        break;
                    }
                }
            }

            if (contains(rr.options.byweekno, 1)) {
                // Check week number 1 of next year as well
                // orig-TODO : Check -numweeks for next year.
                var i = no1wkst + numweeks * 7;
                if (no1wkst != firstwkst) {
                    i -= 7 - firstwkst;
                }
                if (i < this.yearlen) {
                    // If week starts in next year, we
                    // don't care about it.
                    for (var j = 0; j < 7; j++) {
                        this.wnomask[i] = 1;
                        i += 1;
                        if (this.wdaymask[i] == rr.options.wkst) {
                            break;
                        }
                    }
                }
            }

            if (no1wkst) {
                // Check last week number of last year as
                // well. If no1wkst is 0, either the year
                // started on week start, or week number 1
                // got days from last year, so there are no
                // days from last year's last week number in
                // this year.
                var lnumweeks;
                if (!contains(rr.options.byweekno, -1)) {
                    var lyearweekday = dateutil.getWeekday(
                        new Date(year - 1, 0, 1));
                    var lno1wkst = pymod(
                        7 - lyearweekday + rr.options.wkst, 7);
                    var lyearlen = dateutil.isLeapYear(year - 1) ? 366 : 365;
                    if (lno1wkst >= 4) {
                        lno1wkst = 0;
                        lnumweeks = Math.floor(
                            52
                            + pymod(
                                lyearlen + pymod(
                                    lyearweekday - rr.options.wkst, 7), 7)
                            / 4);
                    } else {
                        lnumweeks = Math.floor(
                            52 + pymod(this.yearlen - no1wkst, 7) / 4);
                    }
                } else {
                    lnumweeks = -1;
                }
                if (contains(rr.options.byweekno, lnumweeks)) {
                    for (var i = 0; i < no1wkst; i++) {
                        this.wnomask[i] = 1;
                    }
                }
            }
        }
    }

    if (plb(rr.options.bynweekday)
        && (month != this.lastmonth || year != this.lastyear)) {
        var ranges = [];
        if (rr.options.freq == RRule.YEARLY) {
            if (plb(rr.options.bymonth)) {
                for (j = 0; j < rr.options.bymonth.length; j++) {
                    month = rr.options.bymonth[j];
                    ranges.push(this.mrange.slice(month - 1, month + 1));
                }
            } else {
                ranges = [[0, this.yearlen]];
            }
        } else if (rr.options.freq == RRule.MONTHLY) {
            ranges = [this.mrange.slice(month - 1, month + 1)];
        }
        if (plb(ranges)) {
            // Weekly frequency won't get here, so we may not
            // care about cross-year weekly periods.
            this.nwdaymask = repeat(0, this.yearlen);

            for (var j = 0; j < ranges.length; j++) {
                var rang = ranges[j];
                var first = rang[0], last = rang[1];
                last -= 1;
                for (var k = 0; k < rr.options.bynweekday.length; k++) {
                    var wday = rr.options.bynweekday[k][0],
                        n = rr.options.bynweekday[k][1];
                    if (n < 0) {
                        i = last + (n + 1) * 7;
                        i -= pymod(this.wdaymask[i] - wday, 7);
                    } else {
                        i = first + (n - 1) * 7;
                        i += pymod(7 - this.wdaymask[i] + wday, 7);
                    }
                    if (first <= i && i <= last) {
                        this.nwdaymask[i] = 1;
                    }
                }
            }

        }

        this.lastyear = year;
        this.lastmonth = month;
    }

    if (rr.options.byeaster !== null) {
        this.eastermask = this.easter(year, rr.options.byeaster);
    }
};

Iterinfo.prototype.ydayset = function(year, month, day) {
    return [range(this.yearlen), 0, this.yearlen];
};

Iterinfo.prototype.mdayset = function(year, month, day) {
    var set = repeat(null, this.yearlen);
    var start = this.mrange[month-1];
    var end = this.mrange[month];
    for (var i = start; i < end; i++) {
        set[i] = i;
    }
    return [set, start, end];
};

Iterinfo.prototype.wdayset = function(year, month, day) {

    // We need to handle cross-year weeks here.
    var set = repeat(null, this.yearlen + 7);
    var i = dateutil.toOrdinal(
        new Date(year, month - 1, day)) - this.yearordinal;
    var start = i;
    for (var j = 0; j < 7; j++) {
        set[i] = i;
        ++i;
        if (this.wdaymask[i] == this.rrule.options.wkst) {
            break;
        }
    }
    return [set, start, i];
};

Iterinfo.prototype.ddayset = function(year, month, day) {
    var set = repeat(null, this.yearlen);
    var i = dateutil.toOrdinal(
        new Date(year, month - 1, day)) - this.yearordinal;
    set[i] = i;
    return [set, i, i + 1];
};

Iterinfo.prototype.htimeset = function(hour, minute, second) {
    var set = [], rr = this.rrule;
    for (var i = 0; i < rr.options.byminute.length; i++) {
        minute = rr.options.byminute[i];
        for (var j = 0; j < rr.options.bysecond.length; j++) {
            second = rr.options.bysecond[j];
            set.push(new dateutil.Time(hour, minute, second));
        }
    }
    dateutil.sort(set);
    return set;
};

Iterinfo.prototype.mtimeset = function(hour, minute, second) {
    var set = [], rr = this.rrule;
    for (var j = 0; j < rr.options.bysecond.length; j++) {
        second = rr.options.bysecond[j];
        set.push(new dateutil.Time(hour, minute, second));
    }
    dateutil.sort(set);
    return set;
};

Iterinfo.prototype.stimeset = function(hour, minute, second) {
    return [new dateutil.Time(hour, minute, second)];
};


//=============================================================================
// Results
//=============================================================================

/**
 * This class helps us to emulate python's generators, sorta.
 */
var IterResult = function(method, args) {
    this.init(method, args)
};

IterResult.prototype = {

    init: function(method, args) {
        this.method = method;
        this.args = args;

        this._result = [];

        this.minDate = null;
        this.maxDate = null;

        if (method == 'between') {
            this.maxDate = args.inc
                ? args.before
                : new Date(args.before.getTime() - 1);
            this.minDate = args.inc
                ? args.after
                : new Date(args.after.getTime() + 1);
        } else if (method == 'before') {
            this.maxDate = args.inc ? args.dt : new Date(args.dt.getTime() - 1);
        } else if (method == 'after') {
            this.minDate = args.inc ? args.dt : new Date(args.dt.getTime() + 1);
        }
    },

    /**
     * Possibly adds a date into the result.
     *
     * @param {Date} date - the date isn't necessarly added to the result
     *                      list (if it is too late/too early)
     * @return {Boolean} true if it makes sense to continue the iteration;
     *                   false if we're done.
     */
    accept: function(date) {
        var tooEarly = this.minDate && date < this.minDate,
            tooLate = this.maxDate && date > this.maxDate;

        if (this.method == 'between') {
            if (tooEarly)
                return true;
            if (tooLate)
                return false;
        } else if (this.method == 'before') {
            if (tooLate)
                return false;
        } else if (this.method == 'after') {
            if (tooEarly)
                return true;
            this.add(date);
            return false;
        }

        return this.add(date);

    },

    /**
     *
     * @param {Date} date that is part of the result.
     * @return {Boolean} whether we are interested in more values.
     */
    add: function(date) {
        this._result.push(date);
        return true;
    },

    /**
     * 'before' and 'after' return only one date, whereas 'all'
     * and 'between' an array.
     * @return {Date,Array?}
     */
    getValue: function() {
        switch (this.method) {
            case 'all':
            case 'between':
                return this._result;
            case 'before':
            case 'after':
                return this._result.length
                    ? this._result[this._result.length - 1]
                    : null;
        }
    }

};


/**
 * IterResult subclass that calls a callback function on each add,
 * and stops iterating when the callback returns false.
 */
var CallbackIterResult = function(method, args, iterator) {
    var allowedMethods = ['all', 'between'];
    if (!contains(allowedMethods, method)) {
        throw new Error('Invalid method "' + method
            + '". Only all and between works with iterator.');
    }
    this.add = function(date) {
        if (iterator(date, this._result.length)) {
            this._result.push(date);
            return true;
        }
        return false;

    };

    this.init(method, args);

};
CallbackIterResult.prototype = IterResult.prototype;


//=============================================================================
// Export
//=============================================================================

if (serverSide) {
    module.exports = {
        RRule: RRule
        // rruleset: rruleset
    }
}
if (typeof ender === 'undefined') {
    root['RRule'] = RRule;
    // root['rruleset'] = rruleset;
}

if (typeof define === "function" && define.amd) {
    /*global define:false */
    define("rrule", [], function () {
        return RRule;
    });
}

}(this));

/* SOURCE: js/nlp.js */
;;/*!
 * rrule.js - Library for working with recurrence rules for calendar dates.
 * https://github.com/jkbrzt/rrule
 *
 * Copyright 2010, Jakub Roztocil and Lars Schoning
 * Licenced under the BSD licence.
 * https://github.com/jkbrzt/rrule/blob/master/LICENCE
 *
 */

/**
 *
 * Implementation of RRule.fromText() and RRule::toText().
 *
 *
 * On the client side, this file needs to be included
 * when those functions are used.
 *
 */
(function (root){


var serverSide = typeof module !== 'undefined' && module.exports;
var RRule;


if (serverSide) {
    RRule = require('./rrule').RRule;
} else if (root.RRule) {
    RRule = root.RRule;
} else if (typeof require !== 'undefined') {
    if (!RRule) {RRule = require('rrule');}
} else {
    throw new Error('rrule.js is required for rrule/nlp.js to work')
}


//=============================================================================
// Helper functions
//=============================================================================

/**
 * Return true if a value is in an array
 */
var contains = function(arr, val) {
    return arr.indexOf(val) != -1;
};


//=============================================================================
// ToText
//=============================================================================


/**
 *
 * @param {RRule} rrule
 * Optional:
 * @param {Function} gettext function
 * @param {Object} language definition
 * @constructor
 */
var ToText = function(rrule, gettext, language) {

    this.gettext = gettext || function(id) {return id};
    this.language = language || ENGLISH;
    this.text = '';

    this.rrule = rrule;
    this.freq = rrule.options.freq;
    this.options = rrule.options;
    this.origOptions = rrule.origOptions;

    if (this.origOptions.bymonthday) {
        var bymonthday = [].concat(this.options.bymonthday);
        var bynmonthday = [].concat(this.options.bynmonthday);
        bymonthday.sort();
        bynmonthday.sort();
        bynmonthday.reverse();
        // 1, 2, 3, .., -5, -4, -3, ..
        this.bymonthday = bymonthday.concat(bynmonthday);
        if (!this.bymonthday.length) {
            this.bymonthday = null;
        }
    }

    if (this.origOptions.byweekday) {
        var byweekday = !(this.origOptions.byweekday instanceof Array)
                            ? [this.origOptions.byweekday]
                            : this.origOptions.byweekday;
        var days = String(byweekday);
        this.byweekday = {
            allWeeks:byweekday.filter(function (weekday) {
                return !Boolean(weekday.n);
            }),
            someWeeks:byweekday.filter(function (weekday) {
                return Boolean(weekday.n);
            }),
            isWeekdays:(
                days.indexOf('MO') != -1 &&
                    days.indexOf('TU') != -1 &&
                    days.indexOf('WE') != -1 &&
                    days.indexOf('TH') != -1 &&
                    days.indexOf('FR') != -1 &&
                    days.indexOf('SA') == -1 &&
                    days.indexOf('SU') == -1
                )
        };


        var sortWeekDays = function(a, b) {
            return a.weekday - b.weekday;
        };

        this.byweekday.allWeeks.sort(sortWeekDays);
        this.byweekday.someWeeks.sort(sortWeekDays);

        if (!this.byweekday.allWeeks.length) {
            this.byweekday.allWeeks = null;
        }
        if (!this.byweekday.someWeeks.length) {
            this.byweekday.someWeeks = null;
        }
    }
    else {
        this.byweekday = null;
    }

};


ToText.IMPLEMENTED = [];
var common = [
    'count', 'until', 'interval',
    'byweekday', 'bymonthday', 'bymonth'
];
ToText.IMPLEMENTED[RRule.DAILY]   = common;
ToText.IMPLEMENTED[RRule.WEEKLY]  = common;
ToText.IMPLEMENTED[RRule.MONTHLY] = common;
ToText.IMPLEMENTED[RRule.YEARLY]  = ['byweekno', 'byyearday'].concat(common);

/**
 * Test whether the rrule can be fully converted to text.
 * @param {RRule} rrule
 * @return {Boolean}
 */
ToText.isFullyConvertible = function(rrule) {
    var canConvert = true;

    if (!(rrule.options.freq in ToText.IMPLEMENTED)) {
        return false;
    }
    if (rrule.origOptions.until && rrule.origOptions.count) {
        return false;
    }
    for (var key in rrule.origOptions) {
        if (contains(['dtstart', 'wkst', 'freq'], key)) {
            return true;
        }
        if (!contains(ToText.IMPLEMENTED[rrule.options.freq], key)) {
            canConvert = false;
            return false;
        }
    }

    return canConvert;
};


ToText.prototype = {


    isFullyConvertible: function() {
        return ToText.isFullyConvertible(this.rrule);
    },


    /**
     * Perform the conversion. Only some of the frequencies are supported.
     * If some of the rrule's options aren't supported, they'll
     * be omitted from the output an "(~ approximate)" will be appended.
     * @return {*}
     */
    toString: function() {

        var gettext = this.gettext;

        if (!(this.options.freq in ToText.IMPLEMENTED)) {
            return gettext(
                'RRule error: Unable to fully convert this rrule to text');
        }

        this.text = [gettext('every')];

        this[RRule.FREQUENCIES[this.options.freq]]();

        if (this.options.until) {
            this.add(gettext('until'));
            var until = this.options.until;
            this.add(this.language.monthNames[until.getMonth()])
                .add(until.getDate() + ',')
                .add(until.getFullYear());
        } else if (this.options.count) {
            this.add(gettext('for'))
                .add(this.options.count)
                .add(this.plural(this.options.count)
                        ? gettext('times')
                        : gettext('time'));
        }

        if (!this.isFullyConvertible()) {
            this.add(gettext('(~ approximate)'));
        }
        return this.text.join('');
    },

    DAILY: function() {
        var gettext = this.gettext;
        if (this.options.interval != 1) {
            this.add(this.options.interval);
        }

        if (this.byweekday && this.byweekday.isWeekdays) {
            this.add(this.plural(this.options.interval)
                         ? gettext('weekdays')
                         : gettext('weekday'));
        } else {
            this.add(this.plural(this.options.interval)
                ? gettext('days') :  gettext('day'));
        }

        if (this.origOptions.bymonth) {
            this.add(gettext('in'));
            this._bymonth();
        }

        if (this.bymonthday) {
            this._bymonthday();
        } else if (this.byweekday) {
            this._byweekday();
        }

    },

    WEEKLY: function() {
        var gettext = this.gettext;
        if (this.options.interval != 1) {
            this.add(this.options.interval).add(
                this.plural(this.options.interval)
                    ? gettext('weeks')
                    :  gettext('week'));
        }

        if (this.byweekday && this.byweekday.isWeekdays) {

            if (this.options.interval == 1) {
                this.add(this.plural(this.options.interval)
                    ? gettext('weekdays')
                    : gettext('weekday'));
            } else {
                this.add(gettext('on')).add(gettext('weekdays'));
            }

        } else {

            if (this.options.interval == 1) {
                this.add(gettext('week'))
            }

            if (this.origOptions.bymonth) {
                this.add(gettext('in'));
                this._bymonth();
            }

            if (this.bymonthday) {
                this._bymonthday();
            } else if (this.byweekday) {
                this._byweekday();
            }
        }

    },

    MONTHLY: function() {
        var gettext = this.gettext;
        if (this.origOptions.bymonth) {
            if (this.options.interval != 1) {
                this.add(this.options.interval).add(gettext('months'));
                if (this.plural(this.options.interval)) {
                    this.add(gettext('in'));
                }
            } else {
                //this.add(gettext('MONTH'));
            }
            this._bymonth();
        } else {
            if (this.options.interval != 1) {
                this.add(this.options.interval);
            }
            this.add(this.plural(this.options.interval)
                ? gettext('months')
                :  gettext('month'));
        }
        if (this.bymonthday) {
            this._bymonthday();
        } else if (this.byweekday && this.byweekday.isWeekdays) {
            this.add(gettext('on')).add(gettext('weekdays'));
        } else if (this.byweekday) {
            this._byweekday();
        }
    },

    YEARLY: function() {
        var gettext = this.gettext;
        if (this.origOptions.bymonth) {
            if (this.options.interval != 1) {
                this.add(this.options.interval);
                this.add(gettext('years'));
            } else {
                // this.add(gettext('YEAR'));
            }
            this._bymonth();
        } else {
            if (this.options.interval != 1) {
                this.add(this.options.interval);
            }
            this.add(this.plural(this.options.interval)
                ? gettext('years')
                :  gettext('year'));
        }


        if (this.bymonthday) {
            this._bymonthday();
        } else if (this.byweekday) {
            this._byweekday();
        }


        if (this.options.byyearday) {
            this.add(gettext('on the'))
                .add(this.list(this.options.byyearday,
                     this.nth, gettext('and')))
                .add(gettext('day'));
        }

        if (this.options.byweekno) {
            this.add(gettext('in'))
                .add(this.plural(this.options.byweekno.length)
                        ? gettext('weeks') :  gettext('week'))
                .add(this.list(this.options.byweekno, null, gettext('and')));
        }
    },

    _bymonthday: function() {
        var gettext = this.gettext;
        if (this.byweekday && this.byweekday.allWeeks) {
            this.add(gettext('on'))
                .add(this.list(this.byweekday.allWeeks,
                     this.weekdaytext, gettext('or')))
                .add(gettext('the'))
                .add(this.list(this.bymonthday, this.nth, gettext('or')));
        } else {
            this.add(gettext('on the'))
                .add(this.list(this.bymonthday, this.nth, gettext('and')));
        }
        //this.add(gettext('DAY'));
    },

    _byweekday: function() {
        var gettext = this.gettext;
        if (this.byweekday.allWeeks && !this.byweekday.isWeekdays) {
            this.add(gettext('on'))
                .add(this.list(this.byweekday.allWeeks, this.weekdaytext));
        }

        if (this.byweekday.someWeeks) {

            if (this.byweekday.allWeeks) {
                this.add(gettext('and'));
            }

            this.add(gettext('on the'))
                .add(this.list(this.byweekday.someWeeks,
                               this.weekdaytext,
                               gettext('and')));
        }
    },

    _bymonth: function() {
        this.add(this.list(this.options.bymonth,
                           this.monthtext,
                           this.gettext('and')));
    },

    nth: function(n) {
        var nth, npos, gettext = this.gettext;

        if (n == -1) {
            return gettext('last');
        }

        npos = Math.abs(n);

        switch(npos) {
            case 1:
            case 21:
            case 31:
                nth = npos + gettext('st');
                break;
            case 2:
            case 22:
                nth = npos + gettext('nd');
                break;
            case 3:
            case 23:
                nth = npos + gettext('rd');
                break;
            default:
                nth = npos + gettext('th');
        }

        return  n < 0 ? nth + ' ' + gettext('last') : nth;

    },

    monthtext: function(m) {
        return this.language.monthNames[m - 1];
    },

    weekdaytext: function(wday) {
        var weekday = typeof wday === 'number' ? wday : wday.getJsWeekday();
        return (wday.n ? this.nth(wday.n) + ' ' : '')
            + this.language.dayNames[weekday];
    },

    plural: function(n) {
        return n % 100 != 1;
    },

    add: function(s) {
        this.text.push(' ');
        this.text.push(s);
        return this;
    },

    list: function(arr, callback, finalDelim, delim) {

        var delimJoin = function (array, delimiter, finalDelimiter) {
            var list = '';
            for(var i = 0; i < array.length; i++) {
                if (i != 0) {
                    if (i == array.length - 1) {
                        list += ' ' + finalDelimiter + ' ';
                    } else {
                        list += delimiter + ' ';
                    }
                }
                list += array[i];
            }
            return list;
        };

        delim = delim || ',';
        callback = callback || (function(o){return o;});
        var self = this;
        var realCallback = function(arg) {
            return callback.call(self, arg);
        };

        if (finalDelim) {
            return delimJoin(arr.map(realCallback), delim, finalDelim);
        } else {
            return arr.map(realCallback).join(delim + ' ');
        }


    }


};


//=============================================================================
// fromText
//=============================================================================
/**
 * Will be able to convert some of the below described rules from
 * text format to a rule object.
 *
 *
 * RULES
 *
 * Every ([n])
 * 		  day(s)
 * 		| [weekday], ..., (and) [weekday]
 * 		| weekday(s)
 * 		| week(s)
 * 		| month(s)
 * 		| [month], ..., (and) [month]
 * 		| year(s)
 *
 *
 * Plus 0, 1, or multiple of these:
 *
 * on [weekday], ..., (or) [weekday] the [monthday], [monthday], ... (or) [monthday]
 *
 * on [weekday], ..., (and) [weekday]
 *
 * on the [monthday], [monthday], ... (and) [monthday] (day of the month)
 *
 * on the [nth-weekday], ..., (and) [nth-weekday] (of the month/year)
 *
 *
 * Plus 0 or 1 of these:
 *
 * for [n] time(s)
 *
 * until [date]
 *
 * Plus (.)
 *
 *
 * Definitely no supported for parsing:
 *
 * (for year):
 * 		in week(s) [n], ..., (and) [n]
 *
 * 		on the [yearday], ..., (and) [n] day of the year
 * 		on day [yearday], ..., (and) [n]
 *
 *
 * NON-TERMINALS
 *
 * [n]: 1, 2 ..., one, two, three ..
 * [month]: January, February, March, April, May, ... December
 * [weekday]: Monday, ... Sunday
 * [nth-weekday]: first [weekday], 2nd [weekday], ... last [weekday], ...
 * [monthday]: first, 1., 2., 1st, 2nd, second, ... 31st, last day, 2nd last day, ..
 * [date]:
 * 		[month] (0-31(,) ([year])),
 * 		(the) 0-31.(1-12.([year])),
 * 		(the) 0-31/(1-12/([year])),
 * 		[weekday]
 *
 * [year]: 0000, 0001, ... 01, 02, ..
 *
 * Definitely not supported for parsing:
 *
 * [yearday]: first, 1., 2., 1st, 2nd, second, ... 366th, last day, 2nd last day, ..
 *
 * @param {String} text
 * @return {Object, Boolean} the rule, or null.
 */
var fromText = function(text, language) {
    return new RRule(parseText(text, language))
};

var parseText = function(text, language) {

    var ttr = new Parser((language || ENGLISH).tokens);

    if(!ttr.start(text)) {
        return null;
    }

    var options = {};

    S();
    return options;

    function S() {
        ttr.expect('every');

        // every [n]
        var n;
        if(n = ttr.accept('number'))
            options.interval = parseInt(n[0]);

        if(ttr.isDone())
            throw new Error('Unexpected end');

        switch(ttr.symbol) {
        case 'day(s)':
            options.freq = RRule.DAILY;
            if (ttr.nextSymbol()) {
                ON();
                F();
            }
            break;

            // FIXME Note: every 2 weekdays != every two weeks on weekdays.
            // DAILY on weekdays is not a valid rule
        case 'weekday(s)':
            options.freq = RRule.WEEKLY;
            options.byweekday = [
                RRule.MO,
                RRule.TU,
                RRule.WE,
                RRule.TH,
                RRule.FR
            ];
            ttr.nextSymbol();
            F();
            break;

        case 'week(s)':
            options.freq = RRule.WEEKLY;
            if (ttr.nextSymbol()) {
                ON();
                F();
            }
            break;

        case 'month(s)':
            options.freq = RRule.MONTHLY;
            if (ttr.nextSymbol()) {
                ON();
                F();
            }
            break;

        case 'year(s)':
            options.freq = RRule.YEARLY;
            if (ttr.nextSymbol()) {
                ON();
                F();
            }
            break;

        case 'monday':
        case 'tuesday':
        case 'wednesday':
        case 'thursday':
        case 'friday':
        case 'saturday':
        case 'sunday':
            options.freq = RRule.WEEKLY;
            options.byweekday = [RRule[ttr.symbol.substr(0, 2).toUpperCase()]];

            if(!ttr.nextSymbol())
                return;

            // TODO check for duplicates
            while (ttr.accept('comma')) {
                if(ttr.isDone())
                    throw new Error('Unexpected end');

                var wkd;
                if(!(wkd = decodeWKD())) {
                    throw new Error('Unexpected symbol ' + ttr.symbol
                        + ', expected weekday');
                }

                options.byweekday.push(RRule[wkd]);
                ttr.nextSymbol();
            }
            MDAYs();
            F();
            break;

        case 'january':
        case 'february':
        case 'march':
        case 'april':
        case 'may':
        case 'june':
        case 'july':
        case 'august':
        case 'september':
        case 'october':
        case 'november':
        case 'december':
            options.freq = RRule.YEARLY;
            options.bymonth = [decodeM()];

            if(!ttr.nextSymbol())
                return;

            // TODO check for duplicates
            while (ttr.accept('comma')) {
                if(ttr.isDone())
                    throw new Error('Unexpected end');

                var m;
                if(!(m = decodeM())) {
                    throw new Error('Unexpected symbol ' + ttr.symbol
                        + ', expected month');
                }

                options.bymonth.push(m);
                ttr.nextSymbol();
            }

            ON();
            F();
            break;

        default:
            throw new Error('Unknown symbol');

        }
    }

    function ON() {

        var on = ttr.accept('on');
        var the = ttr.accept('the');
        if(!(on || the)) {
            return;
        }

        do {

            var nth, wkd, m;

            // nth <weekday> | <weekday>
            if(nth = decodeNTH()) {
                //ttr.nextSymbol();

                if (wkd = decodeWKD()) {
                    ttr.nextSymbol();
                    if (!options.byweekday) {
                        options.byweekday = [];
                    }
                    options.byweekday.push(RRule[wkd].nth(nth));
                } else {
                    if(!options.bymonthday) {
                        options.bymonthday = [];
                    }
                    options.bymonthday.push(nth);
                    ttr.accept('day(s)');
                }

                // <weekday>
            } else if(wkd = decodeWKD()) {
                ttr.nextSymbol();
                if(!options.byweekday)
                    options.byweekday = [];
                options.byweekday.push(RRule[wkd]);
            } else if(ttr.symbol == 'weekday(s)') {
                ttr.nextSymbol();
                if(!options.byweekday)
                    options.byweekday = [];
                options.byweekday.push(RRule.MO);
                options.byweekday.push(RRule.TU);
                options.byweekday.push(RRule.WE);
                options.byweekday.push(RRule.TH);
                options.byweekday.push(RRule.FR);
            } else if(ttr.symbol == 'week(s)') {
                ttr.nextSymbol();
                var n;
                if(!(n = ttr.accept('number'))) {
                    throw new Error('Unexpected symbol ' + ttr.symbol
                        + ', expected week number');
                }
                options.byweekno = [n[0]];
                while(ttr.accept('comma')) {
                    if(!(n = ttr.accept('number'))) {
                        throw new Error('Unexpected symbol ' + ttr.symbol
                            + '; expected monthday');
                    }
                    options.byweekno.push(n[0]);
                }

            } else if(m = decodeM()) {
                ttr.nextSymbol();
                if(!options.bymonth)
                    options.bymonth = [];
                options.bymonth.push(m);
            } else {
                return;
            }

        } while (ttr.accept('comma') || ttr.accept('the') || ttr.accept('on'));
    }

    function decodeM() {
        switch(ttr.symbol) {
        case 'january':
            return 1;
        case 'february':
            return 2;
        case 'march':
            return 3;
        case 'april':
            return 4;
        case 'may':
            return 5;
        case 'june':
            return 6;
        case 'july':
            return 7;
        case 'august':
            return 8;
        case 'september':
            return 9;
        case 'october':
            return 10;
        case 'november':
            return 11;
        case 'december':
            return 12;
        default:
            return false;
        }
    }

    function decodeWKD() {
        switch(ttr.symbol) {
        case 'monday':
        case 'tuesday':
        case 'wednesday':
        case 'thursday':
        case 'friday':
        case 'saturday':
        case 'sunday':
            return ttr.symbol.substr(0, 2).toUpperCase();
            break;

        default:
            return false;
        }
    }

    function decodeNTH() {

        switch(ttr.symbol) {
        case 'last':
            ttr.nextSymbol();
            return -1;
        case 'first':
            ttr.nextSymbol();
            return 1;
        case 'second':
            ttr.nextSymbol();
            return ttr.accept('last') ? -2 : 2;
        case 'third':
            ttr.nextSymbol();
            return ttr.accept('last') ? -3 : 3;
        case 'nth':
            var v = parseInt(ttr.value[1]);
            if(v < -366 || v > 366)
                throw new Error('Nth out of range: ' + v);

            ttr.nextSymbol();
            return ttr.accept('last') ? -v : v;

        default:
            return false;
        }
    }

    function MDAYs() {

        ttr.accept('on');
        ttr.accept('the');

        var nth;
        if(!(nth = decodeNTH())) {
            return;
        }

        options.bymonthday = [nth];
        ttr.nextSymbol();

        while(ttr.accept('comma')) {

            if (!(nth = decodeNTH())) {
                throw new Error('Unexpected symbol ' + ttr.symbol
                        + '; expected monthday');
            }

            options.bymonthday.push(nth);

            ttr.nextSymbol();
        }
    }

    function F() {

        if(ttr.symbol == 'until') {

            var date = Date.parse(ttr.text);

            if (!date) {
                throw new Error('Cannot parse until date:' + ttr.text);
            }
            options.until = new Date(date);
        } else if(ttr.accept('for')){

            options.count = ttr.value[0];
            ttr.expect('number');
            /* ttr.expect('times') */
        }
    }
};


//=============================================================================
// Parser
//=============================================================================

var Parser = function(rules) {
   this.rules = rules;
};

Parser.prototype.start = function(text) {
   this.text = text;
   this.done = false;
   return this.nextSymbol();
};

Parser.prototype.isDone = function() {
   return this.done && this.symbol == null;
};

Parser.prototype.nextSymbol = function() {
   var p = this, best, bestSymbol;

   this.symbol = null;
   this.value = null;
   do {
       if(this.done) {
           return false;
       }

       best = null;

       var match, rule;
       for (var name in this.rules) {
           rule = this.rules[name];
           if(match = rule.exec(p.text)) {
               if(best == null || match[0].length > best[0].length) {
                   best = match;
                   bestSymbol = name;
               }
           }

       }

       if(best != null) {
           this.text = this.text.substr(best[0].length);

           if(this.text == '') {
               this.done = true;
           }
       }

       if(best == null) {
           this.done = true;
           this.symbol = null;
           this.value = null;
           return;
       }
   } while(bestSymbol == 'SKIP');

   this.symbol = bestSymbol;
   this.value = best;
   return true;
};

Parser.prototype.accept = function(name) {
   if(this.symbol == name) {
       if(this.value) {
           var v = this.value;
           this.nextSymbol();
           return v;
       }

       this.nextSymbol();
       return true;
   }

   return false;
};

Parser.prototype.expect = function(name) {
   if(this.accept(name)) {
       return true;
   }

   throw new Error('expected ' + name + ' but found ' + this.symbol);
};


//=============================================================================
// i18n
//=============================================================================

var ENGLISH = {
    dayNames: [
        "Sunday", "Monday", "Tuesday", "Wednesday",
        "Thursday", "Friday", "Saturday"
    ],
    monthNames: [
        "January", "February", "March", "April", "May",
        "June", "July", "August", "September", "October",
        "November", "December"
    ],
    tokens: {
        'SKIP': /^[ \r\n\t]+|^\.$/,
        'number': /^[1-9][0-9]*/,
        'numberAsText': /^(one|two|three)/i,
        'every': /^every/i,
        'day(s)': /^days?/i,
        'weekday(s)': /^weekdays?/i,
        'week(s)': /^weeks?/i,
        'month(s)': /^months?/i,
        'year(s)': /^years?/i,
        'on': /^(on|in)/i,
        'the': /^the/i,
        'first': /^first/i,
        'second': /^second/i,
        'third': /^third/i,
        'nth': /^([1-9][0-9]*)(\.|th|nd|rd|st)/i,
        'last': /^last/i,
        'for': /^for/i,
        'time(s)': /^times?/i,
        'until': /^(un)?til/i,
        'monday': /^mo(n(day)?)?/i,
        'tuesday': /^tu(e(s(day)?)?)?/i,
        'wednesday': /^we(d(n(esday)?)?)?/i,
        'thursday': /^th(u(r(sday)?)?)?/i,
        'friday': /^fr(i(day)?)?/i,
        'saturday': /^sa(t(urday)?)?/i,
        'sunday': /^su(n(day)?)?/i,
        'january': /^jan(uary)?/i,
        'february': /^feb(ruary)?/i,
        'march': /^mar(ch)?/i,
        'april': /^apr(il)?/i,
        'may': /^may/i,
        'june': /^june?/i,
        'july': /^july?/i,
        'august': /^aug(ust)?/i,
        'september': /^sep(t(ember)?)?/i,
        'october': /^oct(ober)?/i,
        'november': /^nov(ember)?/i,
        'december': /^dec(ember)?/i,
        'comma': /^(,\s*|(and|or)\s*)+/i
    }
};


//=============================================================================
// Export
//=============================================================================

var nlp = {
    fromText: fromText,
    parseText: parseText,
    isFullyConvertible: ToText.isFullyConvertible,
    toText: function(rrule, gettext, language) {
        return new ToText(rrule, gettext, language).toString();
    }
};

if (serverSide) {
    module.exports = nlp
} else {
  root['_RRuleNLP'] = nlp;
}

if (typeof define === "function" && define.amd) {
    /*global define:false */
    define("rrule", [], function () {
        return RRule;
    });
}

})(this);

/* SOURCE: js/rrecur-parser.js */
;;function rhc_in_array(needle,haystack){
	var r = jQuery.inArray(needle,haystack);
	return (r!=undefined && (r != -1)) ;
}

/* The following are wrappers of the old Scheduler for rrule.js */

Scheduler = function(start_date, rfc_rrule, test_mode) { // Scheduler "class" (global visibility)
    this.test_mode = test_mode === true ? true : false;
    this.start_date = start_date;
    
    this.exception_dates = [];
	this.repeat_dates = [];
	this.rule = null;

    if (rfc_rrule) {
    	this.rule = RRule.fromString( 'DTSTART=' + this.timeToUntilString( start_date ) + ';' + rfc_rrule );		
		this.rule.dtstart = start_date;
    }
}; 

Scheduler.prototype.timeToUntilString = function(time) {
	// this is a copy of the one rrule.js uses.
	var date = new Date(time);
	var comp, comps = [
		date.getUTCFullYear(),
		date.getUTCMonth() + 1,
		date.getUTCDate(),
		'T',
		date.getUTCHours(),
		date.getUTCMinutes(),
		date.getUTCSeconds(),
		'Z'
	];
	for (var i = 0; i < comps.length; i++) {
		comp = comps[i];
		if (!/[TZ]/.test(comp) && comp < 10) {
			comps[i] = '0' + String(comp);
		}
	}
	return comps.join('');
};

// retourns all occurrences as Date array (test mode => timestamp array)
Scheduler.prototype.all_occurrences = function(filter_begin_ts, filter_end_ts) {
	if( null==this.rule ){
		return [this.start_date];
	}
    var occurrences = [];		
	occurrences = this.rule.between(new Date(filter_begin_ts), new Date(filter_end_ts));
    	
	//add rdates
	if(this.repeat_dates.length>0){		
		for (var i = 0; i< this.repeat_dates.length; i++){
			var occurrence = new Date(this.repeat_dates[i]);
			if ( !rhc_in_array(ts,occurrences) ){
				occurrences.push(occurrence);
			}
		}
		occurrences.sort();	
	}
	
	// removes exdates
    var nb_occurrences = occurrences.length;
    var occurrences_without_exdates = [];
    for (var i = 0; i < nb_occurrences; i++) {
        var occurrence = occurrences[i];
        var ts = occurrence.getTime();
        if ( !rhc_in_array(ts,this.exception_dates) ) {
            occurrences_without_exdates.push(this.test_mode ? ts : occurrence);
        }
    }
	
    return occurrences_without_exdates;
}

// retourns occurrences in the range [ begin_date, end_date ] as Date array (test mode => timestamp array)
Scheduler.prototype.occurrences_between = function(begin_date, end_date) {
    var begin_ts = begin_date.getTime();
    var end_ts = end_date.getTime();

    return this.all_occurrences(begin_ts, end_ts);
}

//---modified for limited output when using until, but we only need a certain amount _limit
// retourns all occurrences as Date array (test mode => timestamp array)
Scheduler.prototype.limited_occurrences = function(filter_begin_ts, filter_end_ts, _limit) {
    var begin_ts = begin_date.getTime();
    var end_ts = end_date.getTime();

    return this.all_occurrences(begin_ts, end_ts).slice(0,_limit);
}

// adds at least one EXDATE (optional)
Scheduler.prototype.add_exception_dates = function(dates) {
    var nb_date = dates.length;
    for (var i = 0; i < nb_date; i++) {
        this.exception_dates.push(dates[i].getTime());
    }
    this.exception_dates.sort();
}

/* add repeat dates RDATE*/
Scheduler.prototype.add_rdates = function(dates) {
    var nb_date = dates.length;
    for (var i = 0; i < nb_date; i++) {
        this.repeat_dates.push(dates[i].getTime());
    }
    this.repeat_dates.sort();
}
/* SOURCE: fullcalendar/fullcalendar/fullcalendar.custom.js */
;;/*!
 * FullCalendar v1.6.4
 * Docs & License: http://arshaw.com/fullcalendar/
 * (c) 2013 Adam Shaw
 */

/*
 * Use fullcalendar.css for basic styling.
 * For event drag & drop, requires jQuery UI draggable.
 * For event resizing, requires jQuery UI resizable.
 */
 
(function($, undefined) {


;;

var defaults = {

	// display
	defaultView: 'month',
	aspectRatio: 1.35,
	header: {
		left: 'title',
		center: '',
		right: 'today prev,next'
	},
	weekends: true,
	weekNumbers: false,
	weekNumberCalculation: 'iso',
	weekNumberTitle: 'W',
	
	// editing
	//editable: false,
	//disableDragging: false,
	//disableResizing: false,
	
	allDayDefault: true,
	ignoreTimezone: true,
	
	// event ajax
	lazyFetching: true,
	startParam: 'start',
	endParam: 'end',
	
	// time formats
	titleFormat: {
		month: 'MMMM yyyy',
		week: "MMM d[ yyyy]{ '&#8212;'[ MMM] d yyyy}",
		day: 'dddd, MMM d, yyyy'
	},
	columnFormat: {
		month: 'ddd',
		week: 'ddd M/d',
		day: 'dddd M/d'
	},
	timeFormat: { // for event elements
		'': 'h(:mm)t' // default
	},
	
	// locale
	isRTL: false,
	firstDay: 0,
	monthNames: ['January','February','March','April','May','June','July','August','September','October','November','December'],
	monthNamesShort: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
	dayNames: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
	dayNamesShort: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
	buttonText: {
		prev: "<span class='fc-text-arrow'>&lsaquo;</span>",
		next: "<span class='fc-text-arrow'>&rsaquo;</span>",
		prevYear: "<span class='fc-text-arrow'>&laquo;</span>",
		nextYear: "<span class='fc-text-arrow'>&raquo;</span>",
		today: 'today',
		month: 'month',
		week: 'week',
		day: 'day'
	},
	
	// jquery-ui theming
	theme: false,
	buttonIcons: {
		prev: 'circle-triangle-w',
		next: 'circle-triangle-e'
	},
	
	//selectable: false,
	unselectAuto: true,
	
	dropAccept: '*',
	
	handleWindowResize: true
	
};

// right-to-left defaults
var rtlDefaults = {
	header: {
		left: 'next,prev today',
		center: '',
		right: 'title'
	},
	buttonText: {
		prev: "<span class='fc-text-arrow'>&rsaquo;</span>",
		next: "<span class='fc-text-arrow'>&lsaquo;</span>",
		prevYear: "<span class='fc-text-arrow'>&raquo;</span>",
		nextYear: "<span class='fc-text-arrow'>&laquo;</span>"
	},
	buttonIcons: {
		prev: 'circle-triangle-e',
		next: 'circle-triangle-w'
	}
};



;;

var fc = $.fullCalendar = { version: "1.6.4" };
var fcViews = fc.views = {};


$.fn.fullCalendar = function(options) {


	// method calling
	if (typeof options == 'string') {
		var args = Array.prototype.slice.call(arguments, 1);
		var res;
		this.each(function() {
			var calendar = $.data(this, 'fullCalendar');
			if (calendar && $.isFunction(calendar[options])) {
				var r = calendar[options].apply(calendar, args);
				if (res === undefined) {
					res = r;
				}
				if (options == 'destroy') {
					$.removeData(this, 'fullCalendar');
				}
			}
		});
		if (res !== undefined) {
			return res;
		}
		return this;
	}

	options = options || {};
	
	// would like to have this logic in EventManager, but needs to happen before options are recursively extended
	var eventSources = options.eventSources || [];
	delete options.eventSources;
	if (options.events) {
		eventSources.push(options.events);
		delete options.events;
	}
	

	options = $.extend(true, {},
		defaults,
		(options.isRTL || options.isRTL===undefined && defaults.isRTL) ? rtlDefaults : {},
		options
	);
	
	
	this.each(function(i, _element) {
		var element = $(_element);
		var calendar = new Calendar(element, options, eventSources);
		element.data('fullCalendar', calendar); // TODO: look into memory leak implications
		calendar.render();
	});
	
	
	return this;
	
};


// function for adding/overriding defaults
function setDefaults(d) {
	$.extend(true, defaults, d);
}



;;

 
function Calendar(element, options, eventSources) {
	var t = this;
	
	
	// exports
	t.options = options;
	t.render = render;
	t.destroy = destroy;
	t.refetchEvents = refetchEvents;
	t.reportEvents = reportEvents;
	t.reportEventChange = reportEventChange;
	t.rerenderEvents = rerenderEvents;
	t.changeView = changeView;
	t.select = select;
	t.unselect = unselect;
	t.prev = prev;
	t.next = next;
	t.prevYear = prevYear;
	t.nextYear = nextYear;
	t.today = today;
	t.gotoDate = gotoDate;
	t.incrementDate = incrementDate;
	t.formatDate = function(format, date) { return formatDate(format, date, options) };
	t.formatDates = function(format, date1, date2) { return formatDates(format, date1, date2, options) };
	t.getDate = getDate;
	t.getView = getView;
	t.option = option;
	t.trigger = trigger;
//RHC Custom methods for use in the header	
	t.rhc_search = rhc_search;
	
	function rhc_search(calendar,e,hide){
		if( $(_element).find('.fc-filters-dialog').length>0 ){
			if( hide || $(_element).find('.fc-filters-dialog').is(':visible') ){
				$(_element).find('.fc-filters-dialog').stop()
					.find('.fbd-unchecked').css('overflow-y','hidden').end()
					.animate({opacity:0,top:-10},'fast','linear',function(){$(this).hide();});
			}else{
				jQuery('.fct-tooltip').trigger('close-tooltip');
				$(_element).find('.fc-filters-dialog').stop().show()
					.find('.fbd-unchecked').css('overflow-y','hidden').end()// some browsers have an awfull effect when changing the opacity of the scrollbar container.
					.animate({opacity:1,top:0},'fast','linear',function(){
						$(this).find('.fbd-unchecked').css('overflow-y','auto');
					});				
			}
		}
	}

	// imports
	EventManager.call(t, options, eventSources);
	var isFetchNeeded = t.isFetchNeeded;
	var fetchEvents = t.fetchEvents;
	
	
	// locals
	var _element = element[0];
	var header;
	var headerElement;
	var content;
	var tm; // for making theme classes
	var currentView;
	var elementOuterWidth;
	var suggestedViewHeight;
	var resizeUID = 0;
	var ignoreWindowResize = 0;
	var date = new Date();
	var events = [];
	var _dragElement;
	
	t.date = date;
	
	/* Main Rendering
	-----------------------------------------------------------------------------*/
	
	
	setYMD(date, options.year, options.month, options.date);
	
	
	function render(inc) {
		if (!content) {
			initialRender();
		}
		else if (elementVisible()) {
			// mainly for the public API
			calcSize();
			_renderView(inc);
		}
	}
	
	
	function initialRender() {
		tm = options.theme ? 'ui' : 'fc';
		element.addClass('fc');
		if (options.isRTL) {
			element.addClass('fc-rtl');
		}
		else {
			element.addClass('fc-ltr');
		}
		if (options.theme) {
			element.addClass('ui-widget');
		}

		content = $("<div class='fc-content' style='position:relative'/>")
			.prependTo(element);

		header = new Header(t, options);
		headerElement = header.render();
		if (headerElement) {
			element.prepend(headerElement);
		}

		changeView(options.defaultView);

		if (options.handleWindowResize) {
			$(window).resize(windowResize);
		}

		// needed for IE in a 0x0 iframe, b/c when it is resized, never triggers a windowResize
		if (!bodyVisible()) {
			lateRender();
		}
	}
	
	
	// called when we know the calendar couldn't be rendered when it was initialized,
	// but we think it's ready now
	function lateRender() {
		setTimeout(function() { // IE7 needs this so dimensions are calculated correctly
			if (!currentView.start && bodyVisible()) { // !currentView.start makes sure this never happens more than once
				renderView();
			}
		},0);
	}
	
	
	function destroy() {

		if (currentView) {
			trigger('viewDestroy', currentView, currentView, currentView.element);
			currentView.triggerEventDestroy();
		}

		$(window).unbind('resize', windowResize);

		header.destroy();
		content.remove();
		element.removeClass('fc fc-rtl ui-widget');
	}
	
	
	function elementVisible() {
		return element.is(':visible');
	}
	
	
	function bodyVisible() {
		return $('body').is(':visible');
	}
	
	
	
	/* View Rendering
	-----------------------------------------------------------------------------*/
	
	// TODO: improve view switching (still weird transition in IE, and FF has whiteout problem)
	
	function changeView(newViewName) {
		if (!currentView || newViewName != currentView.name) {
			_changeView(newViewName);
		}
	}


	function _original_changeView(newViewName) {
		ignoreWindowResize++;

		if (currentView) {
			trigger('viewDestroy', currentView, currentView, currentView.element);
			unselect();
			currentView.triggerEventDestroy(); // trigger 'eventDestroy' for each event
			freezeContentHeight();
			currentView.element.remove();
			header.deactivateButton(currentView.name);
		}

		header.activateButton(newViewName);

		currentView = new fcViews[newViewName](
			$("<div class='fc-view fc-view-" + newViewName + "' style='position:relative'/>")
				.appendTo(content),
			t // the calendar object
		);

		renderView();
		unfreezeContentHeight();

		ignoreWindowResize--;
	}
	
	function _changeView(newViewName) {
//-- RHC START
//-- Note: as of 1.64 the currentview is removed, not sure why, we are not removing it on our customization as it breaks the sliding animation
//-- when changing views.
		firstTime = content.find('.fc-view').length==0?true:false;
		noTransition = firstTime||(t.options.transition.notransition&&parseInt(t.options.transition.notransition)==1)?true:false;
		var oldView = currentView;
		var newViewElement;		
		jQuery('.fct-tooltip').trigger('close-tooltip');
//-- RHC END
		ignoreWindowResize++;

		if (currentView) {
			trigger('viewDestroy', currentView, currentView, currentView.element);
			unselect();
			currentView.triggerEventDestroy(); // trigger 'eventDestroy' for each event
			freezeContentHeight();
			if( noTransition )currentView.element.remove();
			header.deactivateButton(currentView.name);
		}

		header.activateButton(newViewName);

		currentView = new fcViews[newViewName](
			$("<div class='fc-view fc-view-" + newViewName + "' style='position:relative'/>")
				.appendTo(content),
			t // the calendar object
		);
		
		if( oldView && oldView.viewLeave ) oldView.viewLeave( oldView, currentView, t );
//-- RHC START
		if(currentView.transitionStarted)currentView.transitionStarted(oldView);	
		
		if( noTransition ){
			if(currentView.transitionEnded)currentView.transitionEnded(oldView);	
		}else{
			content.css('overflow', 'hidden');
			var _width = content.width();
			var _height= content.height();
			var anim = {
				rtl:{
					newView:{
						left:_width,
						top:0
					},
					oldView:{
						left:(_width*-1),
						top:0
					}
				},
				ltr:{
					newView:{
						left:(_width*-1),
						top:0
					},
					oldView:{
						left:_width,
						top:0
					}
				},
				ttb:{
					newView:{
						left:0,
						top:(_height*-1)
					},
					oldView:{
						left:0,
						top:_height
					}
				},
				btt:{
					newView:{
						left:0,
						top:_height
					},
					oldView:{
						left:0,
						top:(_height*-1)
					}
				}
			};
			
			var direction = t.options.transition.direction ? t.options.transition.direction : 'horizontal';			
			if(oldView){
				if( $( '.fc-button-' + newViewName).length==0 ){
					var canim = direction=='horizontal'?anim.rtl:anim.ttb;
				}else if( ($( '.fc-button-' + oldView.name).length>0) && ($( '.fc-button-' + newViewName).length>0) && ($( '.fc-button-' + oldView.name).position().left < $( '.fc-button-' + newViewName).position().left) ){
					var canim = direction=='horizontal'?anim.rtl:anim.ttb;
				}else{
					var canim = direction=='horizontal'?anim.ltr:anim.btt;
				}
				
				currentView.lastView = oldView.name;
			}else{
				var canim = direction=='horizontal'?anim.rtl:anim.ttb;			
				currentView.lastView = false;
			}
		
			if(oldView){
				oldView.element
					.css('z-index',0)
					.css('position','absolute')
				;
			}
				
			currentView.element
				.appendTo(content)
				.css('left', canim.newView.left )
				.css('top', canim.newView.top )
				.css('opacity',0)
				.css('z-index',1)
				.show()
			;	
			
			oldView.element
				.animate({opacity:0,left:canim.oldView.left,top:canim.oldView.top},(t.options.transition.duration||'slow'),(t.options.transition.easing||'linear'),function(){
					oldView.element.hide()
						.css('position','relative')
						.css('opacity',1)
						.css('left',0)
					;
				})	
	
			renderView();
			freezeContentHeight();
			currentView.element
				.animate({opacity:1,left:0,top:0},(t.options.transition.duration||'slow'),(t.options.transition.easing||'linear'),function(){			
					oldView.element.hide().css('position','relative');
					if(currentView.transitionEnded)currentView.transitionEnded(oldView);					
					
					unfreezeContentHeight();
			
					ignoreWindowResize--;
		
					//perform some cleanup:
					content.find('.fc-view:hidden').remove();
				})
			;	
			
			return;// we call the rest of the code when the animation is finished: unfreeze sets overflow to '', and breaks the animation.
		}
		
//-- RHC END
		renderView();
		unfreezeContentHeight();

		ignoreWindowResize--;
	}


	function renderView(inc) {
		if (
			!currentView.start || // never rendered before
			inc || date < currentView.start || date >= currentView.end // or new date range
		) {
			if (elementVisible()) {
				_renderView(inc);
			}
		}
	}


	function _renderView(inc) { // assumes elementVisible
		ignoreWindowResize++;

		if (currentView.start) { // already been rendered?
			trigger('viewDestroy', currentView, currentView, currentView.element);
			unselect();
			clearEvents();
		}
		
		freezeContentHeight();
		currentView.render(date, inc || 0); // the view's render method ONLY renders the skeleton, nothing else

		//RHC MOD skipMonths
		if( t.options.skipMonths && -1 != $.inArray( date.getMonth(), t.options.skipMonths ) ){
			increase = inc||1;//always increase or decrease.
			var a=0;
			while(a++<366){//max loop a whole year.
				if( -1 == $.inArray( date.getMonth(), t.options.skipMonths ) ){
					currentView.render(date, 0);//increase is zero. 
					break;
				}else{
					date.setDate( date.getDate()+increase );
				}
			}
		}
		//RHC MOD END

		setSize();
		unfreezeContentHeight();
		(currentView.afterRender || noop)();

		updateTitle();
		updateTodayButton();

		trigger('viewRender', currentView, currentView, currentView.element);
		currentView.trigger('viewDisplay', _element); // deprecated

		ignoreWindowResize--;

		getAndRenderEvents();
	}
	
	

	/* Resizing
	-----------------------------------------------------------------------------*/
	
	
	function updateSize() {
		if (elementVisible()) {
			unselect();
			clearEvents();
			calcSize();
			setSize();
			//RHC MOD START
			//on the stacking feature, updateSize is appending repeated events
			if( currentView.name=='rhc_event' ) return;
			//RHC MOD END				
			renderEvents();
		}
	}
	
	
	function calcSize() { // assumes elementVisible
		if (options.contentHeight) {
			suggestedViewHeight = options.contentHeight;
		}
		else if (options.height) {
			suggestedViewHeight = options.height - (headerElement ? headerElement.height() : 0) - vsides(content);
		}
		else {
			suggestedViewHeight = Math.round(content.width() / Math.max(options.aspectRatio, .5));
		}
	}
	
	
	function setSize() { // assumes elementVisible

		if (suggestedViewHeight === undefined) {
			calcSize(); // for first time
				// NOTE: we don't want to recalculate on every renderView because
				// it could result in oscillating heights due to scrollbars.
		}

		ignoreWindowResize++;
		currentView.setHeight(suggestedViewHeight);
		currentView.setWidth(content.width());
		ignoreWindowResize--;

		elementOuterWidth = element.outerWidth();
	}
	
	
	function windowResize() {
		if (!ignoreWindowResize) {
			if (currentView.start) { // view has already been rendered
				var uid = ++resizeUID;
				setTimeout(function() { // add a delay
					if (uid == resizeUID && !ignoreWindowResize && elementVisible()) {
						if (elementOuterWidth != (elementOuterWidth = element.outerWidth())) {
							ignoreWindowResize++; // in case the windowResize callback changes the height
							updateSize();
							currentView.trigger('windowResize', _element);
							ignoreWindowResize--;
						}
					}
				}, 200);
			}else{
				// calendar must have been initialized in a 0x0 iframe that has just been resized
				lateRender();
			}
		}
	}
	
	
	
	/* Event Fetching/Rendering
	-----------------------------------------------------------------------------*/
	// TODO: going forward, most of this stuff should be directly handled by the view


	function refetchEvents() { // can be called as an API method
		clearEvents();
		fetchAndRenderEvents();
	}


	function rerenderEvents(modifiedEventID) { // can be called as an API method
		clearEvents();
		renderEvents(modifiedEventID);
	}


	function renderEvents(modifiedEventID) { // TODO: remove modifiedEventID hack
		if (elementVisible()) {
			currentView.setEventData(events); // for View.js, TODO: unify with renderEvents
			currentView.renderEvents(events, modifiedEventID); // actually render the DOM elements
			currentView.trigger('eventAfterAllRender');
		}
	}


	function clearEvents() {
		currentView.triggerEventDestroy(); // trigger 'eventDestroy' for each event
		currentView.clearEvents(); // actually remove the DOM elements
		currentView.clearEventData(); // for View.js, TODO: unify with clearEvents
	}
	

	function getAndRenderEvents() {
		if (!options.lazyFetching || isFetchNeeded(currentView.visStart, currentView.visEnd)) {
			fetchAndRenderEvents();
		}
		else {
			renderEvents();
		}
	}


	function fetchAndRenderEvents() {
		fetchEvents(currentView.visStart, currentView.visEnd);
			// ... will call reportEvents
			// ... which will call renderEvents
	}

	
	// called when event data arrives
	function reportEvents(_events) {
		events = _events;
		renderEvents();
	}


	// called when a single event's data has been changed
	function reportEventChange(eventID) {
		rerenderEvents(eventID);
	}



	/* Header Updating
	-----------------------------------------------------------------------------*/


	function updateTitle() {
		header.updateTitle(currentView.title);
	}


	function updateTodayButton() {
		var today = new Date();
		if (today >= currentView.start && today < currentView.end) {
			header.disableButton('today');
		}
		else {
			header.enableButton('today');
		}
	}
	


	/* Selection
	-----------------------------------------------------------------------------*/
	

	function select(start, end, allDay) {
		currentView.select(start, end, allDay===undefined ? true : allDay);
	}
	

	function unselect() { // safe to be called before renderView
		if (currentView) {
			currentView.unselect();
		}
	}
	
	
	
	/* Date
	-----------------------------------------------------------------------------*/
	
	
	function prev() {
		renderView(-1);
	}
	
	
	function next() {
		renderView(1);
	}
	
	
	function prevYear() {
		addYears(date, -1);
		renderView();
	}
	
	
	function nextYear() {
		addYears(date, 1);
		renderView();
	}
	
	
	function today() {
		date = new Date();
		renderView();
	}
	
	
	function gotoDate(year, month, dateOfMonth) {
		if (year instanceof Date) {
			date = cloneDate(year); // provided 1 argument, a Date
		}else{
			setYMD(date, year, month, dateOfMonth);
		}
		renderView();
	}
	
	
	function incrementDate(years, months, days) {
		if (years !== undefined) {
			addYears(date, years);
		}
		if (months !== undefined) {
			addMonths(date, months);
		}
		if (days !== undefined) {
			addDays(date, days);
		}
		renderView();
	}
	
	
	function getDate() {
		return cloneDate(date);
	}



	/* Height "Freezing"
	-----------------------------------------------------------------------------*/


	function freezeContentHeight() {
		content.css({
			width: '100%',
			height: content.height(),
			overflow: 'hidden'
		});
	}


	function unfreezeContentHeight() {
		content.css({
			width: '',
			height: '',
			overflow: ''
		});
	}
	
	
	
	/* Misc
	-----------------------------------------------------------------------------*/
	
	
	function getView() {
		return currentView;
	}
	
	
	function option(name, value) {
		if (value === undefined) {
			return options[name];
		}
		if (name == 'height' || name == 'contentHeight' || name == 'aspectRatio') {
			options[name] = value;
			updateSize();
		}
	}
	
	
	function trigger(name, thisObj) {
		if (options[name]) {
			return options[name].apply(
				thisObj || _element,
				Array.prototype.slice.call(arguments, 2)
			);
		}
	}
	
	
	
	/* External Dragging
	------------------------------------------------------------------------*/
	
	if (options.droppable) {
		$(document)
			.bind('dragstart', function(ev, ui) {
				var _e = ev.target;
				var e = $(_e);
				if (!e.parents('.fc').length) { // not already inside a calendar
					var accept = options.dropAccept;
					if ($.isFunction(accept) ? accept.call(_e, e) : e.is(accept)) {
						_dragElement = _e;
						currentView.dragStart(_dragElement, ev, ui);
					}
				}
			})
			.bind('dragstop', function(ev, ui) {
				if (_dragElement) {
					currentView.dragStop(_dragElement, ev, ui);
					_dragElement = null;
				}
			});
	}
	

}

;;

function Header(calendar, options) {
	var t = this;
	
	
	// exports
	t.render = render;
	t.destroy = destroy;
	t.updateTitle = updateTitle;
	t.activateButton = activateButton;
	t.deactivateButton = deactivateButton;
	t.disableButton = disableButton;
	t.enableButton = enableButton;
	
	
	// locals
	var element = $([]);
	var tm;
	


	function render() {
		tm = options.theme ? 'ui' : 'fc';
		var sections = options.header;
		if (sections) {
			element = $("<div class='fc-header'/>")
				.append(
					$("<div class='fc-header-row' />")
						.append(renderSection('center'))
						.append(renderSection('left'))
						.append(renderSection('right'))
				);
			return element;
		}
	}
	
	
	function destroy() {
		element.remove();
	}
	
	
	function renderSection(position) {
		var e = $("<div class='fc-header-cell fc-header-" + position + "'/>");
		var buttonStr = options.header[position];
		if (buttonStr) {
			$.each(buttonStr.split(' '), function(i) {
				if (i > 0) {
					e.append("<span class='fc-header-space'/>");
				}
				var prevButton;
				$.each(this.split(','), function(j, buttonName) {
					if (buttonName == 'title') {
						e.append("<span class='fc-header-title'><h2>&nbsp;</h2></span>");
						if (prevButton) {
							prevButton.addClass(tm + '-corner-right');
						}
						prevButton = null;
					}else{
						var buttonClick;
						if (calendar[buttonName]) {
							buttonClick = calendar[buttonName]; // calendar method
						}
						else if (fcViews[buttonName]) {
							buttonClick = function() {
								button.removeClass(tm + '-state-hover'); // forget why
								calendar.changeView(buttonName);
							};
						}
//---RHC MOD: allow passing a callback through options
						else if( options[buttonName] ){
							buttonClick = function() {
								buttonClick = options[buttonName]; // callback
							};
						}	
//--- END RHC MOD;																		
						if (buttonClick) {
							var icon = options.theme ? smartProperty(options.buttonIcons, buttonName) : null; // why are we using smartProperty here?
							var text = smartProperty(options.buttonText, buttonName); // why are we using smartProperty here?
							var button = $(
								"<span class='fc-button fc-button-" + buttonName + " " + tm + "-state-default'>" +
									(icon ?
										"<span class='fc-icon-wrap'>" +
											"<span class='ui-icon ui-icon-" + icon + "'/>" +
										"</span>" :
										text
										) +
								"</span>"
								)
								.click(function() {
									if (!button.hasClass(tm + '-state-disabled')) {
//---RHC MOD: pass the calendar and event objects to the button method so that it can access calendar instance methods
										buttonClick(calendar,e);									
										//original: buttonClick();
									}
								})
								.mousedown(function() {
									button
										.not('.' + tm + '-state-active')
										.not('.' + tm + '-state-disabled')
										.addClass(tm + '-state-down');
								})
								.mouseup(function() {
									button.removeClass(tm + '-state-down');
								})
								.hover(
									function() {
										button
											.not('.' + tm + '-state-active')
											.not('.' + tm + '-state-disabled')
											.addClass(tm + '-state-hover');
									},
									function() {
										button
											.removeClass(tm + '-state-hover')
											.removeClass(tm + '-state-down');
									}
								)
								.appendTo(e);
							disableTextSelection(button);
							if (!prevButton) {
								button.addClass(tm + '-corner-left');
							}
							prevButton = button;
						}
					}
				});
				if (prevButton) {
					prevButton.addClass(tm + '-corner-right');
				}
			});
		}
		return e;
	}
	
	
	function updateTitle(html) {
		element.find('h2')
			.html(html);
	}
	
	
	function activateButton(buttonName) {
		element.find('span.fc-button-' + buttonName)
			.addClass(tm + '-state-active');
	}
	
	
	function deactivateButton(buttonName) {
		element.find('span.fc-button-' + buttonName)
			.removeClass(tm + '-state-active');
	}
	
	
	function disableButton(buttonName) {
		element.find('span.fc-button-' + buttonName)
			.addClass(tm + '-state-disabled');
	}
	
	
	function enableButton(buttonName) {
		element.find('span.fc-button-' + buttonName)
			.removeClass(tm + '-state-disabled');
	}


}

;;

fc.sourceNormalizers = [];
fc.sourceFetchers = [];

var ajaxDefaults = {
	dataType: 'json',
	cache: false
};

var eventGUID = 1;


function EventManager(options, _sources) {
	var t = this;
	
	
	// exports
	t.isFetchNeeded = isFetchNeeded;
	t.fetchEvents = fetchEvents;
	t.addEventSource = addEventSource;
	t.removeEventSource = removeEventSource;
	t.updateEvent = updateEvent;
	t.renderEvent = renderEvent;
	t.removeEvents = removeEvents;
	t.clientEvents = clientEvents;
	t.normalizeEvent = normalizeEvent;
	t.removeEventSources = removeEventSources;
	
	
	// imports
	var trigger = t.trigger;
	var getView = t.getView;
	var reportEvents = t.reportEvents;
	
	
	// locals
	var stickySource = { events: [] };
	var sources = [ stickySource ];
	var rangeStart, rangeEnd;
	var currentFetchID = 0;
	var pendingSourceCnt = 0;
	var loadingLevel = 0;
	var cache = [];
	
	
	for (var i=0; i<_sources.length; i++) {
		_addEventSource(_sources[i]);
	}
	
	
	
	/* Fetching
	-----------------------------------------------------------------------------*/
	
	
	function isFetchNeeded(start, end) {
		return !rangeStart || start < rangeStart || end > rangeEnd;
	}
	
	
	function fetchEvents(start, end) {
		rangeStart = start;
		rangeEnd = end;
		cache = [];
		var fetchID = ++currentFetchID;
		var len = sources.length;
		pendingSourceCnt = len;
		for (var i=0; i<len; i++) {
			fetchEventSource(sources[i], fetchID);
		}
	}
	
	
	function fetchEventSource(source, fetchID) {
		_fetchEventSource(source, function(events) {
			if (fetchID == currentFetchID) {
				if (events) {

					if (options.eventDataTransform) {
						events = $.map(events, options.eventDataTransform);
					}
					if (source.eventDataTransform) {
						events = $.map(events, source.eventDataTransform);
					}
					// TODO: this technique is not ideal for static array event sources.
					//  For arrays, we'll want to process all events right in the beginning, then never again.
				
					for (var i=0; i<events.length; i++) {
						events[i].source = source;
						normalizeEvent(events[i]);
					}
					cache = cache.concat(events);
				}
				pendingSourceCnt--;
				if (!pendingSourceCnt) {
					reportEvents(cache);
				}
			}
		});
	}
	
	
	function _fetchEventSource(source, callback) {
		var i;
		var fetchers = fc.sourceFetchers;
		var res;
		for (i=0; i<fetchers.length; i++) {
			res = fetchers[i](source, rangeStart, rangeEnd, callback);
			if (res === true) {
				// the fetcher is in charge. made its own async request
				return;
			}
			else if (typeof res == 'object') {
				// the fetcher returned a new source. process it
				_fetchEventSource(res, callback);
				return;
			}
		}
		var events = source.events;
		if (events) {
			if ($.isFunction(events)) {
				pushLoading();
				events(cloneDate(rangeStart), cloneDate(rangeEnd), function(events) {
					callback(events);
					popLoading();
				});
			}
			else if ($.isArray(events)) {
				callback(events);
			}
			else {
				callback();
			}
		}else{
			var url = source.url;
			if (url) {
				var success = source.success;
				var error = source.error;
				var complete = source.complete;

				// retrieve any outbound GET/POST $.ajax data from the options
				var customData;
				if ($.isFunction(source.data)) {
					// supplied as a function that returns a key/value object
					customData = source.data();
				}
				else {
					// supplied as a straight key/value object
					customData = source.data;
				}

				// use a copy of the custom data so we can modify the parameters
				// and not affect the passed-in object.
				var data = $.extend({}, customData || {});

				var startParam = firstDefined(source.startParam, options.startParam);
				var endParam = firstDefined(source.endParam, options.endParam);
				if (startParam) {
					data[startParam] = Math.round(+rangeStart / 1000);
				}
				if (endParam) {
					data[endParam] = Math.round(+rangeEnd / 1000);
				}

				pushLoading();
				$.ajax($.extend({}, ajaxDefaults, source, {
					data: data,
					success: function(events) {
						events = events || [];
						var res = applyAll(success, this, arguments);
						if ($.isArray(res)) {
							events = res;
						}
						callback(events);
					},
					error: function() {
						applyAll(error, this, arguments);
						callback();
					},
					complete: function() {
						applyAll(complete, this, arguments);
						popLoading();
					}
				}));
			}else{
				callback();
			}
		}
	}
	
	
	
	/* Sources
	-----------------------------------------------------------------------------*/
	

	function addEventSource(source) {
		source = _addEventSource(source);
		if (source) {
			pendingSourceCnt++;
			fetchEventSource(source, currentFetchID); // will eventually call reportEvents
		}
	}
	
	
	function _addEventSource(source) {
		if ($.isFunction(source) || $.isArray(source)) {
			source = { events: source };
		}
		else if (typeof source == 'string') {
			source = { url: source };
		}
		if (typeof source == 'object') {
			normalizeSource(source);
			sources.push(source);
			return source;
		}
	}
	

	function removeEventSource(source) {
		sources = $.grep(sources, function(src) {
			return !isSourcesEqual(src, source);
		});
		// remove all client events from that source
		cache = $.grep(cache, function(e) {
			return !isSourcesEqual(e.source, source);
		});
		reportEvents(cache);
	}
	
	function removeEventSources() {
	 sources = [];
	
	 // remove all client events from all sources
	 cache = [];
	
	 reportEvents(cache);
	}
	
	/* Manipulation
	-----------------------------------------------------------------------------*/
	
	
	function updateEvent(event) { // update an existing event
		var i, len = cache.length, e,
			defaultEventEnd = getView().defaultEventEnd, // getView???
			startDelta = event.start - event._start,
			endDelta = event.end ?
				(event.end - (event._end || defaultEventEnd(event))) // event._end would be null if event.end
				: 0;                                                      // was null and event was just resized
		for (i=0; i<len; i++) {
			e = cache[i];
			if (e._id == event._id && e != event) {
				e.start = new Date(+e.start + startDelta);
				if (event.end) {
					if (e.end) {
						e.end = new Date(+e.end + endDelta);
					}else{
						e.end = new Date(+defaultEventEnd(e) + endDelta);
					}
				}else{
					e.end = null;
				}
				e.title = event.title;
				e.url = event.url;
				e.allDay = event.allDay;
				e.className = event.className;
				e.editable = event.editable;
				e.color = event.color;
				e.backgroundColor = event.backgroundColor;
				e.borderColor = event.borderColor;
				e.textColor = event.textColor;
				normalizeEvent(e);
			}
		}
		normalizeEvent(event);
		reportEvents(cache);
	}
	
	
	function renderEvent(event, stick) {
		normalizeEvent(event);
		if (!event.source) {
			if (stick) {
				stickySource.events.push(event);
				event.source = stickySource;
			}
			cache.push(event);
		}
		reportEvents(cache);
	}
	
	
	function removeEvents(filter) {
		if (!filter) { // remove all
			cache = [];
			// clear all array sources
			for (var i=0; i<sources.length; i++) {
				if ($.isArray(sources[i].events)) {
					sources[i].events = [];
				}
			}
		}else{
			if (!$.isFunction(filter)) { // an event ID
				var id = filter + '';
				filter = function(e) {
					return e._id == id;
				};
			}
			cache = $.grep(cache, filter, true);
			// remove events from array sources
			for (var i=0; i<sources.length; i++) {
				if ($.isArray(sources[i].events)) {
					sources[i].events = $.grep(sources[i].events, filter, true);
				}
			}
		}
		reportEvents(cache);
	}
	
	
	function clientEvents(filter) {
		if ($.isFunction(filter)) {
			return $.grep(cache, filter);
		}
		else if (filter) { // an event ID
			filter += '';
			return $.grep(cache, function(e) {
				return e._id == filter;
			});
		}
		return cache; // else, return all
	}
	
	
	
	/* Loading State
	-----------------------------------------------------------------------------*/
	
	
	function pushLoading() {
		if (!loadingLevel++) {
			trigger('loading', null, true, getView());
		}
	}
	
	
	function popLoading() {
		if (!--loadingLevel) {
			trigger('loading', null, false, getView());
		}
	}
	
	
	
	/* Event Normalization
	-----------------------------------------------------------------------------*/
	
	
	function normalizeEvent(event) {
		var source = event.source || {};
		var ignoreTimezone = firstDefined(source.ignoreTimezone, options.ignoreTimezone);
		event._id = event._id || (event.id === undefined ? '_fc' + eventGUID++ : event.id + '');
		if (event.date) {
			if (!event.start) {
				event.start = event.date;
			}
			delete event.date;
		}
		event._start = cloneDate(event.start = parseDate(event.start, ignoreTimezone));
		event.end = parseDate(event.end, ignoreTimezone);
		if (event.end && event.end <= event.start) {
			event.end = null;
		}
		event._end = event.end ? cloneDate(event.end) : null;
		if (event.allDay === undefined) {
			event.allDay = firstDefined(source.allDayDefault, options.allDayDefault);
		}
		if (event.className) {
			if (typeof event.className == 'string') {
				event.className = event.className.split(/\s+/);
			}
		}else{
			event.className = [];
		}
		// TODO: if there is no start date, return false to indicate an invalid event
	}
	
	
	
	/* Utils
	------------------------------------------------------------------------------*/
	
	
	function normalizeSource(source) {
		if (source.className) {
			// TODO: repeat code, same code for event classNames
			if (typeof source.className == 'string') {
				source.className = source.className.split(/\s+/);
			}
		}else{
			source.className = [];
		}
		var normalizers = fc.sourceNormalizers;
		for (var i=0; i<normalizers.length; i++) {
			normalizers[i](source);
		}
	}
	
	
	function isSourcesEqual(source1, source2) {
		return source1 && source2 && getSourcePrimitive(source1) == getSourcePrimitive(source2);
	}
	
	
	function getSourcePrimitive(source) {
		return ((typeof source == 'object') ? (source.events || source.url) : '') || source;
	}


}

;;


fc.addDays = addDays;
fc.cloneDate = cloneDate;
fc.parseDate = parseDate;
fc.parseISO8601 = parseISO8601;
fc.parseTime = parseTime;
fc.formatDate = formatDate;
fc.formatDates = formatDates;
fc.addMonths = addMonths;//RHC ADDED


/* Date Math
-----------------------------------------------------------------------------*/

var dayIDs = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
	DAY_MS = 86400000,
	HOUR_MS = 3600000,
	MINUTE_MS = 60000;
	

function addYears(d, n, keepTime) {
	d.setFullYear(d.getFullYear() + n);
	if (!keepTime) {
		clearTime(d);
	}
	return d;
}


function addMonths(d, n, keepTime) { // prevents day overflow/underflow
	if (+d) { // prevent infinite looping on invalid dates
		var m = d.getMonth() + n,
			check = cloneDate(d);
		check.setDate(1);
		check.setMonth(m);
		d.setMonth(m);
		if (!keepTime) {
			clearTime(d);
		}
		while (d.getMonth() != check.getMonth()) {
			d.setDate(d.getDate() + (d < check ? 1 : -1));
		}
	}
	return d;
}


function addDays(d, n, keepTime) { // deals with daylight savings
	if (+d) {
		var dd = d.getDate() + n,
			check = cloneDate(d);
		check.setHours(9); // set to middle of day
		check.setDate(dd);
		d.setDate(dd);
		if (!keepTime) {
			clearTime(d);
		}
		fixDate(d, check);
	}
	return d;
}


function fixDate(d, check) { // force d to be on check's YMD, for daylight savings purposes
	if (+d) { // prevent infinite looping on invalid dates
		while (d.getDate() != check.getDate()) {
			d.setTime(+d + (d < check ? 1 : -1) * HOUR_MS);
		}
	}
}


function addMinutes(d, n) {
	d.setMinutes(d.getMinutes() + n);
	return d;
}


function clearTime(d) {
	d.setHours(0);
	d.setMinutes(0);
	d.setSeconds(0); 
	d.setMilliseconds(0);
	return d;
}


function cloneDate(d, dontKeepTime) {
	if (dontKeepTime) {
		return clearTime(new Date(+d));
	}
	return new Date(+d);
}


function zeroDate() { // returns a Date with time 00:00:00 and dateOfMonth=1
	var i=0, d;
	do {
		d = new Date(1970, i++, 1);
	} while (d.getHours()); // != 0
	return d;
}


function dayDiff(d1, d2) { // d1 - d2
	return Math.round((cloneDate(d1, true) - cloneDate(d2, true)) / DAY_MS);
}


function setYMD(date, y, m, d) {
	if (y !== undefined && y != date.getFullYear()) {
		date.setDate(1);
		date.setMonth(0);
		date.setFullYear(y);
	}
	if (m !== undefined && m != date.getMonth()) {
		date.setDate(1);
		date.setMonth(m);
	}
	if (d !== undefined) {
		date.setDate(d);
	}
}



/* Date Parsing
-----------------------------------------------------------------------------*/


function parseDate(s, ignoreTimezone) { // ignoreTimezone defaults to true
	if (typeof s == 'object') { // already a Date object
		return s;
	}
	if (typeof s == 'number') { // a UNIX timestamp
		return new Date(s * 1000);
	}
	if (typeof s == 'string') {
		if (s.match(/^\d+(\.\d+)?$/)) { // a UNIX timestamp
			return new Date(parseFloat(s) * 1000);
		}
		if (ignoreTimezone === undefined) {
			ignoreTimezone = true;
		}
		return parseISO8601(s, ignoreTimezone) || (s ? new Date(s) : null);
	}
	// TODO: never return invalid dates (like from new Date(<string>)), return null instead
	return null;
}


function parseISO8601(s, ignoreTimezone) { // ignoreTimezone defaults to false
	// derived from http://delete.me.uk/2005/03/iso8601.html
	// TODO: for a know glitch/feature, read tests/issue_206_parseDate_dst.html
	var m = s.match(/^([0-9]{4})(-([0-9]{2})(-([0-9]{2})([T ]([0-9]{2}):([0-9]{2})(:([0-9]{2})(\.([0-9]+))?)?(Z|(([-+])([0-9]{2})(:?([0-9]{2}))?))?)?)?)?$/);
	if (!m) {
		return null;
	}
	var date = new Date(m[1], 0, 1);
	if (ignoreTimezone || !m[13]) {
		var check = new Date(m[1], 0, 1, 9, 0);
		if (m[3]) {
			date.setMonth(m[3] - 1);
			check.setMonth(m[3] - 1);
		}
		if (m[5]) {
			date.setDate(m[5]);
			check.setDate(m[5]);
		}
		fixDate(date, check);
		if (m[7]) {
			date.setHours(m[7]);
		}
		if (m[8]) {
			date.setMinutes(m[8]);
		}
		if (m[10]) {
			date.setSeconds(m[10]);
		}
		if (m[12]) {
			date.setMilliseconds(Number("0." + m[12]) * 1000);
		}
		fixDate(date, check);
	}else{
		date.setUTCFullYear(
			m[1],
			m[3] ? m[3] - 1 : 0,
			m[5] || 1
		);
		date.setUTCHours(
			m[7] || 0,
			m[8] || 0,
			m[10] || 0,
			m[12] ? Number("0." + m[12]) * 1000 : 0
		);
		if (m[14]) {
			var offset = Number(m[16]) * 60 + (m[18] ? Number(m[18]) : 0);
			offset *= m[15] == '-' ? 1 : -1;
			date = new Date(+date + (offset * 60 * 1000));
		}
	}
	return date;
}


function parseTime(s) { // returns minutes since start of day
	if (typeof s == 'number') { // an hour
		return s * 60;
	}
	if (typeof s == 'object') { // a Date object
		return s.getHours() * 60 + s.getMinutes();
	}
	var m = s.match(/(\d+)(?::(\d+))?\s*(\w+)?/);
	if (m) {
		var h = parseInt(m[1], 10);
		if (m[3]) {
			h %= 12;
			if (m[3].toLowerCase().charAt(0) == 'p') {
				h += 12;
			}
		}
		return h * 60 + (m[2] ? parseInt(m[2], 10) : 0);
	}
}



/* Date Formatting
-----------------------------------------------------------------------------*/
// TODO: use same function formatDate(date, [date2], format, [options])


function formatDate(date, format, options) {
	return formatDates(date, null, format, options);
}


function formatDates(date1, date2, format, options) {
	options = options || defaults;

	var date = date1,
		otherDate = date2,
		i, len = format.length, c,
		i2, formatter,
		res = '';
	for (i=0; i<len; i++) {
		c = format.charAt(i);
		if (c == "'") {
			for (i2=i+1; i2<len; i2++) {
				if (format.charAt(i2) == "'") {
					if (date) {
						if (i2 == i+1) {
							res += "'";
						}else{
							res += format.substring(i+1, i2);
						}
						i = i2;
					}
					break;
				}
			}
		}
		else if (c == '(') {
			for (i2=i+1; i2<len; i2++) {
				if (format.charAt(i2) == ')') {
					var subres = formatDate(date, format.substring(i+1, i2), options);
					if (parseInt(subres.replace(/\D/, ''), 10)) {
						res += subres;
					}
					i = i2;
					break;
				}
			}
		}
		else if (c == '[') {
			for (i2=i+1; i2<len; i2++) {
				if (format.charAt(i2) == ']') {
					var subformat = format.substring(i+1, i2);
					var subres = formatDate(date, subformat, options);
					if (subres != formatDate(otherDate, subformat, options)) {
						res += subres;
					}
					i = i2;
					break;
				}
			}
		}
		else if (c == '{') {
			date = date2;
			otherDate = date1;
		}
		else if (c == '}') {
			date = date1;
			otherDate = date2;
		}
		else {
			for (i2=len; i2>i; i2--) {
				if (formatter = dateFormatters[format.substring(i, i2)]) {
					if (date) {
						res += formatter(date, options);
					}
					i = i2 - 1;
					break;
				}
			}
			if (i2 == i) {
				if (date) {
					res += c;
				}
			}
		}
	}
	return res;
};


var dateFormatters = {
	s	: function(d)	{ return d.getSeconds() },
	ss	: function(d)	{ return zeroPad(d.getSeconds()) },
	m	: function(d)	{ return d.getMinutes() },
	mm	: function(d)	{ return zeroPad(d.getMinutes()) },
	h	: function(d)	{ return d.getHours() % 12 || 12 },
	hh	: function(d)	{ return zeroPad(d.getHours() % 12 || 12) },
	H	: function(d)	{ return d.getHours() },
	HH	: function(d)	{ return zeroPad(d.getHours()) },
	d	: function(d)	{ return d.getDate() },
	dd	: function(d)	{ return zeroPad(d.getDate()) },
	ddd	: function(d,o)	{ return o.dayNamesShort[d.getDay()] },
	dddd: function(d,o)	{ return o.dayNames[d.getDay()] },
	M	: function(d)	{ return d.getMonth() + 1 },
	MM	: function(d)	{ return zeroPad(d.getMonth() + 1) },
	MMM	: function(d,o)	{ return o.monthNamesShort[d.getMonth()] },
	MMMM: function(d,o)	{ return o.monthNames[d.getMonth()] },
	yy	: function(d)	{ return (d.getFullYear()+'').substring(2) },
	yyyy: function(d)	{ return d.getFullYear() },
	t	: function(d)	{ return d.getHours() < 12 ? 'a' : 'p' },
	tt	: function(d)	{ return d.getHours() < 12 ? 'am' : 'pm' },
	T	: function(d)	{ return d.getHours() < 12 ? 'A' : 'P' },
	TT	: function(d)	{ return d.getHours() < 12 ? 'AM' : 'PM' },
	u	: function(d)	{ return formatDate(d, "yyyy-MM-dd'T'HH:mm:ss'Z'") },
	S	: function(d)	{
		var date = d.getDate();
		if (date > 10 && date < 20) {
			return 'th';
		}
		return ['st', 'nd', 'rd'][date%10-1] || 'th';
	},
	w   : function(d, o) { // local
		return o.weekNumberCalculation(d);
	},
	W   : function(d) { // ISO
		return iso8601Week(d);
	}
};
fc.dateFormatters = dateFormatters;


/* thanks jQuery UI (https://github.com/jquery/jquery-ui/blob/master/ui/jquery.ui.datepicker.js)
 * 
 * Set as calculateWeek to determine the week of the year based on the ISO 8601 definition.
 * `date` - the date to get the week for
 * `number` - the number of the week within the year that contains this date
 */
function iso8601Week(date) {
	var time;
	var checkDate = new Date(date.getTime());

	// Find Thursday of this week starting on Monday
	checkDate.setDate(checkDate.getDate() + 4 - (checkDate.getDay() || 7));

	time = checkDate.getTime();
	checkDate.setMonth(0); // Compare with Jan 1
	checkDate.setDate(1);
	return Math.floor(Math.round((time - checkDate) / 86400000) / 7) + 1;
}


;;

fc.applyAll = applyAll;


/* Event Date Math
-----------------------------------------------------------------------------*/


function exclEndDay(event) {
	if (event.end) {
		return _exclEndDay(event.end, event.allDay);
	}else{
		return addDays(cloneDate(event.start), 1);
	}
}


function _exclEndDay(end, allDay) {
	end = cloneDate(end);
	return allDay || end.getHours() || end.getMinutes() ? addDays(end, 1) : clearTime(end);
	// why don't we check for seconds/ms too?
}



/* Event Element Binding
-----------------------------------------------------------------------------*/


function lazySegBind(container, segs, bindHandlers) {
	container.unbind('mouseover').mouseover(function(ev) {
		var parent=ev.target, e,
			i, seg;
		while (parent != this) {
			e = parent;
			parent = parent.parentNode;
		}
		if ((i = e._fci) !== undefined) {
			e._fci = undefined;
			seg = segs[i];
			bindHandlers(seg.event, seg.element, seg);
			$(ev.target).trigger(ev);
		}
		ev.stopPropagation();
	});
}



/* Element Dimensions
-----------------------------------------------------------------------------*/


function setOuterWidth(element, width, includeMargins) {
	for (var i=0, e; i<element.length; i++) {
		e = $(element[i]);
		e.width(Math.max(0, width - hsides(e, includeMargins)));
	}
}


function setOuterHeight(element, height, includeMargins) {
	for (var i=0, e; i<element.length; i++) {
		e = $(element[i]);
		e.height(Math.max(0, height - vsides(e, includeMargins)));
	}
}


function hsides(element, includeMargins) {
	return hpadding(element) + hborders(element) + (includeMargins ? hmargins(element) : 0);
}


function hpadding(element) {
	return (parseFloat($.css(element[0], 'paddingLeft', true)) || 0) +
	       (parseFloat($.css(element[0], 'paddingRight', true)) || 0);
}


function hmargins(element) {
	return (parseFloat($.css(element[0], 'marginLeft', true)) || 0) +
	       (parseFloat($.css(element[0], 'marginRight', true)) || 0);
}


function hborders(element) {
	return (parseFloat($.css(element[0], 'borderLeftWidth', true)) || 0) +
	       (parseFloat($.css(element[0], 'borderRightWidth', true)) || 0);
}


function vsides(element, includeMargins) {
	return vpadding(element) +  vborders(element) + (includeMargins ? vmargins(element) : 0);
}


function vpadding(element) {
	return (parseFloat($.css(element[0], 'paddingTop', true)) || 0) +
	       (parseFloat($.css(element[0], 'paddingBottom', true)) || 0);
}


function vmargins(element) {
	return (parseFloat($.css(element[0], 'marginTop', true)) || 0) +
	       (parseFloat($.css(element[0], 'marginBottom', true)) || 0);
}


function vborders(element) {
	return (parseFloat($.css(element[0], 'borderTopWidth', true)) || 0) +
	       (parseFloat($.css(element[0], 'borderBottomWidth', true)) || 0);
}



/* Misc Utils
-----------------------------------------------------------------------------*/


//TODO: arraySlice
//TODO: isFunction, grep ?


function noop() { }


function dateCompare(a, b) {
	return a - b;
}


function arrayMax(a) {
	return Math.max.apply(Math, a);
}


function zeroPad(n) {
	return (n < 10 ? '0' : '') + n;
}


function smartProperty(obj, name) { // get a camel-cased/namespaced property of an object
	if (obj[name] !== undefined) {
		return obj[name];
	}
	var parts = name.split(/(?=[A-Z])/),
		i=parts.length-1, res;
	for (; i>=0; i--) {
		res = obj[parts[i].toLowerCase()];
		if (res !== undefined) {
			return res;
		}
	}
	return obj[''];
}


function htmlEscape(s) {
	return s.replace(/&/g, '&amp;')
		.replace(/</g, '&lt;')
		.replace(/>/g, '&gt;')
		.replace(/'/g, '&#039;')
		.replace(/"/g, '&quot;')
		.replace(/\n/g, '<br />');
}


function disableTextSelection(element) {
	element
		.attr('unselectable', 'on')
		.css('MozUserSelect', 'none')
		.bind('selectstart.ui', function() { return false; });
}


/*
function enableTextSelection(element) {
	element
		.attr('unselectable', 'off')
		.css('MozUserSelect', '')
		.unbind('selectstart.ui');
}
*/


function markFirstLast(e) {
	e.children()
		.removeClass('fc-first fc-last')
		.filter(':first-child')
			.addClass('fc-first')
		.end()
		.filter(':last-child')
			.addClass('fc-last');
}


function setDayID(cell, date) {
	cell.each(function(i, _cell) {
		_cell.className = _cell.className.replace(/^fc-\w*/, 'fc-' + dayIDs[date.getDay()]);
		// TODO: make a way that doesn't rely on order of classes
	});
}


function getSkinCss(event, opt) {
	var source = event.source || {};
	var eventColor = event.color;
	var sourceColor = source.color;
	var optionColor = opt('eventColor');
	var backgroundColor =
		event.backgroundColor ||
		eventColor ||
		source.backgroundColor ||
		sourceColor ||
		opt('eventBackgroundColor') ||
		optionColor;
	var borderColor =
		event.borderColor ||
		eventColor ||
		source.borderColor ||
		sourceColor ||
		opt('eventBorderColor') ||
		optionColor;
	var textColor =
		event.textColor ||
		source.textColor ||
		opt('eventTextColor');
	var statements = [];
	if (backgroundColor) {
		statements.push('background-color:' + backgroundColor);
	}
	if (borderColor) {
		statements.push('border-color:' + borderColor);
	}
	if (textColor) {
		statements.push('color:' + textColor);
	}
	return statements.join(';');
}


function applyAll(functions, thisObj, args) {
	if ($.isFunction(functions)) {
		functions = [ functions ];
	}
	if (functions) {
		var i;
		var ret;
		for (i=0; i<functions.length; i++) {
			ret = functions[i].apply(thisObj, args) || ret;
		}
		return ret;
	}
}


function firstDefined() {
	for (var i=0; i<arguments.length; i++) {
		if (arguments[i] !== undefined) {
			return arguments[i];
		}
	}
}


;;

fcViews.month = MonthView;

function MonthView(element, calendar) {
	var t = this;
	
	
	// exports
	t.render = render;
	
	
	// imports
	BasicView.call(t, element, calendar, 'month');
	var opt = t.opt;
	var renderBasic = t.renderBasic;
	var skipHiddenDays = t.skipHiddenDays;
	var getCellsPerWeek = t.getCellsPerWeek;
	var formatDate = calendar.formatDate;
	
	
	function render(date, delta) {
		//RHC MOD START
		var left_trim_date = opt('left_trim_date') ? Math.abs( parseInt( opt('left_trim_date') ) ) : 0 ;
		var right_trim_date = opt('right_trim_date') ? Math.abs( parseInt( opt('right_trim_date') ) ) : 0 ;		

		left_trim_date = left_trim_date > 28 ? 28 : left_trim_date ;
		right_trim_date = right_trim_date > 28 ? 28 : right_trim_date ;

		if( left_trim_date && right_trim_date && left_trim_date > right_trim_date ){
			_tmp = left_trim_date;
			left_trim_date = right_trim_date;
			right_trim_date = _tmp;
		}
		
		var upcoming_trim_past = false;
		if( opt('upcoming') && opt('upcoming_trim_past') ){
			upcoming_trim_past = parseInt( opt('upcoming_trim_past') );
			upcoming_trim_past = 0==upcoming_trim_past ? false : true;
		}

		var now = new Date();
		//date.setDate(1); //this breaks the view change consistency, but i dont remember why we needed it in the first place.  The trim past weeks works, so it seems that it was not needed after all.
		//RHC MOD END
		
		if (delta) {
			addMonths(date, delta);
			date.setDate(1);
		}

		var firstDay = opt('firstDay');

		var start = cloneDate(date, true);
		start.setDate(1);
		end = addMonths(cloneDate(start), 1);
		if( upcoming_trim_past && end.getTime() < now.getTime() ){
			calendar.next()		
			return;
		}	
		//RHC MOD START		
		upcoming_trim_past = upcoming_trim_past && (start.getTime() < now.getTime());

		if( upcoming_trim_past ){	
			start = new Date();		
			date = cloneDate( start, true );//avoid moving the date furhter in the past by clicking prev arrow.
			//---
			end = addMonths(cloneDate(start), 1);
			end.setDate( 0 );
			end.setHours( 23, 59, 59 );						
		}
		
		if( left_trim_date ){
			start.setDate( left_trim_date );
		}
		
		if( right_trim_date ){
			end = cloneDate(start);
			end.setDate( right_trim_date );
			end.setHours( 23, 59, 59 );				
		}			 
		//RHC MOD END

		var visStart = cloneDate(start);
		addDays(visStart, -((visStart.getDay() - firstDay + 7) % 7));
		skipHiddenDays(visStart);

		var visEnd = cloneDate(end);
		addDays(visEnd, (7 - visEnd.getDay() + firstDay) % 7);

		skipHiddenDays(visEnd, -1, true);

		var colCnt = getCellsPerWeek();
		//-- Note: rowCnt should be performed on visEnd and visStart before they where added days.
		var rowCnt = Math.ceil(dayDiff(visEnd, visStart) / 7); // should be no need for Math.round

		if (opt('weekMode') == 'fixed') {
			_weeks_to_add = 6 - rowCnt;//RHC FIX
			if( _weeks_to_add > 0 ){//RHC FIX
				addDays(visEnd, _weeks_to_add * 7); // add weeks to make up for it
			} //RHC FIX
			//original. when using weekMode fixed, sometimes rowCnt would be 7 causing a negative number.
			//addDays(visEnd, (6 - rowCnt) * 7);
			rowCnt = 6;
			//RHC MOD START
			if( upcoming_trim_past ){
				var rowCnt = Math.ceil(dayDiff(visEnd, visStart) / 7);
			} 
			//RHC MOD END			

		}

		t.title = formatDate(start, opt('titleFormat'));

		t.start = start;
		t.end = end;
		t.visStart = visStart;
		t.visEnd = visEnd;

		renderBasic(rowCnt, colCnt, true);
	}
	
	
}

;;

fcViews.basicWeek = BasicWeekView;

function BasicWeekView(element, calendar) {
	var t = this;
	
	
	// exports
	t.render = render;
	
	
	// imports
	BasicView.call(t, element, calendar, 'basicWeek');
	var opt = t.opt;
	var renderBasic = t.renderBasic;
	var skipHiddenDays = t.skipHiddenDays;
	var getCellsPerWeek = t.getCellsPerWeek;
	var formatDates = calendar.formatDates;
	
	
	function render(date, delta) {

		if (delta) {
			addDays(date, delta * 7);
		}

		var start = addDays(cloneDate(date), -((date.getDay() - opt('firstDay') + 7) % 7));
		var end = addDays(cloneDate(start), 7);

		var visStart = cloneDate(start);
		skipHiddenDays(visStart);

		var visEnd = cloneDate(end);
		skipHiddenDays(visEnd, -1, true);

		var colCnt = getCellsPerWeek();

		t.start = start;
		t.end = end;
		t.visStart = visStart;
		t.visEnd = visEnd;

		t.title = formatDates(
			visStart,
			addDays(cloneDate(visEnd), -1),
			opt('titleFormat')
		);
		//RHC:MOD changed third argument to true, for mobile layout.
		renderBasic(1, colCnt, true);
	}
	
	
}

;;

fcViews.basicDay = BasicDayView;


function BasicDayView(element, calendar) {
	var t = this;
	
	
	// exports
	t.render = render;
	
	
	// imports
	BasicView.call(t, element, calendar, 'basicDay');
	var opt = t.opt;
	var renderBasic = t.renderBasic;
	var skipHiddenDays = t.skipHiddenDays;
	var formatDate = calendar.formatDate;
	
	
	function render(date, delta) {

		if (delta) {
			addDays(date, delta);
		}
		skipHiddenDays(date, delta < 0 ? -1 : 1);

		var start = cloneDate(date, true);
		var end = addDays(cloneDate(start), 1);

		t.title = formatDate(date, opt('titleFormat'));

		t.start = t.visStart = start;
		t.end = t.visEnd = end;

		renderBasic(1, 1, false);
	}
	
	
}

;;

setDefaults({
	weekMode: 'fixed'
});


function BasicView(element, calendar, viewName) {
	var t = this;
	
	
	// exports
	t.renderBasic = renderBasic;
	t.setHeight = setHeight;
	t.setWidth = setWidth;
	t.renderDayOverlay = renderDayOverlay;
	t.defaultSelectionEnd = defaultSelectionEnd;
	t.renderSelection = renderSelection;
	t.clearSelection = clearSelection;
	t.reportDayClick = reportDayClick; // for selection (kinda hacky)
	t.dragStart = dragStart;
	t.dragStop = dragStop;
	t.defaultEventEnd = defaultEventEnd;
	t.getHoverListener = function() { return hoverListener };
	t.colLeft = colLeft;
	t.colRight = colRight;
	t.colContentLeft = colContentLeft;
	t.colContentRight = colContentRight;
	t.getIsCellAllDay = function() { return true };
	t.allDayRow = allDayRow;
	t.getRowCnt = function() { return rowCnt };
	t.getColCnt = function() { return colCnt };
	t.getColWidth = function() { return colWidth };
	t.getDaySegmentContainer = function() { return daySegmentContainer };
	
	
	// imports
	View.call(t, element, calendar, viewName);
	OverlayManager.call(t);
	SelectionManager.call(t);
	BasicEventRenderer.call(t);
	var opt = t.opt;
	var trigger = t.trigger;
	var renderOverlay = t.renderOverlay;
	var clearOverlays = t.clearOverlays;
	var daySelectionMousedown = t.daySelectionMousedown;
	var cellToDate = t.cellToDate;
	var dateToCell = t.dateToCell;
	var rangeToSegments = t.rangeToSegments;
	var formatDate = calendar.formatDate;
	
	
	// locals
	
	var table;
	var head;
	var headCells;
	var body;
	var bodyRows;
	var bodyCells;
	var bodyFirstCells;
	var firstRowCellInners;
	var firstRowCellContentInners;
	var daySegmentContainer;
	
	var viewWidth;
	var viewHeight;
	var colWidth;
	var weekNumberWidth;
	
	var rowCnt, colCnt;
	var showNumbers;
	var coordinateGrid;
	var hoverListener;
	var colPositions;
	var colContentPositions;
	
	var tm;
	var colFormat;
	var showWeekNumbers;
	var weekNumberTitle;
	var weekNumberFormat;
	
	
	
	/* Rendering
	------------------------------------------------------------*/
	
	
	disableTextSelection(element.addClass('fc-grid'));
	
	
	function renderBasic(_rowCnt, _colCnt, _showNumbers) {
		rowCnt = _rowCnt;
		colCnt = _colCnt;
		showNumbers = _showNumbers;
		updateOptions();

		if (!body) {
			buildEventContainer();
		}

		buildTable();
	}
	
	
	function updateOptions() {
		tm = opt('theme') ? 'ui' : 'fc';
		colFormat = opt('columnFormat');

		// week # options. (TODO: bad, logic also in other views)
		showWeekNumbers = opt('weekNumbers');
		weekNumberTitle = opt('weekNumberTitle');
		if (opt('weekNumberCalculation') != 'iso') {
			weekNumberFormat = "w";
		}
		else {
			weekNumberFormat = "W";
		}
	}
	
	
	function buildEventContainer() {
		daySegmentContainer =
			$("<div class='fc-event-container' style='position:absolute;z-index:8;top:0;left:0'/>")
				.appendTo(element);
	}
	
	
	function buildTable() {
		var html = buildTableHTML();

		if (table) {
			table.remove();
		}
		table = $(html).appendTo(element);

		head = table.find('thead');
		headCells = head.find('.fc-day-header');
		body = table.find('tbody');
		bodyRows = body.find('tr');
		bodyCells = body.find('.fc-day');
		bodyFirstCells = bodyRows.find('td:first-child');

		firstRowCellInners = bodyRows.eq(0).find('.fc-day > div');
		firstRowCellContentInners = bodyRows.eq(0).find('.fc-day-content > div');
		
		markFirstLast(head.add(head.find('tr'))); // marks first+last tr/th's
		markFirstLast(bodyRows); // marks first+last td's
		bodyRows.eq(0).addClass('fc-first');
		bodyRows.filter(':last').addClass('fc-last');

		bodyCells.each(function(i, _cell) {
			var date = cellToDate(
				Math.floor(i / colCnt),
				i % colCnt
			);
			trigger('dayRender', t, date, $(_cell));
		});

		dayBind(bodyCells);
	}



	/* HTML Building
	-----------------------------------------------------------*/


	function buildTableHTML() {
		var html =
			"<table class='fc-border-separate' style='width:100%' cellspacing='0'>" +
			buildHeadHTML() +
			buildBodyHTML() +
			"</table>";

		return html;
	}


	function buildHeadHTML() {
		var headerClass = tm + "-widget-header";
		var html = '';
		var col;
		var date;

		html += "<thead><tr>";

		if (showWeekNumbers) {
			html +=
				"<th class='fc-week-number " + headerClass + "'>" +
				htmlEscape(weekNumberTitle) +
				"</th>";
		}

		for (col=0; col<colCnt; col++) {
			date = cellToDate(0, col);
			html +=
				"<th class='fc-day-header fc-" + dayIDs[date.getDay()] + " " + headerClass + "'>" +
				htmlEscape(formatDate(date, colFormat)) +
				"</th>";
		}

		html += "</tr></thead>";

		return html;
	}


	function buildBodyHTML() {
		var contentClass = tm + "-widget-content";
		var html = '';
		var row;
		var col;
		var date;

		html += "<tbody>";

		for (row=0; row<rowCnt; row++) {

			html += "<tr class='fc-week'>";

			if (showWeekNumbers) {
				date = cellToDate(row, 0);
				html +=
					"<td class='fc-week-number " + contentClass + "'>" +
					"<div>" +
					htmlEscape(formatDate(date, weekNumberFormat)) +
					"</div>" +
					"</td>";
			}

			for (col=0; col<colCnt; col++) {
				date = cellToDate(row, col);
				html += buildCellHTML(date);
			}

			html += "</tr>";
		}

		html += "</tbody>";

		return html;
	}


	function buildCellHTML(date) {
		var contentClass = tm + "-widget-content";
		var month = t.start.getMonth();
		var today = clearTime(new Date());
		var html = '';
		var classNames = [
			'fc-day',
			'fc-' + dayIDs[date.getDay()],
			contentClass
		];

		if (date.getMonth() != month) {
			classNames.push('fc-other-month');
		}
		if (+date == +today) {
			classNames.push(
				'fc-today',
				tm + '-state-highlight'
			);
		}
		else if (date < today) {
			classNames.push('fc-past');
		}
		else {
			classNames.push('fc-future');
		}

		html +=
			"<td" +
			" class='" + classNames.join(' ') + "'" +
			" data-date='" + formatDate(date, 'yyyy-MM-dd') + "'" +
			">" +
			"<div>";

		if (showNumbers) {
			//RHC MOD: allow using the col format in the cell for basicWeek
			switch(viewName){
				case 'basicWeek':
					value = htmlEscape(formatDate(date, colFormat));
					break;
				default:
					value = date.getDate();
			}
			
			html += "<div class='fc-day-number'>" + value + "</div>";
		}

		html +=
			"<div class='fc-day-content'>" +
			"<div style='position:relative'>&nbsp;</div>" +
			"</div>" +
			"</div>" +
			"</td>";

		return html;
	}



	/* Dimensions
	-----------------------------------------------------------*/
	
	
	function setHeight(height) {
		//-- rhc start
		if( $(t.element).closest('.rhc_holder').is('.fc-small') ) return;
		//-- rhc end
		viewHeight = height;
		
		var bodyHeight = viewHeight - head.height();
		var rowHeight;
		var rowHeightLast;
		var cell;
			
		if (opt('weekMode') == 'variable') {
			rowHeight = rowHeightLast = Math.floor(bodyHeight / (rowCnt==1 ? 2 : 6));
		}else{
			rowHeight = Math.floor(bodyHeight / rowCnt);
			rowHeightLast = bodyHeight - rowHeight * (rowCnt-1);
		}
		
		bodyFirstCells.each(function(i, _cell) {
			if (i < rowCnt) {
				cell = $(_cell);
				cell.find('> div').css(
					'min-height',
					(i==rowCnt-1 ? rowHeightLast : rowHeight) - vsides(cell)
				);
			}
		});
		
	}
	
	
	function setWidth(width) {
		viewWidth = width;
		colPositions.clear();
		colContentPositions.clear();

		weekNumberWidth = 0;
		if (showWeekNumbers) {
			weekNumberWidth = head.find('th.fc-week-number').outerWidth();
		}

		colWidth = Math.floor((viewWidth - weekNumberWidth) / colCnt);
		setOuterWidth(headCells.slice(0, -1), colWidth);
	}
	
	
	
	/* Day clicking and binding
	-----------------------------------------------------------*/
	
	
	function dayBind(days) {
		days.click(dayClick)
			.mousedown(daySelectionMousedown);
	}
	
	
	function dayClick(ev) {
		if (!opt('selectable')) { // if selectable, SelectionManager will worry about dayClick
			var date = parseISO8601($(this).data('date'));
			trigger('dayClick', this, date, true, ev);
		}
	}
	
	
	
	/* Semi-transparent Overlay Helpers
	------------------------------------------------------*/
	// TODO: should be consolidated with AgendaView's methods


	function renderDayOverlay(overlayStart, overlayEnd, refreshCoordinateGrid) { // overlayEnd is exclusive

		if (refreshCoordinateGrid) {
			coordinateGrid.build();
		}

		var segments = rangeToSegments(overlayStart, overlayEnd, null);

		for (var i=0; i<segments.length; i++) {
			var segment = segments[i];
			dayBind(
				renderCellOverlay(
					segment.row,
					segment.leftCol,
					segment.row,
					segment.rightCol
				)
			);
		}
	}

	
	function renderCellOverlay(row0, col0, row1, col1) { // row1,col1 is inclusive
		var rect = coordinateGrid.rect(row0, col0, row1, col1, element);
		return renderOverlay(rect, element);
	}
	
	
	
	/* Selection
	-----------------------------------------------------------------------*/
	
	
	function defaultSelectionEnd(startDate, allDay) {
		return cloneDate(startDate);
	}
	
	
	function renderSelection(startDate, endDate, allDay) {
		renderDayOverlay(startDate, addDays(cloneDate(endDate), 1), true); // rebuild every time???
	}
	
	
	function clearSelection() {
		clearOverlays();
	}
	
	
	function reportDayClick(date, allDay, ev) {
		var cell = dateToCell(date);
		var _element = bodyCells[cell.row*colCnt + cell.col];
		trigger('dayClick', _element, date, allDay, ev);
	}
	
	
	
	/* External Dragging
	-----------------------------------------------------------------------*/
	
	
	function dragStart(_dragElement, ev, ui) {
		hoverListener.start(function(cell) {
			clearOverlays();
			if (cell) {
				renderCellOverlay(cell.row, cell.col, cell.row, cell.col);
			}
		}, ev);
	}
	
	
	function dragStop(_dragElement, ev, ui) {
		var cell = hoverListener.stop();
		clearOverlays();
		if (cell) {
			var d = cellToDate(cell);
			trigger('drop', _dragElement, d, true, ev, ui);
		}
	}
	
	
	
	/* Utilities
	--------------------------------------------------------*/
	
	
	function defaultEventEnd(event) {
		return cloneDate(event.start);
	}
	
	
	coordinateGrid = new CoordinateGrid(function(rows, cols) {
		var e, n, p;
		headCells.each(function(i, _e) {
			e = $(_e);
			n = e.offset().left;
			if (i) {
				p[1] = n;
			}
			p = [n];
			cols[i] = p;
		});
		p[1] = n + e.outerWidth();
		bodyRows.each(function(i, _e) {
			if (i < rowCnt) {
				e = $(_e);
				n = e.offset().top;
				if (i) {
					p[1] = n;
				}
				p = [n];
				rows[i] = p;
			}
		});
		p[1] = n + e.outerHeight();
	});
	
	
	hoverListener = new HoverListener(coordinateGrid);
	
	colPositions = new HorizontalPositionCache(function(col) {
		return firstRowCellInners.eq(col);
	});

	colContentPositions = new HorizontalPositionCache(function(col) {
		return firstRowCellContentInners.eq(col);
	});


	function colLeft(col) {
		return colPositions.left(col);
	}


	function colRight(col) {
		return colPositions.right(col);
	}
	
	
	function colContentLeft(col) {
		return colContentPositions.left(col);
	}
	
	
	function colContentRight(col) {
		return colContentPositions.right(col);
	}
	
	
	function allDayRow(i) {
		return bodyRows.eq(i);
	}
	
}

;;

function BasicEventRenderer() {
	var t = this;
	
	
	// exports
	t.renderEvents = renderEvents;
	t.clearEvents = clearEvents;
	

	// imports
	DayEventRenderer.call(t);

	
	function renderEvents(events, modifiedEventId) {
		t.renderDayEvents(events, modifiedEventId);
	}
	
	
	function clearEvents() {
		t.getDaySegmentContainer().empty();
	}


	// TODO: have this class (and AgendaEventRenderer) be responsible for creating the event container div

}

;;

fcViews.agendaWeek = AgendaWeekView;

function AgendaWeekView(element, calendar) {
	var t = this;
	
	
	// exports
	t.render = render;
	
	
	// imports
	AgendaView.call(t, element, calendar, 'agendaWeek');
	var opt = t.opt;
	var renderAgenda = t.renderAgenda;
	var skipHiddenDays = t.skipHiddenDays;
	var getCellsPerWeek = t.getCellsPerWeek;
	var formatDates = calendar.formatDates;

	
	function render(date, delta) {

		if (delta) {
			addDays(date, delta * 7);
		}

		var start = addDays(cloneDate(date), -((date.getDay() - opt('firstDay') + 7) % 7));
		var end = addDays(cloneDate(start), 7);

		var visStart = cloneDate(start);
		skipHiddenDays(visStart);

		var visEnd = cloneDate(end);
		skipHiddenDays(visEnd, -1, true);

		var colCnt = getCellsPerWeek();

		t.title = formatDates(
			visStart,
			addDays(cloneDate(visEnd), -1),
			opt('titleFormat')
		);

		t.start = start;
		t.end = end;
		t.visStart = visStart;
		t.visEnd = visEnd;

		renderAgenda(colCnt);
	}

}

;;

fcViews.agendaDay = AgendaDayView;


function AgendaDayView(element, calendar) {
	var t = this;
	
	
	// exports
	t.render = render;
	
	
	// imports
	AgendaView.call(t, element, calendar, 'agendaDay');
	var opt = t.opt;
	var renderAgenda = t.renderAgenda;
	var skipHiddenDays = t.skipHiddenDays;
	var formatDate = calendar.formatDate;
	
	
	function render(date, delta) {

		if (delta) {
			addDays(date, delta);
		}
		skipHiddenDays(date, delta < 0 ? -1 : 1);

		var start = cloneDate(date, true);
		var end = addDays(cloneDate(start), 1);

		t.title = formatDate(date, opt('titleFormat'));

		t.start = t.visStart = start;
		t.end = t.visEnd = end;

		renderAgenda(1);
	}
	

}

;;

setDefaults({
	allDaySlot: true,
	allDayText: 'all-day',
	firstHour: 6,
	slotMinutes: 30,
	defaultEventMinutes: 120,
	axisFormat: 'h(:mm)tt',
	timeFormat: {
		agenda: 'h:mm{ - h:mm}'
	},
	dragOpacity: {
		agenda: .5
	},
	minTime: 0,
	maxTime: 24,
	slotEventOverlap: true
});


// TODO: make it work in quirks mode (event corners, all-day height)
// TODO: test liquid width, especially in IE6


function AgendaView(element, calendar, viewName) {
	var t = this;
	
	
	// exports
	t.renderAgenda = renderAgenda;
	t.setWidth = setWidth;
	t.setHeight = setHeight;
	t.afterRender = afterRender;
	t.defaultEventEnd = defaultEventEnd;
	t.timePosition = timePosition;
	t.getIsCellAllDay = getIsCellAllDay;
	t.allDayRow = getAllDayRow;
	t.getCoordinateGrid = function() { return coordinateGrid }; // specifically for AgendaEventRenderer
	t.getHoverListener = function() { return hoverListener };
	t.colLeft = colLeft;
	t.colRight = colRight;
	t.colContentLeft = colContentLeft;
	t.colContentRight = colContentRight;
	t.getDaySegmentContainer = function() { return daySegmentContainer };
	t.getSlotSegmentContainer = function() { return slotSegmentContainer };
	t.getMinMinute = function() { return minMinute };
	t.getMaxMinute = function() { return maxMinute };
	t.getSlotContainer = function() { return slotContainer };
	t.getRowCnt = function() { return 1 };
	t.getColCnt = function() { return colCnt };
	t.getColWidth = function() { return colWidth };
	t.getSnapHeight = function() { return snapHeight };
	t.getSnapMinutes = function() { return snapMinutes };
	t.defaultSelectionEnd = defaultSelectionEnd;
	t.renderDayOverlay = renderDayOverlay;
	t.renderSelection = renderSelection;
	t.clearSelection = clearSelection;
	t.reportDayClick = reportDayClick; // selection mousedown hack
	t.dragStart = dragStart;
	t.dragStop = dragStop;
	
	
	// imports
	View.call(t, element, calendar, viewName);
	OverlayManager.call(t);
	SelectionManager.call(t);
	AgendaEventRenderer.call(t);
	var opt = t.opt;
	var trigger = t.trigger;
	var renderOverlay = t.renderOverlay;
	var clearOverlays = t.clearOverlays;
	var reportSelection = t.reportSelection;
	var unselect = t.unselect;
	var daySelectionMousedown = t.daySelectionMousedown;
	var slotSegHtml = t.slotSegHtml;
	var cellToDate = t.cellToDate;
	var dateToCell = t.dateToCell;
	var rangeToSegments = t.rangeToSegments;
	var formatDate = calendar.formatDate;
	
	
	// locals
	
	var dayTable;
	var dayHead;
	var dayHeadCells;
	var dayBody;
	var dayBodyCells;
	var dayBodyCellInners;
	var dayBodyCellContentInners;
	var dayBodyFirstCell;
	var dayBodyFirstCellStretcher;
	var slotLayer;
	var daySegmentContainer;
	var allDayTable;
	var allDayRow;
	var slotScroller;
	var slotContainer;
	var slotSegmentContainer;
	var slotTable;
	var selectionHelper;
	
	var viewWidth;
	var viewHeight;
	var axisWidth;
	var colWidth;
	var gutterWidth;
	var slotHeight; // TODO: what if slotHeight changes? (see issue 650)

	var snapMinutes;
	var snapRatio; // ratio of number of "selection" slots to normal slots. (ex: 1, 2, 4)
	var snapHeight; // holds the pixel hight of a "selection" slot
	
	var colCnt;
	var slotCnt;
	var coordinateGrid;
	var hoverListener;
	var colPositions;
	var colContentPositions;
	var slotTopCache = {};
	
	var tm;
	var rtl;
	var minMinute, maxMinute;
	var colFormat;
	var showWeekNumbers;
	var weekNumberTitle;
	var weekNumberFormat;
	

	
	/* Rendering
	-----------------------------------------------------------------------------*/
	
	
	disableTextSelection(element.addClass('fc-agenda'));
	
	
	function renderAgenda(c) {
		colCnt = c;
		updateOptions();

		if (!dayTable) { // first time rendering?
			buildSkeleton(); // builds day table, slot area, events containers
		}
		else {
			buildDayTable(); // rebuilds day table
		}
	}
	
	
	function updateOptions() {

		tm = opt('theme') ? 'ui' : 'fc';
		rtl = opt('isRTL')
		minMinute = parseTime(opt('minTime'));
		maxMinute = parseTime(opt('maxTime'));
		colFormat = opt('columnFormat');

		// week # options. (TODO: bad, logic also in other views)
		showWeekNumbers = opt('weekNumbers');
		weekNumberTitle = opt('weekNumberTitle');
		if (opt('weekNumberCalculation') != 'iso') {
			weekNumberFormat = "w";
		}
		else {
			weekNumberFormat = "W";
		}

		snapMinutes = opt('snapMinutes') || opt('slotMinutes');
	}



	/* Build DOM
	-----------------------------------------------------------------------*/


	function buildSkeleton() {
		var headerClass = tm + "-widget-header";
		var contentClass = tm + "-widget-content";
		var s;
		var d;
		var i;
		var maxd;
		var minutes;
		var slotNormal = opt('slotMinutes') % 15 == 0;
		
		buildDayTable();
		
		slotLayer =
			$("<div style='position:absolute;z-index:2;left:0;width:100%'/>")
				.appendTo(element);
				
		if (opt('allDaySlot')) {
		
			daySegmentContainer =
				$("<div class='fc-event-container' style='position:absolute;z-index:8;top:0;left:0'/>")
					.appendTo(slotLayer);
		
			s =
				"<table style='width:100%' class='fc-agenda-allday' cellspacing='0'>" +
				"<tr>" +
				"<th class='" + headerClass + " fc-agenda-axis'>" + opt('allDayText') + "</th>" +
				"<td>" +
				"<div class='fc-day-content'><div style='position:relative'/></div>" +
				"</td>" +
				"<th class='" + headerClass + " fc-agenda-gutter'>&nbsp;</th>" +
				"</tr>" +
				"</table>";
			allDayTable = $(s).appendTo(slotLayer);
			allDayRow = allDayTable.find('tr');
			
			dayBind(allDayRow.find('td'));
			
			slotLayer.append(
				"<div class='fc-agenda-divider " + headerClass + "'>" +
				"<div class='fc-agenda-divider-inner'/>" +
				"</div>"
			);
			
		}else{
		
			daySegmentContainer = $([]); // in jQuery 1.4, we can just do $()
		
		}
		
		slotScroller =
			$("<div style='position:absolute;width:100%;overflow-x:hidden;overflow-y:auto'/>")
				.appendTo(slotLayer);
				
		slotContainer =
			$("<div style='position:relative;width:100%;overflow:hidden'/>")
				.appendTo(slotScroller);
				
		slotSegmentContainer =
			$("<div class='fc-event-container' style='position:absolute;z-index:8;top:0;left:0'/>")
				.appendTo(slotContainer);
		
		s =
			"<table class='fc-agenda-slots' style='width:100%' cellspacing='0'>" +
			"<tbody>";
		d = zeroDate();
		maxd = addMinutes(cloneDate(d), maxMinute);
		addMinutes(d, minMinute);
		slotCnt = 0;
		for (i=0; d < maxd; i++) {
			minutes = d.getMinutes();
			s +=
				"<tr class='fc-slot" + i + ' ' + (!minutes ? '' : 'fc-minor') + "'>" +
				"<th class='fc-agenda-axis " + headerClass + "'>" +
				((!slotNormal || !minutes) ? formatDate(d, opt('axisFormat')) : '&nbsp;') +
				"</th>" +
				"<td class='" + contentClass + "'>" +
				"<div style='position:relative'>&nbsp;</div>" +
				"</td>" +
				"</tr>";
			addMinutes(d, opt('slotMinutes'));
			slotCnt++;
		}
		s +=
			"</tbody>" +
			"</table>";
		slotTable = $(s).appendTo(slotContainer);
		
		slotBind(slotTable.find('td'));
	}



	/* Build Day Table
	-----------------------------------------------------------------------*/


	function buildDayTable() {
		var html = buildDayTableHTML();

		if (dayTable) {
			dayTable.remove();
		}
		dayTable = $(html).appendTo(element);

		dayHead = dayTable.find('thead');
		dayHeadCells = dayHead.find('th').slice(1, -1); // exclude gutter
		dayBody = dayTable.find('tbody');
		dayBodyCells = dayBody.find('td').slice(0, -1); // exclude gutter
		dayBodyCellInners = dayBodyCells.find('> div');
		dayBodyCellContentInners = dayBodyCells.find('.fc-day-content > div');

		dayBodyFirstCell = dayBodyCells.eq(0);
		dayBodyFirstCellStretcher = dayBodyCellInners.eq(0);
		
		markFirstLast(dayHead.add(dayHead.find('tr')));
		markFirstLast(dayBody.add(dayBody.find('tr')));

		// TODO: now that we rebuild the cells every time, we should call dayRender
	}


	function buildDayTableHTML() {
		var html =
			"<table style='width:100%' class='fc-agenda-days fc-border-separate' cellspacing='0'>" +
			buildDayTableHeadHTML() +
			buildDayTableBodyHTML() +
			"</table>";

		return html;
	}


	function buildDayTableHeadHTML() {
		var headerClass = tm + "-widget-header";
		var date;
		var html = '';
		var weekText;
		var col;

		html +=
			"<thead>" +
			"<tr>";

		if (showWeekNumbers) {
			date = cellToDate(0, 0);
			weekText = formatDate(date, weekNumberFormat);
			if (rtl) {
				weekText += weekNumberTitle;
			}
			else {
				weekText = weekNumberTitle + weekText;
			}
			html +=
				"<th class='fc-agenda-axis fc-week-number " + headerClass + "'>" +
				htmlEscape(weekText) +
				"</th>";
		}
		else {
			html += "<th class='fc-agenda-axis " + headerClass + "'>&nbsp;</th>";
		}

		for (col=0; col<colCnt; col++) {
			date = cellToDate(0, col);
			html +=
				"<th class='fc-" + dayIDs[date.getDay()] + " fc-col" + col + ' ' + headerClass + "'>" +
				htmlEscape(formatDate(date, colFormat)) +
				"</th>";
		}

		html +=
			"<th class='fc-agenda-gutter " + headerClass + "'>&nbsp;</th>" +
			"</tr>" +
			"</thead>";

		return html;
	}


	function buildDayTableBodyHTML() {
		var headerClass = tm + "-widget-header"; // TODO: make these when updateOptions() called
		var contentClass = tm + "-widget-content";
		var date;
		var today = clearTime(new Date());
		var col;
		var cellsHTML;
		var cellHTML;
		var classNames;
		var html = '';

		html +=
			"<tbody>" +
			"<tr>" +
			"<th class='fc-agenda-axis " + headerClass + "'>&nbsp;</th>";

		cellsHTML = '';

		for (col=0; col<colCnt; col++) {

			date = cellToDate(0, col);

			classNames = [
				'fc-col' + col,
				'fc-' + dayIDs[date.getDay()],
				contentClass
			];
			if (+date == +today) {
				classNames.push(
					tm + '-state-highlight',
					'fc-today'
				);
			}
			else if (date < today) {
				classNames.push('fc-past');
			}
			else {
				classNames.push('fc-future');
			}

			cellHTML =
				"<td class='" + classNames.join(' ') + "'>" +
				"<div>" +
				"<div class='fc-day-content'>" +
				"<div style='position:relative'>&nbsp;</div>" +
				"</div>" +
				"</div>" +
				"</td>";

			cellsHTML += cellHTML;
		}

		html += cellsHTML;
		html +=
			"<td class='fc-agenda-gutter " + contentClass + "'>&nbsp;</td>" +
			"</tr>" +
			"</tbody>";

		return html;
	}


	// TODO: data-date on the cells

	
	
	/* Dimensions
	-----------------------------------------------------------------------*/

	
	function setHeight(height) {
		if (height === undefined) {
			height = viewHeight;
		}
		viewHeight = height;
		slotTopCache = {};
	
		var headHeight = dayBody.position().top;
		var allDayHeight = slotScroller.position().top; // including divider
		var bodyHeight = Math.min( // total body height, including borders
			height - headHeight,   // when scrollbars
			slotTable.height() + allDayHeight + 1 // when no scrollbars. +1 for bottom border
		);

		dayBodyFirstCellStretcher
			.height(bodyHeight - vsides(dayBodyFirstCell));
		
		slotLayer.css('top', headHeight);
		
		slotScroller.height(bodyHeight - allDayHeight - 1);
		
		// the stylesheet guarantees that the first row has no border.
		// this allows .height() to work well cross-browser.
		slotHeight = slotTable.find('tr:first').height() + 1; // +1 for bottom border

		snapRatio = opt('slotMinutes') / snapMinutes;
		snapHeight = slotHeight / snapRatio;
	}
	
	
	function setWidth(width) {
		viewWidth = width;
		colPositions.clear();
		colContentPositions.clear();

		var axisFirstCells = dayHead.find('th:first');
		if (allDayTable) {
			axisFirstCells = axisFirstCells.add(allDayTable.find('th:first'));
		}
		axisFirstCells = axisFirstCells.add(slotTable.find('th:first'));
		
		axisWidth = 0;
		setOuterWidth(
			axisFirstCells
				.width('')
				.each(function(i, _cell) {
					axisWidth = Math.max(axisWidth, $(_cell).outerWidth());
				}),
			axisWidth
		);
		
		var gutterCells = dayTable.find('.fc-agenda-gutter');
		if (allDayTable) {
			gutterCells = gutterCells.add(allDayTable.find('th.fc-agenda-gutter'));
		}

		var slotTableWidth = slotScroller[0].clientWidth; // needs to be done after axisWidth (for IE7)
		
		gutterWidth = slotScroller.width() - slotTableWidth;
		if (gutterWidth) {
			setOuterWidth(gutterCells, gutterWidth);
			gutterCells
				.show()
				.prev()
				.removeClass('fc-last');
		}else{
			gutterCells
				.hide()
				.prev()
				.addClass('fc-last');
		}
		
		colWidth = Math.floor((slotTableWidth - axisWidth) / colCnt);
		setOuterWidth(dayHeadCells.slice(0, -1), colWidth);
	}
	


	/* Scrolling
	-----------------------------------------------------------------------*/


	function resetScroll() {
		var d0 = zeroDate();
		var scrollDate = cloneDate(d0);
		scrollDate.setHours(opt('firstHour'));
		var top = timePosition(d0, scrollDate) + 1; // +1 for the border
		function scroll() {
			slotScroller.scrollTop(top);
		}
		scroll();
		setTimeout(scroll, 0); // overrides any previous scroll state made by the browser
	}


	function afterRender() { // after the view has been freshly rendered and sized
		resetScroll();
	}
	
	
	
	/* Slot/Day clicking and binding
	-----------------------------------------------------------------------*/
	

	function dayBind(cells) {
		cells.click(slotClick)
			.mousedown(daySelectionMousedown);
	}


	function slotBind(cells) {
		cells.click(slotClick)
			.mousedown(slotSelectionMousedown);
	}
	
	
	function slotClick(ev) {
		if (!opt('selectable')) { // if selectable, SelectionManager will worry about dayClick
			var col = Math.min(colCnt-1, Math.floor((ev.pageX - dayTable.offset().left - axisWidth) / colWidth));
			var date = cellToDate(0, col);
			var rowMatch = this.parentNode.className.match(/fc-slot(\d+)/); // TODO: maybe use data
			if (rowMatch) {
				var mins = parseInt(rowMatch[1]) * opt('slotMinutes');
				var hours = Math.floor(mins/60);
				date.setHours(hours);
				date.setMinutes(mins%60 + minMinute);
				trigger('dayClick', dayBodyCells[col], date, false, ev);
			}else{
				trigger('dayClick', dayBodyCells[col], date, true, ev);
			}
		}
	}
	
	
	
	/* Semi-transparent Overlay Helpers
	-----------------------------------------------------*/
	// TODO: should be consolidated with BasicView's methods


	function renderDayOverlay(overlayStart, overlayEnd, refreshCoordinateGrid) { // overlayEnd is exclusive

		if (refreshCoordinateGrid) {
			coordinateGrid.build();
		}

		var segments = rangeToSegments(overlayStart, overlayEnd, null);

		for (var i=0; i<segments.length; i++) {
			var segment = segments[i];
			dayBind(
				renderCellOverlay(
					segment.row,
					segment.leftCol,
					segment.row,
					segment.rightCol
				)
			);
		}
	}
	
	
	function renderCellOverlay(row0, col0, row1, col1) { // only for all-day?
		var rect = coordinateGrid.rect(row0, col0, row1, col1, slotLayer);
		return renderOverlay(rect, slotLayer);
	}
	

	function renderSlotOverlay(overlayStart, overlayEnd) {
		for (var i=0; i<colCnt; i++) {
			var dayStart = cellToDate(0, i);
			var dayEnd = addDays(cloneDate(dayStart), 1);
			var stretchStart = new Date(Math.max(dayStart, overlayStart));
			var stretchEnd = new Date(Math.min(dayEnd, overlayEnd));
			if (stretchStart < stretchEnd) {
				var rect = coordinateGrid.rect(0, i, 0, i, slotContainer); // only use it for horizontal coords
				var top = timePosition(dayStart, stretchStart);
				var bottom = timePosition(dayStart, stretchEnd);
				rect.top = top;
				rect.height = bottom - top;
				slotBind(
					renderOverlay(rect, slotContainer)
				);
			}
		}
	}
	
	
	
	/* Coordinate Utilities
	-----------------------------------------------------------------------------*/
	
	
	coordinateGrid = new CoordinateGrid(function(rows, cols) {
		var e, n, p;
		dayHeadCells.each(function(i, _e) {
			e = $(_e);
			n = e.offset().left;
			if (i) {
				p[1] = n;
			}
			p = [n];
			cols[i] = p;
		});
		p[1] = n + e.outerWidth();
		if (opt('allDaySlot')) {
			e = allDayRow;
			n = e.offset().top;
			rows[0] = [n, n+e.outerHeight()];
		}
		var slotTableTop = slotContainer.offset().top;
		var slotScrollerTop = slotScroller.offset().top;
		var slotScrollerBottom = slotScrollerTop + slotScroller.outerHeight();
		function constrain(n) {
			return Math.max(slotScrollerTop, Math.min(slotScrollerBottom, n));
		}
		for (var i=0; i<slotCnt*snapRatio; i++) { // adapt slot count to increased/decreased selection slot count
			rows.push([
				constrain(slotTableTop + snapHeight*i),
				constrain(slotTableTop + snapHeight*(i+1))
			]);
		}
	});
	
	
	hoverListener = new HoverListener(coordinateGrid);
	
	colPositions = new HorizontalPositionCache(function(col) {
		return dayBodyCellInners.eq(col);
	});
	
	colContentPositions = new HorizontalPositionCache(function(col) {
		return dayBodyCellContentInners.eq(col);
	});
	
	
	function colLeft(col) {
		return colPositions.left(col);
	}


	function colContentLeft(col) {
		return colContentPositions.left(col);
	}


	function colRight(col) {
		return colPositions.right(col);
	}
	
	
	function colContentRight(col) {
		return colContentPositions.right(col);
	}


	function getIsCellAllDay(cell) {
		return opt('allDaySlot') && !cell.row;
	}


	function realCellToDate(cell) { // ugh "real" ... but blame it on our abuse of the "cell" system
		var d = cellToDate(0, cell.col);
		var slotIndex = cell.row;
		if (opt('allDaySlot')) {
			slotIndex--;
		}
		if (slotIndex >= 0) {
			addMinutes(d, minMinute + slotIndex * snapMinutes);
		}
		return d;
	}
	
	
	// get the Y coordinate of the given time on the given day (both Date objects)
	function timePosition(day, time) { // both date objects. day holds 00:00 of current day
		day = cloneDate(day, true);
		if (time < addMinutes(cloneDate(day), minMinute)) {
			return 0;
		}
		if (time >= addMinutes(cloneDate(day), maxMinute)) {
			return slotTable.height();
		}
		var slotMinutes = opt('slotMinutes'),
			minutes = time.getHours()*60 + time.getMinutes() - minMinute,
			slotI = Math.floor(minutes / slotMinutes),
			slotTop = slotTopCache[slotI];
		if (slotTop === undefined) {
			slotTop = slotTopCache[slotI] =
				slotTable.find('tr').eq(slotI).find('td div')[0].offsetTop;
				// .eq() is faster than ":eq()" selector
				// [0].offsetTop is faster than .position().top (do we really need this optimization?)
				// a better optimization would be to cache all these divs
		}
		return Math.max(0, Math.round(
			slotTop - 1 + slotHeight * ((minutes % slotMinutes) / slotMinutes)
		));
	}
	
	
	function getAllDayRow(index) {
		return allDayRow;
	}
	
	
	function defaultEventEnd(event) {
		var start = cloneDate(event.start);
		if (event.allDay) {
			return start;
		}
		return addMinutes(start, opt('defaultEventMinutes'));
	}
	
	
	
	/* Selection
	---------------------------------------------------------------------------------*/
	
	
	function defaultSelectionEnd(startDate, allDay) {
		if (allDay) {
			return cloneDate(startDate);
		}
		return addMinutes(cloneDate(startDate), opt('slotMinutes'));
	}
	
	
	function renderSelection(startDate, endDate, allDay) { // only for all-day
		if (allDay) {
			if (opt('allDaySlot')) {
				renderDayOverlay(startDate, addDays(cloneDate(endDate), 1), true);
			}
		}else{
			renderSlotSelection(startDate, endDate);
		}
	}
	
	
	function renderSlotSelection(startDate, endDate) {
		var helperOption = opt('selectHelper');
		coordinateGrid.build();
		if (helperOption) {
			var col = dateToCell(startDate).col;
			if (col >= 0 && col < colCnt) { // only works when times are on same day
				var rect = coordinateGrid.rect(0, col, 0, col, slotContainer); // only for horizontal coords
				var top = timePosition(startDate, startDate);
				var bottom = timePosition(startDate, endDate);
				if (bottom > top) { // protect against selections that are entirely before or after visible range
					rect.top = top;
					rect.height = bottom - top;
					rect.left += 2;
					rect.width -= 5;
					if ($.isFunction(helperOption)) {
						var helperRes = helperOption(startDate, endDate);
						if (helperRes) {
							rect.position = 'absolute';
							selectionHelper = $(helperRes)
								.css(rect)
								.appendTo(slotContainer);
						}
					}else{
						rect.isStart = true; // conside rect a "seg" now
						rect.isEnd = true;   //
						selectionHelper = $(slotSegHtml(
							{
								title: '',
								start: startDate,
								end: endDate,
								className: ['fc-select-helper'],
								editable: false
							},
							rect
						));
						selectionHelper.css('opacity', opt('dragOpacity'));
					}
					if (selectionHelper) {
						slotBind(selectionHelper);
						slotContainer.append(selectionHelper);
						setOuterWidth(selectionHelper, rect.width, true); // needs to be after appended
						setOuterHeight(selectionHelper, rect.height, true);
					}
				}
			}
		}else{
			renderSlotOverlay(startDate, endDate);
		}
	}
	
	
	function clearSelection() {
		clearOverlays();
		if (selectionHelper) {
			selectionHelper.remove();
			selectionHelper = null;
		}
	}
	
	
	function slotSelectionMousedown(ev) {
		if (ev.which == 1 && opt('selectable')) { // ev.which==1 means left mouse button
			unselect(ev);
			var dates;
			hoverListener.start(function(cell, origCell) {
				clearSelection();
				if (cell && cell.col == origCell.col && !getIsCellAllDay(cell)) {
					var d1 = realCellToDate(origCell);
					var d2 = realCellToDate(cell);
					dates = [
						d1,
						addMinutes(cloneDate(d1), snapMinutes), // calculate minutes depending on selection slot minutes 
						d2,
						addMinutes(cloneDate(d2), snapMinutes)
					].sort(dateCompare);
					renderSlotSelection(dates[0], dates[3]);
				}else{
					dates = null;
				}
			}, ev);
			$(document).one('mouseup', function(ev) {
				hoverListener.stop();
				if (dates) {
					if (+dates[0] == +dates[1]) {
						reportDayClick(dates[0], false, ev);
					}
					reportSelection(dates[0], dates[3], false, ev);
				}
			});
		}
	}


	function reportDayClick(date, allDay, ev) {
		trigger('dayClick', dayBodyCells[dateToCell(date).col], date, allDay, ev);
	}
	
	
	
	/* External Dragging
	--------------------------------------------------------------------------------*/
	
	
	function dragStart(_dragElement, ev, ui) {
		hoverListener.start(function(cell) {
			clearOverlays();
			if (cell) {
				if (getIsCellAllDay(cell)) {
					renderCellOverlay(cell.row, cell.col, cell.row, cell.col);
				}else{
					var d1 = realCellToDate(cell);
					var d2 = addMinutes(cloneDate(d1), opt('defaultEventMinutes'));
					renderSlotOverlay(d1, d2);
				}
			}
		}, ev);
	}
	
	
	function dragStop(_dragElement, ev, ui) {
		var cell = hoverListener.stop();
		clearOverlays();
		if (cell) {
			trigger('drop', _dragElement, realCellToDate(cell), getIsCellAllDay(cell), ev, ui);
		}
	}
	

}

;;

function AgendaEventRenderer() {
	var t = this;
	
	
	// exports
	t.renderEvents = renderEvents;
	t.clearEvents = clearEvents;
	t.slotSegHtml = slotSegHtml;
	
	
	// imports
	DayEventRenderer.call(t);
	var opt = t.opt;
	var trigger = t.trigger;
	var isEventDraggable = t.isEventDraggable;
	var isEventResizable = t.isEventResizable;
	var eventEnd = t.eventEnd;
	var eventElementHandlers = t.eventElementHandlers;
	var setHeight = t.setHeight;
	var getDaySegmentContainer = t.getDaySegmentContainer;
	var getSlotSegmentContainer = t.getSlotSegmentContainer;
	var getHoverListener = t.getHoverListener;
	var getMaxMinute = t.getMaxMinute;
	var getMinMinute = t.getMinMinute;
	var timePosition = t.timePosition;
	var getIsCellAllDay = t.getIsCellAllDay;
	var colContentLeft = t.colContentLeft;
	var colContentRight = t.colContentRight;
	var cellToDate = t.cellToDate;
	var getColCnt = t.getColCnt;
	var getColWidth = t.getColWidth;
	var getSnapHeight = t.getSnapHeight;
	var getSnapMinutes = t.getSnapMinutes;
	var getSlotContainer = t.getSlotContainer;
	var reportEventElement = t.reportEventElement;
	var showEvents = t.showEvents;
	var hideEvents = t.hideEvents;
	var eventDrop = t.eventDrop;
	var eventResize = t.eventResize;
	var renderDayOverlay = t.renderDayOverlay;
	var clearOverlays = t.clearOverlays;
	var renderDayEvents = t.renderDayEvents;
	var calendar = t.calendar;
	var formatDate = calendar.formatDate;
	var formatDates = calendar.formatDates;


	// overrides
	t.draggableDayEvent = draggableDayEvent;

	
	
	/* Rendering
	----------------------------------------------------------------------------*/
	

	function renderEvents(events, modifiedEventId) {
		var i, len=events.length,
			dayEvents=[],
			slotEvents=[];
		for (i=0; i<len; i++) {
			if (events[i].allDay) {
				dayEvents.push(events[i]);
			}else{
				slotEvents.push(events[i]);
			}
		}

		if (opt('allDaySlot')) {
			renderDayEvents(dayEvents, modifiedEventId);
			setHeight(); // no params means set to viewHeight
		}

		renderSlotSegs(compileSlotSegs(slotEvents), modifiedEventId);
	}
	
	
	function clearEvents() {
		getDaySegmentContainer().empty();
		getSlotSegmentContainer().empty();
	}

	
	function compileSlotSegs(events) {
		var colCnt = getColCnt(),
			minMinute = getMinMinute(),
			maxMinute = getMaxMinute(),
			d,
			visEventEnds = $.map(events, slotEventEnd),
			i,
			j, seg,
			colSegs,
			segs = [];

		for (i=0; i<colCnt; i++) {

			d = cellToDate(0, i);
			addMinutes(d, minMinute);

			colSegs = sliceSegs(
				events,
				visEventEnds,
				d,
				addMinutes(cloneDate(d), maxMinute-minMinute)
			);

			colSegs = placeSlotSegs(colSegs); // returns a new order

			for (j=0; j<colSegs.length; j++) {
				seg = colSegs[j];
				seg.col = i;
				segs.push(seg);
			}
		}

		return segs;
	}


	function sliceSegs(events, visEventEnds, start, end) {
		var segs = [],
			i, len=events.length, event,
			eventStart, eventEnd,
			segStart, segEnd,
			isStart, isEnd;
		for (i=0; i<len; i++) {
			event = events[i];
			eventStart = event.start;
			eventEnd = visEventEnds[i];
			if (eventEnd > start && eventStart < end) {
				if (eventStart < start) {
					segStart = cloneDate(start);
					isStart = false;
				}else{
					segStart = eventStart;
					isStart = true;
				}
				if (eventEnd > end) {
					segEnd = cloneDate(end);
					isEnd = false;
				}else{
					segEnd = eventEnd;
					isEnd = true;
				}
				segs.push({
					event: event,
					start: segStart,
					end: segEnd,
					isStart: isStart,
					isEnd: isEnd
				});
			}
		}
		return segs.sort(compareSlotSegs);
	}


	function slotEventEnd(event) {
		if (event.end) {
			return cloneDate(event.end);
		}else{
			return addMinutes(cloneDate(event.start), opt('defaultEventMinutes'));
		}
	}
	
	
	// renders events in the 'time slots' at the bottom
	// TODO: when we refactor this, when user returns `false` eventRender, don't have empty space
	// TODO: refactor will include using pixels to detect collisions instead of dates (handy for seg cmp)
	
	function renderSlotSegs(segs, modifiedEventId) {
	
		var i, segCnt=segs.length, seg,
			event,
			top,
			bottom,
			columnLeft,
			columnRight,
			columnWidth,
			width,
			left,
			right,
			html = '',
			eventElements,
			eventElement,
			triggerRes,
			titleElement,
			height,
			slotSegmentContainer = getSlotSegmentContainer(),
			isRTL = opt('isRTL');
			
		// calculate position/dimensions, create html
		for (i=0; i<segCnt; i++) {
			seg = segs[i];
			event = seg.event;
			top = timePosition(seg.start, seg.start);
			bottom = timePosition(seg.start, seg.end);
			columnLeft = colContentLeft(seg.col);
			columnRight = colContentRight(seg.col);
			columnWidth = columnRight - columnLeft;

			// shave off space on right near scrollbars (2.5%)
			// TODO: move this to CSS somehow
			columnRight -= columnWidth * .025;
			columnWidth = columnRight - columnLeft;

			width = columnWidth * (seg.forwardCoord - seg.backwardCoord);

			if (opt('slotEventOverlap')) {
				// double the width while making sure resize handle is visible
				// (assumed to be 20px wide)
				width = Math.max(
					(width - (20/2)) * 2,
					width // narrow columns will want to make the segment smaller than
						// the natural width. don't allow it
				);
			}

			if (isRTL) {
				right = columnRight - seg.backwardCoord * columnWidth;
				left = right - width;
			}
			else {
				left = columnLeft + seg.backwardCoord * columnWidth;
				right = left + width;
			}

			// make sure horizontal coordinates are in bounds
			left = Math.max(left, columnLeft);
			right = Math.min(right, columnRight);
			width = right - left;

			seg.top = top;
			seg.left = left;
			seg.outerWidth = width;
			seg.outerHeight = bottom - top;
			html += slotSegHtml(event, seg);
		}

		slotSegmentContainer[0].innerHTML = html; // faster than html()
		eventElements = slotSegmentContainer.children();
		
		// retrieve elements, run through eventRender callback, bind event handlers
		for (i=0; i<segCnt; i++) {
			seg = segs[i];
			event = seg.event;
			eventElement = $(eventElements[i]); // faster than eq()
			triggerRes = trigger('eventRender', event, event, eventElement);
			if (triggerRes === false) {
				eventElement.remove();
			}else{
				if (triggerRes && triggerRes !== true) {
					eventElement.remove();
					eventElement = $(triggerRes)
						.css({
							position: 'absolute',
							top: seg.top,
							left: seg.left
						})
						.appendTo(slotSegmentContainer);
				}
				seg.element = eventElement;
				if (event._id === modifiedEventId) {
					bindSlotSeg(event, eventElement, seg);
				}else{
					eventElement[0]._fci = i; // for lazySegBind
				}
				reportEventElement(event, eventElement);
			}
		}
		
		lazySegBind(slotSegmentContainer, segs, bindSlotSeg);
		
		// record event sides and title positions
		for (i=0; i<segCnt; i++) {
			seg = segs[i];
			if (eventElement = seg.element) {
				seg.vsides = vsides(eventElement, true);
				seg.hsides = hsides(eventElement, true);
				titleElement = eventElement.find('.fc-event-title');
				if (titleElement.length) {
					seg.contentTop = titleElement[0].offsetTop;
				}
			}
		}
		
		// set all positions/dimensions at once
		for (i=0; i<segCnt; i++) {
			seg = segs[i];
			if (eventElement = seg.element) {
				eventElement[0].style.width = Math.max(0, seg.outerWidth - seg.hsides) + 'px';
				height = Math.max(0, seg.outerHeight - seg.vsides);
				eventElement[0].style.height = height + 'px';
				event = seg.event;
				if (seg.contentTop !== undefined && height - seg.contentTop < 10) {
					// not enough room for title, put it in the time (TODO: maybe make both display:inline instead)
					eventElement.find('div.fc-event-time')
						.text(formatDate(event.start, opt('timeFormat')) + ' - ' + event.title);
					eventElement.find('div.fc-event-title')
						.remove();
				}
				trigger('eventAfterRender', event, event, eventElement);
			}
		}
					
	}
	
	
	function slotSegHtml(event, seg) {
		var html = "<";
		var url = event.url;
		var skinCss = getSkinCss(event, opt);
		var classes = ['fc-event', 'fc-event-vert'];
		if (isEventDraggable(event)) {
			classes.push('fc-event-draggable');
		}
		if (seg.isStart) {
			classes.push('fc-event-start');
		}
		if (seg.isEnd) {
			classes.push('fc-event-end');
		}
		classes = classes.concat(event.className);
		if (event.source) {
			classes = classes.concat(event.source.className || []);
		}
		if (url) {
			html += "a href='" + htmlEscape(event.url) + "'";
		}else{
			html += "div";
		}
		html +=
			" class='" + classes.join(' ') + "'" +
			" style=" +
				"'" +
				"position:absolute;" +
				"top:" + seg.top + "px;" +
				"left:" + seg.left + "px;" +
				skinCss +
				"'" +
			">" +
			"<div class='fc-event-inner'>" +
			"<div class='fc-event-time'>" +
			htmlEscape(formatDates(event.start, event.end, opt('timeFormat'))) +
			"</div>" +
			"<div class='fc-event-title'>" +
			htmlEscape(event.title || '') +
			"</div>" +
			"</div>" +
			"<div class='fc-event-bg'></div>";
		if (seg.isEnd && isEventResizable(event)) {
			html +=
				"<div class='ui-resizable-handle ui-resizable-s'>=</div>";
		}
		html +=
			"</" + (url ? "a" : "div") + ">";
		return html;
	}
	
	
	function bindSlotSeg(event, eventElement, seg) {
		var timeElement = eventElement.find('div.fc-event-time');
		if (isEventDraggable(event)) {
			draggableSlotEvent(event, eventElement, timeElement);
		}
		if (seg.isEnd && isEventResizable(event)) {
			resizableSlotEvent(event, eventElement, timeElement);
		}
		eventElementHandlers(event, eventElement);
	}
	
	
	
	/* Dragging
	-----------------------------------------------------------------------------------*/
	
	
	// when event starts out FULL-DAY
	// overrides DayEventRenderer's version because it needs to account for dragging elements
	// to and from the slot area.
	
	function draggableDayEvent(event, eventElement, seg) {
		var isStart = seg.isStart;
		var origWidth;
		var revert;
		var allDay = true;
		var dayDelta;
		var hoverListener = getHoverListener();
		var colWidth = getColWidth();
		var snapHeight = getSnapHeight();
		var snapMinutes = getSnapMinutes();
		var minMinute = getMinMinute();
		eventElement.draggable({
			opacity: opt('dragOpacity', 'month'), // use whatever the month view was using
			revertDuration: opt('dragRevertDuration'),
			start: function(ev, ui) {
				trigger('eventDragStart', eventElement, event, ev, ui);
				hideEvents(event, eventElement);
				origWidth = eventElement.width();
				hoverListener.start(function(cell, origCell) {
					clearOverlays();
					if (cell) {
						revert = false;
						var origDate = cellToDate(0, origCell.col);
						var date = cellToDate(0, cell.col);
						dayDelta = dayDiff(date, origDate);
						if (!cell.row) {
							// on full-days
							renderDayOverlay(
								addDays(cloneDate(event.start), dayDelta),
								addDays(exclEndDay(event), dayDelta)
							);
							resetElement();
						}else{
							// mouse is over bottom slots
							if (isStart) {
								if (allDay) {
									// convert event to temporary slot-event
									eventElement.width(colWidth - 10); // don't use entire width
									setOuterHeight(
										eventElement,
										snapHeight * Math.round(
											(event.end ? ((event.end - event.start) / MINUTE_MS) : opt('defaultEventMinutes')) /
												snapMinutes
										)
									);
									eventElement.draggable('option', 'grid', [colWidth, 1]);
									allDay = false;
								}
							}else{
								revert = true;
							}
						}
						revert = revert || (allDay && !dayDelta);
					}else{
						resetElement();
						revert = true;
					}
					eventElement.draggable('option', 'revert', revert);
				}, ev, 'drag');
			},
			stop: function(ev, ui) {
				hoverListener.stop();
				clearOverlays();
				trigger('eventDragStop', eventElement, event, ev, ui);
				if (revert) {
					// hasn't moved or is out of bounds (draggable has already reverted)
					resetElement();
					eventElement.css('filter', ''); // clear IE opacity side-effects
					showEvents(event, eventElement);
				}else{
					// changed!
					var minuteDelta = 0;
					if (!allDay) {
						minuteDelta = Math.round((eventElement.offset().top - getSlotContainer().offset().top) / snapHeight)
							* snapMinutes
							+ minMinute
							- (event.start.getHours() * 60 + event.start.getMinutes());
					}
					eventDrop(this, event, dayDelta, minuteDelta, allDay, ev, ui);
				}
			}
		});
		function resetElement() {
			if (!allDay) {
				eventElement
					.width(origWidth)
					.height('')
					.draggable('option', 'grid', null);
				allDay = true;
			}
		}
	}
	
	
	// when event starts out IN TIMESLOTS
	
	function draggableSlotEvent(event, eventElement, timeElement) {
		var coordinateGrid = t.getCoordinateGrid();
		var colCnt = getColCnt();
		var colWidth = getColWidth();
		var snapHeight = getSnapHeight();
		var snapMinutes = getSnapMinutes();

		// states
		var origPosition; // original position of the element, not the mouse
		var origCell;
		var isInBounds, prevIsInBounds;
		var isAllDay, prevIsAllDay;
		var colDelta, prevColDelta;
		var dayDelta; // derived from colDelta
		var minuteDelta, prevMinuteDelta;

		eventElement.draggable({
			scroll: false,
			grid: [ colWidth, snapHeight ],
			axis: colCnt==1 ? 'y' : false,
			opacity: opt('dragOpacity'),
			revertDuration: opt('dragRevertDuration'),
			start: function(ev, ui) {

				trigger('eventDragStart', eventElement, event, ev, ui);
				hideEvents(event, eventElement);

				coordinateGrid.build();

				// initialize states
				origPosition = eventElement.position();
				origCell = coordinateGrid.cell(ev.pageX, ev.pageY);
				isInBounds = prevIsInBounds = true;
				isAllDay = prevIsAllDay = getIsCellAllDay(origCell);
				colDelta = prevColDelta = 0;
				dayDelta = 0;
				minuteDelta = prevMinuteDelta = 0;

			},
			drag: function(ev, ui) {

				// NOTE: this `cell` value is only useful for determining in-bounds and all-day.
				// Bad for anything else due to the discrepancy between the mouse position and the
				// element position while snapping. (problem revealed in PR #55)
				//
				// PS- the problem exists for draggableDayEvent() when dragging an all-day event to a slot event.
				// We should overhaul the dragging system and stop relying on jQuery UI.
				var cell = coordinateGrid.cell(ev.pageX, ev.pageY);

				// update states
				isInBounds = !!cell;
				if (isInBounds) {
					isAllDay = getIsCellAllDay(cell);

					// calculate column delta
					colDelta = Math.round((ui.position.left - origPosition.left) / colWidth);
					if (colDelta != prevColDelta) {
						// calculate the day delta based off of the original clicked column and the column delta
						var origDate = cellToDate(0, origCell.col);
						var col = origCell.col + colDelta;
						col = Math.max(0, col);
						col = Math.min(colCnt-1, col);
						var date = cellToDate(0, col);
						dayDelta = dayDiff(date, origDate);
					}

					// calculate minute delta (only if over slots)
					if (!isAllDay) {
						minuteDelta = Math.round((ui.position.top - origPosition.top) / snapHeight) * snapMinutes;
					}
				}

				// any state changes?
				if (
					isInBounds != prevIsInBounds ||
					isAllDay != prevIsAllDay ||
					colDelta != prevColDelta ||
					minuteDelta != prevMinuteDelta
				) {

					updateUI();

					// update previous states for next time
					prevIsInBounds = isInBounds;
					prevIsAllDay = isAllDay;
					prevColDelta = colDelta;
					prevMinuteDelta = minuteDelta;
				}

				// if out-of-bounds, revert when done, and vice versa.
				eventElement.draggable('option', 'revert', !isInBounds);

			},
			stop: function(ev, ui) {

				clearOverlays();
				trigger('eventDragStop', eventElement, event, ev, ui);

				if (isInBounds && (isAllDay || dayDelta || minuteDelta)) { // changed!
					eventDrop(this, event, dayDelta, isAllDay ? 0 : minuteDelta, isAllDay, ev, ui);
				}
				else { // either no change or out-of-bounds (draggable has already reverted)

					// reset states for next time, and for updateUI()
					isInBounds = true;
					isAllDay = false;
					colDelta = 0;
					dayDelta = 0;
					minuteDelta = 0;

					updateUI();
					eventElement.css('filter', ''); // clear IE opacity side-effects

					// sometimes fast drags make event revert to wrong position, so reset.
					// also, if we dragged the element out of the area because of snapping,
					// but the *mouse* is still in bounds, we need to reset the position.
					eventElement.css(origPosition);

					showEvents(event, eventElement);
				}
			}
		});

		function updateUI() {
			clearOverlays();
			if (isInBounds) {
				if (isAllDay) {
					timeElement.hide();
					eventElement.draggable('option', 'grid', null); // disable grid snapping
					renderDayOverlay(
						addDays(cloneDate(event.start), dayDelta),
						addDays(exclEndDay(event), dayDelta)
					);
				}
				else {
					updateTimeText(minuteDelta);
					timeElement.css('display', ''); // show() was causing display=inline
					eventElement.draggable('option', 'grid', [colWidth, snapHeight]); // re-enable grid snapping
				}
			}
		}

		function updateTimeText(minuteDelta) {
			var newStart = addMinutes(cloneDate(event.start), minuteDelta);
			var newEnd;
			if (event.end) {
				newEnd = addMinutes(cloneDate(event.end), minuteDelta);
			}
			timeElement.text(formatDates(newStart, newEnd, opt('timeFormat')));
		}

	}
	
	
	
	/* Resizing
	--------------------------------------------------------------------------------------*/
	
	
	function resizableSlotEvent(event, eventElement, timeElement) {
		var snapDelta, prevSnapDelta;
		var snapHeight = getSnapHeight();
		var snapMinutes = getSnapMinutes();
		eventElement.resizable({
			handles: {
				s: '.ui-resizable-handle'
			},
			grid: snapHeight,
			start: function(ev, ui) {
				snapDelta = prevSnapDelta = 0;
				hideEvents(event, eventElement);
				trigger('eventResizeStart', this, event, ev, ui);
			},
			resize: function(ev, ui) {
				// don't rely on ui.size.height, doesn't take grid into account
				snapDelta = Math.round((Math.max(snapHeight, eventElement.height()) - ui.originalSize.height) / snapHeight);
				if (snapDelta != prevSnapDelta) {
					timeElement.text(
						formatDates(
							event.start,
							(!snapDelta && !event.end) ? null : // no change, so don't display time range
								addMinutes(eventEnd(event), snapMinutes*snapDelta),
							opt('timeFormat')
						)
					);
					prevSnapDelta = snapDelta;
				}
			},
			stop: function(ev, ui) {
				trigger('eventResizeStop', this, event, ev, ui);
				if (snapDelta) {
					eventResize(this, event, 0, snapMinutes*snapDelta, ev, ui);
				}else{
					showEvents(event, eventElement);
					// BUG: if event was really short, need to put title back in span
				}
			}
		});
	}
	

}



/* Agenda Event Segment Utilities
-----------------------------------------------------------------------------*/


// Sets the seg.backwardCoord and seg.forwardCoord on each segment and returns a new
// list in the order they should be placed into the DOM (an implicit z-index).
function placeSlotSegs(segs) {
	var levels = buildSlotSegLevels(segs);
	var level0 = levels[0];
	var i;

	computeForwardSlotSegs(levels);

	if (level0) {

		for (i=0; i<level0.length; i++) {
			computeSlotSegPressures(level0[i]);
		}

		for (i=0; i<level0.length; i++) {
			computeSlotSegCoords(level0[i], 0, 0);
		}
	}

	return flattenSlotSegLevels(levels);
}


// Builds an array of segments "levels". The first level will be the leftmost tier of segments
// if the calendar is left-to-right, or the rightmost if the calendar is right-to-left.
function buildSlotSegLevels(segs) {
	var levels = [];
	var i, seg;
	var j;

	for (i=0; i<segs.length; i++) {
		seg = segs[i];

		// go through all the levels and stop on the first level where there are no collisions
		for (j=0; j<levels.length; j++) {
			if (!computeSlotSegCollisions(seg, levels[j]).length) {
				break;
			}
		}

		(levels[j] || (levels[j] = [])).push(seg);
	}

	return levels;
}


// For every segment, figure out the other segments that are in subsequent
// levels that also occupy the same vertical space. Accumulate in seg.forwardSegs
function computeForwardSlotSegs(levels) {
	var i, level;
	var j, seg;
	var k;

	for (i=0; i<levels.length; i++) {
		level = levels[i];

		for (j=0; j<level.length; j++) {
			seg = level[j];

			seg.forwardSegs = [];
			for (k=i+1; k<levels.length; k++) {
				computeSlotSegCollisions(seg, levels[k], seg.forwardSegs);
			}
		}
	}
}


// Figure out which path forward (via seg.forwardSegs) results in the longest path until
// the furthest edge is reached. The number of segments in this path will be seg.forwardPressure
function computeSlotSegPressures(seg) {
	var forwardSegs = seg.forwardSegs;
	var forwardPressure = 0;
	var i, forwardSeg;

	if (seg.forwardPressure === undefined) { // not already computed

		for (i=0; i<forwardSegs.length; i++) {
			forwardSeg = forwardSegs[i];

			// figure out the child's maximum forward path
			computeSlotSegPressures(forwardSeg);

			// either use the existing maximum, or use the child's forward pressure
			// plus one (for the forwardSeg itself)
			forwardPressure = Math.max(
				forwardPressure,
				1 + forwardSeg.forwardPressure
			);
		}

		seg.forwardPressure = forwardPressure;
	}
}


// Calculate seg.forwardCoord and seg.backwardCoord for the segment, where both values range
// from 0 to 1. If the calendar is left-to-right, the seg.backwardCoord maps to "left" and
// seg.forwardCoord maps to "right" (via percentage). Vice-versa if the calendar is right-to-left.
//
// The segment might be part of a "series", which means consecutive segments with the same pressure
// who's width is unknown until an edge has been hit. `seriesBackwardPressure` is the number of
// segments behind this one in the current series, and `seriesBackwardCoord` is the starting
// coordinate of the first segment in the series.
function computeSlotSegCoords(seg, seriesBackwardPressure, seriesBackwardCoord) {
	var forwardSegs = seg.forwardSegs;
	var i;

	if (seg.forwardCoord === undefined) { // not already computed

		if (!forwardSegs.length) {

			// if there are no forward segments, this segment should butt up against the edge
			seg.forwardCoord = 1;
		}
		else {

			// sort highest pressure first
			forwardSegs.sort(compareForwardSlotSegs);

			// this segment's forwardCoord will be calculated from the backwardCoord of the
			// highest-pressure forward segment.
			computeSlotSegCoords(forwardSegs[0], seriesBackwardPressure + 1, seriesBackwardCoord);
			seg.forwardCoord = forwardSegs[0].backwardCoord;
		}

		// calculate the backwardCoord from the forwardCoord. consider the series
		seg.backwardCoord = seg.forwardCoord -
			(seg.forwardCoord - seriesBackwardCoord) / // available width for series
			(seriesBackwardPressure + 1); // # of segments in the series

		// use this segment's coordinates to computed the coordinates of the less-pressurized
		// forward segments
		for (i=0; i<forwardSegs.length; i++) {
			computeSlotSegCoords(forwardSegs[i], 0, seg.forwardCoord);
		}
	}
}


// Outputs a flat array of segments, from lowest to highest level
function flattenSlotSegLevels(levels) {
	var segs = [];
	var i, level;
	var j;

	for (i=0; i<levels.length; i++) {
		level = levels[i];

		for (j=0; j<level.length; j++) {
			segs.push(level[j]);
		}
	}

	return segs;
}


// Find all the segments in `otherSegs` that vertically collide with `seg`.
// Append into an optionally-supplied `results` array and return.
function computeSlotSegCollisions(seg, otherSegs, results) {
	results = results || [];

	for (var i=0; i<otherSegs.length; i++) {
		if (isSlotSegCollision(seg, otherSegs[i])) {
			results.push(otherSegs[i]);
		}
	}

	return results;
}


// Do these segments occupy the same vertical space?
function isSlotSegCollision(seg1, seg2) {
	return seg1.end > seg2.start && seg1.start < seg2.end;
}


// A cmp function for determining which forward segment to rely on more when computing coordinates.
function compareForwardSlotSegs(seg1, seg2) {
	// put higher-pressure first
	return seg2.forwardPressure - seg1.forwardPressure ||
		// put segments that are closer to initial edge first (and favor ones with no coords yet)
		(seg1.backwardCoord || 0) - (seg2.backwardCoord || 0) ||
		// do normal sorting...
		compareSlotSegs(seg1, seg2);
}


// A cmp function for determining which segment should be closer to the initial edge
// (the left edge on a left-to-right calendar).
function compareSlotSegs(seg1, seg2) {
	return seg1.start - seg2.start || // earlier start time goes first
		(seg2.end - seg2.start) - (seg1.end - seg1.start) || // tie? longer-duration goes first
		(seg1.event.title || '').localeCompare(seg2.event.title); // tie? alphabetically by title
}


;;


function View(element, calendar, viewName) {
	var t = this;
	
	
	// exports
	t.element = element;
	t.calendar = calendar;
	t.name = viewName;
	t.opt = opt;
	t.trigger = trigger;
	t.isEventDraggable = isEventDraggable;
	t.isEventResizable = isEventResizable;
	t.setEventData = setEventData;
	t.clearEventData = clearEventData;
	t.eventEnd = eventEnd;
	t.reportEventElement = reportEventElement;
	t.triggerEventDestroy = triggerEventDestroy;
	t.eventElementHandlers = eventElementHandlers;
	t.showEvents = showEvents;
	t.hideEvents = hideEvents;
	t.eventDrop = eventDrop;
	t.eventResize = eventResize;
	// t.title
	// t.start, t.end
	// t.visStart, t.visEnd
	
	
	// imports
	var defaultEventEnd = t.defaultEventEnd;
	var normalizeEvent = calendar.normalizeEvent; // in EventManager
	var reportEventChange = calendar.reportEventChange;
	
	
	// locals
	var eventsByID = {}; // eventID mapped to array of events (there can be multiple b/c of repeating events)
	var eventElementsByID = {}; // eventID mapped to array of jQuery elements
	var eventElementCouples = []; // array of objects, { event, element } // TODO: unify with segment system
	var options = calendar.options;
	
	
	
	function opt(name, viewNameOverride) {
		var v = options[name];
		if ($.isPlainObject(v)) {
			return smartProperty(v, viewNameOverride || viewName);
		}
		return v;
	}

	
	function trigger(name, thisObj) {
		return calendar.trigger.apply(
			calendar,
			[name, thisObj || t].concat(Array.prototype.slice.call(arguments, 2), [t])
		);
	}
	


	/* Event Editable Boolean Calculations
	------------------------------------------------------------------------------*/

	
	function isEventDraggable(event) {
		var source = event.source || {};
		return firstDefined(
				event.startEditable,
				source.startEditable,
				opt('eventStartEditable'),
				event.editable,
				source.editable,
				opt('editable')
			)
			&& !opt('disableDragging'); // deprecated
	}
	
	
	function isEventResizable(event) { // but also need to make sure the seg.isEnd == true
		var source = event.source || {};
		return firstDefined(
				event.durationEditable,
				source.durationEditable,
				opt('eventDurationEditable'),
				event.editable,
				source.editable,
				opt('editable')
			)
			&& !opt('disableResizing'); // deprecated
	}
	
	
	
	/* Event Data
	------------------------------------------------------------------------------*/
	
	
	function setEventData(events) { // events are already normalized at this point
		eventsByID = {};
		var i, len=events.length, event;
		for (i=0; i<len; i++) {
			event = events[i];
			if (eventsByID[event._id]) {
				eventsByID[event._id].push(event);
			}else{
				eventsByID[event._id] = [event];
			}
		}
	}


	function clearEventData() {
		eventsByID = {};
		eventElementsByID = {};
		eventElementCouples = [];
	}
	
	
	// returns a Date object for an event's end
	function eventEnd(event) {
		return event.end ? cloneDate(event.end) : defaultEventEnd(event);
	}
	
	
	
	/* Event Elements
	------------------------------------------------------------------------------*/
	
	
	// report when view creates an element for an event
	function reportEventElement(event, element) {
		eventElementCouples.push({ event: event, element: element });
		if (eventElementsByID[event._id]) {
			eventElementsByID[event._id].push(element);
		}else{
			eventElementsByID[event._id] = [element];
		}
	}


	function triggerEventDestroy() {
		$.each(eventElementCouples, function(i, couple) {
			t.trigger('eventDestroy', couple.event, couple.event, couple.element);
		});
	}
	
	
	// attaches eventClick, eventMouseover, eventMouseout
	function eventElementHandlers(event, eventElement) {
		eventElement
			.click(function(ev) {
				if (!eventElement.hasClass('ui-draggable-dragging') &&
					!eventElement.hasClass('ui-resizable-resizing')) {
						return trigger('eventClick', this, event, ev);
					}
			})
			.hover(
				function(ev) {
					trigger('eventMouseover', this, event, ev);
				},
				function(ev) {
					trigger('eventMouseout', this, event, ev);
				}
			);
		// TODO: don't fire eventMouseover/eventMouseout *while* dragging is occuring (on subject element)
		// TODO: same for resizing
	}
	
	
	function showEvents(event, exceptElement) {
		eachEventElement(event, exceptElement, 'show');
	}
	
	
	function hideEvents(event, exceptElement) {
		eachEventElement(event, exceptElement, 'hide');
	}
	
	
	function eachEventElement(event, exceptElement, funcName) {
		// NOTE: there may be multiple events per ID (repeating events)
		// and multiple segments per event
		var elements = eventElementsByID[event._id],
			i, len = elements.length;
		for (i=0; i<len; i++) {
			if (!exceptElement || elements[i][0] != exceptElement[0]) {
				elements[i][funcName]();
			}
		}
	}
	
	
	
	/* Event Modification Reporting
	---------------------------------------------------------------------------------*/
	
	
	function eventDrop(e, event, dayDelta, minuteDelta, allDay, ev, ui) {
		var oldAllDay = event.allDay;
		var eventId = event._id;
		moveEvents(eventsByID[eventId], dayDelta, minuteDelta, allDay);
		trigger(
			'eventDrop',
			e,
			event,
			dayDelta,
			minuteDelta,
			allDay,
			function() {
				// TODO: investigate cases where this inverse technique might not work
				moveEvents(eventsByID[eventId], -dayDelta, -minuteDelta, oldAllDay);
				reportEventChange(eventId);
			},
			ev,
			ui
		);
		reportEventChange(eventId);
	}
	
	
	function eventResize(e, event, dayDelta, minuteDelta, ev, ui) {
		var eventId = event._id;
		elongateEvents(eventsByID[eventId], dayDelta, minuteDelta);
		trigger(
			'eventResize',
			e,
			event,
			dayDelta,
			minuteDelta,
			function() {
				// TODO: investigate cases where this inverse technique might not work
				elongateEvents(eventsByID[eventId], -dayDelta, -minuteDelta);
				reportEventChange(eventId);
			},
			ev,
			ui
		);
		reportEventChange(eventId);
	}
	
	
	
	/* Event Modification Math
	---------------------------------------------------------------------------------*/
	
	
	function moveEvents(events, dayDelta, minuteDelta, allDay) {
		minuteDelta = minuteDelta || 0;
		for (var e, len=events.length, i=0; i<len; i++) {
			e = events[i];
			if (allDay !== undefined) {
				e.allDay = allDay;
			}
			addMinutes(addDays(e.start, dayDelta, true), minuteDelta);
			if (e.end) {
				e.end = addMinutes(addDays(e.end, dayDelta, true), minuteDelta);
			}
			normalizeEvent(e, options);
		}
	}
	
	
	function elongateEvents(events, dayDelta, minuteDelta) {
		minuteDelta = minuteDelta || 0;
		for (var e, len=events.length, i=0; i<len; i++) {
			e = events[i];
			e.end = addMinutes(addDays(eventEnd(e), dayDelta, true), minuteDelta);
			normalizeEvent(e, options);
		}
	}



	// ====================================================================================================
	// Utilities for day "cells"
	// ====================================================================================================
	// The "basic" views are completely made up of day cells.
	// The "agenda" views have day cells at the top "all day" slot.
	// This was the obvious common place to put these utilities, but they should be abstracted out into
	// a more meaningful class (like DayEventRenderer).
	// ====================================================================================================


	// For determining how a given "cell" translates into a "date":
	//
	// 1. Convert the "cell" (row and column) into a "cell offset" (the # of the cell, cronologically from the first).
	//    Keep in mind that column indices are inverted with isRTL. This is taken into account.
	//
	// 2. Convert the "cell offset" to a "day offset" (the # of days since the first visible day in the view).
	//
	// 3. Convert the "day offset" into a "date" (a JavaScript Date object).
	//
	// The reverse transformation happens when transforming a date into a cell.


	// exports
	t.isHiddenDay = isHiddenDay;
	t.skipHiddenDays = skipHiddenDays;
	t.getCellsPerWeek = getCellsPerWeek;
	t.dateToCell = dateToCell;
	t.dateToDayOffset = dateToDayOffset;
	t.dayOffsetToCellOffset = dayOffsetToCellOffset;
	t.cellOffsetToCell = cellOffsetToCell;
	t.cellToDate = cellToDate;
	t.cellToCellOffset = cellToCellOffset;
	t.cellOffsetToDayOffset = cellOffsetToDayOffset;
	t.dayOffsetToDate = dayOffsetToDate;
	t.rangeToSegments = rangeToSegments;


	// internals
	var hiddenDays = opt('hiddenDays') || []; // array of day-of-week indices that are hidden
	var isHiddenDayHash = []; // is the day-of-week hidden? (hash with day-of-week-index -> bool)
	var cellsPerWeek;
	var dayToCellMap = []; // hash from dayIndex -> cellIndex, for one week
	var cellToDayMap = []; // hash from cellIndex -> dayIndex, for one week
	var isRTL = opt('isRTL');


	// initialize important internal variables
	(function() {

		if (opt('weekends') === false) {
			hiddenDays.push(0, 6); // 0=sunday, 6=saturday
		}

		// Loop through a hypothetical week and determine which
		// days-of-week are hidden. Record in both hashes (one is the reverse of the other).
		for (var dayIndex=0, cellIndex=0; dayIndex<7; dayIndex++) {
			dayToCellMap[dayIndex] = cellIndex;
			isHiddenDayHash[dayIndex] = $.inArray(dayIndex, hiddenDays) != -1;
			if (!isHiddenDayHash[dayIndex]) {
				cellToDayMap[cellIndex] = dayIndex;
				cellIndex++;
			}
		}

		cellsPerWeek = cellIndex;
		if (!cellsPerWeek) {
			throw 'invalid hiddenDays'; // all days were hidden? bad.
		}

	})();


	// Is the current day hidden?
	// `day` is a day-of-week index (0-6), or a Date object
	function isHiddenDay(day) {
		if (typeof day == 'object') {
			day = day.getDay();
		}
		return isHiddenDayHash[day];
	}


	function getCellsPerWeek() {
		return cellsPerWeek;
	}


	// Keep incrementing the current day until it is no longer a hidden day.
	// If the initial value of `date` is not a hidden day, don't do anything.
	// Pass `isExclusive` as `true` if you are dealing with an end date.
	// `inc` defaults to `1` (increment one day forward each time)
	function skipHiddenDays(date, inc, isExclusive) {
		inc = inc || 1;
		while (
			isHiddenDayHash[ ( date.getDay() + (isExclusive ? inc : 0) + 7 ) % 7 ]
		) {
			addDays(date, inc);
		}
	}


	//
	// TRANSFORMATIONS: cell -> cell offset -> day offset -> date
	//

	// cell -> date (combines all transformations)
	// Possible arguments:
	// - row, col
	// - { row:#, col: # }
	function cellToDate() {
		var cellOffset = cellToCellOffset.apply(null, arguments);
		var dayOffset = cellOffsetToDayOffset(cellOffset);
		var date = dayOffsetToDate(dayOffset);
		return date;
	}

	// cell -> cell offset
	// Possible arguments:
	// - row, col
	// - { row:#, col:# }
	function cellToCellOffset(row, col) {
		var colCnt = t.getColCnt();

		// rtl variables. wish we could pre-populate these. but where?
		var dis = isRTL ? -1 : 1;
		var dit = isRTL ? colCnt - 1 : 0;

		if (typeof row == 'object') {
			col = row.col;
			row = row.row;
		}
		var cellOffset = row * colCnt + (col * dis + dit); // column, adjusted for RTL (dis & dit)

		return cellOffset;
	}

	// cell offset -> day offset
	function cellOffsetToDayOffset(cellOffset) {
		var day0 = t.visStart.getDay(); // first date's day of week
		cellOffset += dayToCellMap[day0]; // normlize cellOffset to beginning-of-week
		return Math.floor(cellOffset / cellsPerWeek) * 7 // # of days from full weeks
			+ cellToDayMap[ // # of days from partial last week
				(cellOffset % cellsPerWeek + cellsPerWeek) % cellsPerWeek // crazy math to handle negative cellOffsets
			]
			- day0; // adjustment for beginning-of-week normalization
	}

	// day offset -> date (JavaScript Date object)
	function dayOffsetToDate(dayOffset) {
		var date = cloneDate(t.visStart);
		addDays(date, dayOffset);
		return date;
	}


	//
	// TRANSFORMATIONS: date -> day offset -> cell offset -> cell
	//

	// date -> cell (combines all transformations)
	function dateToCell(date) {
		var dayOffset = dateToDayOffset(date);
		var cellOffset = dayOffsetToCellOffset(dayOffset);
		var cell = cellOffsetToCell(cellOffset);
		return cell;
	}

	// date -> day offset
	function dateToDayOffset(date) {
		return dayDiff(date, t.visStart);
	}

	// day offset -> cell offset
	function dayOffsetToCellOffset(dayOffset) {
		var day0 = t.visStart.getDay(); // first date's day of week
		dayOffset += day0; // normalize dayOffset to beginning-of-week
		return Math.floor(dayOffset / 7) * cellsPerWeek // # of cells from full weeks
			+ dayToCellMap[ // # of cells from partial last week
				(dayOffset % 7 + 7) % 7 // crazy math to handle negative dayOffsets
			]
			- dayToCellMap[day0]; // adjustment for beginning-of-week normalization
	}

	// cell offset -> cell (object with row & col keys)
	function cellOffsetToCell(cellOffset) {
		var colCnt = t.getColCnt();

		// rtl variables. wish we could pre-populate these. but where?
		var dis = isRTL ? -1 : 1;
		var dit = isRTL ? colCnt - 1 : 0;

		var row = Math.floor(cellOffset / colCnt);
		var col = ((cellOffset % colCnt + colCnt) % colCnt) * dis + dit; // column, adjusted for RTL (dis & dit)
		return {
			row: row,
			col: col
		};
	}

	//
	// Converts a date range into an array of segment objects.
	// "Segments" are horizontal stretches of time, sliced up by row.
	// A segment object has the following properties:
	// - row
	// - cols
	// - isStart
	// - isEnd
	//
	function rangeToSegments(startDate, endDate, ev) {
		var rowCnt = t.getRowCnt();
		var colCnt = t.getColCnt();
		var segments = []; // array of segments to return
		// day offset for given date range
		var rangeDayOffsetStart = dateToDayOffset(startDate);
		var rangeDayOffsetEnd = dateToDayOffset(endDate); // exclusive

		//RHC START
		//2.01 already supports nextDayThreshold, but we are not moving yet to 2.01
		// the original supports minutes
		nextDayThreshold  = options.nextDayThreshold && ''!=options.nextDayThreshold ? parseInt(options.nextDayThreshold) : false;
		if( ev && ev.end && ev.end.getHours && false!==nextDayThreshold && (rangeDayOffsetEnd-rangeDayOffsetStart)>1 ){		
			if( ev.end.getHours() <= nextDayThreshold ){
				rangeDayOffsetEnd = rangeDayOffsetEnd - 1 ;
			}	
		}
		//RHC END
		
		// first and last cell offset for the given date range
		// "last" implies inclusivity
		var rangeCellOffsetFirst = dayOffsetToCellOffset(rangeDayOffsetStart);
		var rangeCellOffsetLast = dayOffsetToCellOffset(rangeDayOffsetEnd) - 1;

		// loop through all the rows in the view
		for (var row=0; row<rowCnt; row++) {

			// first and last cell offset for the row
			var rowCellOffsetFirst = row * colCnt;
			var rowCellOffsetLast = rowCellOffsetFirst + colCnt - 1;

			// get the segment's cell offsets by constraining the range's cell offsets to the bounds of the row
			var segmentCellOffsetFirst = Math.max(rangeCellOffsetFirst, rowCellOffsetFirst);
			var segmentCellOffsetLast = Math.min(rangeCellOffsetLast, rowCellOffsetLast);

			// make sure segment's offsets are valid and in view
			if (segmentCellOffsetFirst <= segmentCellOffsetLast) {

				// translate to cells
				var segmentCellFirst = cellOffsetToCell(segmentCellOffsetFirst);
				var segmentCellLast = cellOffsetToCell(segmentCellOffsetLast);

				// view might be RTL, so order by leftmost column
				var cols = [ segmentCellFirst.col, segmentCellLast.col ].sort();

				// Determine if segment's first/last cell is the beginning/end of the date range.
				// We need to compare "day offset" because "cell offsets" are often ambiguous and
				// can translate to multiple days, and an edge case reveals itself when we the
				// range's first cell is hidden (we don't want isStart to be true).
				var isStart = cellOffsetToDayOffset(segmentCellOffsetFirst) == rangeDayOffsetStart;
				var isEnd = cellOffsetToDayOffset(segmentCellOffsetLast) + 1 == rangeDayOffsetEnd; // +1 for comparing exclusively

				segments.push({
					row: row,
					leftCol: cols[0],
					rightCol: cols[1],
					isStart: isStart,
					isEnd: isEnd
				});
			}
		}
		/* RHC START */
		if( $(t.element).parents('.rhcalendar.not-widget').hasClass('fc-small') ){
			new_segments = [];
			$.each(segments,function(i,row){
				leftCol = row.leftCol;
				rightCol = row.rightCol;
				if(leftCol<rightCol){
					for(a=leftCol; a<=rightCol; a++){
						var new_row = jQuery.extend({}, row);
						new_row.leftCol = a;
						new_row.rightCol = a;				
						new_segments.push(new_row);
					}
				}else{
					new_segments.push(row);
				}
			});
			return new_segments;
		}
		/* RHC END */   
		return segments;
	}
	

}

;;

function DayEventRenderer() {
	var t = this;

	
	// exports
	t.renderDayEvents = renderDayEvents;
	t.draggableDayEvent = draggableDayEvent; // made public so that subclasses can override
	t.resizableDayEvent = resizableDayEvent; // "
	
	
	// imports
	var opt = t.opt;
	var trigger = t.trigger;
	var isEventDraggable = t.isEventDraggable;
	var isEventResizable = t.isEventResizable;
	var eventEnd = t.eventEnd;
	var reportEventElement = t.reportEventElement;
	var eventElementHandlers = t.eventElementHandlers;
	var showEvents = t.showEvents;
	var hideEvents = t.hideEvents;
	var eventDrop = t.eventDrop;
	var eventResize = t.eventResize;
	var getRowCnt = t.getRowCnt;
	var getColCnt = t.getColCnt;
	var getColWidth = t.getColWidth;
	var allDayRow = t.allDayRow; // TODO: rename
	var colLeft = t.colLeft;
	var colRight = t.colRight;
	var colContentLeft = t.colContentLeft;
	var colContentRight = t.colContentRight;
	var dateToCell = t.dateToCell;
	var getDaySegmentContainer = t.getDaySegmentContainer;
	var formatDates = t.calendar.formatDates;
	var renderDayOverlay = t.renderDayOverlay;
	var clearOverlays = t.clearOverlays;
	var clearSelection = t.clearSelection;
	var getHoverListener = t.getHoverListener;
	var rangeToSegments = t.rangeToSegments;
	var cellToDate = t.cellToDate;
	var cellToCellOffset = t.cellToCellOffset;
	var cellOffsetToDayOffset = t.cellOffsetToDayOffset;
	var dateToDayOffset = t.dateToDayOffset;
	var dayOffsetToCellOffset = t.dayOffsetToCellOffset;


	// Render `events` onto the calendar, attach mouse event handlers, and call the `eventAfterRender` callback for each.
	// Mouse event will be lazily applied, except if the event has an ID of `modifiedEventId`.
	// Can only be called when the event container is empty (because it wipes out all innerHTML).
	function renderDayEvents(events, modifiedEventId) {

		// do the actual rendering. Receive the intermediate "segment" data structures.
		var segments = _renderDayEvents(
			events,
			false, // don't append event elements
			true // set the heights of the rows
		);

		// report the elements to the View, for general drag/resize utilities
		segmentElementEach(segments, function(segment, element) {
			reportEventElement(segment.event, element);
		});

		// attach mouse handlers
		attachHandlers(segments, modifiedEventId);

		// call `eventAfterRender` callback for each event
		segmentElementEach(segments, function(segment, element) {
			trigger('eventAfterRender', segment.event, segment.event, element);
		});
	}


	// Render an event on the calendar, but don't report them anywhere, and don't attach mouse handlers.
	// Append this event element to the event container, which might already be populated with events.
	// If an event's segment will have row equal to `adjustRow`, then explicitly set its top coordinate to `adjustTop`.
	// This hack is used to maintain continuity when user is manually resizing an event.
	// Returns an array of DOM elements for the event.
	function renderTempDayEvent(event, adjustRow, adjustTop) {

		// actually render the event. `true` for appending element to container.
		// Recieve the intermediate "segment" data structures.
		var segments = _renderDayEvents(
			[ event ],
			true, // append event elements
			false // don't set the heights of the rows
		);

		var elements = [];

		// Adjust certain elements' top coordinates
		segmentElementEach(segments, function(segment, element) {
			if (segment.row === adjustRow) {
				element.css('top', adjustTop);
			}
			elements.push(element[0]); // accumulate DOM nodes
		});

		return elements;
	}


	// Render events onto the calendar. Only responsible for the VISUAL aspect.
	// Not responsible for attaching handlers or calling callbacks.
	// Set `doAppend` to `true` for rendering elements without clearing the existing container.
	// Set `doRowHeights` to allow setting the height of each row, to compensate for vertical event overflow.
	function _renderDayEvents(events, doAppend, doRowHeights) {

		// where the DOM nodes will eventually end up
		var finalContainer = getDaySegmentContainer();

		// the container where the initial HTML will be rendered.
		// If `doAppend`==true, uses a temporary container.
		var renderContainer = doAppend ? $("<div/>") : finalContainer;

		var segments = buildSegments(events);
		var html;
		var elements;

		// calculate the desired `left` and `width` properties on each segment object
		calculateHorizontals(segments);

		// build the HTML string. relies on `left` property
		html = buildHTML(segments);

		// render the HTML. innerHTML is considerably faster than jQuery's .html()
		renderContainer[0].innerHTML = html;

		// retrieve the individual elements
		elements = renderContainer.children();

		// if we were appending, and thus using a temporary container,
		// re-attach elements to the real container.
		if (doAppend) {
			finalContainer.append(elements);
		}

		// assigns each element to `segment.event`, after filtering them through user callbacks
		resolveElements(segments, elements);

		// Calculate the left and right padding+margin for each element.
		// We need this for setting each element's desired outer width, because of the W3C box model.
		// It's important we do this in a separate pass from acually setting the width on the DOM elements
		// because alternating reading/writing dimensions causes reflow for every iteration.
		segmentElementEach(segments, function(segment, element) {
			segment.hsides = hsides(element, true); // include margins = `true`
		});

		// Set the width of each element
		segmentElementEach(segments, function(segment, element) {
			element.width(
				Math.max(0, segment.outerWidth - segment.hsides)
			);
		});

		// Grab each element's outerHeight (setVerticals uses this).
		// To get an accurate reading, it's important to have each element's width explicitly set already.
		segmentElementEach(segments, function(segment, element) {
			segment.outerHeight = element.outerHeight(true); // include margins = `true`
		});

		// Set the top coordinate on each element (requires segment.outerHeight)
		setVerticals(segments, doRowHeights);

		return segments;
	}


	// Generate an array of "segments" for all events.
	function buildSegments(events) {
		var segments = [];
		for (var i=0; i<events.length; i++) {
			var eventSegments = buildSegmentsForEvent(events[i]);
			segments.push.apply(segments, eventSegments); // append an array to an array
		}
		return segments;
	}


	// Generate an array of segments for a single event.
	// A "segment" is the same data structure that View.rangeToSegments produces,
	// with the addition of the `event` property being set to reference the original event.
	function buildSegmentsForEvent(event) {
		var startDate = event.start;
		var endDate = exclEndDay(event);
		var segments = rangeToSegments(startDate, endDate, event);
		for (var i=0; i<segments.length; i++) {
			segments[i].event = event;
		}

		return segments;
	}


	// Sets the `left` and `outerWidth` property of each segment.
	// These values are the desired dimensions for the eventual DOM elements.
	function calculateHorizontals(segments) {
		var isRTL = opt('isRTL');
		for (var i=0; i<segments.length; i++) {
			var segment = segments[i];

			// Determine functions used for calulating the elements left/right coordinates,
			// depending on whether the view is RTL or not.
			// NOTE:
			// colLeft/colRight returns the coordinate butting up the edge of the cell.
			// colContentLeft/colContentRight is indented a little bit from the edge.
			var leftFunc = (isRTL ? segment.isEnd : segment.isStart) ? colContentLeft : colLeft;
			var rightFunc = (isRTL ? segment.isStart : segment.isEnd) ? colContentRight : colRight;

			var left = leftFunc(segment.leftCol);
			var right = rightFunc(segment.rightCol);
			segment.left = left;
			segment.outerWidth = right - left;
		}
	}


	// Build a concatenated HTML string for an array of segments
	function buildHTML(segments) {
		var html = '';
		for (var i=0; i<segments.length; i++) {
			html += buildHTMLForSegment(segments[i]);
		}
		return html;
	}


	// Build an HTML string for a single segment.
	// Relies on the following properties:
	// - `segment.event` (from `buildSegmentsForEvent`)
	// - `segment.left` (from `calculateHorizontals`)
	function buildHTMLForSegment(segment) {
		var html = '';
		var isRTL = opt('isRTL');
		var event = segment.event;
		var url = event.url;

		// generate the list of CSS classNames
		var classNames = [ 'fc-event', 'fc-event-hori' ];
		if (isEventDraggable(event)) {
			classNames.push('fc-event-draggable');
		}
		if (segment.isStart) {
			classNames.push('fc-event-start');
		}
		if (segment.isEnd) {
			classNames.push('fc-event-end');
		}
		// use the event's configured classNames
		// guaranteed to be an array via `normalizeEvent`
		classNames = classNames.concat(event.className);
		if (event.source) {
			// use the event's source's classNames, if specified
			classNames = classNames.concat(event.source.className || []);
		}

		// generate a semicolon delimited CSS string for any of the "skin" properties
		// of the event object (`backgroundColor`, `borderColor` and such)
		var skinCss = getSkinCss(event, opt);

		if (url) {
			html += "<a href='" + htmlEscape(url) + "'";
		}else{
			html += "<div";
		}
		html +=
			" class='" + classNames.join(' ') + "'" +
			" style=" +
				"'" +
				"position:absolute;" +
				"left:" + segment.left + "px;" +
				skinCss +
				"'" +
			">" +
			"<div class='fc-event-inner'>";
		if (!event.allDay && segment.isStart) {
			html +=
				"<span class='fc-event-time'>" +
				htmlEscape(
					formatDates(event.start, event.end, opt('timeFormat'))
				) +
				"</span>";
		}
		html +=
			"<span class='fc-event-title'>" +
			htmlEscape(event.title || '') +
			"</span>" +
			"</div>";
		if (segment.isEnd && isEventResizable(event)) {
			html +=
				"<div class='ui-resizable-handle ui-resizable-" + (isRTL ? 'w' : 'e') + "'>" +
				"&nbsp;&nbsp;&nbsp;" + // makes hit area a lot better for IE6/7
				"</div>";
		}
		html += "</" + (url ? "a" : "div") + ">";

		// TODO:
		// When these elements are initially rendered, they will be briefly visibile on the screen,
		// even though their widths/heights are not set.
		// SOLUTION: initially set them as visibility:hidden ?

		return html;
	}


	// Associate each segment (an object) with an element (a jQuery object),
	// by setting each `segment.element`.
	// Run each element through the `eventRender` filter, which allows developers to
	// modify an existing element, supply a new one, or cancel rendering.
	function resolveElements(segments, elements) {
		for (var i=0; i<segments.length; i++) {
			var segment = segments[i];
			var event = segment.event;
			var element = elements.eq(i);

			// call the trigger with the original element
			var triggerRes = trigger('eventRender', event, event, element);

			if (triggerRes === false) {
				// if `false`, remove the event from the DOM and don't assign it to `segment.event`
				element.remove();
			}
			else {
				if (triggerRes && triggerRes !== true) {
					// the trigger returned a new element, but not `true` (which means keep the existing element)

					// re-assign the important CSS dimension properties that were already assigned in `buildHTMLForSegment`
					triggerRes = $(triggerRes)
						.css({
							position: 'absolute',
							left: segment.left
						});

					element.replaceWith(triggerRes);
					element = triggerRes;
				}

				segment.element = element;
			}
		}
	}



	/* Top-coordinate Methods
	-------------------------------------------------------------------------------------------------*/


	// Sets the "top" CSS property for each element.
	// If `doRowHeights` is `true`, also sets each row's first cell to an explicit height,
	// so that if elements vertically overflow, the cell expands vertically to compensate.
	function setVerticals(segments, doRowHeights) {
		var rowContentHeights = calculateVerticals(segments); // also sets segment.top
		var rowContentElements = getRowContentElements(); // returns 1 inner div per row
		var rowContentTops = [];
		if( false ) { /* RHC */
			// Set each row's height by setting height of first inner div
			if (doRowHeights) {
				for (var i=0; i<rowContentElements.length; i++) {
					rowContentElements[i].height(rowContentHeights[i]);
				}
			}
	
			// Get each row's top, relative to the views's origin.
			// Important to do this after setting each row's height.
			for (var i=0; i<rowContentElements.length; i++) {
				rowContentTops.push(
					rowContentElements[i].position().top
				);
			}
	
			// Set each segment element's CSS "top" property.
			// Each segment object has a "top" property, which is relative to the row's top, but...
			segmentElementEach(segments, function(segment, element) {
				element.css(
					'top',
					rowContentTops[segment.row] + segment.top // ...now, relative to views's origin
				);
			});
		}/* RHC dddd*/
		else{	

			/* RHC START */
			var rowCnt = getRowCnt();
			var colCnt = getColCnt();
			var holderHeights=[];
			for(row=0;row<rowCnt;row++){
				holderHeights[row]=[];
				segmentElementEach(segments, function(segment, element) {
		  			if(segment.row!=row)return;
					if(segment.leftCol>segment.rightcol)return;
					for(col=segment.leftCol; col<=segment.rightCol; col++){
						holderHeights[ row ][ col ] = holderHeights[ row ][ col ] || 0;
						holderHeights[ row ][ col ] += segment.outerHeight; 
					}
				});
			}		
			//set the content of each cell just enough tall to hold overlaid events. (fluid design)
			if (doRowHeights) {
				for (var i=0; i<rowContentElements.length; i++) {
					if( rowContentElements[i].length >= holderHeights[i].length ){
						for (var j=0; j<rowContentElements[i].length; j++){
							h = holderHeights[i] && holderHeights[i][j] ? holderHeights[i][j] : false ;
							if(false===h){
								rowContentElements[i].eq(j).addClass('fc-day-no-events');
							}else{
								rowContentElements[i].eq(j).height( h );
							}
						}					
					}else{
						//this applies to agenda views
						new_h = 0;
						$.each(holderHeights[i],function(k,h){
							new_h = h>new_h?h:new_h;
						});
						rowContentElements[i].height( new_h );
					}  
				}
			}		
	
			for (var i=0; i<rowContentElements.length; i++) {
				for (var j=0; j<rowContentElements[i].length; j++){	
					rowContentTops[i] = rowContentTops[i]||[];
					rowContentTops[i][j] = rowContentElements[i].eq(j).position().top;
				}
			}
			// Set each segment element's CSS "top" property.
			// Each segment object has a "top" property, which is relative to the row's top, but...		
			segmentElementEach(segments, function(segment, element) {
				contentTop = rowContentTops[segment.row][segment.leftCol] || rowContentTops[segment.row][0] ; 
				element.css(
					'top',
					contentTop + segment.top // ...now, relative to views's origin
				);
			});		
		}
		/* RHC END */	
	}


	// Calculate the "top" coordinate for each segment, relative to the "top" of the row.
	// Also, return an array that contains the "content" height for each row
	// (the height displaced by the vertically stacked events in the row).
	// Requires segments to have their `outerHeight` property already set.
	function calculateVerticals(segments) {
		var rowCnt = getRowCnt();
		var colCnt = getColCnt();
		var rowContentHeights = []; // content height for each row
		var segmentRows = buildSegmentRows(segments); // an array of segment arrays, one for each row

		for (var rowI=0; rowI<rowCnt; rowI++) {
			var segmentRow = segmentRows[rowI];

			// an array of running total heights for each column.
			// initialize with all zeros.
			var colHeights = [];
			for (var colI=0; colI<colCnt; colI++) {
				colHeights.push(0);
			}

			// loop through every segment
			for (var segmentI=0; segmentI<segmentRow.length; segmentI++) {
				var segment = segmentRow[segmentI];

				// find the segment's top coordinate by looking at the max height
				// of all the columns the segment will be in.
				segment.top = arrayMax(
					colHeights.slice(
						segment.leftCol,
						segment.rightCol + 1 // make exclusive for slice
					)
				);

				// adjust the columns to account for the segment's height
				for (var colI=segment.leftCol; colI<=segment.rightCol; colI++) {
					colHeights[colI] = segment.top + segment.outerHeight;
				}
			}

			// the tallest column in the row should be the "content height"
			rowContentHeights.push(arrayMax(colHeights));
		}

		return rowContentHeights;
	}


	// Build an array of segment arrays, each representing the segments that will
	// be in a row of the grid, sorted by which event should be closest to the top.
	function buildSegmentRows(segments) {
		var rowCnt = getRowCnt();
		var segmentRows = [];
		var segmentI;
		var segment;
		var rowI;

		// group segments by row
		for (segmentI=0; segmentI<segments.length; segmentI++) {
			segment = segments[segmentI];
			rowI = segment.row;
			if (segment.element) { // was rendered?
				if (segmentRows[rowI]) {
					// already other segments. append to array
					segmentRows[rowI].push(segment);
				}
				else {
					// first segment in row. create new array
					segmentRows[rowI] = [ segment ];
				}
			}
		}

		// sort each row
		for (rowI=0; rowI<rowCnt; rowI++) {
			segmentRows[rowI] = sortSegmentRow(
				segmentRows[rowI] || [] // guarantee an array, even if no segments
			);
		}

		return segmentRows;
	}


	// Sort an array of segments according to which segment should appear closest to the top
	function sortSegmentRow(segments) {
		var sortedSegments = [];

		// build the subrow array
		var subrows = buildSegmentSubrows(segments);

		// flatten it
		for (var i=0; i<subrows.length; i++) {
			sortedSegments.push.apply(sortedSegments, subrows[i]); // append an array to an array
		}

		return sortedSegments;
	}


	// Take an array of segments, which are all assumed to be in the same row,
	// and sort into subrows.
	function buildSegmentSubrows(segments) {

		// Give preference to elements with certain criteria, so they have
		// a chance to be closer to the top.
		segments.sort(compareDaySegments);

		var subrows = [];
		for (var i=0; i<segments.length; i++) {
			var segment = segments[i];

			// loop through subrows, starting with the topmost, until the segment
			// doesn't collide with other segments.
			for (var j=0; j<subrows.length; j++) {
				if (!isDaySegmentCollision(segment, subrows[j])) {
					break;
				}
			}
			// `j` now holds the desired subrow index
			if (subrows[j]) {
				subrows[j].push(segment);
			}
			else {
				subrows[j] = [ segment ];
			}
		}

		return subrows;
	}


	// Return an array of jQuery objects for the placeholder content containers of each row.
	// The content containers don't actually contain anything, but their dimensions should match
	// the events that are overlaid on top.
	function getRowContentElements() {
		var i;
		var rowCnt = getRowCnt();
		var rowDivs = [];
		for (i=0; i<rowCnt; i++) {
			rowDivs[i] = allDayRow(i)
				.find('div.fc-day-content > div');
		}
		return rowDivs;
	}



	/* Mouse Handlers
	---------------------------------------------------------------------------------------------------*/
	// TODO: better documentation!


	function attachHandlers(segments, modifiedEventId) {
		var segmentContainer = getDaySegmentContainer();

		segmentElementEach(segments, function(segment, element, i) {
			var event = segment.event;
			if (event._id === modifiedEventId) {
				bindDaySeg(event, element, segment);
			}else{
				element[0]._fci = i; // for lazySegBind
			}
		});

		lazySegBind(segmentContainer, segments, bindDaySeg);
	}


	function bindDaySeg(event, eventElement, segment) {

		if (isEventDraggable(event)) {
			t.draggableDayEvent(event, eventElement, segment); // use `t` so subclasses can override
		}

		if (
			segment.isEnd && // only allow resizing on the final segment for an event
			isEventResizable(event)
		) {
			t.resizableDayEvent(event, eventElement, segment); // use `t` so subclasses can override
		}

		// attach all other handlers.
		// needs to be after, because resizableDayEvent might stopImmediatePropagation on click
		eventElementHandlers(event, eventElement);
	}

	
	function draggableDayEvent(event, eventElement) {
		var hoverListener = getHoverListener();
		var dayDelta;
		eventElement.draggable({
			delay: 50,
			opacity: opt('dragOpacity'),
			revertDuration: opt('dragRevertDuration'),
			start: function(ev, ui) {
				trigger('eventDragStart', eventElement, event, ev, ui);
				hideEvents(event, eventElement);
				hoverListener.start(function(cell, origCell, rowDelta, colDelta) {
					eventElement.draggable('option', 'revert', !cell || !rowDelta && !colDelta);
					clearOverlays();
					if (cell) {
						var origDate = cellToDate(origCell);
						var date = cellToDate(cell);
						dayDelta = dayDiff(date, origDate);
						renderDayOverlay(
							addDays(cloneDate(event.start), dayDelta),
							addDays(exclEndDay(event), dayDelta)
						);
					}else{
						dayDelta = 0;
					}
				}, ev, 'drag');
			},
			stop: function(ev, ui) {
				hoverListener.stop();
				clearOverlays();
				trigger('eventDragStop', eventElement, event, ev, ui);
				if (dayDelta) {
					eventDrop(this, event, dayDelta, 0, event.allDay, ev, ui);
				}else{
					eventElement.css('filter', ''); // clear IE opacity side-effects
					showEvents(event, eventElement);
				}
			}
		});
	}

	
	function resizableDayEvent(event, element, segment) {
		var isRTL = opt('isRTL');
		var direction = isRTL ? 'w' : 'e';
		var handle = element.find('.ui-resizable-' + direction); // TODO: stop using this class because we aren't using jqui for this
		var isResizing = false;
		
		// TODO: look into using jquery-ui mouse widget for this stuff
		disableTextSelection(element); // prevent native <a> selection for IE
		element
			.mousedown(function(ev) { // prevent native <a> selection for others
				ev.preventDefault();
			})
			.click(function(ev) {
				if (isResizing) {
					ev.preventDefault(); // prevent link from being visited (only method that worked in IE6)
					ev.stopImmediatePropagation(); // prevent fullcalendar eventClick handler from being called
					                               // (eventElementHandlers needs to be bound after resizableDayEvent)
				}
			});
		
		handle.mousedown(function(ev) {
			if (ev.which != 1) {
				return; // needs to be left mouse button
			}
			isResizing = true;
			var hoverListener = getHoverListener();
			var rowCnt = getRowCnt();
			var colCnt = getColCnt();
			var elementTop = element.css('top');
			var dayDelta;
			var helpers;
			var eventCopy = $.extend({}, event);
			var minCellOffset = dayOffsetToCellOffset( dateToDayOffset(event.start) );
			clearSelection();
			$('body')
				.css('cursor', direction + '-resize')
				.one('mouseup', mouseup);
			trigger('eventResizeStart', this, event, ev);
			hoverListener.start(function(cell, origCell) {
				if (cell) {

					var origCellOffset = cellToCellOffset(origCell);
					var cellOffset = cellToCellOffset(cell);

					// don't let resizing move earlier than start date cell
					cellOffset = Math.max(cellOffset, minCellOffset);

					dayDelta =
						cellOffsetToDayOffset(cellOffset) -
						cellOffsetToDayOffset(origCellOffset);

					if (dayDelta) {
						eventCopy.end = addDays(eventEnd(event), dayDelta, true);
						var oldHelpers = helpers;

						helpers = renderTempDayEvent(eventCopy, segment.row, elementTop);
						helpers = $(helpers); // turn array into a jQuery object

						helpers.find('*').css('cursor', direction + '-resize');
						if (oldHelpers) {
							oldHelpers.remove();
						}

						hideEvents(event);
					}
					else {
						if (helpers) {
							showEvents(event);
							helpers.remove();
							helpers = null;
						}
					}
					clearOverlays();
					renderDayOverlay( // coordinate grid already rebuilt with hoverListener.start()
						event.start,
						addDays( exclEndDay(event), dayDelta )
						// TODO: instead of calling renderDayOverlay() with dates,
						// call _renderDayOverlay (or whatever) with cell offsets.
					);
				}
			}, ev);
			
			function mouseup(ev) {
				trigger('eventResizeStop', this, event, ev);
				$('body').css('cursor', '');
				hoverListener.stop();
				clearOverlays();
				if (dayDelta) {
					eventResize(this, event, dayDelta, 0, ev);
					// event redraw will clear helpers
				}
				// otherwise, the drag handler already restored the old events
				
				setTimeout(function() { // make this happen after the element's click event
					isResizing = false;
				},0);
			}
		});
	}
	

}



/* Generalized Segment Utilities
-------------------------------------------------------------------------------------------------*/


function isDaySegmentCollision(segment, otherSegments) {
	for (var i=0; i<otherSegments.length; i++) {
		var otherSegment = otherSegments[i];
		if (
			otherSegment.leftCol <= segment.rightCol &&
			otherSegment.rightCol >= segment.leftCol
		) {
			return true;
		}
	}
	return false;
}


function segmentElementEach(segments, callback) { // TODO: use in AgendaView?
	for (var i=0; i<segments.length; i++) {
		var segment = segments[i];
		var element = segment.element;
		if (element) {
			callback(segment, element, i);
		}
	}
}


// A cmp function for determining which segments should appear higher up
function compareDaySegments(a, b) {
	return (b.rightCol - b.leftCol) - (a.rightCol - a.leftCol) || // put wider events first
		b.event.allDay - a.event.allDay || // if tie, put all-day events first (booleans cast to 0/1)
		a.event.start - b.event.start || // if a tie, sort by event start date
		(a.event.title || '').localeCompare(b.event.title) // if a tie, sort by event title
}


;;

//BUG: unselect needs to be triggered when events are dragged+dropped

function SelectionManager() {
	var t = this;
	
	
	// exports
	t.select = select;
	t.unselect = unselect;
	t.reportSelection = reportSelection;
	t.daySelectionMousedown = daySelectionMousedown;
	
	
	// imports
	var opt = t.opt;
	var trigger = t.trigger;
	var defaultSelectionEnd = t.defaultSelectionEnd;
	var renderSelection = t.renderSelection;
	var clearSelection = t.clearSelection;
	
	
	// locals
	var selected = false;



	// unselectAuto
	if (opt('selectable') && opt('unselectAuto')) {
		$(document).mousedown(function(ev) {
			var ignore = opt('unselectCancel');
			if (ignore) {
				if ($(ev.target).parents(ignore).length) { // could be optimized to stop after first match
					return;
				}
			}
			unselect(ev);
		});
	}
	

	function select(startDate, endDate, allDay) {
		unselect();
		if (!endDate) {
			endDate = defaultSelectionEnd(startDate, allDay);
		}
		renderSelection(startDate, endDate, allDay);
		reportSelection(startDate, endDate, allDay);
	}
	
	
	function unselect(ev) {
		if (selected) {
			selected = false;
			clearSelection();
			trigger('unselect', null, ev);
		}
	}
	
	
	function reportSelection(startDate, endDate, allDay, ev) {
		selected = true;
		trigger('select', null, startDate, endDate, allDay, ev);
	}
	
	
	function daySelectionMousedown(ev) { // not really a generic manager method, oh well
		var cellToDate = t.cellToDate;
		var getIsCellAllDay = t.getIsCellAllDay;
		var hoverListener = t.getHoverListener();
		var reportDayClick = t.reportDayClick; // this is hacky and sort of weird
		if (ev.which == 1 && opt('selectable')) { // which==1 means left mouse button
			unselect(ev);
			var _mousedownElement = this;
			var dates;
			hoverListener.start(function(cell, origCell) { // TODO: maybe put cellToDate/getIsCellAllDay info in cell
				clearSelection();
				if (cell && getIsCellAllDay(cell)) {
					dates = [ cellToDate(origCell), cellToDate(cell) ].sort(dateCompare);
					renderSelection(dates[0], dates[1], true);
				}else{
					dates = null;
				}
			}, ev);
			$(document).one('mouseup', function(ev) {
				hoverListener.stop();
				if (dates) {
					if (+dates[0] == +dates[1]) {
						reportDayClick(dates[0], true, ev);
					}
					reportSelection(dates[0], dates[1], true, ev);
				}
			});
		}
	}


}

;;
 
function OverlayManager() {
	var t = this;
	
	
	// exports
	t.renderOverlay = renderOverlay;
	t.clearOverlays = clearOverlays;
	
	
	// locals
	var usedOverlays = [];
	var unusedOverlays = [];
	
	
	function renderOverlay(rect, parent) {
		var e = unusedOverlays.shift();
		if (!e) {
			e = $("<div class='fc-cell-overlay' style='position:absolute;z-index:3'/>");
		}
		if (e[0].parentNode != parent[0]) {
			e.appendTo(parent);
		}
		usedOverlays.push(e.css(rect).show());
		return e;
	}
	

	function clearOverlays() {
		var e;
		while (e = usedOverlays.shift()) {
			unusedOverlays.push(e.hide().unbind());
		}
	}


}

;;

function CoordinateGrid(buildFunc) {

	var t = this;
	var rows;
	var cols;
	
	
	t.build = function() {
		rows = [];
		cols = [];
		buildFunc(rows, cols);
	};
	
	
	t.cell = function(x, y) {
		var rowCnt = rows.length;
		var colCnt = cols.length;
		var i, r=-1, c=-1;
		for (i=0; i<rowCnt; i++) {
			if (y >= rows[i][0] && y < rows[i][1]) {
				r = i;
				break;
			}
		}
		for (i=0; i<colCnt; i++) {
			if (x >= cols[i][0] && x < cols[i][1]) {
				c = i;
				break;
			}
		}
		return (r>=0 && c>=0) ? { row:r, col:c } : null;
	};
	
	
	t.rect = function(row0, col0, row1, col1, originElement) { // row1,col1 is inclusive
		var origin = originElement.offset();
		return {
			top: rows[row0][0] - origin.top,
			left: cols[col0][0] - origin.left,
			width: cols[col1][1] - cols[col0][0],
			height: rows[row1][1] - rows[row0][0]
		};
	};

}

;;

function HoverListener(coordinateGrid) {


	var t = this;
	var bindType;
	var change;
	var firstCell;
	var cell;
	
	
	t.start = function(_change, ev, _bindType) {
		change = _change;
		firstCell = cell = null;
		coordinateGrid.build();
		mouse(ev);
		bindType = _bindType || 'mousemove';
		$(document).bind(bindType, mouse);
	};
	
	
	function mouse(ev) {
		_fixUIEvent(ev); // see below
		var newCell = coordinateGrid.cell(ev.pageX, ev.pageY);
		if (!newCell != !cell || newCell && (newCell.row != cell.row || newCell.col != cell.col)) {
			if (newCell) {
				if (!firstCell) {
					firstCell = newCell;
				}
				change(newCell, firstCell, newCell.row-firstCell.row, newCell.col-firstCell.col);
			}else{
				change(newCell, firstCell);
			}
			cell = newCell;
		}
	}
	
	
	t.stop = function() {
		$(document).unbind(bindType, mouse);
		return cell;
	};
	
	
}



// this fix was only necessary for jQuery UI 1.8.16 (and jQuery 1.7 or 1.7.1)
// upgrading to jQuery UI 1.8.17 (and using either jQuery 1.7 or 1.7.1) fixed the problem
// but keep this in here for 1.8.16 users
// and maybe remove it down the line

function _fixUIEvent(event) { // for issue 1168
	if (event.pageX === undefined) {
		event.pageX = event.originalEvent.pageX;
		event.pageY = event.originalEvent.pageY;
	}
}
;;

function HorizontalPositionCache(getElement) {

	var t = this,
		elements = {},
		lefts = {},
		rights = {};
		
	function e(i) {
		return elements[i] = elements[i] || getElement(i);
	}
	
	t.left = function(i) {
		return lefts[i] = lefts[i] === undefined ? e(i).position().left : lefts[i];
	};
	
	t.right = function(i) {
		return rights[i] = rights[i] === undefined ? t.left(i) + e(i).width() : rights[i];
	};
	
	t.clear = function() {
		elements = {};
		lefts = {};
		rights = {};
	};
	
}

;;

})(jQuery);
/* SOURCE: fullcalendar/fullcalendar/gcal.js */
;;/*!
 * FullCalendar v1.6.4 Google Calendar Plugin
 * Docs & License: http://arshaw.com/fullcalendar/
 * (c) 2013 Adam Shaw
 */
 
(function($) {


var fc = $.fullCalendar;
var formatDate = fc.formatDate;
var parseISO8601 = fc.parseISO8601;
var addDays = fc.addDays;
var applyAll = fc.applyAll;


fc.sourceNormalizers.push(function(sourceOptions) {
	if (sourceOptions.dataType == 'gcal' ||
		sourceOptions.dataType === undefined &&
		(sourceOptions.url || '').match(/^(http|https):\/\/www.google.com\/calendar\/feeds\//)) {
			sourceOptions.dataType = 'gcal';
			if (sourceOptions.editable === undefined) {
				sourceOptions.editable = false;
			}
		}
});


fc.sourceFetchers.push(function(sourceOptions, start, end) {
	if (sourceOptions.dataType == 'gcal') {
		return transformOptions(sourceOptions, start, end);
	}
});


function transformOptions(sourceOptions, start, end) {

	var success = sourceOptions.success;
	var data = $.extend({}, sourceOptions.data || {}, {
		'start-min': formatDate(start, 'u'),
		'start-max': formatDate(end, 'u'),
		'singleevents': true,
		'max-results': 9999
	});
	
	var ctz = sourceOptions.currentTimezone;
	if (ctz) {
		data.ctz = ctz = ctz.replace(' ', '_');
	}

	return $.extend({}, sourceOptions, {
		url: sourceOptions.url.replace(/\/basic$/, '/full') + '?alt=json-in-script&callback=?',
		dataType: 'jsonp',
		data: data,
		startParam: false,
		endParam: false,
		success: function(data) {
			var events = [];
			if (data.feed.entry) {
				$.each(data.feed.entry, function(i, entry) {
					var startStr = entry['gd$when'][0]['startTime'];
					var start = parseISO8601(startStr, true);
					var end = parseISO8601(entry['gd$when'][0]['endTime'], true);
					var allDay = startStr.indexOf('T') == -1;
					var url;
					$.each(entry.link, function(i, link) {
						if (link.type == 'text/html') {
							url = link.href;
							if (ctz) {
								url += (url.indexOf('?') == -1 ? '?' : '&') + 'ctz=' + ctz;
							}
						}
					});
					if (allDay) {
						addDays(end, -1); // make inclusive
					}
					events.push({
						id: entry['gCal$uid']['value'],
						title: entry['title']['$t'],
						url: url,
						start: start,
						end: end,
						allDay: allDay,
						location: entry['gd$where'][0]['valueString'],
						description: entry['content']['$t']
					});
				});
			}
			var args = [events].concat(Array.prototype.slice.call(arguments, 1));
			var res = applyAll(success, this, args);
			if ($.isArray(res)) {
				return res;
			}
			return events;
		}
	});
	
}


// legacy
fc.gcalFeed = function(url, sourceOptions) {
	return $.extend({}, sourceOptions, { url: url, dataType: 'gcal' });
};


})(jQuery);

/* SOURCE: js/fullcalendar_custom_views.js */
;;//custom fullCalendar views created for calendarize-it.

(function($){

$.fullCalendar.views.WeekEventList = WeekEventList;	
function WeekEventList(element, calendar) {
	var t = this;
	var body;
	var addDays = $.fullCalendar.addDays;
	var cloneDate = $.fullCalendar.cloneDate;
	var formatDates = $.fullCalendar.formatDates;
	
	options = calendar.options;
	// imports
	EventView.call(t, element, calendar );

	// exports
	t.render = render;
	t.viewChanged = viewChanged;
	function render(date, delta) {

		if (delta) {
			addDays(date, delta * 7);
		}

		var start = addDays(cloneDate(date), -((date.getDay() - opt('firstDay') + 7) % 7));
		var end = addDays(cloneDate(start), 7);

		var visStart = cloneDate(start);
		//skipHiddenDays(visStart);

		var visEnd = cloneDate(end);
		//skipHiddenDays(visEnd, -1, true);

		//var colCnt = getCellsPerWeek();

		if( calendar.options.titleFormat.week ){
			calendar.options.titleFormat.week = calendar.options.titleFormat.week.replace(/&#91;/g,'[');
			calendar.options.titleFormat.week = calendar.options.titleFormat.week.replace(/&#93;/g,']');
			t.title = formatDates(
				visStart,
				addDays(cloneDate(visEnd), -1),
				calendar.options.titleFormat.week,
				calendar.options
			);				
		}

		t.start = start;
		t.end = end;
		t.visStart = visStart;
		t.visEnd = visEnd;

		//---
		var firstTime = !body;
		if(firstTime){
			$('<div class="fc-events-holder"></div>').appendTo(element);
			body = true;
		}else{
			 
		}		
	}
	
	function viewChanged(){
	
	}
	
	function opt(name, viewNameOverride) {
		var v = options[name];
		return v;
	}	
}

$.fullCalendar.views.rhc_event = EventView;	
function EventView(element, calendar) {
	var t = this;
	var body;
	t.name = 'rhc_event';
	t.render = render;
	t.unselect = unselect;
	t.setHeight = setHeight;
	t.setWidth = setWidth;
	t.clearEvents = clearEvents;
	t.renderEvents = renderEvents;
	t.trigger = trigger;
	t.viewChanged = viewChanged;
	t.beforeAnimation = beforeAnimation;
	t.setEventData = setEventData; //fc 1.64
	t.clearEventData = clearEventData;//fc 1.64
	t.triggerEventDestroy = triggerEventDestroy;//fc 1.64
	
	t.element = element;
	t.oldView = null;
	//not part of fc api.
	t.calendar = calendar;//needed for clicking event title.
	fc = $.fullCalendar;
	//--
	t.direction = 0;//direction in wich the user is navigating.
	t.first_date = null;
	t.scroll_lockdown = false;
	t.loading = loading;
	t.have_events = false;
	t.rendered_events = [];
	
	if( calendar.options.eventList.daysahead && parseInt( calendar.options.eventList.delta ) > parseInt( calendar.options.eventList.daysahead )  ){
		calendar.options.eventList.delta = calendar.options.eventList.daysahead;
	}
	
	function viewChanged(oldView){
		if(oldView){
			if( oldView.visStart && oldView.visEnd ){
				t.title = oldView.title;
				//t.visStart = oldView.visStart;
				t.visStart = oldView.start;
				t.visEnd = oldView.visEnd;
				t.oldView = oldView;

				if( calendar.options.eventList.upcoming && calendar.options.eventList.upcoming=='1' ){
					var _now = new Date();
					t.visStart = t.visStart.getTime() > _now.getTime() ? t.visStart : _now ;
				}		
				
				var months = calendar.options.eventList.monthsahead?calendar.options.eventList.monthsahead:'';
				months = months.replace(' ','')==''?1:parseInt(months);	
				if( months>0 ){
					var _visEnd = new Date( t.visStart );
					_visEnd.setMonth( _visEnd.getMonth() + months );
					t.visEnd = _visEnd;		
				}	
				
				var days = calendar.options.eventList.daysahead?calendar.options.eventList.daysahead:'';
				days = days.replace(' ','')==''?0:parseInt(days);	
				if( days>0 ){
					var _visEnd = new Date( t.visStart );
					_visEnd.setDate( _visEnd.getDate() + days - 1 );
					_visEnd.setHours(23,59,59);
					t.visEnd = _visEnd;						
				}						
			}	
		}
	}

	
	function setEventData( events ){
/*		events.splice(3,5);
console.log('setEventData', typeof events );
console.log(events);	
*/
	}
	
	function clearEventData(){
	
	}
	
	function triggerEventDestroy(){
	
	}
	
	//not part of fc api.
	function beforeAnimation(oldView){
		
	}

	function render(date,delta){	

		var stack = calendar.options.eventList.stack && parseInt(calendar.options.eventList.stack)==1 || false ;
		t.direction = delta;
		custom_delta = parseInt( calendar.options.eventList.delta );
		custom_delta = isNaN(custom_delta) ? 0 : custom_delta;
		date_changed = false;
		if( stack && custom_delta > 0 && t.first_date && t.direction < 0 && date > t.first_date ){
			date = fc.cloneDate( t.first_date );
			date_changed=true;
		}
	
		if( t.direction == 0 ){
			t.first_date = fc.cloneDate( date );
		}else if( t.direction < 0 && t.first_date < date ){
			t.first_date = fc.cloneDate( date );
		}

		if(delta && (custom_delta > 0) ){
			fc.addDays( date, custom_delta*delta );
			delta=0;
		}

		if(date_changed){
			calendar.gotoDate(date);//change the calendar current date
		}
		
		if(custom_delta > 0){
			start = fc.cloneDate(date, true);
			end = fc.addDays( fc.cloneDate(start), custom_delta );		
			_end = fc.cloneDate( end );					
		}else{
			_end = false;
		}
	
		//----------------------------------------------------------------
		t.start = fc.cloneDate(date, true);//if not defined, hidden views do not update size on window resize.
		var firstTime = !body;
		if(firstTime){
			$('<div class="fc-events-holder"></div>').appendTo(element);
			body = true;
		}else{
			 
		}

		if(t.oldView){
		
		}else{
			t.oldView = new $.fullCalendar.views['month']( $('<div>') ,calendar);
//			calendar.gotoDate(date);//this produces a double load. i dont remember what this was for. but it no longer seems aplicable
		}

		if(t.oldView){	
			if( custom_delta ){		
				t.oldView.render( fc.cloneDate(date), delta );
			}else{
				t.oldView.render( date, delta ); //allow the regular view to modify date when custom delta not used.
			}
			_end = false===_end ?  fc.cloneDate( t.oldView.visEnd ) : _end ;

			if( t.oldView.visStart && t.oldView.visEnd ){
				t.title = t.oldView.title;
				if(custom_delta){
					t.start 	= fc.cloneDate( start );
					t.end 		= fc.cloneDate( end );
					t.visStart 	= fc.cloneDate( start );
					t.visEnd 	= fc.cloneDate( end );							
				}else{
					t.start 	= fc.cloneDate( t.oldView.start );
					t.end 		= fc.cloneDate( t.oldView.end );
					t.visStart 	= fc.cloneDate( t.oldView.start );
					t.visEnd 	= fc.cloneDate( t.oldView.visEnd );				
				}
		
				if( calendar.options.eventList.TitleFormat ){
					calendar.options.eventList.TitleFormat = calendar.options.eventList.TitleFormat.replace(/&#91;/g,'[');
					calendar.options.eventList.TitleFormat = calendar.options.eventList.TitleFormat.replace(/&#93;/g,']');
					t.title = fc.formatDates(
						fc.cloneDate( t.visStart ),
						fc.addDays( fc.cloneDate( _end ), -1),
						calendar.options.eventList.TitleFormat,
						calendar.options
					);				
				}
			}		
		}

		if( calendar.options.eventList.upcoming && calendar.options.eventList.upcoming=='1' ){
			var _now = new Date();
			_now.setHours(0,0,0);//set the first hour of the day for the cache.
			dayspast = calendar.options.widgetlist.dayspast || 0 ;
			_now.setDate(_now.getDate()-parseInt(dayspast));		
			t.visStart = t.visStart.getTime() > _now.getTime() ? t.visStart : _now ;
		}

		var months = calendar.options.eventList.monthsahead?calendar.options.eventList.monthsahead:'';
		months = months.replace(' ','')==''?( custom_delta > 0 ? 0 : 1 ):parseInt(months);	
		if( months>0 ){
			var _visEnd = new Date( t.visStart );
			_visEnd.setMonth( _visEnd.getMonth() + months );
			t.visEnd = _visEnd;		
		}
		
		var days = calendar.options.eventList.daysahead?calendar.options.eventList.daysahead:'';
		days = days.replace(' ','')==''?0:parseInt(days);	
		if( days>0 ){
			var _visEnd = new Date( t.visStart );
			_visEnd.setDate( _visEnd.getDate() + days - 1 );
			_visEnd.setHours(23,59,59);
			t.visEnd = _visEnd;									
		}			
				
		//-- auto scroll
		if( parseInt(calendar.options.eventList.auto) && parseInt(calendar.options.eventList.stack) ){
			var _id = $(element).parents('.rhc_holder').attr('id');
			if( 'undefined' == typeof $(document).data( 'rhc_event_scroll' ) ){
				$(document).data( 'rhc_event_scroll' , _id )
				jQuery(document).scroll(function(){ rhc_event_scroll( _id ); });
			}
		}
	}
	
	function rhc_event_scroll( id ){
		if( false===t.have_events ) return;
		var _view = $('#' + id + ' .fc-view-rhc_event');
		if( _view.is(':visible') && !t.scroll_lockdown){
			//console.log( 'scrolled and not loading' );	
			// Get the positon of the more_items div if all your items are ind objects and they push down the more_item will it alwase be in a different pos
			var items_div = $(_view).parents('.rhc_holder');//$(_view).find('.fc-events-holder');
			var items_div_offset = items_div.offset();
			// extra calibration for mobil phones
			if (window.mobile){
				paddingForMobile = 1000;
			}else{
				paddingForMobile = 0;
			}

			if( ($(window).scrollTop() + $(window).height()) == $(document).height() ){
				//scroll hit the bottom
				t.scroll_lockdown = true;
				$(_view).parents('.rhc_holder').find('.fullCalendar').fullCalendar('next');				
			}else{
				//bottom of list passed a certain offset
				var _offset =  ( calendar.options.eventList.scrolloffset && ''!=calendar.options.eventList.scrolloffset ) ? calendar.options.eventList.scrolloffset : ( $(window).height() / 2 );
				var _offset = _offset -paddingForMobile ; 
				document_bottom = $(document).scrollTop()+$(window).height();
				bottom_position = items_div_offset.top + items_div.outerHeight();				
				if ( document_bottom > (bottom_position + _offset) ){
					t.scroll_lockdown = true;
					$(_view).parents('.rhc_holder').find('.fullCalendar').fullCalendar('next');
				}
			}						
		}
	}
	
	function unselect(){

	}
	function setHeight(h){
		//element.css('min-height',h);
		element.css('min-height','200px');
		element.css('height','auto');
	}
	function setWidth(){/*console.log('setWidth');*/}
	function clearEvents(){

	}
	function renderEvents(_events, modifiedEventId){
		var view_template = $(rhc_event_tpl);
		var item_template = view_template.find('.fc-event-list-item').clone().removeClass('fc-remove');
		var date_template = view_template.find('.fc-event-list-date').clone().removeClass('fc-remove');
		var no_events_template = view_template.find('.fc-event-list-no-events').clone().removeClass('fc-remove');
		if(calendar.options.eventList && calendar.options.eventList.eventListNoEventsText){
			no_events_template.find('.fc-no-list-events-message').html(calendar.options.eventList.eventListNoEventsText);
		}
		
		//--support widget templates
		widget_templates = false;
		if( calendar.options.eventList && calendar.options.eventList.eventlist_template && ''!=calendar.options.eventList.eventlist_template ){
			if( $(calendar.options.eventList.eventlist_template).length>0 ){
				widget_templates = true;
				item_template = $(calendar.options.eventList.eventlist_template).find('.rhc-widget-upcoming-item');
			}		
		}
		//---
		var stack_events = calendar.options.eventList.stack && '1'==calendar.options.eventList.stack ? true :false;
		
		if( stack_events && t.direction > 0 ){
			var _fc_events_holder = element.find('.fc-events-holder');//stack behavior.
		}else{
			var _fc_events_holder = element.find('.fc-events-holder').empty();
			t.rendered_events = [];
		}

		view_template
			.appendTo( _fc_events_holder )
			.find('.fc-remove').remove();
					
		if( stack_events ){
			$(_fc_events_holder).find('.fc-event-list-no-events').parents('.fc-event-list-container').remove();
		}					
					
		if(_events.length>0){		
			t.have_events = true;
			if(widget_templates){
				//widget template based render.
				var date_options = calendar.options;
				var options = calendar.options.widgetlist;
				var render_events=_events;		
				var sel = '#'+options.sel;
				options.dayspast = options.dayspast?options.dayspast:0;
				 				
				var vis_end = $.fullCalendar.parseDate( options.end );			
				if(options.horizon && ( options.horizon=='hour' || options.horizon=='end') ){
					var tmp = [];
					var _now = new Date();					
					_now.setDate(_now.getDate()-options.dayspast);				

					if(options.historic && options.historic=='1'){
						_now = $.fullCalendar.parseDate( options.specific_date );
					}
								
					for(var a=0;a<render_events.length;a++){
						if( render_events[a].end && options.horizon=='end' ){
							if(  render_events[a].end.getTime() < _now.getTime() )
								continue;						
						}else{
							if(  render_events[a].start.getTime() < _now.getTime() )
								continue;
						}
						
						if(  render_events[a].start.getTime() > vis_end.getTime() )
							continue;
							
						tmp[tmp.length]=render_events[a];	
					}
					render_events = tmp;
				}else{
					//handle a situation where repeat events are added and have
					//a  date before the start date
					var tmp = [];
					var _now = new Date();	
					_now.setDate(_now.getDate()-options.dayspast);	
					if(options.historic){
						if(''!=options.specific_date){
							_now = $.fullCalendar.parseDate( options.specific_date );
						}					
					}							
					for(var a=0;a<render_events.length;a++){
						var event_start = new Date(render_events[a].start);
						_now.setHours(0,0,0,0);
						event_start.setHours(0,0,0,0);
						
						if(  event_start.getTime() < _now.getTime() )			
							continue;

						if(  event_start.getTime() > vis_end.getTime() )	
							continue;
							
						tmp[tmp.length]=render_events[a];	
					}
					render_events = tmp;
				}
					
				render_events.sort( _rhc_sort_events );	
				//handle premiere
				if( options.premiere && options.premiere=='1' ){
					//real premiere
					var tmp = [];
					for(var a=0;a<render_events.length;a++){								
						if( render_events[a].premiere ){
							tmp[tmp.length]=render_events[a];						
						}	
					}
					render_events = tmp;					
				}else if( options.premiere && options.premiere=='2' ){
					//first event in a requested range
					var done_event_ids = [];
					var tmp = [];
					for(var a=0;a<render_events.length;a++){		
						if( $.inArray( render_events[a]._id, done_event_ids ) > -1 ){
							continue;
						}						
						done_event_ids.push( render_events[a]._id );
						tmp.push( render_events[a] );	
					}
					render_events = tmp;	
				}
				//--					
				
				render_events = render_events.slice(0, options.number );				
				
				var done_days = [];//for eventlist widget supppport.	
				$.each(render_events,function(i,ev){
					var item = item_template.clone();
					//-- support widget templates:
					var e = ev;
					var desc = e.description.split(' ');
					desc = desc.slice(0, options.words);
					e.description = desc.join(' ');
					//--
					if( options.using_calendar_url && ''!=options.using_calendar_url ){
						e.url = options.using_calendar_url; 
					}
					var href = e.url;
		
					var str = item_template.clone();
					str
						.find('.rhc-title-link')
							.html( e.title )
							.data('rhc_event',e)
							.attr('href', href )
							.end()
						.find('.rhc-event-link')
							.data('rhc_event',e)
							.attr('href', href )
							.end()
						.find('.rhc-description').html( e.description ).end()
						.find('.rhc-widget-date').html('').end()
						.find('.rhc-widget-time').html('').end()
						.find('.rhc-widget-end-date').html('').end()
						.find('.rhc-widget-end-time').html('').end()
						;
					
					if(''!=options.fcdate_format){
						str.find('.rhc-widget-date').html( $.fullCalendar.formatDate(e.start,options.fcdate_format,date_options) );
						str.find('.rhc-widget-end-date').html( $.fullCalendar.formatDate(e.end,options.fcdate_format,date_options) );
						//-- start end range
						dstart = $.fullCalendar.formatDate(e.start,'yyyy-MM-dd',date_options);
						dend = $.fullCalendar.formatDate(e.end,'yyyy-MM-dd',date_options);
						var diff =  Math.floor(( Date.parse(dend) - Date.parse(dstart) ) / 86400000);
						if( diff>0 ){
							tmp = $.fullCalendar.formatDate(e.start,options.fcdate_format,date_options) + ' &#8211; ' + $.fullCalendar.formatDate(e.end,options.fcdate_format,date_options);
							str.find('.rhc-widget-date-range').html( tmp );
							str.find('.rhc-day_diff0').hide();
						}else{
							str.find('.rhc-widget-date-range').html( $.fullCalendar.formatDate(e.start,options.fcdate_format,date_options) );
							str.find('.rhc-day_diff1').hide();
						}
						//--
					}
				
					if(''!=options.fctime_format && !e.allDay){
						str.find('.rhc-widget-time').html(  $.fullCalendar.formatDate(e.start,options.fctime_format,date_options) );
						str.find('.rhc-widget-end-time').html(  $.fullCalendar.formatDate(e.end,options.fctime_format,date_options) );
					}else{
						//str.find('.rhc-widget-date-time').hide();
					}
					
					if(e.allDay){
						str.addClass('fc-is-allday');
						str.find('.rhc-widget-time').hide();
					}
					
					//--- date parts
					str.find('.rhc-date-start').each(function(i,el){
						$(el).html( $.fullCalendar.formatDate(e.start, $(el).html(), date_options) );				
					});
					//--//rhc-featured-date 
					var done_day = $.fullCalendar.formatDate(e.start,'yyyyMMdd',date_options);
					if( -1==$.inArray(done_day,done_days) ){
						done_days.push(done_day);
					}else{
						str.find('.hide-repeat-date').addClass('repeated-date');
					}
					//---
					
					if(options.showimage==1){
						str.addClass('featured-1');
						if( e.image && e.image[0] && e.image[0]!='' ){
							$('<a></a>')
								.addClass('rhc-image-link')
								.data('rhc_event',e)
								.attr('href',href)
								.append( $('<img></img>').attr('src',e.image[0]) )
								.appendTo( str.find('.rhc-widget-upcoming-featured-image') )
							;
						}
					}else{
						str.addClass('featured-0');
						str.find('.rhc-widget-upcoming-featured-image').remove();
					}
					
					$(str).find('.rhc-title-link,.rhc-event-link,.rhc-image-link').click(function(_e){
						var args = {url: e.url}
						if(e.gotodate){
							args.gotodate = e.gotodate;
						}
						if(e.event_rdate){
							args.event_rdate = e.event_rdate;
						}
						return _rhc_widget_link_click(args,this);	
					});
					//--terms
					item=str;
					item.find('.fc-event-term')
						.empty().hide()
						.parent().addClass('rhc_event-empty-taxonomy')
					;
					if(ev.terms && ev.terms.length>0){
						$.each(ev.terms,function(i,t){		
							if( item.find('.taxonomy-'+t.taxonomy).parent().find('a').length>0 ){
								item.find('.taxonomy-'+t.taxonomy).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
							}
													
							if( t.name && ''!=t.name && item.find('.taxonomy-'+t.taxonomy).length>0 ){
								if( t.url=='' ){
									$('<span>'+ t.name +'</span>')
										.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy') )
									;	
								}else{
									$('<a>'+ t.name +'</a>')
										.attr('href',t.url)
										.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy') )
									;								
								}
		
							}
							
							if( item.find('.taxonomy-'+t.taxonomy+'-gaddress').length>0 && t.gaddress && t.gaddress!=''){
								if( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).parent().find('a').length>0 ){
									item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
								}							
								
								var _url = 'http://www.google.com/maps?f=q&hl=en&source=embed&q=' + escape(t.gaddress);
								$('<a>'+ t.gaddress +'</a>')
									.attr('href', _url)
									.attr('target','_blank')
									.appendTo( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).show().parent().removeClass('rhc_event-empty-taxonomy').end() )
								;	
							}
							
							for(var term_property in t) {
								if( term_property=='taxonomy' ) continue;
								term_property_value = t[term_property];
								if( item.find('.taxonomy-'+t.taxonomy+'-'+term_property).length>0 && term_property_value!=''){
									$('<span>'+ term_property_value +'</span>')
										.appendTo( item.find('.taxonomy-'+t.taxonomy+'-'+term_property) )
									;	
								}
							}								
						});
					}
					//-----------------------------------------------------------------							
					if(str.find('.move-out').length>0){
						str.find('.move-out').appendTo(sel);
					}		
					
					triggerRes = trigger('eventRender', ev, ev, str);
					if(false===triggerRes){
					
					}else{
						view_template.find('.fc-event-list-holder').append(str);
					}					
					trigger('loading', null, false);
					return;		
				});
			}else{
				calendar.options.widgetlist.dayspast = calendar.options.widgetlist.dayspast?calendar.options.widgetlist.dayspast:0;
				//default original view render
				events = [];
				var now = new Date();
				now.setDate(now.getDate()-calendar.options.widgetlist.dayspast);
				$.each(_events,function(i,ev){
					if(stack_events && t.rendered_events.length>0){
						//prevent repeating events when stacking is active.
						for(var a=0; a<t.rendered_events.length; a++){
							test_event = t.rendered_events[a];
							if( 'function'==typeof test_event.start.getTime && 'function'==typeof ev.start.getTime ){				
								if(test_event.id==ev.id && test_event.start.getTime()==ev.start.getTime() )return;
							}
						};
					}

					t.rendered_events.push(ev);

					if(calendar.options.eventList && 1==parseInt(calendar.options.eventList.removeended) ){
						if(ev.end!=null && ev.end<now)return;				
					}
					
					if(calendar.options.eventList && calendar.options.eventList.outofrange=='1'){
						//if(ev.end!=null && ev.start<t.visStart && ev.end<t.visEnd)return;
						if(ev.end!=null){
							if(ev.end<t.visStart)return;
						}
					}else{
						if(ev.start<t.visStart)return;
						if(ev.start>t.visEnd)return;				
					}
					events[events.length]=ev;
				});
				if(events.length==0)return;
				//---
				if( '1'==calendar.options.eventList.reverse ){
					events.sort(_rsort_events);
				}else{
					events.sort(_sort_events);
				}
				
				var extended_details_ids = [];
				var extended_details = calendar.options.eventList.extendedDetails && '1'==calendar.options.eventList.extendedDetails ? true : false;
				var last_date = '';		
				var done_days = [];//for eventlist widget supppport.	
				$.each(events,function(i,ev){
				
					if( 'undefined'!=typeof(calendar.options.eventList.display) && calendar.options.eventList.display>0 ){
						if(i>=calendar.options.eventList.display)return;
					}
					
					var item = item_template.clone();
					
					if(ev.gcal || ev.url==''){
						item
							.find('.fc-event-list-title').parent()
							.empty()
							.append( $('<span></span>').addClass('fc-event-list-title').html(ev.title) )
						;
					}else if(ev.direct_link){
						item
							.find('.fc-event-list-title').html(ev.title).end()
							.find('a.fc-event-link')
								.attr('href',ev.url)	
								.end()	
						;
					}else{
						item
							.find('.fc-event-list-title').html(ev.title).end()
							.find('a.fc-event-link')
								.attr('target','')
								.attr('href','javascript:void(0);')	
								.bind('click',function(e){
									var click_method = calendar.options.eventClick?calendar.options.eventClick:fc_click;
									click_method(ev,e,t);
								})
								.end()	
						;
					}
//extended_details=true;//force extended details
					var local_feed = ev.local_feed ? true : false;					
					if(extended_details && local_feed){									
						item.find('.fe-extrainfo-container')
							.addClass('skip-render')
							.addClass('ext_det_'+ev.id)
							.hide()
							.data('ev',ev)
							.before('<div class="ext-list-loading loading-events"><div class="ext-list-loading-1 ajax-loader loading-events"><div class="ext-list-loading-2x xspinner icon-xspinner-3"></div></div></div>')
							;
							
						if(-1==$.inArray(ev.id,extended_details_ids) ){
							extended_details_ids.push(ev.id);
						}	
					}
					
					if( true ){		
						//regular template
						//-----------------------------------------------------------------
						item
							.find('.fc-event-list-description').html(ev.description).end()
						;
		
						if( ev.description && ''==ev.description.replace(' ','') ){
							item.find('.fc-event-list-description').addClass('rhc-empty-description');
						}
						
						if(ev.fc_click_link=='none'){
							item.find('a.fc-event-link').addClass('fc-no-link');
						}
						
						//--thumbnail
						if(ev.image&&ev.image[0]){
							item.find('img.fc-event-list-image').attr('src',ev.image[0]);
						}else{
							item.find('.fc-event-list-featured-image').empty();
						}	
						//--hour
						if(ev.allDay){
							item.find('.fc-time').remove();
							item.find('.fc-end-time').remove();
							var _start_date_format = calendar.options.eventList.extDateFormat||'dddd MMMM d, yyyy.';
						}else{
							item.find('.fc-time').html( $.fullCalendar.formatDate(ev.start,'h:mmtt') );
							item.find('.fc-end-time').html( $.fullCalendar.formatDate(ev.end,'h:mmtt') );
							var _start_date_format = calendar.options.eventList.extDateFormat||'dddd MMMM d, yyyy.';
						}

						//--start
						if(ev.start){
							item.find('.fc-start').html( $.fullCalendar.formatDate(ev.start,_start_date_format,calendar.options) );
						}else{
							item.find('.fc-start').remove();
						}
						//--end
						if(ev.end){
							item.find('.fc-end').html( $.fullCalendar.formatDate(ev.end,_start_date_format,calendar.options) );
						}else{
							item.find('.fc-end')
								.parent().addClass('rhc_event-empty-taxonomy').end()
								.remove()
								
							;
						}
						//--remove link
						item.find('.fc-event-link.fc-event-list-title').each(function(i,el){				
							if( parseInt( RHC.disable_event_link ) && 'javascript:void(0);' == $(el).attr('href') ){
								$(el).replaceWith( $(el).text() );
							}
						});
						//--terms
						item.find('.fc-event-term')
							.empty().hide()
							.parent().addClass('rhc_event-empty-taxonomy')
						;
						if(ev.terms && ev.terms.length>0){
							$.each(ev.terms,function(i,t){		
								if( item.find('.taxonomy-'+t.taxonomy).parent().find('a').length>0 ){
									item.find('.taxonomy-'+t.taxonomy).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
								}
														
								if( t.name && ''!=t.name && item.find('.taxonomy-'+t.taxonomy).length>0 ){
									if( t.url=='' ){
										$('<span>'+ t.name +'</span>')
											.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy').end() )
										;	
									}else{
										$('<a>'+ t.name +'</a>')
											.attr('href',t.url)
											.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy').end() )
										;								
									}
			
								}
								
								if( item.find('.taxonomy-'+t.taxonomy+'-gaddress').length>0 && t.gaddress && t.gaddress!=''){
									if( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).parent().find('a').length>0 ){
										item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
									}							
									
									var _url = 'http://www.google.com/maps?f=q&hl=en&source=embed&q=' + escape(t.gaddress);
									$('<a>'+ t.gaddress +'</a>')
										.attr('href', _url)
										.attr('target','_blank')
										.appendTo( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).show().parent().removeClass('rhc_event-empty-taxonomy').end() )
									;	
								}
							});
						}
						
						if( ev.meta && ev.meta.length > 0 ){
							$.each( ev.meta, function(i,m){
								sel = '.fc-event-meta-' + m[0];
								val = m[1];
								item
									.find(sel).html(val).end()
								;	
															
							});
						}

						//-----------------------------------------------------------------						
					}
					
					triggerRes = trigger('eventRender', ev, ev, item);
					if(false===triggerRes){
					
					}else{
						if( calendar.options.eventList.ShowHeader && parseInt(calendar.options.eventList.ShowHeader)==1){
							var header_date = ev.start;
							if($.fullCalendar.formatDate(header_date,'yyyyMMdd')!=$.fullCalendar.formatDate(last_date,'yyyyMMdd')){
								last_date = header_date;
								var date_str = date_template.clone();
								date_str.find('.fc-event-list-date-header').html( $.fullCalendar.formatDate(ev.start, calendar.options.eventList.DateFormat||'dddd MMMM d, yyyy',calendar.options) );
								view_template.find('.fc-event-list-holder').append(date_str);
							}				
						}
						
						view_template.find('.fc-event-list-holder').append(item);
					}
				});	
				
				if( extended_details_ids.length>0 ){
					if( 'undefined'==typeof calendar.extended_detail_cache ){
						calendar.extended_detail_cache = {};
					}
				
					var pending_extended_details_ids = [];
					$.each(extended_details_ids,function(i,id){
						if( 'undefined' == typeof calendar.extended_detail_cache[id] ){
							pending_extended_details_ids.push(id);
						}
					});		

					if( pending_extended_details_ids.length == 0 ){
						//nothing missing, just render from cache.
						cb_render_extended_details( $, extended_details_ids, view_template, calendar );
					}else{
						url = RHC.ajaxurl;
						url = url + '?rhc_action=extended_details';
						
						if(extended_details_ids.length>0){
							$.each(extended_details_ids,function(i,id){
								url = url + '&ids[]=' + id;
							});
						}								

						ver = RHC.last_modified && ''!=RHC.last_modified ? RHC.last_modified : now.getTime() ;
						url = url + '&ver=' + ver; 
						
						queryString = url.substring( url.indexOf('?') + 1 );	

						hash = CryptoJS.MD5( queryString )
						u = hash.toString(CryptoJS.enc.Hex);	

						url = url + '&_=' + u ;						

						//some details are missing, complete with ajax.
						var ajax_args = {
							url: url,
							type:'GET',
							dataType:'html',
							not_used_data: {
								rhc_action:'extended_details',
								ids:extended_details_ids
							},
							success: function(data){									
								$.each(extended_details_ids,function(i,id){
									if( $(data).find('.'+id).length > 0 ){
										calendar.extended_detail_cache[id] = $(data).find('.'+id).clone();	
									}else{
										$(element).find('.skip-render.ext_det_'+id)
											.removeClass('skip-render')
											.removeClass('ext_det_'+id)
											.fadeIn('fast')
											.parent().find('.ext-list-loading').fadeOut('fast')
										;	
									}
								});
								
								cb_render_extended_details( $, extended_details_ids, view_template, calendar );
							},
							error: function(){
								$(element).find('.skip-render').show();
								$(element).parent().find('.ext-list-loading').fadeOut('fast');
								cb_render_extended_details( $, extended_details_ids, view_template, calendar );//render those in cache.
							}
						}					
						$.ajax(ajax_args);
					}
				}	
				
			}	
		}else{
			t.have_events = false;
			view_template.find('.fc-event-list-holder').append(no_events_template);	
			view_template.find('.fc-no-list-events-message').show();
		}
		trigger('loading', null, false);
	}
	
	function cb_render_extended_details( $, extended_details_ids, view_template, calendar ){
		$.each(extended_details_ids,function(i,id){
			if( 'undefined'==typeof calendar.extended_detail_cache[id] ){
				return
			};
			
			view_template.find('.ext_det_'+id).each(function(j,el){
				var replacement = calendar.extended_detail_cache[id].clone();
				var ev = $(el).data('ev');
				//-------------------------------------
				//fc_start
				replacement.find('.postmeta-fc_start .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.start, calendar.options.eventList.extDateFormat||'MMMM d, yyyy',calendar.options)
				);
				//fc_start_time
				replacement.find('.postmeta-fc_start_time .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.start, calendar.options.eventList.extTimeFormat||'h:mm tt',calendar.options)
				);
				//fc_start_datetime
				replacement.find('.postmeta-fc_start_datetime .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.start, calendar.options.eventList.extDateTimeFormat||'MMMM d, yyyy. h:mm tt',calendar.options)
				);
				//fc_end
				replacement.find('.postmeta-fc_end .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.end, calendar.options.eventList.extDateFormat||'MMMM d, yyyy',calendar.options)
				);
				//fc_end_time
				replacement.find('.postmeta-fc_end_time .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.end, calendar.options.eventList.extTimeFormat||'h:mm tt',calendar.options)
				);
				//fc_end_datetime
				replacement.find('.postmeta-fc_end_datetime .fe-extrainfo-value').html( 
					$.fullCalendar.formatDate(ev.end, calendar.options.eventList.extDateTimeFormat||'MMMM d, yyyy. h:mm tt',calendar.options)
				);
				//--rhp share button
				if( replacement.find('.fc-button-social-panels').length > 0 ){
					var share = replacement.find('.fc-button-social-panels');
					new_rhp_vars = share.data('rhp_vars');
					new_rhp_vars.shareLink = ev.url;
					new_rhp_vars.shareRedirectURI = ev.url;
					share.data('rhp_vars',new_rhp_vars);
				}
				//-------------------------------------
				replacement.find('.fe-image-holder').RHCLink( ev, $(el).closest('.fullCalendar').fullCalendar('getView') );
				
				original = 	$(el).replaceWith(replacement);
				replacement.parent().find('.ext-list-loading').fadeOut('fast');
			});
		});		
		$('BODY').trigger('dbox.loaded');			
	}
	
	function trigger(name, thisObj) {
		return calendar.trigger.apply(
			calendar,
			[name, thisObj || t].concat(Array.prototype.slice.call(arguments, 2), [t])
		);
	}
	
	function loading( isLoading, view, fc_options ){
		if(isLoading){
			t.scroll_lockdown = true;
			$(view.element).parents('.rhc_holder').addClass('stacking-loading');
		}else{
			t.scroll_lockdown = false;
			$(view.element).parents('.rhc_holder').removeClass('stacking-loading');
		}
	}
	
	function _sort_events(o,p){
		if(o.start>p.start){
			return 1;
		}else if(o.start<p.start){
			return -1;
		}else{
			return 0;
		}
	}
	function _rsort_events(o,p){
		if(o.start<p.start){
			return 1;
		}else if(o.start>p.start){
			return -1;
		}else{
			return 0;
		}
	}
}	

$.fullCalendar.views.rhc_detail = DetailView;	
function DetailView(element, calendar) {
	var t = this;
	var body;
	t.name = 'rhc_detail';
	t.render = render;
	t.unselect = unselect;
	t.setHeight = setHeight;
	t.setWidth = setWidth;
	t.clearEvents = clearEvents;
	t.renderEvents = renderEvents;
	t.trigger = trigger;
	t.viewChanged = viewChanged;
	t.beforeAnimation = beforeAnimation;
	
	t.element = element;
	
	function viewChanged(){
	
	}
	
	function beforeAnimation(oldView){
	
	}	
	function render(date,delta){
		t.start = date;//if not defined, hidden views do not update size on window resize.
		var firstTime = !body;
		if(firstTime){
			$('<div class="fc-detail-view-holder"><div class="fc-detail-view-content">TODO: a single event details. The button will be removed on the top right controls, and this view will be triggered when selecting an event.</div><div class="fc-detail-view-wp_footer" style="display:none;"></div></div>').appendTo(element);
			body = true;
		}else{
			 
		}
	}
	function unselect(){/*console.log('unselect');*/}
	function setHeight(h){
		//element.css('height',h);
		
		element.css('min-height','200px');
		element.css('height','auto');		
	}
	function setWidth(){/*console.log('setWidth');*/}
	function clearEvents(){
		/*console.log('clearEvents');*/
		$('.fc-detail-view-content').html( '' );
	}
	function renderEvents(){
		//console.log( calendar.last_clicked_event );
		//console.log('renderEvents');
		
		var args = {
			'id' : calendar.last_clicked_event.id
		};
		
		
		$.post(calendar.options.singleSource,args,function(data){
			if(data.R=='OK'){
				
				if( $('body .fc-single-item-holder').length==0 ){
					$('body').append('<div class="fc-single-item-holder"></div>');
				}
				
				$('body .fc-single-item-holder').empty();
				$(data.DATA.footer).each(function(i,inp){
					if( inp.nodeName && inp.nodeName=='SCRIPT'){
						var script   = document.createElement("script");
						if( $(inp).attr('type') ){
							script.type  = ($(inp).attr('type')||'');
						}
						if($(inp).attr('src')){
							script.src   = ($(inp).attr('src')||'');    // use this for linked script
						
						}else{
							script.text  = ($(inp).html()||'');
						}
						
						
						document.body.appendChild(script);
						
						//$('body .fc-single-item-holder').append( script );
						
					}else{
						$('body .fc-single-item-holder').append( inp );					
					}
				});
				
				$('.fc-detail-view-content').html( data.DATA.body );
			}
		},'json');
		
	}
	function trigger(){/*console.log('trigger');*/}
}	

})(jQuery);

function _rhc_widget_link_click(calEvent,el){
	var event = jQuery(el).data('rhc_event')||false;
	if(event && event.fc_click_target){
		var target = event.fc_click_target;
	}else{
		var target = '_self';
	}
	if(calEvent.event_rdate || calEvent.gotodate){
		jQuery('form#calendarizeit_repeat_instance').remove();
		var form = '<form id="calendarizeit_repeat_instance" method="post"></form>';
		jQuery(form)
			.attr('action',calEvent.url)
			.attr('target',target)
			.appendTo('BODY')	
		;
		if(calEvent.gotodate){
			jQuery('<input type="hidden" name="gotodate" value="' + calEvent.gotodate + '"/>')
				.appendTo('form#calendarizeit_repeat_instance')
			;
		}
		if(calEvent.event_rdate){
			jQuery('<input type="hidden" name="event_rdate" value="' + calEvent.event_rdate + '" />')
				.appendTo('form#calendarizeit_repeat_instance')
			;
		}

		jQuery('form#calendarizeit_repeat_instance')
			.submit(function(e){
				e.stopPropagation();
				var url = calEvent.url;				
				if( url == null || url.indexOf("javascript:void(0);") > 0 ){
					return false;
				}
				return true;
			})
			.submit()
		;	
	}else{
		var url = calEvent.url;
		if (url != null && url.indexOf("javascript:void(0);") == 0){
			return false;
		}	
		if(target=='_blank'){
			window.open(url);
		}else{
			location.href = url;
		}
	}
	return false;
}

function _rhc_sort_events(o,p){
	if(o.start>p.start){
		return 1;
	}else if(o.start<p.start){
		return -1;
	}else{
		return 0;
	}
}
/* SOURCE: js/md5.js */
;;/*
CryptoJS v3.1.2
code.google.com/p/crypto-js
(c) 2009-2013 by Jeff Mott. All rights reserved.
code.google.com/p/crypto-js/wiki/License
*/
var CryptoJS=CryptoJS||function(s,p){var m={},l=m.lib={},n=function(){},r=l.Base={extend:function(b){n.prototype=this;var h=new n;b&&h.mixIn(b);h.hasOwnProperty("init")||(h.init=function(){h.$super.init.apply(this,arguments)});h.init.prototype=h;h.$super=this;return h},create:function(){var b=this.extend();b.init.apply(b,arguments);return b},init:function(){},mixIn:function(b){for(var h in b)b.hasOwnProperty(h)&&(this[h]=b[h]);b.hasOwnProperty("toString")&&(this.toString=b.toString)},clone:function(){return this.init.prototype.extend(this)}},
q=l.WordArray=r.extend({init:function(b,h){b=this.words=b||[];this.sigBytes=h!=p?h:4*b.length},toString:function(b){return(b||t).stringify(this)},concat:function(b){var h=this.words,a=b.words,j=this.sigBytes;b=b.sigBytes;this.clamp();if(j%4)for(var g=0;g<b;g++)h[j+g>>>2]|=(a[g>>>2]>>>24-8*(g%4)&255)<<24-8*((j+g)%4);else if(65535<a.length)for(g=0;g<b;g+=4)h[j+g>>>2]=a[g>>>2];else h.push.apply(h,a);this.sigBytes+=b;return this},clamp:function(){var b=this.words,h=this.sigBytes;b[h>>>2]&=4294967295<<
32-8*(h%4);b.length=s.ceil(h/4)},clone:function(){var b=r.clone.call(this);b.words=this.words.slice(0);return b},random:function(b){for(var h=[],a=0;a<b;a+=4)h.push(4294967296*s.random()|0);return new q.init(h,b)}}),v=m.enc={},t=v.Hex={stringify:function(b){var a=b.words;b=b.sigBytes;for(var g=[],j=0;j<b;j++){var k=a[j>>>2]>>>24-8*(j%4)&255;g.push((k>>>4).toString(16));g.push((k&15).toString(16))}return g.join("")},parse:function(b){for(var a=b.length,g=[],j=0;j<a;j+=2)g[j>>>3]|=parseInt(b.substr(j,
2),16)<<24-4*(j%8);return new q.init(g,a/2)}},a=v.Latin1={stringify:function(b){var a=b.words;b=b.sigBytes;for(var g=[],j=0;j<b;j++)g.push(String.fromCharCode(a[j>>>2]>>>24-8*(j%4)&255));return g.join("")},parse:function(b){for(var a=b.length,g=[],j=0;j<a;j++)g[j>>>2]|=(b.charCodeAt(j)&255)<<24-8*(j%4);return new q.init(g,a)}},u=v.Utf8={stringify:function(b){try{return decodeURIComponent(escape(a.stringify(b)))}catch(g){throw Error("Malformed UTF-8 data");}},parse:function(b){return a.parse(unescape(encodeURIComponent(b)))}},
g=l.BufferedBlockAlgorithm=r.extend({reset:function(){this._data=new q.init;this._nDataBytes=0},_append:function(b){"string"==typeof b&&(b=u.parse(b));this._data.concat(b);this._nDataBytes+=b.sigBytes},_process:function(b){var a=this._data,g=a.words,j=a.sigBytes,k=this.blockSize,m=j/(4*k),m=b?s.ceil(m):s.max((m|0)-this._minBufferSize,0);b=m*k;j=s.min(4*b,j);if(b){for(var l=0;l<b;l+=k)this._doProcessBlock(g,l);l=g.splice(0,b);a.sigBytes-=j}return new q.init(l,j)},clone:function(){var b=r.clone.call(this);
b._data=this._data.clone();return b},_minBufferSize:0});l.Hasher=g.extend({cfg:r.extend(),init:function(b){this.cfg=this.cfg.extend(b);this.reset()},reset:function(){g.reset.call(this);this._doReset()},update:function(b){this._append(b);this._process();return this},finalize:function(b){b&&this._append(b);return this._doFinalize()},blockSize:16,_createHelper:function(b){return function(a,g){return(new b.init(g)).finalize(a)}},_createHmacHelper:function(b){return function(a,g){return(new k.HMAC.init(b,
g)).finalize(a)}}});var k=m.algo={};return m}(Math);
(function(s){function p(a,k,b,h,l,j,m){a=a+(k&b|~k&h)+l+m;return(a<<j|a>>>32-j)+k}function m(a,k,b,h,l,j,m){a=a+(k&h|b&~h)+l+m;return(a<<j|a>>>32-j)+k}function l(a,k,b,h,l,j,m){a=a+(k^b^h)+l+m;return(a<<j|a>>>32-j)+k}function n(a,k,b,h,l,j,m){a=a+(b^(k|~h))+l+m;return(a<<j|a>>>32-j)+k}for(var r=CryptoJS,q=r.lib,v=q.WordArray,t=q.Hasher,q=r.algo,a=[],u=0;64>u;u++)a[u]=4294967296*s.abs(s.sin(u+1))|0;q=q.MD5=t.extend({_doReset:function(){this._hash=new v.init([1732584193,4023233417,2562383102,271733878])},
_doProcessBlock:function(g,k){for(var b=0;16>b;b++){var h=k+b,w=g[h];g[h]=(w<<8|w>>>24)&16711935|(w<<24|w>>>8)&4278255360}var b=this._hash.words,h=g[k+0],w=g[k+1],j=g[k+2],q=g[k+3],r=g[k+4],s=g[k+5],t=g[k+6],u=g[k+7],v=g[k+8],x=g[k+9],y=g[k+10],z=g[k+11],A=g[k+12],B=g[k+13],C=g[k+14],D=g[k+15],c=b[0],d=b[1],e=b[2],f=b[3],c=p(c,d,e,f,h,7,a[0]),f=p(f,c,d,e,w,12,a[1]),e=p(e,f,c,d,j,17,a[2]),d=p(d,e,f,c,q,22,a[3]),c=p(c,d,e,f,r,7,a[4]),f=p(f,c,d,e,s,12,a[5]),e=p(e,f,c,d,t,17,a[6]),d=p(d,e,f,c,u,22,a[7]),
c=p(c,d,e,f,v,7,a[8]),f=p(f,c,d,e,x,12,a[9]),e=p(e,f,c,d,y,17,a[10]),d=p(d,e,f,c,z,22,a[11]),c=p(c,d,e,f,A,7,a[12]),f=p(f,c,d,e,B,12,a[13]),e=p(e,f,c,d,C,17,a[14]),d=p(d,e,f,c,D,22,a[15]),c=m(c,d,e,f,w,5,a[16]),f=m(f,c,d,e,t,9,a[17]),e=m(e,f,c,d,z,14,a[18]),d=m(d,e,f,c,h,20,a[19]),c=m(c,d,e,f,s,5,a[20]),f=m(f,c,d,e,y,9,a[21]),e=m(e,f,c,d,D,14,a[22]),d=m(d,e,f,c,r,20,a[23]),c=m(c,d,e,f,x,5,a[24]),f=m(f,c,d,e,C,9,a[25]),e=m(e,f,c,d,q,14,a[26]),d=m(d,e,f,c,v,20,a[27]),c=m(c,d,e,f,B,5,a[28]),f=m(f,c,
d,e,j,9,a[29]),e=m(e,f,c,d,u,14,a[30]),d=m(d,e,f,c,A,20,a[31]),c=l(c,d,e,f,s,4,a[32]),f=l(f,c,d,e,v,11,a[33]),e=l(e,f,c,d,z,16,a[34]),d=l(d,e,f,c,C,23,a[35]),c=l(c,d,e,f,w,4,a[36]),f=l(f,c,d,e,r,11,a[37]),e=l(e,f,c,d,u,16,a[38]),d=l(d,e,f,c,y,23,a[39]),c=l(c,d,e,f,B,4,a[40]),f=l(f,c,d,e,h,11,a[41]),e=l(e,f,c,d,q,16,a[42]),d=l(d,e,f,c,t,23,a[43]),c=l(c,d,e,f,x,4,a[44]),f=l(f,c,d,e,A,11,a[45]),e=l(e,f,c,d,D,16,a[46]),d=l(d,e,f,c,j,23,a[47]),c=n(c,d,e,f,h,6,a[48]),f=n(f,c,d,e,u,10,a[49]),e=n(e,f,c,d,
C,15,a[50]),d=n(d,e,f,c,s,21,a[51]),c=n(c,d,e,f,A,6,a[52]),f=n(f,c,d,e,q,10,a[53]),e=n(e,f,c,d,y,15,a[54]),d=n(d,e,f,c,w,21,a[55]),c=n(c,d,e,f,v,6,a[56]),f=n(f,c,d,e,D,10,a[57]),e=n(e,f,c,d,t,15,a[58]),d=n(d,e,f,c,B,21,a[59]),c=n(c,d,e,f,r,6,a[60]),f=n(f,c,d,e,z,10,a[61]),e=n(e,f,c,d,j,15,a[62]),d=n(d,e,f,c,x,21,a[63]);b[0]=b[0]+c|0;b[1]=b[1]+d|0;b[2]=b[2]+e|0;b[3]=b[3]+f|0},_doFinalize:function(){var a=this._data,k=a.words,b=8*this._nDataBytes,h=8*a.sigBytes;k[h>>>5]|=128<<24-h%32;var l=s.floor(b/
4294967296);k[(h+64>>>9<<4)+15]=(l<<8|l>>>24)&16711935|(l<<24|l>>>8)&4278255360;k[(h+64>>>9<<4)+14]=(b<<8|b>>>24)&16711935|(b<<24|b>>>8)&4278255360;a.sigBytes=4*(k.length+1);this._process();a=this._hash;k=a.words;for(b=0;4>b;b++)h=k[b],k[b]=(h<<8|h>>>24)&16711935|(h<<24|h>>>8)&4278255360;return a},clone:function(){var a=t.clone.call(this);a._hash=this._hash.clone();return a}});r.MD5=t._createHelper(q);r.HmacMD5=t._createHmacHelper(q)})(Math);
/* SOURCE: js/calendarize.js */
;;(function($){
	var methods = {
		init : function( options ){
			var settings = $.extend( {
				'editable':	false,
				'mode': 'view'
			}, options);		
			
			$('.fc-dialog').CalendarizeDialog();
			
			function fbd_move_cell(cell,destination){	
				if( !cell.hasClass('fbd-cell') ){
					cell = cell.parents('.fbd-cell');
				}				

				if( destination.hasClass('fbd-checked') ){
					var animation = {opacity:0,left:-30};
				}else{
					var animation = {opacity:0,left:30};
				}
				var _easing = 'linear';
				var _duration = 'fast';				
				if( destination.find('.fbd-cell').length==0 ){
					$(cell).animate(animation,_duration,_easing,function(){
						$(this).appendTo(destination).css('left',animation.left*-1).animate({opacity:1,left:0});
					});
				}else{
					var cells = destination.find('.fbd-cell');
					if( parseInt($(cell).data('tab-index')) > parseInt($(cells[cells.length-1]).data('tab-index')) ){
						//$(cell).appendTo(destination);
						$(cell).animate(animation,_duration,_easing,function(){
							$(this).appendTo(destination).css('left',animation.left*-1).animate({opacity:1,left:0});
						});
					}else if(parseInt($(cell).data('tab-index')) < parseInt($(cells[0]).data('tab-index'))){
						//$(cells[0]).before(cell);
						$(cell).animate(animation,_duration,_easing,function(){
							$(cells[0]).before(cell).prev()
								.css('left',animation.left*-1).animate({opacity:1,left:0});
						});								
					}else{
						for(a=0;a<cells.length;a++){
							var _destination = cells[a];
							if( (parseInt($(cell).data('tab-index')) > parseInt($(cells[a]).data('tab-index'))) && (parseInt($(cell).data('tab-index')) < parseInt($(cells[a+1]).data('tab-index'))) ){
								$(cell).animate(animation,_duration,_easing,function(){									
									$(_destination).after( 
										$(this).css('left',animation.left*-1).animate({opacity:1,left:0})
									);
								});		
								break;
							}
						}							
					}
				}
			}
	
			return this.each(function(){
				var data = $(this).data('Calendarize');
				if(!data){
					$(this)
						.data('Calendarize',settings)
						.Calendarize('mode',settings.mode)
					;
										
					//-- add a placeholder for lateral event list
					if($(this).find('.rhc-sidelist').length==0){
						$('<div class="rhc-sidelist-holder"><div class="rhc-sidelist-tab"><div class="rhc-sidelist-tab-label"></div></div><div class="rhc-sidelist-head"></div><div class="rhc-sidelist"></div></div>').appendTo(this);
						$(this).find('.rhc-sidelist-tab').click(function(e){					
							$(this).parents('.rhc-sidelist-holder').toggleClass('sidelist-open');
						});
					}
	
					//-- add a placeholder for a horizontal control bar
					if($(this).find('fullCalendar > .fc-head-control').length==0){
						//.fc-view-rhc_gmap
						//.fc-header
						var tax_filter_selector = '.fc-header';
						if( $(this).find(tax_filter_selector).length>0 ){
							$(this).find(tax_filter_selector).after('<div class="fc-head-control rh-flat-ui"><div class="tax_filter_nav"><a href="#" class="tax_filter_previous btn btn-small btn-taxfilter fui-arrow-left"></a></div><div class="tax_filter_holder_viewport"><div class="tax_filter_holder"></div></div></div>');						
							$(this).find('.tax_filter_previous').click(function(e){
								var holder = $(this).parents('.fc-head-control').find('.tax_filter_holder');
								holder.stop(false,true);
								if( holder.find('.tax_filter_item_holder').length>0 ){					
									var slide = holder.find('.tax_filter_item_holder').first();
									slide.stop(false,true);
									var width = -1*slide.outerWidth(true);
									var opacity = slide.css('opacity');			
									slide.animate({opacity:0},400,'swing');
									holder.animate({'margin-left':width},500,'swing',function(){								
										slide
											.stop(false,true)
											.appendTo(holder)
											.css('opacity',opacity)
										;
										$(this).css('margin-left',0);
									});
								}						
							});
						}
					}	
					//-- add dialog with appropiate taxonomies
					if($(this).find('.fc-lower-head-tools').length==0){
						$(this).find('.fc-header').after('<div class="fc-lower-head-tools"></div>');
						if( $(this).find('.fc-lower-head-tools .fc-filters-dialog').length==0 ){
							$(this).find('.fc-filters-dialog-holder .fc-filters-dialog').clone().appendTo( $(this).find('.fc-lower-head-tools') );
						}
					}	
					//-- limit height of filters-dialog
					var _h = parseInt($(this).find('.fc-content').innerHeight()) * 0.6;			
					_h = _h<300?300:_h;
					$(this).find('.fc-lower-head-tools .fc-filters-dialog').find('.fbd-unchecked').css('max-height',_h+'px');
					
					
					//-- tabs click				
					$(this).find('.fc-filters-dialog .fbd-tabs').on('click',function(e){
						$(this).parent().parent()
							.find('.fbd-tabs').removeClass('fbd-active-tab').end()
							.find('.fbd-tabs-panel').hide().end()
							.find( $(this).find('a').data('tab-target') ).show()
							;
						$(this).addClass('fbd-active-tab');
					}).first().trigger('click');
					//-- all unchecked unload
					$(this).find('.fbd-cell input[type="checkbox"]').attr('checked',false);
					//-- move checked items
					$(this).find('.fbd-cell input[type="checkbox"]').on('click',function(e){
						if( $(this).is(':checked') ){
							var destination = $(this).parent().parent().parent().parent().find('.fbd-checked');
						}else{
							var destination = $(this).parent().parent().parent().parent().find('.fbd-unchecked');
						}
						fbd_move_cell($(this).parent().parent(),destination);
					});
					//-- easier access
					$(this).find('.fullCalendar .fbd-dg-apply,.fullCalendar .fbd-dg-remove').attr('rel',$(this).attr('id'));
					//-- apply filter click
					$(this).find('.fullCalendar .fbd-dg-apply').on('click',function(e){
						return methods.apply_filter.apply( $(this),[]);
					});
					//-- close filter dialog
					$(this).find('.fbd-close-tooltip a').unbind('click').click(function(e){
						$(this).parents('.fullCalendar').find('.fc-button-rhc_search').trigger('click');
					});					
					//-- remove filter click
					$(this).find('.fullCalendar .fbd-dg-remove').on('click',function(e){
						//clear search forms:
						$(this).parents('.rhc_holder').find('input[name=s]').val('').trigger('change');
						
						$('#'+$(this).attr('rel'))
							.find('input[type=checkbox].fbd-filter').each(function(i,inp){
								if( typeof $(inp).attr('checked') == 'undefined' ) return;//no need to go throught the unchecked ones.													
								$(inp).attr('checked',false);
								var destination = $(this).parent().parent().parent().parent().find('.fbd-unchecked');
								fbd_move_cell($(this).parents('.fbd-cell'),destination);
							})/*.attr('checked',false)*/.end()
							.find('.fbd-dg-apply').trigger('click');
							$(this).closest('.fullCalendar').fullCalendar('gotoDate', $(this).closest('.fullCalendar').data('starting_date') );
							$(this).parents('.fullCalendar').find('.fc-button-rhc_search').trigger('click');
					});
					//--
					$(this).find('.fullCalendar .fc-header').on('click',function(e){
						$('.fct-tooltip').trigger('close-tooltip');
					});
					//--
					$(document).keyup(function(e) {
						if (e.keyCode == 27) { 
							$('.fct-tooltip').trigger('close-tooltip'); 	
							$('.fc-filters-dialog:visible').stop()
								.find('.fbd-unchecked').css('overflow-y','hidden').end()
								.animate({opacity:0,top:-10},'fast','linear',function(){$(this).hide();});							
						}
					});		
					//-- add a bottom arrow
					if( $(this).find('fc-view-loading-bottom').length==0 ){
						$(this).find('.fullCalendar .fc-footer')										
							.before(
								$('<div class="fc-view-loading-bottom"></div>')
									.append( 
										$('<div class="fc-view-loading-bottom-1"><div class="fc-view-loading-bottom-2 fc-next-arrow"></div></div>') 
											.click(function(e){
												$(this).parents('.rhc_holder').find('.fullCalendar').fullCalendar('next');
											})								
									)
							)						
						;					
					}

					//--
					$(this).trigger('rhc_loaded');								
				}
			});
		},
		mode : function ( mode ){
			var _this = this;
			var data = $(this).data('Calendarize');
			if( !data || !data.modes ) return;
			var fc_options = $.extend( data.common, data.modes[mode].options);	
			var regColorcode = /^(#)?([0-9a-fA-F]{3})([0-9a-fA-F]{3})?$/;
			//--
			preload_events( this, fc_options );	
					
			if(fc_options.for_widget){
				fc_options.eventRender = function (event,element,view){					
					return cb_event_render(calendar,true,event,element,view,fc_options);
				};
				
				fc_options.eventAfterAllRender = function ( view ){
					hide_widget_event_list( calendar, false, null, null, view, fc_options);
					return cb_event_render_all( calendar, true, null, null, view, fc_options);
				};
				
				fc_options.dayClick = function (date,allDay,jsEvent,view){
					return cb_dayclick(date,allDay,jsEvent,view,fc_options,_this);
				}			
			}else{
				fc_options.eventRender = function (event,element,view){	
					if( 'rhc_grid'!=view.name ){
						$('.fc-event-title', element).html(event.title);
					}			
					return cb_event_render(calendar,false,event,element,view,fc_options);
				}
				fc_options.eventAfterAllRender = function ( view ){
					return cb_event_render_all( calendar, false, null, null, view, fc_options);
				};								
			}

			fc_options.loading = function( isLoading, view ){							
				return cb_events_loading(_this, this, isLoading, view, calendar, fc_options);
			}	
			
			fc_options.eventDataTransform = function(data){
				if( data.start && data.start.getFullYear ){
					if(!data.terms){
						data.terms=[]
					}
					//-- month
					var new_term = {
						filter_type: 'AND',
						term_priority: parseInt(data.start.getMonth()),
						description: $.fullCalendar.formatDate( data.start, 'MMMM', fc_options ),
						taxonomy: 'core_month',
						taxonomy_label: (fc_options.tax_filter_label && fc_options.tax_filter_label.month) ? fc_options.tax_filter_label.month : 'month',
						slug: $.fullCalendar.formatDate( data.start, 'M', fc_options )
					};
					data.terms.unshift(new_term);
					
					//-- year
					var year = data.start.getFullYear();
					var new_term = {
						filter_type: 'AND',
						term_priority: parseInt(year),
						description: year,
						taxonomy: 'core_year',
						taxonomy_label: (fc_options.tax_filter_label && fc_options.tax_filter_label.year) ? fc_options.tax_filter_label.year : 'year',
						slug: parseInt(year)
					};				
					data.terms.unshift(new_term);
				}
				
				return data;
			}
			
			/*
			fc_options.events = function(start, end, callback) {
		        $.fn.Calendarize.events_source(start, end, callback, fc_options);
		    };
			*/
			var rhc_event_src = function(start, end, callback) {
		        $.fn.Calendarize.events_source(start, end, callback, fc_options);
		    };
			
			fc_options.eventSources = [];
			if(fc_options.json_only!='1'){
				fc_options.eventSources.push(rhc_event_src);
			}		
			if( fc_options.json_feed && fc_options.json_feed.length>0 ){
				if(fc_options.json_only=='1'){
					fc_options.events = null;
					fc_options.singleSource = null;				
				}
				
				if( fc_options.json_feed && fc_options.json_feed.length>0 ){
					$.each(fc_options.json_feed,function(i,f){
						if(f.rhc_feed && f.rhc_feed=='1'){
							var rhc_feed_src = function(start,end,callback){
								$.fn.Calendarize.rhc_feed_src(start, end, callback, f, fc_options);
							}
							fc_options.eventSources[fc_options.eventSources.length] = rhc_feed_src;
						}else{			
							//fc_options.eventSources = fc_options.eventSources.concat(f);
							var rhc_ext_event_src = function(start, end, callback) {
						        $.fn.Calendarize.ext_events_source(start, end, callback, f, fc_options);
						    };							
							fc_options.eventSources[fc_options.eventSources.length] = rhc_ext_event_src;
						}						
					});
				}			
			}	
  					
			/* deprecated fc 1.64
			fc_options.viewDisplay = function(view,element){ //this will change to viewRender
				cb_view_display( fc_options.for_widget,calendar,view,element );
			};	
			*/
			fc_options.viewRender = function(view,element){ 
				cb_view_display( fc_options.for_widget,calendar,view,element );
			};
			
			fc_options.eventMouseover = function(event, jsEvent, view){
				cb_event_mouseover( event, jsEvent, view );			
				if( fc_options.tooltip_on_hover && '1'==fc_options.tooltip_on_hover ){
					$(jsEvent.target).closest('a').click();
				}
				
				$(jsEvent.target).closest('a').addClass('event-hovered');
			}	
				
			fc_options.eventMouseout = function(event, jsEvent, view){
				$(jsEvent.target).closest('a').removeClass('event-hovered');
			}	
					
			fc_options.calendar_id = $(this).attr('id');									
//sources ----------
			f = $(this).find('.fullCalendar').fullCalendar( fc_options );
			if(data.editable && f.find('.fc-edit-tools').length==0 ){
				f.prepend('<div class="fc-edit-tools"></div>');
			}	
			
			if( f.find('.fc-footer').length==0 ){
				f.append('<div class="fc-footer"></div>');
				if(fc_options.icalendar_align){
					$('.fc-footer')
						.css('text-align',fc_options.icalendar_align)
						.addClass('dlg-align-'+fc_options.icalendar_align)
					;
				}
			}
			
			//--some cleanup of the header--
			if( fc_options.header && (fc_options.header.center+fc_options.header.left+fc_options.header.right).length==0 ){
				$(this).find('.fc-header').css('display','none');
				$(this).find('.fc-edit-tools').css('display','none');
				$(this).find('.fc-head-control').css('display','none');
				$(this).find('.fc-lower-head-tools').css('display','none');
				$(this).find('.fc-header').attr('hello',1);
			}
						
			if(true){
//-----------------------------------
				var e = f.find('.fc-footer');
				var calendar = f;
				var tm = fc_options.theme ? 'ui' : 'fc';
				if( $( ".ical-tooltip-template" ).length>0 ){
						var text = $( ".ical-tooltip-template" ).first().data('button_text');
						add_footer_button({
							calendar: f,
							calendarize:_this,
							e:e,
							tm:tm,
							label:text,
							buttonName:'icalendar',
							buttonClick:ical_footer_button_click
						});														
				}	
//-----------------------------------			
			}
			
			if(fc_options.gotodate && fc_options.gotodate!=''){
				 $(this).find('.fullCalendar').fullCalendar('gotoDate', $.fullCalendar.parseDate(fc_options.gotodate) );
			}
			
			$(this).find('.fullCalendar').data('starting_date', $(this).find('.fullCalendar').fullCalendar( 'getDate' ) );
			
			//--
			render_tax_filters.apply(this, [fc_options] );
		},
		destroy : function(){
			return this.each(function(){
				var $this = $(this),
				    data = $this.data('Calendarize');
				$(window).unbind('.Calendarize');
				data.Calendarize.remove();
				$this.removeData('Calendarize');
			});
		},
		apply_filter: function( trigger_rhc_search ){
			trigger_rhc_search = 'undefined'==typeof trigger_rhc_search ? true : trigger_rhc_search;
			//trigger_rhc_search = false===trigger_rhc_search?false:||true;
			return this.each(function(){			
				var cal_id = '#'+$(this).attr('rel');
				//--- clear bg color
				$(cal_id+' .fullCalendar').find('.bg_matched').each(function(i,el){
					$(el)
						.css('background-color', ($(el).data('original_bg')||'') )
					;			
				});	
				//-----
				var taxonomies = [];
				$(cal_id+' .fullCalendar').find('.fbd-filter-group').each(function(i,element){		
					var terms=[];
					$(element).find('input[type=checkbox].fbd-filter:checked').each(function(j,inp){
						terms[terms.length]=$(inp).val();
					});
					if(terms.length>0){
						taxonomies[taxonomies.length]={
							'taxonomy':$(this).data('taxonomy'),
							'terms':terms.join(','),
							'terms_array':terms
						};
					}
				});
				
				var data = $(cal_id).data('Calendarize');
				var fc_options = data.modes[data.mode].options;
			
				fc_options.calendar_id = $(cal_id).attr('id');	
				var fc = $(cal_id + ' .fullCalendar');	
			
				var current_view = fc.fullCalendar('getView');
				current_view.clear_events = true;			
				
				var filter = '';
				if(taxonomies){
					$.each(taxonomies,function(i,t){
						if(fc_options.replace_square_brackets){
							filter += '&tax%5B'+t.taxonomy+'%5D=' + t.terms ;
						}else{
							filter += '&tax['+t.taxonomy+']=' + t.terms ;								
						}
					});
				}
				//-- handle search string
				if( $(cal_id).find('.fc-lower-head-tools  input[name=s]').length ){
					var s = $(cal_id).find('.fc-lower-head-tools  input[name=s]').val();
					if(''!=s){
						filter += '&s=' + escape( s )
					}
				}
									
				fc_options.events_source_query_original = fc_options.events_source_query_original?fc_options.events_source_query_original:fc_options.events_source_query;
				if(''!=filter){
					fc.fullCalendar('removeEventSources');
					fc_options.events_source_query = fc_options.events_source_query_original + filter;
				}else{
					fc.fullCalendar('removeEventSources');
					fc_options.events_source_query = fc_options.events_source_query_original;
				}
	
				var new_source = function(start, end, callback) {
					$.fn.Calendarize.events_source(start, end, callback, fc_options);
				};
				fc.fullCalendar('addEventSource',new_source);
				
				if(taxonomies.length==0){				
					if(fc_options.json_feed && fc_options.json_feed.length > 0){
			//			fc.fullCalendar('removeEventSources');
						$.each(fc_options.json_feed,function(i,f){
							//fc.fullCalendar('addEventSource',f);
							if(f.rhc_feed && f.rhc_feed=='1'){
								var rhc_feed_src = function(start,end,callback){
									$.fn.Calendarize.rhc_feed_src(start, end, callback, f, fc_options);
								}
								fc.fullCalendar('addEventSource',rhc_feed_src);
							}else{
								//fc.fullCalendar('addEventSource',f);
								var rhc_ext_event_src = function(start, end, callback) {
							        $.fn.Calendarize.ext_events_source(start, end, callback, f, fc_options);
							    };							
								fc.fullCalendar('addEventSource',rhc_ext_event_src);
							}							
						});			
					}	
				}else{
					var filtered_sources = [];
					$.each(taxonomies,function(i,tax){
						$.each(tax.terms_array,function(j,tax_term){	
							if( fc_options.json_feed && fc_options.json_feed.length>0 ){
								$.each(fc_options.json_feed,function(i,f){
									if( $.inArray(f,filtered_sources) > -1 ) return;
									if(f.terms && f.terms.length>0){
										for(var i=0;i<f.terms.length;i++){					
											if( f.terms[i].taxonomy == tax.taxonomy && f.terms[i].slug == tax_term ){					
												if( -1 == $.inArray(f,filtered_sources) ){
													filtered_sources.push(f);
												}	
												return;				
											}
										}
									}
								});								
							}						
						});				
					});
					$.each(filtered_sources,function(i,f){
						if(f.rhc_feed && f.rhc_feed=='1'){
							var rhc_feed_src = function(start,end,callback){
								$.fn.Calendarize.rhc_feed_src(start, end, callback, f, fc_options);
							}
							fc.fullCalendar('addEventSource',rhc_feed_src);
						}else{
							//fc.fullCalendar('addEventSource',f);
							var rhc_ext_event_src = function(start, end, callback) {
						        $.fn.Calendarize.ext_events_source(start, end, callback, f, fc_options);
						    };							
							fc.fullCalendar('addEventSource',rhc_ext_event_src);
						}
					});					
				}

				if( 'rhc_gmap' == current_view.name || 'rhc_grid' == current_view.name ){
					//note: this behavior only makes sense in map view and grid view because these change the date automatically, so a change
					//in the dropdown needs to reset the pagination.
					$(this).closest('.fullCalendar').fullCalendar('gotoDate', $(this).closest('.fullCalendar').data('starting_date') );
				}
								
				if( trigger_rhc_search ){
					$(this).parents('.fullCalendar').find('.fc-button-rhc_search').trigger('click');
				}
				//Removed because gotoDate already calls render, and the extra line was causing a race condition where the first set of events are skipped
				//effectively showing events in the future, and not the inmediate events
				//$(this).closest('.fullCalendar').fullCalendar('render');
				$(this).closest('.fullCalendar').find('.fc-no-list-events-message').hide();
			});
		}
	};
	
	$.fn.Calendarize = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.Calendarize' );
		}    
	};
	
	var rhc_events_cache = [];
	  
	$.fn.Calendarize.rhc_feed_src = function( start, end, callback, f, fc_options){
		jQuery(document).ready(function($){
			var use_cache = true;
			var data = [];
			var now = new Date();
			var _fingerprint = RHC.last_modified && ''!=RHC.last_modified ? RHC.last_modified : now.getTime() ;
			var args = {
				start:		Math.round(start.getTime() / 1000),
				end:		Math.round(end.getTime() / 1000),
				'_': _fingerprint,
				'data[]': 	data
			};
			
			for(var a=0;a<rhc_events_cache.length;a++){		
				if(
					use_cache &&
					rhc_events_cache[a].start <= args.start &&
					rhc_events_cache[a].end	>= args.end &&
					rhc_events_cache[a].url == f.url
				){		
					if(parseInt(fc_options.debugjs))rhc_console('rhc_feed_src.  Loading from rhc_events_cache.');																				
					callback(rhc_events_cache[a].events);
					return;
				}
			}		  		

			var cache = args;
			cache.url = f.url;	
			
			$.post(f.url,args,function(data){
				if(data.R=='OK'){
					var events = [];
					events = rhc_events_to_fc_events(start,end,data,false);
					//-----	
					cache.events = events;
					
					if( !in_rhc_events_cache( cache.start, cache.end, cache.url ) ){									
						rhc_events_cache[rhc_events_cache.length]=cache;
					}else{
		
					}
								
					callback(events);
				}else if(data.R=='ERR'){
					//alert(data.MSG);
				}else{
					//alert('Unexpected error');
				}
			},'json');				
		});
	}
	
	$.fn.Calendarize.ext_events_source = function( start, end, callback, f, fc_options ){
		jQuery(document).ready(function($){
			var use_cache = true;
			var data = [];
			var now = new Date();
			var _fingerprint = RHC.last_modified && ''!=RHC.last_modified ? RHC.last_modified : now.getTime() ;
			var args = {
				start:		Math.round(start.getTime() / 1000),
				end:		Math.round(end.getTime() / 1000),
				'_': _fingerprint,
				'data[]': 	data
			};
			
			for(var a=0;a<rhc_events_cache.length;a++){		
				if(
					use_cache &&
					rhc_events_cache[a].start <= args.start &&
					rhc_events_cache[a].end	>= args.end &&
					rhc_events_cache[a].url == f.url
				){		
					if(parseInt(fc_options.debugjs))rhc_console('rhc_feed_src.  Loading from rhc_events_cache.');																					
					callback(rhc_events_cache[a].events);
					return;
				}
			}		  		

			var cache = args;
			cache.url = f.url;	
			
			$.post(f.url,args,function(data){		
				cache.events = data;
				if( !in_rhc_events_cache( cache.start, cache.end, cache.url ) ){									
					rhc_events_cache[rhc_events_cache.length]=cache;
				}else{
	
				}
				callback( cache.events );
			},'json');				
		});
	}
	
	$.fn.Calendarize.events_source = function( start, end, callback, fc_options ){			
		jQuery(document).ready(function($){
			var data = [];
			$('.calendarize_meta_data').each(function(i,inp){
				if(inp.type=='checkbox'){
					data[data.length] = [inp.name,($(inp).is(':checked')?1:0)];
				}else{
					data[data.length] = [inp.name,($(inp).val())];
				}
			});
	
			var url = fc_options.events_source + fc_options.events_source_query;
			//wpml
			if(typeof icl_lang!='undefined'){
				url += '&lang=' + icl_lang;
			}else if( typeof icl_vars!='undefined' && icl_vars.current_language ){
				url += '&lang=' + icl_vars.current_language;
			}
			//end wpml	


			if( fc_options.calendar_id && ''!=fc_options.calendar_id ){
				vo = $('#'+fc_options.calendar_id).find('.fullCalendar').fullCalendar('getView');
				view_name = vo.name;
			}else{
				view_name = '';
			}
			
			var use_cache = true;
			var now = new Date();
			var _fingerprint = RHC.last_modified && ''!=RHC.last_modified ? RHC.last_modified : now.getTime() ;
			var args = {
				start:		Math.round(start.getTime() / 1000),
				end:		Math.round(end.getTime() / 1000),
				rhc_shrink: (fc_options.shrink?parseInt(fc_options.shrink):''),
				view: view_name,
				'ver': _fingerprint,
				'_': '',
				'data[]': 	data
			};

			for(var a=0;a<rhc_events_cache.length;a++){

				if(
					use_cache &&
					rhc_events_cache[a].start <= args.start &&
					rhc_events_cache[a].end	>= args.end &&
					rhc_events_cache[a].url == url
				){		
					if(parseInt(fc_options.debugjs))rhc_console('Loading from rhc_events_cache.');																
					callback(rhc_events_cache[a].events);
					return;
				}
			}		
			
			var cache = args;
			cache.url = url;				
			/*
			$.post(url,args,function(data){
				if(data.R=='OK'){
					var events = [];
					events = rhc_events_to_fc_events(start,end,data,true);
					//-----	
					cache.events = events;
					rhc_events_cache[rhc_events_cache.length]=cache;				
					callback(events);
				}else if(data.R=='ERR'){
					//alert(data.MSG);
				}else{
					//alert('Unexpected error');
				}
			},'json');		
			*/
			url = url + '&start=' + args.start + '&end=' + args.end + '&rhc_shrink=' + args.rhc_shrink + '&view=' + args.view + '&ver=' + args.ver;
			if(data.length>0){
				$.each(data,function(i,d){
					url = url + '&data[' + i + '][0]=' + d[0];
					url = url + '&data[' + i + '][1]=' + d[1];
				});
			}			
			
			//ver is a hash representing the latest update
			//_ is a hash representing a query with the exact query string
						
			queryString = url.substring( url.indexOf('?') + 1 );	
			hash = CryptoJS.MD5( queryString )
			args._ = hash.toString(CryptoJS.enc.Hex);	
	
			url = url + '&_=' + args._ ;
			
			function _handle_event_source_ajax_response( data ){
				if(data.R=='OK'){
					var events = [];
					events = rhc_events_to_fc_events(start,end,data,true);
					events = handle_local_tz( events, fc_options, data );
					events = allday_group( events, fc_options );
					//-----	
					cache.events = events;
					
					if( !in_rhc_events_cache( cache.start, cache.end, cache.url ) ){					
						rhc_events_cache[rhc_events_cache.length]=cache;
					}else{
			
					}
									
					callback(events);
				}else if(data.R=='ERR'){
					//alert(data.MSG);
				}else{
					//alert('Unexpected error');
				}
			}
			
			$.ajax({
	       		url: url,
				type: 'GET',
				contentType:"application/json; charset=utf-8",
				dataType: 'json',
				cache: true,
	       		success: function(data){ 
					_handle_event_source_ajax_response( data );
	       		},
				error: function( jqXHR, textStatus, err ){		
					if( 'parsererror'==textStatus ){
						try {
							response = jqXHR.responseText.replace( /<!--[\s\S]*?-->/g, "");
							data = $.parseJSON( response );
							
							_handle_event_source_ajax_response( data )
						}catch(e){
						
						}			
					}	
				}     
	    	});//$.ajax				
			
		});
	}
	
	$.fn.RHCLink = function ( ev, view ){
		var t= view;
		var calendar = view.calendar
		var options = calendar.options;
		
        var settings = $.extend({
        	eventClick: 'fc_click'    
        }, options );	
		
		var target = ev.fc_click_target || '_self';
		
		if(ev.gcal || ev.url==''){
			return $(this);
		}else if(ev.direct_link){
			return $(this).wrap( $('<a></a>').attr('href', ev.url).attr('target',target) ).parent();
		}else{
			return $(this).wrap( 
				$('<a></a>')
					.attr('target',target)
					.attr('href', ev.url ) 	
					.unbind('click')
					.bind('click',function(e){
						var click_method = calendar.options.eventClick?calendar.options.eventClick:fc_click;
						return click_method(ev,e,t);
					})							
			).parent();
		}
	}
	
	function allday_group( events, fc_options ){
		_allday_group = 'undefined' != typeof fc_options.allday_group && 0<parseInt(fc_options.allday_group) ? parseInt(fc_options.allday_group) : 0 ;
		if( 0 < _allday_group ){
			$.each(events,function(i,e){
				if( 'undefined' != typeof e.color && e.color!='' ){
					if( 1==_allday_group ){
						//group by event color
						e.title = '<span style="display:none;">' + e.color + '</span>' + e.title;
					}else if( 2==_allday_group ){
						//group by menu_order
						if( 'undefined'!=typeof e.menu_order ){
							e.title = '<span style="display:none;">' + parseInt(e.menu_order) + '</span>' + e.title;
						}
					}
				}	
			});			
		}

		return events;
	}
	
	function preload_events( o, fc_options ){
		if( fc_options.preload && $(o).find('.rhc-preload').length ){
			$(o).find('.rhc-preload').each(function(i,el){
				if( !$(el).data('preloaded') ){
					$(el).data('preloaded', true);
					try {
						cache = $(el).data('request');
						cache = eval(cache);
						if( cache ){
							if( $(el).data('events') ){
								tmp_events = $(el).data('events');
								data = eval( tmp_events );
							}else{
								data = $.parseJSON( $(el).html() );
							}
							
							external_source = $(el).data('external_source') || false;
							
							if(data.R=='OK'){
								cache.url = $(el).data('url');
								if( !in_rhc_events_cache( cache.start, cache.end, cache.url ) ){
									//---
									cache.events = data.EVENTS;					
									var events = [];
									start = new Date( cache.start * 1000 );
									end = new Date( cache.end * 1000 );
									events = rhc_events_to_fc_events( start, end, data, true );
									events = handle_local_tz( events, fc_options, data );
									//-----	
									cache.events = events;
									rhc_events_cache[rhc_events_cache.length]=cache;									
								}	
							}else if( external_source && 'object' == typeof data ){
								cache.url = $(el).data('url');
								if( !in_rhc_events_cache( cache.start, cache.end, cache.url ) ){
									cache.events = data.EVENTS;					
									var events = data;
									start = new Date( cache.start * 1000 );
									end = new Date( cache.end * 1000 );
									
									events = handle_local_tz( events, fc_options, data );
									//-----	
									cache.events = events;
									rhc_events_cache[rhc_events_cache.length]=cache;									
								}	
							}				
						}						
					}catch(e){
					
					}					
				}
			});
		}
	}
	
	function in_rhc_events_cache( start, end, url ){
		for(var a=0;a<rhc_events_cache.length;a++){
			if(
				rhc_events_cache[a].start <= start &&
				rhc_events_cache[a].end	>= end &&
				rhc_events_cache[a].url == url
			){		
				return true;
			}
		}		
		return false;
	}
	
	function handle_local_tz( events, fc_options, data ){
		local_tz = ('local_tz' in fc_options) ? parseInt(fc_options.local_tz) : 0 ;

		if( 0==local_tz ) return events;
		
		if( 'GMT_OFFSET' in data ){
			var source_offset = data.GMT_OFFSET * -1 * 60;
			var destination_offset = new Date().getTimezoneOffset();
			if( source_offset==destination_offset ) return events;
			for (var i = 0; i < events.length; i++) {
				if( !events[i].allDay ){				
					if( 'object' == typeof events[i].start )
						events[i].start = date_change_offset( events[i].start, source_offset );
					if( 'object' == typeof events[i]._start )
						events[i]._start = date_change_offset( events[i]._start, source_offset );	
					if( 'object' == typeof events[i].end )
						events[i].end = date_change_offset( events[i].end, source_offset );	
					if( 'object' == typeof events[i]._end )
						events[i]._end = date_change_offset( events[i]._end, source_offset );	
					//---
					var period = jQuery.fullCalendar.formatDate(  events[i].start, "yyyyMMddHHmmss" );
					var end = jQuery.fullCalendar.formatDate(  events[i].end, "yyyyMMddHHmmss" );
					if( period && ''!=period ){
						if(end && ''!=end){
							period = period + ',' + end;
						}
						events[i].event_rdate = period;
						events[i].url = '' == events[i].url ? '' : _add_param_to_url( events[i].url, 'event_rdate', events[i].event_rdate );
					}								
				}
			}
		}

		return events;
	}
	
	function date_change_offset( _date, source_offset ){
		return new Date( _date.getTime() - (60000*(_date.getTimezoneOffset() - source_offset)));
	}
					
	function handle_field_map(data){
		if( data.MAP && data.MAP.length > 0 && data.EVENTS && data.EVENTS.length > 0 ){
			new_events = [];
			jQuery.each( data.EVENTS, function(i,ev){
	
				new_ev = {};
				jQuery.each( data.MAP, function(j,m){
					if( ev[m[0]] ){
						new_ev[m[1]] = ev[m[0]];
					}
				});
				/* bug fix, when empty allday is not correctly defined.*/
				if(typeof new_ev['allDay']=='undefined'){
					new_ev['allDay']=false;
				}
				
				if( new_ev.terms && new_ev.terms.length>0 ){
					//-- replace object
					new_terms = [];
					jQuery.each( new_ev.terms, function(k,term){
						if( typeof term=='object' ){
							new_terms[ k ] = term;
						}else{
							new_terms[ k ] = data.TERMS[term];					
						}
					});		
					new_ev.terms = new_terms;
								
					//-- replace field names
					new_terms = [];
					jQuery.each( new_ev.terms, function(k,term){
						new_term = {};
						jQuery.each( data.MAP, function(j,m){
							if( term[m[0]] ){
								new_term[m[1]] = term[m[0]];
							}
						});
						new_terms[ new_terms.length ] = new_term;			
					});
					new_ev.terms = new_terms;
				}

				new_events[new_events.length]=new_ev;
			});		
			data.EVENTS = new_events;
		}
	
		return data;
	}
	
	function rhc_events_to_fc_events(start,end,data,local_feed){
		var events = [];
		data = handle_field_map(data);
		if(data.EVENTS.length>0){
			$(data.EVENTS).each(function(i,e){	
				e.premiere = true;
				e.description = typeof e.description=='undefined' ? '' : e.description ;
				e.local_feed = typeof e.local_feed=='undefined' ? local_feed : e.local_feed; 	
				if( !e.color || e.color=='' || e.color=='#' ){
					if(e.terms && e.terms.length>0){
						for(var a=0;a<e.terms.length;a++){
							var color = e.terms[a].background_color && e.terms[a].background_color.length>1 ? e.terms[a].background_color : false ;
							var textColor = e.terms[a].color && e.terms[a].color.length>1 ? e.terms[a].color : false ; 
							
							textColor = color && false===textColor ? '#fff' : textColor;
							color = textColor && false===color ? '#fff' : color;
							
							if(color && textColor){
								e.color = color;
								e.textColor = textColor;
								break;
							}
						}
					}						
				}

				if('undefined'==typeof(e.start) || null==e.start)return;
				e.src_start = e.start;
				e.fc_rrule = e.fc_rrule?e.fc_rrule:'';
				if(''==e.fc_rrule && ''==e.fc_rdate){
					events[events.length]=e;
				}else{						
					var duration = false;
					var e_start = new Date( $.fullCalendar.parseDate( e.start ) );
					if(e.end){
						var e_end = new Date( $.fullCalendar.parseDate( e.end ) );
						duration = e_end.getTime() - e_start.getTime();
					}	
//								var fc_start = new Date(e.fc_start+' '+e.fc_start_time);
//								var fc_start = new Date(e.start);
					var fc_start = $.fullCalendar.parseDate( e.start );
					e.fc_rrule = ''==e.fc_rrule?'FREQ=DAILY;INTERVAL=1;COUNT=1':e.fc_rrule;
					
					
					try {
						scheduler = new Scheduler(fc_start, e.fc_rrule, true);
						if(e.fc_interval!='' && e.fc_exdate){
							//handle exception dates
							var fc_exdate_arr = exdate_to_array_of_dates(e.fc_exdate);
							if(fc_exdate_arr.length>0)
								scheduler.add_exception_dates(fc_exdate_arr);
						}	
						if(e.fc_rdate && e.fc_rdate!=''){
							//handle rdates
							var fc_rdate_arr = exdate_to_array_of_dates(e.fc_rdate);
							if(fc_rdate_arr.length>0)
								scheduler.add_rdates(fc_rdate_arr);
						}
																			
						occurrences = scheduler.occurrences_between(start, end);
						if(occurrences.length>0){
							$(occurrences).each(function(i,o){
								var new_start = new Date(o);
								var p = $.extend(true, {}, e);
								p.premiere = new_start.getTime()==e_start.getTime() ;
								p._start 	= new_start;
								p.start 	= new_start;
								p.fc_start 	= $.fullCalendar.formatDate(new_start,'yyyy-MM-dd');
								p.fc_start_time = $.fullCalendar.formatDate(new_start,'HH:mm:ss');
								p.fc_date_time 	= $.fullCalendar.formatDate(new_start,'yyyy-MM-dd HH:mm:ss');
								if(duration){
									var end_time = new_start.getTime() + duration;
									var new_end = new Date();
									new_end.setTime(end_time);
									p._end = new_end;
									p.end = new_end;
									p.fc_end = $.fullCalendar.formatDate(new_end,'yyyy-MM-dd');
									p.fc_end_time = $.fullCalendar.formatDate(new_end,'HH:mm:ss');
								}else{
									p.end = p.start;
									p._end = p._start;
								}
								p.repeat_instance = true;
								p = _add_repeat_instance_data_to_event(p);
								events[events.length]=p;
							});
						}else{

						}
						//handle a situation, where there is no recurring instance in the date range (start / end) but the event was set
						//with long diference between start and end so the event doesnt actually starts or ends in the given time window.
						//this applies both with occurence.length=0 or >0.
						if( e_start <= start && e_end > start ){
							e.start = e_start;
							e.end = e_end;
							events[events.length]=e;							
						}							
					}catch(err){
						console.log( err.message, e );
					}							
				}
			});
		}	

		if( events.length > 0 ){
			if( ! events[0].local_feed ){
				events.sort( _rhc_sort_events );

				var new_events = [];
				$(events).each(function(i,ev){
					if( !ev.local_feed ){
						//remove duplicate id and date
						if( new_events.length > 0 ){
							for( var a=0; a < new_events.length; a++ ){
								cev = new_events[a];							
								if( ev.id == cev.id && ev.start.getTime() == cev.start.getTime() && ev.network == cev.network ){
									return true;
								}
							}
						}
						
						new_events.push( ev );
					}
				});		
				events = new_events;		
			}
		}

		return events;
	}
	var sidelist_events = [];
	function cb_event_render(calendar,for_widget,event,element,view,fc_options){
		if(!calendar){
			calendar = $(view.element).parents('.fullCalendar');
		}
		/* the following code prevents all views from rendering any events between dec 16 till dec 31 2013.
		var holiday_start 	= new Date(2013,11,16,0,0,0);
		var holiday_end 	= new Date(2014,0,1,0,0,0);
		if( event.start > holiday_start && event.start < holiday_end ){
			return false;
		}
		*/
	
		showothermonth = fc_options && fc_options.showothermonth ? parseInt(fc_options.showothermonth) : 1;//active by default.
		showothermonth = view && view.name && 'month'==view.name ? showothermonth : 1;//this option is only valid for month view.
		if( 'month'==view.name && $(element).parents('.rhcalendar.not-widget').hasClass('fc-small') ){
			showothermonth=0;
		}
		if( 0==showothermonth && event.start && event.end && view.start && view.end ){
			/* Events that ended before visualization start are removed */
			if( event.end.getTime() < view.start.getTime() ){
				return false;
			}
			/* Events that start past the visualization end are removed */
			if( event.start.getTime() >= view.end.getTime() ){
				return false;
			}
		}
		//external sources still showing, when end is not set on source
		if( 0==showothermonth && event.start && null==event.end && view.start && view.end ){
			/* Events that ended before visualization start are removed */
			if( event.start.getTime() < view.start.getTime() ){
				return false;
			}
			/* Events that start past the visualization end are removed */
			if( event.start.getTime() >= view.end.getTime() ){
				return false;
			}
		}
		
		//skip events
		event_skip = fc_options && fc_options.event_skip ? parseInt(fc_options.event_skip) : 0;	
		if( event_skip ){
			if( 'undefined' == typeof view.event_skip ){
				view.event_skip = event_skip;
			} 
			
			if( view.event_skip > 0 ){
				view.event_skip--;
				return false;
			}
		}

		//-- all views upcoming only	
		if( 1==parseInt(fc_options.upcoming) ){
			var now = new Date();
			if( event.allDay ){
				now.setHours(0,0,0,0);
			}

			if( event.start.getTime() < now.getTime() ){			
				return false;
			}
		}
		
		norepeat = view.get_norepeat ? view.get_norepeat( ( fc_options.norepeat || false ) ) : ( fc_options.norepeat || false );
		norepeat = parseInt(norepeat);
		if( norepeat && view && event && event.id ){	
			view.rendered = view.rendered ? view.rendered : [] ;
			if( -1 == $.inArray( event.id, view.rendered ) ){
				view.rendered.push( event.id );			
			}else{
				return false;
			}			
		}

		if( fc_options.taxonomycolor && '1'==fc_options.taxonomycolor ){
			if( event.terms ){
				var classes = [];
				$.each( event.terms, function(i,term){
					str = 'tax_' + term.taxonomy + '_' + term.slug;
					str = str.replace(/ /g,"_");
					classes.push( str );
				});
				if( classes.length > 0 ){
					$(element).addClass( classes.join(' ') );
				}			
			}		
		}
		

		
		if(event.venue_directory && view.name!='rhc_gmap'){
			return false;
		}
		
		if( view.name=='rhc_gmap' && event.start ){		
			if( 1==parseInt( fc_options.gmap_view.upcoming ) ){
				if( event.start.getTime() < view.visStart.getTime() ){
					return false;
				}			
			}else if( event.end && 2==parseInt( fc_options.gmap_view.upcoming ) ){
				if( event.end.getTime() < view.visStart.getTime() ){
					return false;
				}	
			} 
		}
			
		var tax_filters = $(calendar).data('rhc_tax_filters');
		if(tax_filters && tax_filters.length>0){	
			var filter_out = true;
			var matched_taxonomies = [];
			var filter_taxonomies = [];
			$.each( event.terms, function(j,term){
				$.each(tax_filters,function(i,filter){
//----					
					if( -1 ==$.inArray(filter.taxonomy,filter_taxonomies) ){
						filter_taxonomies.push(filter.taxonomy);
					}
					
					if( filter.taxonomy==term.taxonomy ){
						if( term.gaddress && term.gaddress==filter.term ){
							filter_out=false;
							matched_taxonomies.push(term.taxonomy);
						}else if( term.description && term.description==filter.term ){
							filter_out=false;
							matched_taxonomies.push(term.taxonomy);
						}else if( term.name && term.name==filter.term ){
							filter_out=false;
							matched_taxonomies.push(term.taxonomy);
						}	
					}
				});
			});
			if(!filter_out && filter_taxonomies.length>0){
				$.each(filter_taxonomies,function(i,tax){
					if( -1 == $.inArray(tax,matched_taxonomies) ){
						filter_out=true;
					}
				});
			}
			
			if(filter_out){					
				return false;
			}	
		}	

		//max events
		max_events = fc_options && fc_options.max_events ? parseInt(fc_options.max_events) : 0;	
		if( max_events ){
			if( 'undefined' == typeof view.max_events ){
				view.max_events = max_events;
				view.rendered_events_count = 0;
			} 
			
			if( view.rendered_events_count >= view.max_events ){
				return false;
			}else{
				view.rendered_events_count++;
			}
		}
			
		if(for_widget){
			var pattern=/fc-day([0-9]{1,2})/i;	
			var day_diff = 0;
			if(event.start&&event.end){
				var s = new Date(event.start);
				var e = new Date(event.end);
				s.setHours(0,0,0,0);
				e.setHours(0,0,0,0);
				day_diff = Math.floor((e.getTime()-s.getTime())/(86400000));
			}
	
			var day_number = event._start.getDate();
			if( day_diff==0 ){
				$(view.element).find('.fc-day-number').each(function(i,inp){						
					if( day_number==$(inp).html() ){
						if(  event.start.getMonth() == view.start.getMonth() ){				
							if( !$(inp).parent().parent().hasClass('fc-other-month') ){
								$(inp).parent().parent()
									.addClass('fc-state-highlight')
									.addClass('fc-have-event')
									.css('background-image','none')
								;									
							}
						}else{
							if( $(inp).parent().parent().hasClass('fc-other-month') ){
								$(inp).parent().parent()
									.addClass('fc-state-highlight')
									.addClass('fc-have-event')
									.css('background-image','none')
								;										
							}
						}	
					}
				});	
			}else{			
				var s = new Date(event.start);
				var e = new Date(event.start);		
				
				s.setHours(0,0,0);
				e.setHours(23,59,59);
					
				$(view.element).find('.fc-day-number').each(function(i,inp){
					current_date_str = $(inp).closest('.fc-day').data('date');
					current_date = new Date( current_date_str + 'T00:00:00Z' );

					//convert timezone
					current_date.setTime( current_date.getTime() + s.getTimezoneOffset()*60*1000 );			
					if( current_date.getTime() <= e.getTime() && current_date.getTime() >= s.getTime() ){
						$(inp).parent().parent()
							.addClass('fc-state-highlight')
							.addClass('fc-have-event')
							.css('background-image','none')
						;	
					}
				});			
			}

			
								
			return false;		
		}else{
			/*
			var skip_sidelist = event.skip_sidelist || false;
			//--- render on event list		
			if(!skip_sidelist && view.name=='rhc_gmap' && $(calendar).parent().find('.rhc-sidelist').length>0){
				if(fc_options.sidelist && fc_options.sidelist.template && $(fc_options.sidelist.template).length>0){
					cb_event_render_sidelist( calendar, for_widget, event,element, view, fc_options );
				}
			}
			*/
			//moved to a callback after all events are rendered.
			sidelist_events.push(event);
		}
		
		/**/
		if(fc_options.matchBackground && '1'==fc_options.matchBackground){
			loop_date = new Date( event['_start']  );
			compare_date = event['_end'] || event['_start'];
			var a=0;
			while(loop_date<=compare_date){
				sel = ".fc-day[data-date='" + $.fullCalendar.formatDate(loop_date,'yyyy-MM-dd') + "']";
				original_bg = $(view.element).find(sel).css('background-color');

				$(view.element).find(sel)
					.data('original_bg', original_bg)
					.addClass('bg_matched')
					.css('background-color', ( $(element).length && $(element).get(0).tagName ? $(element).css('background-color') || '' : '' ) )
				;
				
				loop_date.setDate( loop_date.getDate() + 1 );
				if(a++>5000){
					break;
				}
			}	
		}
		

		render_something = false;
		/**/
		if(fc_options.month_event_image && '1'==fc_options.month_event_image && view.name=='month'){
			if( event.month_image && event.month_image[0] ){
				loop_date = new Date( event['_start']  );
				sel = ".fc-day[data-date='" + $.fullCalendar.formatDate(loop_date,'yyyy-MM-dd') + "']";
				ratio = event.month_image[2]/event.month_image[1];
				
				container_w = view.element.find(sel).outerWidth();
				_w = container_w;
				_h = _w * ratio; 
				
				$(element)
					.addClass('has-fc-image')
					.find('.fc-event-inner').prepend(
					$('<div></div>')
						.addClass('fc-image-cont')
						.append(
							$('<img />')
								.attr('src', event.month_image[0])
								.attr('height', parseInt(_h) )
								.css('height', parseInt(_h) )
								.addClass('fc-image')
								
						)			
				);
				
				render_something = true;
			}
		}
		
		if( 'month'==view.name ){
			fc_options.render_events = 'undefined' == typeof fc_options.render_events ? 1 : fc_options.render_events ;
			if( 0==parseInt( fc_options.render_events ) ){
				if( render_something ){
					$(element).find('.fc-event-title').hide();
					$(element).find('.fc-event-time').hide();
					$(element).css('background-color', 'transparent');
				}else{
					return false;
				}
				
			}		
			
			if( 'undefined' == typeof fc_options.fixed_title || fc_options.fixed_title.length == 0 ){
			
			}else{
				$(element).find('.fc-event-time').html('&nbsp;');
				$(element).find('.fc-event-title').html( fc_options.fixed_title );
			}
		}		
		
		/*individual early loading dynamic tooltip*/
		if( false || (fc_options.early_dynamic_tooltip && '1'==fc_options.early_dynamic_tooltip) ){
			cb_event_mouseover( event, null, view );
		}
		
		if( fc_options.tooltip_close_on_title_leave && parseInt(fc_options.tooltip_close_on_title_leave) ){
			//when leaving event title, trigger close tooltip if not hovered
			$(element).mouseleave(function(e){
				handle = setTimeout( function(){				
					if( 0==$('.fc-event.event-hovered').length ){
						if( $('.fct-tooltip').is(':visible') ){
							if( !$('.fct-tooltip:visible').first().is(':hover') ){
								$('.fct-tooltip:visible').trigger('close-tooltip'); 
							}
						}		
					}		
				}, 200 );				
			});				
		}
	}

	function hide_widget_event_list(calendar,for_widget,event,element,view,fc_options){	
		var holder = jQuery( calendar ).parents('.rhc_holder').find('.rhc_calendar_widget_day_click_holder');
		if( holder.children().length > 0 ){
			holder.children().fadeOut('fast',function(){
				
			});
		}
	}
	
	function cb_event_render_all(calendar,for_widget,event,element,view,fc_options){			
		if('undefined' ==typeof calendar)
			calendar = $(view.element).parents('.rhcalendar.rhc_holder');	

		norepeat = view.get_norepeat ? view.get_norepeat( ( fc_options.norepeat || false ) ) : ( fc_options.norepeat || false );
		norepeat = parseInt(norepeat);
		if( norepeat && view  ){
			view.rendered = view.handle_rendered ? view.handle_rendered() : [] ;		
		}
			
		has_sidelist_holder = $(calendar).parent().find('.rhc-sidelist').length>0 ? true : false;
		events = sidelist_events || [];
		if( events.length > 0 ){	
			//sidelist tab label
			var tab = $(calendar).parent().find('.rhc-sidelist-holder .rhc-sidelist-tab-label');
			if(tab.length>0 && fc_options.sidelist && fc_options.sidelist.labels && fc_options.sidelist.labels.tab){
				tab.html(fc_options.sidelist.labels.tab);
			}					
	
			render_sidelist(calendar, events, view.name, fc_options);	
		}	
		sidelist_events=[];
		//--
		
		if( -1 == $.inArray( view.name, ['rhc_event','rhc_gmap'] ) ){
			//TODO:load all tooltip details at once.		
		}
		
		$('body').trigger('cb_view_display', [for_widget, calendar, view, element] );
	}
	
	function render_tax_filters( fc_options ){
		var settings = fc_options && fc_options.taxfilter ? fc_options.taxfilter : {
			holder_class: 'rh-flat-ui fc-head-control',
			selectpicker: true,
			size: 10,
			menu_class: 'tax_filter_menu_medium',
			multiple: ( ( fc_options.tax_filter_multiple && parseInt(fc_options.tax_filter_multiple) ) ? true : false )
		};	
		var holder = $(this);
		if( $(this).find("[class*='fc-button-btn_tax_']").length > 0 ){
			holder.addClass('rhc-has-tax-filter');		
		}
		$(this).find("[class*='fc-button-btn_tax_']").each(function(i,el){
			var taxonomy = (el.className.match(/(^|\s)(fc\-button\-btn_tax_([^\s]*))/) || [,,''])[3];
			
			var dropdown = $('<select class="selectpicker"></select>');
			if(settings.multiple){
				dropdown.attr('multiple',true);
			}
			//console.log(taxonomy,el);	
			dropdown
				.attr('data-taxonomy', taxonomy)
				.append($('<option value="">' + $(this).html() + '</option>'))
			;
			
			holder.find(".fbd-filter[data-taxonomy='" + taxonomy + "']").each(function(e,c){
				var bgcolor = $(c).data('bgcolor')||'transparent';
				dropdown.append(
					$('<option data-bgcolor="' + bgcolor + '" value="' + $(c).val() + '">' + $(c).closest('label').find('.fbd-term-label').html() + '</option>')
				);
			});			
		
			if(dropdown.find('option').length>1){
				$(el).replaceWith( dropdown );
				dropdown.wrap(
					$('<div class="tax_filter_holder fc-button fc-state-default"></div>')
						.addClass(settings.holder_class)
						.addClass(settings.menu_class)
				);
			}else{
				$(el).remove();
				console.log('Taxonomy filter added to calendar, but disabled in options.  Also turning off the hierarchical filter can help.');
			}
			
			if( settings.selectpicker ){
				dropdown.selectpicker({
					style: 'btn-small btn-taxfilter btn_tax',
					size: settings.size
				});	
				var have_color = false;
				var dropdown_menu = dropdown.parent().find('.dropdown-menu');	
				dropdown.find('option').each(function(i,option){
					bgcolor = $(option).attr('data-bgcolor')||'transparent';
					if('transparent'!=bgcolor)have_color=true;
					dropdown_menu.find('li[rel="' + i + '"] a')
						.prepend( $('<span class="rhc-term-color"></span>').css('background-color',bgcolor).addClass(('transparent'==bgcolor?'rhc-no-color':'')) )
					;
				});	
				if(have_color){
					dropdown_menu.addClass('rhc-with-tax-color');
				}
			}
			
			dropdown.unbind('change', tax_filter_change).bind('change', {taxonomy:taxonomy,holder:holder}, tax_filter_change);
		});
	}
	
	function tax_filter_change(e){
		$(this).attr('rel', $(e.data.holder).attr('id') );
		var value = $(this).val();
		value = null==value ? '' : value;
		var values = [];
		
		if( 'string'==typeof value ){
			values.push(value);
		}else{
			$.each( value, function(i,v){
				if( ''==v )return true;
				values.push(v);	
			});		
		}

		e.data.holder.find(".fbd-filter[data-taxonomy='" + e.data.taxonomy + "']").each(function(e,c){
			if( -1 == $.inArray( $(c).val(), values ) ){
				$(c).attr('checked', false);
			}else{
				$(c).attr('checked', true);
			}
		});			
		methods.apply_filter.apply( $(this),[false]);
		return true;
	}
	
	function render_sidelist(calendar, events, view_name, fc_options){
		//render events
		$.each(events,function(i,event){
			var skip_sidelist = event.skip_sidelist || false;
			//--- render on event list		
			if(!skip_sidelist && view_name=='rhc_gmap' && has_sidelist_holder ){
				if(fc_options.sidelist && fc_options.sidelist.template && $(fc_options.sidelist.template).length>0){
					$(calendar).parent().find('.rhc-sidelist-holder').addClass('has-events');
					sidelist = $(calendar).parent().find('.rhc-sidelist');
					render_sidelist_event( sidelist, event, fc_options );
				}
			}
		});
		$('.rhc-sidelist-event-item').show();	
	}
	
	function render_sidelist_event( sidelist, event, fc_options ){	
		jQuery(document).ready(function($){
					//---- filter out expired events
					var s = new Date(event.start);
					var now = new Date();
					now.setHours(0,0,0,0);
					if( s.getTime() < now.getTime() ){
						return false;
					} 
					//-----
					var item = $(fc_options.sidelist.template).clone();
					item.attr('id','').addClass('rhc-sidelist-event-item');
					//title
				
					if( event.url && ''!=event.url && event.url!='javascript:void(0);'){					
						var target = fc_options.sidelist.link_target || '_BLANK';
						target = ''==target?'_BLANK':target;
						var title = $('<a href="' + event.url + '">' + event.title + '</a>')
						 	.attr('target',target)
						 	.attr('href','javascript:void(0);')	
						 	.bind('click',function(e){
						 		var click_method = fc_options.eventClick?fc_options.eventClick:fc_click;
						 		event.fc_click_link = 'page';
								event.fc_click_target = target;
								click_method(event,e,null);
						 	})							
						;
					}else{
						var title = $('<span></span').html(event.title);
					}
					item
						.find('.rhc-sidelist-title').empty()
						.append(title)
					;
					//date
					var date_format = item.find('.rhc-sidelist-date').html();
					item.find('.rhc-sidelist-date').html(
						$.fullCalendar.formatDate(event.start,date_format,fc_options)
					);
					//image
					if( event.image && event.image[0] && event.image[0]!='' ){
						var image = $('<img></img>').attr('src',event.image[0]);
					}	
					//handle venue directory
					if( event.venue_directory ){
						item
							.addClass('venue-directory-item')
							.find('.rhc-sidelist-date').hide()
						;
					}
						
					item.find('.rhc-sidelist-image').append(image);			
			
					sidelist
						.append(item.show())
					;
		});
	}
	
	function cb_events_loading(main_holder, fc_holder, isLoading, view, calendar, fc_options){
	 	if( fc_options.for_widget ){
			if(view.loading)view.loading( isLoading, view, fc_options );
			handle_loading_overlay( main_holder, fc_holder, isLoading, view, calendar, fc_options );
			if(isLoading){
				$( main_holder ).find('.fc-have-event').each(function(i,inp){
					$(this)
						.removeClass('fc-state-highlight')
						.removeClass('fc-have-event')
						.css('background-image','')
					;
				});
			}else{
				cb_events_loaded( fc_holder, calendar, view, fc_options);
			}		
		}else{
			if(view.loading)view.loading( isLoading, view, fc_options );
			if(!isLoading){			
				cb_events_loaded( fc_holder, calendar, view, fc_options );
			}
			
			handle_loading_overlay( main_holder, fc_holder, isLoading, view, calendar, fc_options );
		}
	}
	
	function handle_loading_overlay( main_holder, fc_holder_notused, isLoading, view, calendar, fc_options ){
		if( 'undefined'==typeof(fc_options.loadingOverlay)||'1'!=fc_options.loadingOverlay)return;
		if( isLoading ){
			//--placeholder for a loading overlay
			if( 0==$( main_holder ).find('.fc-content .fc-view-loading').length  ){
				$( main_holder ).find('.fullCalendar .fc-content')
					.prepend(
						$('<div class="fc-view-loading"></div>')
							.hide()
							.append('<div class="fc-view-loading-1 ajax-loader"><div class="fc-view-loading-2x xspinner icon-xspinner-3"></div></div>')
					)	
				;								
			}
		
			$( main_holder )
				.addClass('is-loading')
				.find('.fc-view-loading')
				.addClass('loading-events')
				.find('.ajax-loader').addClass('loading-events').end()
				.stop()
				.fadeIn()
			;				
		}else{					
			$( main_holder )
				.removeClass('is-loading')
				.find('.fc-view-loading').stop().fadeOut('fast',function(){
				$( main_holder ).find().remove('.fc-view-loading');
				if(view.name=='rhc_event'){
					$( main_holder ).find('.fc-view-rhc_event').css('min-height','');
				}						
			});
		}
	}
	
	function cb_events_loaded(el,_calendar,view,fc_options){	
		calendar = el;	
				
		if( fc_options.tax_filter && fc_options.tax_filter!='1')return;
		if( $(calendar).find('.fc-head-control').length==0 )return;

		var events = $(calendar).fullCalendar('clientEvents');
		var taxonomies = [];
		$.each(events,function(i,ev){	
			if( ev.terms && ev.terms.length>0 ){
				$.each(ev.terms,function(j,term){
				
					if( fc_options.tax_filter_include && fc_options.tax_filter_include.length > 0 ){
						if( -1 == $.inArray(term.taxonomy,fc_options.tax_filter_include) ){
							return;
						}
					}else if( fc_options.tax_filter_skip && -1!=$.inArray(term.taxonomy,fc_options.tax_filter_skip) ){
						return;
					}
				
					var existing_index = -1;
					for(var a=0;a<taxonomies.length;a++){
						if(taxonomies[a].taxonomy==term.taxonomy){
							existing_index = a;
							break;
						}
					}
					
					//				
					var value = '';
					if(term.gaddress){
						value = term.gaddress;
					}else if(term.description){
						value = term.description;
					}else if(term.name){
						value = term.name;
					}else{
						value = 'unknown';
					}
	
					var val = {
						value:value,
						order: term.term_priority?parseInt(term.term_priority):0,
						local_feed: ev.local_feed,
						term: term
					};
			
					if(existing_index==-1){
						taxonomies[taxonomies.length]={
							taxonomy: term.taxonomy,
							label: term.taxonomy_label,
							terms: [value],
							uterms: [val],//unsorted terms
							print_priority: term.print_priority?parseInt(term.print_priority):0,
							filter_type: term.filter_type?term.filter_type:'',
							color: term.color||'',
							background_color: term.background_color||''
						};					
					}else{
						if(-1==$.inArray(value, taxonomies[existing_index].terms ) ){
							taxonomies[existing_index].terms.push(value);
							taxonomies[existing_index].uterms.push(val);
						}
					}
				});
			}
		});
		
		if( fc_options.tax_filter_include && fc_options.tax_filter_include.length > 0 && taxonomies.length > 0 ){
			new_taxonomies = [];
			$.each( fc_options.tax_filter_include, function(i,filter_taxonomy){
				$.each( taxonomies, function(j,tax){
					if( filter_taxonomy==tax.taxonomy ){
						new_taxonomies[new_taxonomies.length]=tax;
					}
				});
			});
			taxonomies = new_taxonomies;
		} 

		//render form for fc-head-control
		if(taxonomies.length>0){
			var cont = $(calendar).find('.fc-head-control .tax_filter_holder');
			cont.empty();
			cont.parents('.fc-head-control').removeClass('has-filters');

			$.each(taxonomies,function(i,tax){
				if(tax.terms.lengt==0)return;
				
				//sort terms
				tax.uterms.sort(cb_sort_tax_filter);
				tax.terms = [];

				var last_order = false;
				var is_sorted = false;
				$.each(tax.uterms,function(i,t){
					if( last_order && last_order!=t.order ){
						is_sorted=true;
					}
					last_order = t.order;
					tax.terms.push(t.value);
				});
				
				if( !is_sorted ){
					tax.terms.sort();
					tax.uterms.sort(cb_sort_alphanum);
				}
		
				var sel = $('<select></select>')
					.attr('title',tax.label)
					.attr('multiple','multiple')
					.addClass('tax_filter_field')
					.addClass('selectpicker')
					.data('taxonomy',tax.taxonomy)
					.data('taxonomy_filter_type',tax.filter_type)
					.append('<option value="">' + tax.label + '</option>')
				;
			
				$.each(tax.uterms,function(j,t){
					bgcolor = t.term.background_color || 'transparent';		
					option_label = t.term && t.term.name ? t.term.name : t.value ;
					_option = $('<option value="'+t.value+'">'+ option_label +'</option>').data('term',t) ;
					_option.attr('data-bgcolor', bgcolor );
					sel
						.append( _option )
					;
				});
				
				sel
					.appendTo(cont)
					.wrap('<div class="tax_filter_item_holder"></div>')
					.selectpicker({
						style: 'btn-small btn-taxfilter'
					})
				;
				//----
				var have_color = false;
				var dropdown_menu = sel.parent().find('.dropdown-menu');	
				sel.find('option').each(function(i,option){
					bgcolor = $(option).attr('data-bgcolor')||'transparent';
					if('transparent'!=bgcolor)have_color=true;
					dropdown_menu.find('li[rel="' + i + '"] a')
						.prepend( $('<span class="rhc-term-color"></span>').css('background-color',bgcolor).addClass(('transparent'==bgcolor?'rhc-no-color':'')) )
					;
				});	
				if(have_color){
					dropdown_menu.addClass('rhc-with-tax-color');
				}
				//----				
				cont.parents('.fc-head-control').addClass('has-filters');
				
			});		
			//--
			cont.find('.tax_filter_field')
				.change(function(e){			
					var calendar = $(this).parents('.fullCalendar');
					var tax_filters = [];
					$(calendar).find('.tax_filter_field').each(function(i,el){
						$(el).find('option:selected').each(function(j,option){
							var value = $(option).attr('value');
							if(value=='')return;
							var filter_type = $(el).data('taxonomy_filter_type');
							var o = $(option).data('term');
				
							tax_filters.push({
								taxonomy: $(el).data('taxonomy'),
								term: value,
								filter_type: filter_type,
								slug: o.term && o.term.slug?o.term.slug:null ,
								term_id: o.term && o.term.term_id ? o.term.term_id : null,
								local_feed: o.local_feed 
							});							
						});
					});
	
					if($(calendar).parent().find('.rhc-sidelist').length>0){//there could be a better place to locate this, a callback maybe.
						$(calendar).parent().find('.rhc-sidelist-holder').removeClass('has-events');
						$(calendar).parent().find('.rhc-sidelist').empty();//clear list of events (floating sidelist);
					}
					
					args = {tax_filters:tax_filters};
					if( fc_options.show_ad ){
						args.show_ad = fc_options.show_ad;
					}
					
					$(calendar)
						.data('rhc_tax_filters',tax_filters)
						.fullCalendar('rerenderEvents')
					;
			
					$('BODY').trigger( 'rhc_filter', args );
				})
			;					
		}	
	
		return;	
	}
	
	function cb_view_display( for_widget, calendar, view, element ){
		if(!calendar){
			calendar = $(view.element).parents('.fullCalendar');
		}
		
		set_fc_small(calendar);
		
		var _view = $(calendar).fullCalendar('getView');		
		if(_view.name=='rhc_gmap'){//hardcoded. for now only map view needs this filtering.
			$(calendar).find('.fc-head-control').addClass('show-control');
		}else{
			$(calendar).find('.fc-head-control').removeClass('show-control');
		}
		
		//--
		if(_view.name=='rhc_event'){
			$(element).parents('.rhc_holder').addClass('view-rhc_event');
		}else{
			$(element).parents('.rhc_holder').removeClass('view-rhc_event');
		}
		
		$(calendar).data('rhc_tax_filters',[]);
		$(calendar).find('.tax_filter_field').each(function(i,el){
			$(el).val('');
		});		
		
		var now = new Date();
		if( view.visStart <= now && view.visEnd >= now ){
			$(element).parents('.rhc_holder')
				.addClass('has-current-date')
				.removeClass('not-current-date')
			;
		}else{
			$(element).parents('.rhc_holder')
				.removeClass('has-current-date')
				.addClass('not-current-date')
			;		
		}

		if( view.name == 'month' ){
			//why dont we just test this in the first place? posibly because has-current-date is used by addon and other kind of view.
			if( $(element).parents('.rhc_holder').find('.fc-today').length>0 && $(element).parents('.rhc_holder').find('.fc-today').is('.fc-other-month') ){
				$(element).parents('.rhc_holder')
					.removeClass('has-current-date')
					.addClass('not-current-date')
				;	
			}
		}
		
		if( $(element).parents('.rhc_holder').is('.flat-ui-cal') ){			
			var data = $(calendar).parents('.rhc_holder').data('Calendarize');
			var fc_options = data.modes[data.mode].options;
			if( $(element).parents('.rhc_holder').is('.has-current-date') ){
				try {
					var hformat = $("<div/>").html(fc_options.widget_hformat).text();
				}catch(e){
					var hformat = null;
				}
				//fc_options.flatui_header_format = "'<span class=''fuiw-month''>'d. MMM yyyy'</span>'";
				var _format = hformat || "'<span class=''fuiw-dayname''>'dddd'</span><span class=''fuiw-month''>'MMMM'</span><span class=''fuiw-year''>'yyyy'</span><span class=''fuiw-day''>'d'</span>'";
				$(calendar).find('.fc-header-title h2').html( $.fullCalendar.formatDate(now, _format, fc_options) );
			}else{
				str = $(calendar).find('.fc-header-title h2').html();
				str = str.trim();
				var res = str.split(" ");	
				if(res.length==2){
					if( isNaN(res[1]) ){
						_format = "<span class='fuiw-month'>" + res[1] + "</span><span class='fuiw-year'>" + res[0] + "</span>";
					}else{
						_format = "<span class='fuiw-month'>" + res[0] + "</span><span class='fuiw-year'>" + res[1] + "</span>";
					}
					$(calendar).find('.fc-header-title h2').html(_format);
				}
			}
			
			_skip = fc_options.widget_onechardaylabel && 1==parseInt( fc_options.widget_onechardaylabel ) ? true : false ;
			if( !_skip ){
				$(calendar).find('.fc-day-header').each(function(i,el){
					$(el).html( $(el).html().substring(0,1) );
				});			
			}

		}
	}
	
	function cb_sort_tax_filter( o, p ){
		if(o.order>p.order){
			return 1;
		}else if(o.order<p.order){
			return -1;
		}else{
			return 0;
		}
	}
	
	function cb_sort_alphanum( o, p ) {
	    a = o.value.toString();
		b = p.value.toString();
		var reA = /[^a-zA-Z]/g;
		var reN = /[^0-9]/g;		
		var aA = a.replace(reA, "");
	    var bA = b.replace(reA, "");
	    if(aA === bA) {
	        var aN = parseInt(a.replace(reN, ""), 10);
	        var bN = parseInt(b.replace(reN, ""), 10);
	        return aN === bN ? 0 : aN > bN ? 1 : -1;
	    } else {
	        return aA > bA ? 1 : -1;
	    }
	}	
	
	function add_footer_button( options ){
		var settings = $.extend( {
			'calendarize': null, //Calendarize element
			'calendar': null, //fullCalendar instance
			'e':null,
			'tm':'fc',
			'buttonName':'undefined',
			'label':'',
			'buttonClick':function(f,btn,e) {}
		}, options);			
		
		tm = settings.tm;
		
		var button = $(
			"<span class='fc-button fc-button-" + settings.buttonName + " " + tm + "-state-default '>" +
				"<span class='fc-button-inner'>" +
					"<span class='fc-button-content'>" + 
					settings.label +
					"</span>" +
					"<span class='fc-button-effect'><span></span></span>" +
				"</span>" +
			"</span>" 
		);		
		if (button) {
			button
				.click(function(e) {
					if (!button.hasClass(tm + '-state-disabled')) {
						settings.buttonClick( this, e, settings);
					}
				})
				.mousedown(function() {
					button
						.not('.' + tm + '-state-active')
						.not('.' + tm + '-state-disabled')
						.addClass(tm + '-state-down');
				})
				.mouseup(function() {
					button.removeClass(tm + '-state-down');
				})
				.hover(
					function() {
						button
							.not('.' + tm + '-state-active')
							.not('.' + tm + '-state-disabled')
							.addClass(tm + '-state-hover');
					},
					function() {
						button
							.removeClass(tm + '-state-hover')
							.removeClass(tm + '-state-down');
					}
				)
				.appendTo( settings.e );
			
			button.addClass(tm + '-corner-left');
			button.addClass(tm + '-corner-right');
		}	
	}
	
	function ical_footer_button_click( btn, e, settings){
		var calendarize = settings.calendarize; f
		if( $(btn).parent().find('.ical-tooltip').length>0 ){
			$(btn).parent().find('.ical-tooltip').remove();
		}else{
			var data = $(calendarize).data('Calendarize');
			var options = data.modes[data.mode].options;
			var url = options.events_source + options.events_source_query;
			url = url.replace('get_calendar_events','get_icalendar_events');
			var url2 = url + '&ics=1';

			var feed = options.feed && ''!=options.feed ? '&feed=' + options.feed : '';
			url = url + feed;
			url2 = url2 + feed;
			
			var tooltip = $('.ical-tooltip-template').first().clone();
			tooltip
				.removeClass('ical-tooltip-template')
				.addClass('ical-tooltip')
				.find('.ical-url').html(url).end()
				.find('.ical-clip')
					.attr('href',url)
					.on('click',function(e){
			            $(this).focus();
			            $(this).select();
						return false;

					})
					.end()
				.find('.ical-close')
					.on('click',function(e){
						$(this).parents('.fc-footer').find('.fc-button-icalendar').trigger('click');
					})
				.end()
				.find('.ical-ics').attr('href',url2).end()
			;						
			$(btn).after( tooltip );
			
			tooltip.fadeIn('fast',function(e){
				tooltip
					.find('textarea.ical-url')
					.focus()
					.select()
				;
			});
		}					
	}
	
	function cb_dayclick(date,allDay,jsEvent,view,fc_options,_this){
		if( fc_options.dayclick ){
			var fn = fc_options.dayclick && ''!=fc_options.dayclick && window[fc_options.dayclick] ? window[fc_options.dayclick] : false; 
			if( fn ){
				return fn( date,allDay,jsEvent,view,fc_options,_this );
			}
		}else{
			var fn = fc_options.widget_dayclick && ''!=fc_options.widget_dayclick && window[fc_options.widget_dayclick] ? window[fc_options.widget_dayclick] : false; 
			if( fn ){		
				calendar_widget_day_click( date,allDay,jsEvent,view, rhc_events_cache, fc_options, _this );
			}else if(fc_options.widget_link){
				if(fc_options.widget_link_view){
					var _view = fc_options.widget_link_view;
				}else{
					var _view = 'agendaDay';
				}
				$('<form method="post" />')
					.attr('action',fc_options.widget_link)
					.append('<input type="hidden" name="gotodate" value="'+ $.fullCalendar.formatDate( date, 'yyyy-MM-dd' ) +'" />')
					.append('<input type="hidden" name="defaultview" value="'+ _view +'" />')
					.append('<input type="hidden" name="fcalendar" value="'+ (fc_options.ev_calendar?fc_options.ev_calendar:'') +'" />')
					.append('<input type="hidden" name="fvenue" value="'+ (fc_options.ev_venue?fc_options.ev_venue:'') +'" />')
					.append('<input type="hidden" name="forganizer" value="'+ (fc_options.ev_organizer?fc_options.ev_organizer:'') +'" />')
					
					.appendTo(_this)
					.submit()
				;
			}		
		}
	}	
})(jQuery);


(function($){
	var methods = {
		init : function( options ){
			var settings = $.extend( {
				'draggable':true
			}, options);		

			return this.each(function(){
				var data = $(this).data('CalendarizeDialog');
				if(!data){
					$(this).data('CalendarizeDialog',settings);
					if(settings.draggable){$(this).draggable({handle:'.ui-widget-header'});}
					$(this).find('.ui-dialog-titlebar-close').on('click',function(e){$(this).parent().parent().parent().CalendarizeDialog('close');});	j	
				}
				$(this).hide();
			});
		},
		open : function ( o ){
			$(this)
				.show()
				.css('margin-left',0)
				.offset( o.offset )
				.css('margin-left', o.margin_left )
			;
		},
		close : function (){
			$(this).hide();
		}
	};
	$.fn.CalendarizeDialog = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.CalendarizeDialog' );
		}    
	};
})(jQuery);

(function($){
	var methods = {
		init : function( options ){
			var settings = $.extend( {
				'todo':	false
			}, options);			
			
			return this.each(function(){
				var gmap = $(this);
				//--init map
				var data = gmap.data('rhc_gmap');
				if( !data ){
					gmap.data('rhc_gmap',true);
				
					init_gmap( gmap, get_markers( gmap ), 0 );
					return true;
				}
			});
		}
	};
	
	function get_markers( gmap ){
		var markers = [];
		gmap.children().each(function(i,el){		
			markers.push({
				name: $(el).html(),
				lon: $(el).data('glon'),
				lat: $(el).data('glat'),
				info: $(el).data('ginfo'),				
				address: $(el).data('gaddress'),
				marker_active: $(el).data('marker_active'),
				marker_inactive: $(el).data('marker_active'),
				marker_size: $(el).data('marker_size')
			});
		});
		return markers;
	}
	
	function init_gmap( gmap, markers, depth ){
		depth++;
		if( depth > 10 ) return false;		
		if( 'interactive' != gmap.data('type') ) return false;
		if( markers.length==0 ) return false;
		//-- markers
		function make_geocode_callback( markers, a ){
			var geocodeCallBack = function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					latlng = results[0].geometry.location;
					
					markers[a].lat = latlng.lat();
					markers[a].lon = latlng.lng();
				}
				return init_gmap( gmap, markers, depth);
			}
			return geocodeCallBack;
		}
		
		for( var a=0; a < markers.length ; a++ ){
			if( !markers[a].lat && !markers[a].lon && markers[a].address ){				
				var geocoder_map = new google.maps.Geocoder();
				geocoder_map.geocode( { 'address': markers[a].address}, make_geocode_callback( markers, a ) );	
				return;			
			}	
		}

		/*
		size = gmap.data('size');
		size_arr = size.split('x');
		*/
		gmap.uniqueId();
		
		ratio = gmap.data('ratio');
		ratio = ''==ratio?'4:3':ratio;
		ratio_arr = ratio.split(':');
		
		h = gmap.width() * ratio_arr[1] / ratio_arr[0] ;
		gmap.height( h );
   		//--
   		maptype = gmap.data('maptype') || 'ROADMAP' ;
   		//--
   		settings = {
   			mapTypeId: google.maps.MapTypeId[maptype],
   			center: new google.maps.LatLng( markers[0].lat, markers[0].lon )
   		};
   		if( gmap.data('zoom') ){
   			settings.zoom = gmap.data('zoom');
   		}
   		
		var map = new google.maps.Map( gmap.get(0) , settings);

		var bounds = new google.maps.LatLngBounds();
		var infowindow = new google.maps.InfoWindow();
		
		//-- add markers to map
		$.each( markers, function(i,data){			

			marker = new google.maps.Marker({
				position: new google.maps.LatLng( data.lat, data.lon ),
				map: map
			});
	
			bounds.extend(marker.position);			
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
					infowindow.setContent((data.info||data.name||data.address));
					infowindow.open(map, marker);
				}
			})(marker, i));			
		});
		
				
		if( markers.length > 1 ){
			map.fitBounds(bounds); 
			/* resets to original zoom
			var listener = google.maps.event.addListener(map, "idle", function () {
				map.setZoom( gmap.data('zoom')||3 );
				google.maps.event.removeListener(listener);
			});	
			*/
		}
	}
		
	$.fn.rhcGmap = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.rhcGmap' );
		}    
	};
})(jQuery);

function fc_mouseover(calEvent, jsEvent, view){

}

function fc_event_details(calEvent, jsEvent, view){
	calEvent.id = calEvent.id.replace('@','_');//google cal.
	calEvent.id = calEvent.id.replace('.','_');//google cal.	
	if(calEvent.gcal && calEvent.description){
		calEvent.description = calEvent.description.replace(/\n/g, '<br />');
	}
	jQuery(document).ready(function($){
		var tooltip_target = view.calendar.options.tooltip.target||'_self';
		if(calEvent.fc_click_target){
			tooltip_target = calEvent.fc_click_target
		}
	
		view.calendar.rhc_search(view.calendar,jsEvent,true);	
		var id = 'fct-'+calEvent.id;
		if( $('BODY').find('#'+id).length>0 ){
			$('BODY').find('#'+id).remove();
		}
	
		if( $('BODY').find('#'+id).length==0 ){
			$('BODY').find('#fct-item-template').clone()
				.attr('id',id)
				.addClass('fct-tooltip')
				.bind('close-tooltip',function(e){
					$(this).animate({opacity:0},'fast','swing',function(e){$(this).remove();});
				})
				.find('.fc-close-tooltip a').on('click',function(e){
					$('.fct-tooltip').trigger('close-tooltip');
				}).end()
				.appendTo('BODY');
		}
	
		if( $('BODY').find('#'+id).length>0 ){
			var pos = $(jsEvent.target).offset();
			var view_pos= view.element.offset();
			
			var tip_left = pos.left<(view_pos.left + view.element.width()/2)?true:false;
			var tip_pos = tip_left?'fc-tip-left':'fc-tip-right';
			
			$('.fct-tooltip:not(#'+id+')').trigger('close-tooltip');
		
			var tooltip = $('BODY').find('#'+id);		
			
			$('BODY').trigger('rhc_tooltip_before_show', [calEvent, tooltip, view] );	
			
			tooltip
				.stop()
				.addClass(tip_pos)
				.find('.fc-description').html(calEvent.description).end()
				.css('opacity',0)
				.show()
			;
			if(calEvent.color){
				tooltip.css('border-left-color', calEvent.color);
			}

			if( calEvent.source && calEvent.source.fc_click_target && '_nolink' == calEvent.source.fc_click_target ){
				calEvent.url = false;			
			}

			if( ! parseInt(view.calendar.options.tooltip.image) ){
				calEvent.image = false;
			}
			
			if(calEvent.url){
				var url = calEvent.url;
				if(calEvent.fc_rrule && ''!=calEvent.fc_rrule){			
					/*
					var start = new Date(calEvent.start);			
					var start_seconds = parseInt(start.getTime() / 1000);	
					url = _add_param_to_url(url,'event_start',start_seconds);
					*/
				}
				
				tooltip_click = function(e){
					jQuery('form#calendarizeit_repeat_instance').remove();
					var form = '<form id="calendarizeit_repeat_instance" method="post"></form>';
					jQuery(form)
						.attr('target',tooltip_target)
						.attr('action',calEvent.url)
						.appendTo('BODY')	
					;
					if(calEvent.gotodate){
						jQuery('<input type="hidden" name="gotodate" value="' + calEvent.gotodate + '"/>')
							.appendTo('form#calendarizeit_repeat_instance')
						;
					}
					if(calEvent.event_rdate){
						jQuery('<input type="hidden" name="event_rdate" value="' + calEvent.event_rdate + '" />')
							.appendTo('form#calendarizeit_repeat_instance')
						;
					}
					jQuery('form#calendarizeit_repeat_instance')
						.submit(function(e){
							e.stopPropagation();
							return true;
						})
						.submit()
					;	
					return false;
				}
				
				var title_is_link = !(view.calendar.options.tooltip&&view.calendar.options.tooltip.disableTitleLink&&view.calendar.options.tooltip.disableTitleLink=='1');			
				if( !title_is_link || calEvent.gcal || calEvent.url=='javascript:void(0);'){
					tooltip.find('.fc-title').html( calEvent.title );
				}else{
					if(calEvent.direct_link){
						//fb doesnt likes that you post
						$('<a></a>')
							.attr('href', url )					
							.html( calEvent.title )
							.attr('target',tooltip_target)
							.appendTo( tooltip.find('.fc-title') )
						;	
					}else{
						$('<a></a>')
							.attr('href', url )
							//.attr('href','javascript:void(0);')	
							.bind('click',tooltip_click)			
							.html( calEvent.title )
							.attr('target',tooltip_target)
							.appendTo( tooltip.find('.fc-title') )
						;						
					}		
				
				}

				if(calEvent.image && calEvent.image[0]){
					if(calEvent.direct_link){
						$('<a></a>')
							.attr('href', url )
							.attr('target',tooltip_target)
							.append(
								$('<img />').attr('src', calEvent.image[0])
							)
							.appendTo( tooltip.find('.fc-image') )
						;					
					}else{
						$('<a></a>')
							.attr('href', url )
							//.attr('href', 'javascript:void(0);' )
							.bind('click',tooltip_click)
							.attr('target',tooltip_target)
							.append(
								$('<img />').attr('src', calEvent.image[0])
							)
							.appendTo( tooltip.find('.fc-image') )
						;
					}

				}	
			}else{
				tooltip.find('.fc-title').html(calEvent.title);
				
				if(calEvent.image && calEvent.image[0]){
					$('<img />')
						.attr('src', calEvent.image[0])
						.appendTo( tooltip.find('.fc-image') )
					;
				}				
			}
			
			tooltip.find('.fc-start,.fc-end,.fc-hide').hide();
	
			if(calEvent.allDay){
				if(calEvent.start){
					tooltip.find('.fc-start').append(
						$('<span></span>').html( $.fullCalendar.formatDate( calEvent.start, view.calendar.options.tooltip.startDateAllDay, view.calendar.options ) )
					 ).show();
				}
				if(calEvent.end){
					tooltip.find('.fc-end').append(
						$('<span></span>').html( $.fullCalendar.formatDate( calEvent.end, view.calendar.options.tooltip.endDateAllDay||view.calendar.options.tooltip.startDateAllDay, view.calendar.options ) )
					 ).show();
				}					
			}else{
				if(calEvent.start){
					tooltip.find('.fc-start').append(
						$('<span></span>').html( $.fullCalendar.formatDate( calEvent.start, view.calendar.options.tooltip.startDate, view.calendar.options ) )
					 ).show();
				}
				if(calEvent.end){
					tooltip.find('.fc-end').append(
						$('<span></span>').html( $.fullCalendar.formatDate( calEvent.end, view.calendar.options.tooltip.endDate||view.calendar.options.tooltip.startDate, view.calendar.options ) )
					 ).show();
				}			
			}
			
			if(calEvent.terms && calEvent.terms.length>0){
				$.each(calEvent.terms,function(i,term){
					if(term.gaddress && calEvent.local_feed ){
						var sel = '.fc-term-' + term.taxonomy + '-gaddress';
						if( tooltip.find(sel).find('a').length>0 ){
							tooltip.find(sel).append( '<span class="rhc-tooltip tax-term-divider"></span>' );
						}
						$('<a></a>')
							.attr('href', 'http://www.google.com/maps?f=q&hl=en&source=embed&q='+escape(term.gaddress) )
							.html( term.gaddress )
							.attr('target','_blank')
							.appendTo( tooltip.find(sel).show() )
						;			
					}
					
					if( tooltip.find('.fc-tax-' + term.taxonomy).length>0 ){
						if(term.name==''){			
							tooltip.find('.fc-tax-' + term.taxonomy).hide();
						}else{
							if( tooltip.find('.fc-tax-' + term.taxonomy).find('a').length>0 ){
								tooltip.find('.fc-tax-' + term.taxonomy).append( '<span class="rhc-tooltip tax-term-divider"></span>' );
							}

							if(term.gaddress && false==calEvent.local_feed ){								
								$('<a></a>')
									.attr('href', 'http://www.google.com/maps?f=q&hl=en&source=embed&q='+escape(term.gaddress) )
									.html( term.name )
									.attr('target',tooltip_target)
									.appendTo( tooltip.find('.fc-tax-' + term.taxonomy) )
								;										
							}else if(term.url && term.url!='' && (view.calendar.options.tooltip.taxonomy_links) ){
								$('<a></a>')
									.attr('href', term.url )
									.html( term.name )
									.attr('target',tooltip_target)
									.appendTo( tooltip.find('.fc-tax-' + term.taxonomy) )
								;							
							}else{
								$('<span></span>')
									.html( term.name )
									.appendTo( tooltip.find('.fc-tax-' + term.taxonomy) )
								;	
							}
							
							
							tooltip.find('.fc-tax-' + term.taxonomy)
								.find('.tax-label').html( term.taxonomy_label ).end()
								.show()
							;							
						}
						
					}
				});
			}

			pos.top = pos.top - tooltip.height()/2 + ($(jsEvent.srcElement).height()/2);
			//---adjust tooltip top
			var cal_offset = view.element.offset();		
			var diff = cal_offset.top-pos.top - 5;
			if(diff>0){
				pos.top = pos.top+diff;		
				tooltip.find('.fct-arrow-holder').css('margin-top', diff*-1);			
			}
		
			if( tip_left ){
				pos.left = pos.left + $(jsEvent.target).width();
			}else{
				pos.left = pos.left + tooltip.width()*(-1);
			}
			
			if(view.name=='agendaDay'){
				pos.left = pos.left - tooltip.width() + 50;
			}

			//$('BODY').trigger('rhc_tooltip_before_show', [calEvent, tooltip, view] );	
			tooltip
				//.css('min-height', tooltip.height())
				.css('min-height', '')
				.css('height','auto')
				.offset(pos)
			;		
			
			var client_width = document.documentElement.clientWidth || window.innerWidth;		
			client_right = $(document).scrollLeft() + client_width;
			var tooltip_right = pos.left + tooltip.width(); 
			if( tooltip_right > client_right ){
				pos.left = pos.left - (tooltip_right-client_right) - 12;	
				tooltip
					.offset(pos)
				;					
			}

			tooltip
				.animate({opacity:1},'fast','swing')
			;
			
			tooltip.unbind('mouseleave').bind('mouseleave',function(e){
				var _this = this;
				setTimeout( function(){
					if( $(_this).is(':hover') ) return false;
					if( view.calendar.options.tooltip_on_hover && '1' == view.calendar.options.tooltip_on_hover ){
						$(_this).trigger('close-tooltip');
					}				
				}, 200 );
			

				return true;				
			});
			
			$('BODY').trigger('rhc_tooltip_after_show', [calEvent, tooltip, view] ) ;
		}
	});
}

function no_link(calEvent, jsEvent, view){
	jsEvent.stopPropagation();
	return false;
}

function fc_click_no_action(calEvent, jsEvent, view){
	jsEvent.stopPropagation();
	return false;
}

function fc_click(calEvent, jsEvent, view){		
	var click_link = !calEvent.fc_click_link?'view':calEvent.fc_click_link;
	if(view&&view.name=='rhc_event'&&click_link=='view')click_link='page';//event list with tooltip is redundant.
	if(click_link=='none'){
		return false;
	}
	if('undefined'==typeof calEvent.fc_click_target){
		calEvent.fc_click_target = '_self';
	}	

	if(calEvent.url && click_link=='page' ){
		if(calEvent.fc_click_target && calEvent.fc_click_target!=''){
			fc_event_links_to_page(calEvent, jsEvent, view);
			return false;
		}else{
			return true;
		}
	}else{
		fc_event_details(calEvent, jsEvent, view);
		return false;
	}
}

function fc_event_links_to_page(calEvent, jsEvent, view){
	if(true){
		jQuery('form#calendarizeit_repeat_instance').remove();
		var form = '<form id="calendarizeit_repeat_instance" method="post" target="' + calEvent.fc_click_target + '"></form>';
		jQuery(form)
			.attr('action',calEvent.url)
			.appendTo('BODY')	
		;
		if(calEvent.gotodate){
			jQuery('<input type="hidden" name="gotodate" value="' + calEvent.gotodate + '"/>')
				.appendTo('form#calendarizeit_repeat_instance')
			;
		}
		if(calEvent.event_rdate){
			jQuery('<input type="hidden" name="event_rdate" value="' + calEvent.event_rdate + '" />')
				.appendTo('form#calendarizeit_repeat_instance')
			;
		}
		
		jQuery('form#calendarizeit_repeat_instance')
			.submit(function(e){
				e.stopPropagation();
				return true;
			})
			.submit()
		;	
	}
}

function fc_select(startDate, endDate, allDay, jsEvent, view){
	jQuery(document).ready(function($){
		var offset = $(jsEvent.target).offset();
		var margin_left = $(jsEvent.target).width();
		$('.fc-dialog')
			.CalendarizeDialog('open',{offset:offset,margin_left:margin_left});
		
	});
}

function _add_param_to_url(url, param, paramVal){
	if( url=='javascript:void(0);' ) return url;
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var aditionalURL = tempArray[1]; 
    var temp = "";
    if(aditionalURL){
        var tempArray = aditionalURL.split("&");
        for ( i=0; i<tempArray.length; i++ ){
            if( tempArray[i].split('=')[0] != param ){
                newAdditionalURL += temp+tempArray[i];
                temp = "&";
            }
        }
    }
    var rows_txt = temp+""+param+"="+paramVal;
    return baseURL+"?"+newAdditionalURL+rows_txt;
}

function _add_repeat_instance_data_to_url(e){
	if(e.repeat_instance){
		if( (e.fc_rrule && ''!=e.fc_rrule)||(e.fc_rdate && ''!=e.fc_rdate) ){
			if(e.using_calendar_url){
				var period = jQuery.fullCalendar.formatDate(  e.start, "yyyy-MM-dd" );
				if( period && ''!=period ){
					e.url = _add_param_to_url(e.url,'gotodate',period);
				}			
			}else{
			
				if(e.src_start && e.fc_date_time && e.src_start==e.fc_date_time){
					
				}else{
					var period = jQuery.fullCalendar.formatDate(  e.start, "yyyyMMddHHmmss" );
					var end = jQuery.fullCalendar.formatDate(  e.end, "yyyyMMddHHmmss" );
					if( period && ''!=period ){
						if(end && ''!=end){
							period = period + ',' + end;
						}
						e.url = '' == e.url ? '' :  _add_param_to_url(e.url,'event_rdate',period);
					}					
				}			
			}
		}	
	}
	return e;
}

function _add_repeat_instance_data_to_event(e){
	if(e.repeat_instance){
		if( (e.fc_rrule && ''!=e.fc_rrule)||(e.fc_rdate && ''!=e.fc_rdate) ){
			if(e.using_calendar_url){
				var period = jQuery.fullCalendar.formatDate(  e.start, "yyyy-MM-dd" );
				if( period && ''!=period ){
					e.gotodate = period;
				}			
			}else{
			
				if(e.src_start && e.fc_date_time && e.src_start==e.fc_date_time){
					
				}else{
					var period = jQuery.fullCalendar.formatDate(  e.start, "yyyyMMddHHmmss" );
					var end = jQuery.fullCalendar.formatDate(  e.end, "yyyyMMddHHmmss" );
					if( period && ''!=period ){
						if(end && ''!=end){
							period = period + ',' + end;
						}
						e.event_rdate = period;
						e.url = '' == e.url ? '' : _add_param_to_url( e.url, 'event_rdate', e.event_rdate );
					}					
				}			
			}
		}	
	}
	return e;
}

function exdate_to_array_of_dates(fc_exdate){
	var fc_exdate_arr = fc_exdate==''?[]:fc_exdate.split(',');
	if( fc_exdate_arr.length>0 ){
		var array_of_dates = [];
		for(a=0;a<fc_exdate_arr.length;a++){
			var _exdate = fc_exdate_arr[a]; 
			array_of_dates[array_of_dates.length] = new Date( _exdate.substring(0,4), _exdate.substring(4,6)-1, _exdate.substring(6,8), _exdate.substring(9,11), _exdate.substring(11,13), _exdate.substring(13,15) );
		}
		return array_of_dates;
	}else{
		return [];
	}		
}

jQuery(document).ready(function($){
	init_rhc();
});

function init_rhc(){
	jQuery(document).ready(function($){
		init_sc_ical_feed();
		$('BODY').bind('dbox.loaded',function(){
			init_sc_ical_feed();
		});
		
		//---- initialize any calendars
		$('.rhc_holder').each(function(i,el){
			var ui_theme = $(el).data('rhc_ui_theme');
			if(''!=ui_theme){
				$("#fullcalendar-theme-css").attr("href",ui_theme);
			}
			var rhc_options = $(el).data('rhc_options');
			eval( '$(el).Calendarize('+rhc_options+')' ); 
		});		
		
		$('.fc-button-custom').hover(function(){
			$(this).addClass('fc-state-hover');
		},function(){
			$(this).removeClass('fc-state-hover');
		});
		
	
		$( window ).resize(function() {
			$('.rhcalendar.not-widget .fullCalendar ').each(function(i,calendar){
				set_fc_small(calendar);
			});
		});
		
		if( !$('BODY').data('rhc_tooltip_before_show') ){
			$('BODY')
				.data('rhc_tooltip_before_show',true)
				.bind('rhc_tooltip_before_show', rhc_tooltip_before_show )
			;
		}
		
		if( !$('BODY').data('rhc_tooltip_contend_loaded') ){
			$('BODY')
				.data('rhc_tooltip_contend_loaded',true)
				.bind('rhc_tooltip_contend_loaded', rhc_tooltip_contend_loaded )
			;
		}
		
		$('.rhc-next').on('click', function(e){
			
		});
	});
}

function init_sc_ical_feed(){
jQuery(document).ready(function($){
	if( $('.rhc-ical-feed-cont').length>0 ){
		$('.rhc-ical-feed-cont').each(function(i,o){
			if( '1'==$(o).data('sc_ical_feed_init') )return;//avoid double init.
			$(o).data('sc_ical_feed_init','1');
			var me = this;
			var e = $(this).parent();
			var text = $(this).data('icalendar_button');
			var tm = $(this).attr('data-theme');
			var buttonName = 'icalendar';
			var icalendar_title = $(this).attr('data-title');
			
			var buttonClick = function(me, jsEvent) {
				var url = 'javascript:alert(1);';
				$(me).width( $(me).data('width') );
				var title = icalendar_title ;
				var offset = $(jsEvent.target).offset();
				var margin_left = $(jsEvent.target).width();
				
				$( me )
					.removeClass('ical-tooltip-holder')
					.addClass('ical-tooltip')
					.CalendarizeDialog('open',{offset:offset,margin_left:margin_left})
				;

			};
			
			$( me ).find('.ical-close').unbind('click').click(function(e){
				$( me ).CalendarizeDialog('close');
			});
			
			if (buttonClick) {
				var button = $(
					"<span class='fc-button fc-button-" + buttonName + " " + tm + "-state-default '>" +
						"<span class='fc-button-inner'>" +
							"<span class='fc-button-content'>" + 
							text +
							"</span>" +
							"<span class='fc-button-effect'><span></span></span>" +
						"</span>" +
					"</span>"
				);
				if (button) {
					button
						.click(function(e) {
							if (!button.hasClass(tm + '-state-disabled')) {
								buttonClick(me, e);
							}
						})
						.mousedown(function() {
							button
								.not('.' + tm + '-state-active')
								.not('.' + tm + '-state-disabled')
								.addClass(tm + '-state-down');
						})
						.mouseup(function() {
							button.removeClass(tm + '-state-down');
						})
						.hover(
							function() {
								button
									.not('.' + tm + '-state-active')
									.not('.' + tm + '-state-disabled')
									.addClass(tm + '-state-hover');
							},
							function() {
								button
									.removeClass(tm + '-state-hover')
									.removeClass(tm + '-state-down');
							}
						)
						.appendTo(e);
					
					button.addClass(tm + '-corner-left');
					button.addClass(tm + '-corner-right');
				}
			}		
		});
	}	
});
}

function get_event_ocurrences(e){
	var fc_start = jQuery.fullCalendar.parseDate( e.start );
	e.fc_rrule = ''==e.fc_rrule?'FREQ=DAILY;INTERVAL=1;COUNT=1':e.fc_rrule;
	scheduler = new Scheduler(fc_start, e.fc_rrule, true);
	if(e.fc_interval!='' && e.fc_exdate){
		//handle exception dates
		var fc_exdate_arr = exdate_to_array_of_dates(e.fc_exdate);
		if(fc_exdate_arr.length>0)
			scheduler.add_exception_dates(fc_exdate_arr);
	}	
	if(e.fc_rdate && e.fc_rdate!=''){
		//handle rdates
		var fc_rdate_arr = exdate_to_array_of_dates(e.fc_rdate);
		if(fc_rdate_arr.length>0)
			scheduler.add_rdates(fc_rdate_arr);
	}
															
	occurrences = scheduler.occurrences_between(start, end);
}

function set_fc_small(calendar){
	if( jQuery(calendar).parent().hasClass('not-widget') ){
		var cw = parseInt( jQuery(calendar).width() ) ;
		mobile_width = RHC.mobile_width || 480 ;
		if( cw > 0 && cw <= mobile_width ){		
			//--- switch view if agenda
			var _view = jQuery(calendar).fullCalendar('getView');	
			if( _view.name=='agendaWeek' ){
				jQuery(calendar).data('restore_agenda_week', true);
				jQuery(calendar).fullCalendar('changeView','basicWeek');	
			}
			if( _view.name=='agendaDay' ){
				jQuery(calendar).data('restore_agenda_day', true);
				jQuery(calendar).fullCalendar('changeView','basicDay');	
			}
			
			
			jQuery(calendar).parent().addClass('fc-small');
			//bug fix, in mobile view there is too much space in the first cell.
			jQuery(calendar).find('td:first-child').each(function(i,el){	
				jQuery(el).find('> div').css('min-height','');
			});			
		} else {
			jQuery(calendar).parent().removeClass('fc-small');
			//-- restore view
			var _view = jQuery(calendar).fullCalendar('getView');
			if( 'basicWeek' == _view.name && jQuery(calendar).data('restore_agenda_week') ){
				jQuery(calendar).data('restore_agenda_week', false);
				jQuery(calendar).fullCalendar('changeView','agendaWeek');	
			}
			if( 'basicDay' == _view.name && jQuery(calendar).data('restore_agenda_day') ){
				jQuery(calendar).data('restore_agenda_day', false);
				jQuery(calendar).fullCalendar('changeView','agendaDay');	
			}
		}		
	}	
}

function rhc_tooltip_before_show(e,calEvent, tooltip, view){
	jQuery(document).ready(function($){
		if( (view.calendar.options.tooltip.enableCustom||false) && calEvent.local_feed ){
			tooltip
				.find('.fct-dbox')
				.hide()
			;// do not show the default content.	
			if( RHC.tooltip_details[calEvent.id] && 'loading'==RHC.tooltip_details[calEvent.id] ){
				setTimeout( function(){ rhc_tooltip_before_show(e,calEvent, tooltip, view); } , 200 );				
			}else if( RHC.tooltip_details[calEvent.id] ){
				if( true===RHC.tooltip_details[calEvent.id] ){
					tooltip
						.find('.fct-dbox')
						.show()				
					;
					return true;
				}
				
				tooltip
					.find('.fct-dbox')
					.empty()
					.show()
					.append( RHC.tooltip_details[calEvent.id].clone() )
				;
				//-- refresh dates for reccurring.
				if(calEvent.allDay){
					if(calEvent.start){
						tooltip.find('.postmeta-fc_start .fe-extrainfo-value,.postmeta-fc_start_datetime .fe-extrainfo-value').html(
							$.fullCalendar.formatDate( calEvent.start, view.calendar.options.tooltip.startDateAllDay, view.calendar.options )
						 );
					}
					if(calEvent.end){
						tooltip.find('.postmeta-fc_end .fe-extrainfo-value,.postmeta-fc_end_datetime .fe-extrainfo-value').html(
							$.fullCalendar.formatDate( calEvent.end, view.calendar.options.tooltip.endDateAllDay||view.calendar.options.tooltip.startDateAllDay, view.calendar.options )
						 );
					}					
				}else{
					if(calEvent.start){
						tooltip.find('.postmeta-fc_start .fe-extrainfo-value,.postmeta-fc_start_datetime .fe-extrainfo-value').html(
							$.fullCalendar.formatDate( calEvent.start, view.calendar.options.tooltip.startDate, view.calendar.options )
						 );
					}
					if(calEvent.end){
						tooltip.find('.postmeta-fc_end .fe-extrainfo-value,.postmeta-fc_end_datetime .fe-extrainfo-value').html(
							$.fullCalendar.formatDate( calEvent.end, view.calendar.options.tooltip.endDate||view.calendar.options.tooltip.startDate, view.calendar.options )
						 );
					}			
				}		
				
				$('BODY').trigger('rhc_tooltip_contend_loaded', [e, calEvent, tooltip, view] );		
			}else{
				$.post(RHC.ajaxurl,{
		        		'rhc_action' : 'rhc_tooltip_detail',
						'id': calEvent.id,
						'event_rdate':calEvent.event_rdate
				},function(data){
						if( $(data).find('.fe-extrainfo-holder').length>0 ){
							RHC.tooltip_details[calEvent.id] = $(data).clone();
							rhc_tooltip_before_show(e,calEvent, tooltip, view);
						}else{
							RHC.tooltip_details[calEvent.id] = true;
						}				
				},'html');
			}		
		}
	});
	return true;
}

function cb_event_mouseover( calEvent, e, view ){
	jQuery(document).ready(function($){
		if( (view.calendar.options.tooltip.enableCustom||false) && calEvent.local_feed ){
			if( RHC.tooltip_details[calEvent.id] ){
			}else{
				RHC.tooltip_details[calEvent.id] = 'loading';
				url = RHC.ajaxurl;
				url = url + '?rhc_action=rhc_tooltip_detail&id=' + calEvent.id + '&event_rdate=' + calEvent.event_rdate;  
				var now = new Date();
				ver = RHC.last_modified && ''!=RHC.last_modified ? RHC.last_modified : now.getTime() ;
				url = url + '&ver=' + ver;  

				queryString = url.substring( url.indexOf('?') + 1 );	

				hash = CryptoJS.MD5( queryString )
				u = hash.toString(CryptoJS.enc.Hex);	
		
				url = url + '&_=' + u ;
				
				$.get( url,{},function(data){			
						if( $(data).find('.fe-extrainfo-holder').length>0 ){
							RHC.tooltip_details[calEvent.id] = $(data).clone();
						}else{
							RHC.tooltip_details[calEvent.id] = true;
						}				
				},'html');
			}		
		}
	});
	return true;
}

function rhc_tooltip_contend_loaded( args ){
	init_sc_ical_feed();
}

function calendar_widget_day_click( date,allDay,jsEvent,view, rhc_events_cache_notused, fc_options, _this ){
	var holder = jQuery( _this ).find('.rhc_calendar_widget_day_click_holder');
	if( holder.children().length > 0 ){
		holder.children().fadeOut('fast',function(){
			_calendar_widget_day_click( date,allDay,jsEvent,view, rhc_events_cache_notused, fc_options, _this );
		});
	}else{
		_calendar_widget_day_click( date,allDay,jsEvent,view, rhc_events_cache_notused, fc_options, _this );
	}
	return true;
}

function _calendar_widget_day_click( date,allDay,jsEvent,view, rhc_events_cache_notused, fc_options, _this ){
	//render a list of events below the calendar widget.S
	//rhc_events_cache does not contain external sources.
	client_events = jQuery('#' + fc_options.calendar_id ).find('.fullCalendar').fullCalendar('clientEvents');

	if( client_events.length > 0 ){
		var done_ids = [];
		var filtered_events = [];
		var filter_date = jQuery.fullCalendar.cloneDate( date );
		filter_date.setHours(0,0,0);					
		//--
		jQuery.each( client_events, function(i,ev){
			ev_uid = ev.id + '-' + ev._start.getTime();
			if( -1 != jQuery.inArray(ev_uid, done_ids) ) return;
			var ev_date = jQuery.fullCalendar.cloneDate( ev._start );
			ev_date.setHours(0,0,0);
			if( ev_date.getTime() == filter_date.getTime() ){
				done_ids.push( ev_uid ); 
				filtered_events.push( ev );				
			}	
		});	
		
		filtered_events.sort( _rhc_sort_events );
		var holder = jQuery( _this ).find('.rhc_calendar_widget_day_click_holder');
		var template = jQuery( _this ).find('.rhc_calendar_widget_day_click_template').children(); 		
		holder.empty();
		jQuery.each( filtered_events, function(i,ev){
			ev.fc_click_link = 'page'; //force link to page. tooltip is redundant.
		
			var item = template.clone();
			//title
			item.find('.rhc_title').append(
				jQuery(jQuery('<span></span>').html(ev.title)).RHCLink( ev, view )
			);
			//image
			if(ev.image && ev.image[0]){	
				item.find('.rhc_featured_image').append(
					jQuery( jQuery('<img />').attr('src', ev.image[0]) ).RHCLink( ev, view )
				);				
			}
			//dates
			item.find('.rhc_date').each(function(i,el){
				field = jQuery(el).data('fc_field');
				date_format = jQuery(el).data('fc_date_format');	
				if( value = ev[field] ){
					jQuery(el).html(
						jQuery.fullCalendar.formatDate(value, date_format, fc_options)
					);				
				}
			});
			
			if(ev.allDay){
				item.find('.rhc-event-time').hide();
			}

			//description
			item.find('.rhc_description').html( ev.description );
	
			//taxnomies
			if(ev.terms && ev.terms.length>0){
				jQuery.each(ev.terms,function(i,t){		
					if( item.find('.taxonomy-'+t.taxonomy).parent().find('a').length>0 ){
						item.find('.taxonomy-'+t.taxonomy).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
					}
									
					if( t.name && ''!=t.name && item.find('.taxonomy-'+t.taxonomy).length>0 ){
						if( t.url=='' ){
							jQuery('<span>'+ t.name +'</span>')
								.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy') )
							;	
						}else{
							jQuery('<a>'+ t.name +'</a>')
								.attr('href',t.url)
								.appendTo( item.find('.taxonomy-'+t.taxonomy).show().parent().removeClass('rhc_event-empty-taxonomy') )
							;								
						}

					}
					
					if( item.find('.taxonomy-'+t.taxonomy+'-gaddress').length>0 && t.gaddress && t.gaddress!=''){
						if( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).parent().find('a').length>0 ){
							item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).parent().append( '<span class="rhc-event-list tax-term-divider"></span>' );
						}							
						
						var _url = 'http://www.google.com/maps?f=q&hl=en&source=embed&q=' + escape(t.gaddress);
						jQuery('<a>'+ t.gaddress +'</a>')
							.attr('href', _url)
							.attr('target','_blank')
							.appendTo( item.find('.taxonomy-'+t.taxonomy+'-gaddress' ).show().parent().removeClass('rhc_event-empty-taxonomy').end() )
						;	
					}
				});
			}			
			
			//-- apply event color
			var color = ev.color || ev.source.color || '';
			var textColor = ev.textColor || ev.source.textColor || '';
			textColor = textColor.length<=1?'#ffffff':textColor;
			if( color.length>1 && textColor.length>1 ){
				item.find('.rhc-widget-event-list-date')
					.css('background-color', color)
					.css('color', textColor)
				;
			}
		
			if( fc_options.widget_autoclick && 1==parseInt(fc_options.widget_autoclick) ){
				item.find('.rhc-widget-event-list-head').parents('.rhc-widget-event-list')
					.addClass('open')
					.find('.rhc-widget-event-list-body').show()
				;
			}else{
				//--head click open body
				item.find('.rhc-widget-event-list-head')
					.unbind('click')
					.bind( 'click',  function(e){
						var holder = jQuery(this).parents('.rhc-widget-event-list')
						holder.toggleClass('open');
						if( holder.is('.open') ){
							holder.find('.rhc-widget-event-list-body').slideDown('fast');						
						}else{
							holder.find('.rhc-widget-event-list-body').slideUp('fast');					
						}
					})
				;				
			}


			if( fc_options.widget_autohover && 1==parseInt(fc_options.widget_autohover) ){
				item.find('.rhc-widget-event-list-head')
					.addClass('hover')
				;
			}else{
				//-- head hover animation
				item.find('.rhc-widget-event-list-head')
					.mouseenter( function(){
						jQuery(this).addClass('hover');
					})
					.mouseleave( function(){
						jQuery(this).removeClass('hover');
					})
				;					
			}		

			
			//-- ics download link
			var local_id = ev.local_id || 0;
			if( local_id > 0 ){
				var url = fc_options.events_source + fc_options.events_source_query;
				url = url.replace('get_calendar_events','get_icalendar_events');
				var url2 = url + '&ics=1';						
				url2 = url2 + '&ID=' + local_id;
				item.find('.rhc-icon-ical').click(function(e){
					window.open( url2, '_self');
				});
			}

			//-- google map
			if(ev.terms && ev.terms.length>0){
				jQuery.each(ev.terms,function(i,t){	
					var glon= t.glon || false;
					var glat= t.glat || false;
					var gaddress = t.gaddress || false;				
					var url = '';
					
					var map_holder = item.find('.rhc-map-view');
					var size = map_holder.data('size');
					var zoom = map_holder.data('zoom');
					var maptype= map_holder.data('maptype');
	
					var color = ev.color || ev.source.color || '';				
					if( color.length > 1 ){
						color = color.toUpperCase(color).replace('#','0x');
					}else{
						color = 'blue';
					}
	
					if( false!==glon && false!==glat ){
						url = 	'http://maps.googleapis.com/maps/api/staticmap?center=' + glat + ',' + glon +
								'&zoom=' + zoom + '&size=' + size + '&maptype=' + maptype +
								'&markers=color:' + color + '%7C' + glat + ',' + glon +
								''
						;
					}else if( false!==gaddress && ''!=gaddress ){
						url = 	'http://maps.googleapis.com/maps/api/staticmap?center=' + escape(gaddress) +
								'&zoom=' + zoom + '&size=' + size + '&maptype=' + maptype +
								'&markers=color:' + color + '%7C' + escape(gaddress) +
								''
						;					
					}

					if( ''!=url && 'none' != fc_options.widget_google_map ){
						item.find('.rhc-icon-map').unbind('click').bind('click',function(e){			
							//init interactive map
							var gmap = item.find('.rhc-map-view .sws-gmap3-cont');
							if( gmap.data('gmap_inited') ){
								
							}else{
								
								if( item.find('.rhc-map-view .sws-gmap3-cont').length > 0 ){
									gmap.data('gmap_inited', true);
												
									ratio = item.find('.rhc-map-view').data('ratio');
									arr = ratio.split(':');
									ratio = arr[1] / arr[0]; 
									
									w = item.find('.rhc-map-view').width();
									h = w * ratio;
									
									gmap.height(h);
							
									var maptype= gmap.data('maptype');
									var uid = gmap.data('uid');
									var gaddress = gmap.data('address');
									rhc_gmap3_init({
										glat: gmap.data('glat'),
										glon: gmap.data('glon'),
										zoom: gmap.data('zoom'),
										disableDefaultUI:false,
										map_type:google.maps.MapTypeId[ maptype ],
										uid: uid,
										name:"",
										info_windows:"sws-gmap3-info-" + uid,
										markers:"#sws-gmap3-marker-" + uid,
										address:gaddress,
										scrollwheel:1,
										traffic:false
									});										
									
									return; //map is shown. not returning here makes the map hide
									
								}								
															
							} 
							//show map
							jQuery(this).parents('.rhc-widget-event-list').find('.rhc-map-view').slideToggle( 'fast' );
						}).show();	
	
						if( 'static' == fc_options.widget_google_map ){
							if( ''!=url ){
								item.find('.rhc-map-view').empty().hide().append(
									jQuery('<img />').attr('src', url )
								);
							}					
						}else if( 'interactive' == fc_options.widget_google_map ){
							var map_tpl = '<div class="sws-gmap3-frame"><div id="map_canvas{uid}" class="sws-gmap3-cont"></div></div><div id="sws-gmap3-marker-{uid}" class="sws-gmap3-marker">|||::</div><div class="sws-gmap3-marker"><div id="sws-gmap3-info-{uid}" >{info_windows}</div></div>';
							var uid = ev.id + '-' + ev.start.getTime();
							map_tpl = map_tpl.replace(/\{uid\}/g, uid);
							map_tpl = map_tpl.replace(/\{info_windows\}/g, t.name );
	
							item.find('.rhc-map-view')
								.empty()
								.append( map_tpl )
							;
							
							item.find('.rhc-map-view .sws-gmap3-cont')
								.data('glat', glat)
								.data('glon', glon)
								.data('zoom', zoom)
								.data('maptype', maptype)
								.data('uid', uid)
								.data('address', gaddress)						
							;
						}											
					}
					//			
				});
			}	
		
			//--setup sharing buttons from social panels
			if( 'undefined' != typeof rhp_vars ){			
				if( item.find('.rhc-icon-facebook').length > 0 ){
					item.find('.rhc-icon-facebook').show().unbind('click').bind('click',function(e){
						e.preventDefault();
						
						FB.init({appId: rhp_vars.fb_appID, status: true, cookie: true});
						
						// calling the API ...
						var obj = {
						  method: 'share',
						  href: ev.url,
						  link: ev.url,
						  name: ev.title,
						  caption: ev.title,
						  description: ev.description
						};
						
						function callback(response) {
						  //console.log(response);
						}
						
						FB.ui(obj, callback);
					});
				}
				
				if( item.find('.rhc-icon-twitter').length > 0 ){
					item.find('.rhc-icon-twitter').show().unbind('click').bind('click',function(e){
						var articleUrl = encodeURIComponent( ev.url );
						var articleSummary = encodeURIComponent( ev.description );
						var goto = 'https://twitter.com/share?' +
						    '&url=' + ev.url +
						    '&text=' + ev.title + 
						    '&counturl=' + ev.url;
						window.open(goto, 'Twitter', "width=660,height=400,scrollbars=no;resizable=no");
					});
				}
				
				if( item.find('.rhc-icon-linkedin').length > 0 ){
					item.find('.rhc-icon-linkedin').show().unbind('click').bind('click',function(e){
						var articleUrl = encodeURIComponent( ev.url );
						var articleTitle = encodeURIComponent( ev.title );
						var articleSummary = encodeURIComponent( ev.description );
						var articleSource = encodeURIComponent( ev.url );
						var goto = 'http://www.linkedin.com/shareArticle?mini=true'+
							 '&url='+articleUrl+
							 '&title='+articleTitle+
							 '&summary='+articleSummary+ articleUrl +
							 '&source='+articleSource;

						window.open(goto, 'LinkedIn', "width=660,height=400,scrollbars=no;resizable=no");
					});
				}	
				
				if( item.find('.rhc-icon-googleplus').length > 0 ){
					item.find('.rhc-icon-googleplus').show().unbind('click').bind('click',function(e){
					    var articleUrl = encodeURIComponent( ev.url );
					    var goto = 'https://plus.google.com/share?url=' + articleUrl;
			
						window.open(goto, 'Google+', "width=660,height=400,scrollbars=no;resizable=no");
					});
				}
				
			}
						
			item.hide();
			holder.append( item.fadeIn( 'fast' ) );
		});
		
		jQuery('BODY').trigger('dbox.loaded');	
	}
}

function _rhc_sort_events(o,p){
	if(o.start>p.start){
		return 1;
	}else if(o.start<p.start){
		return -1;
	}else{
		return 0;
	}
}

function btn_tax_dropdown(calendar,header){
	//this function is needed for tax filter not to generate a js error. however the click action is defined somewher else.
}

function dayclick_tooltip_evenlits( date,allDay,jsEvent,view,fc_options,_this ){
	console.log( 'day click', date, _this );
}

function rhc_console(){
    if(console){
        console.log.apply(console, arguments);
    }
}