function rhc_in_array(needle,haystack){
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