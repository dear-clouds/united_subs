////////////////////////////////////////////////////////////////////////////////////////////////////
// Cities
////////////////////////////////////////////////////////////////////////////////////////////////////
// instantiate the bloodhound suggestion engine
var weathers = new Bloodhound({
    datumTokenizer: function (d) {
        return Bloodhound.tokenizers.whitespace(d.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: 'http://api.openweathermap.org/data/2.5/find?q=%QUERY&type=like&mode=json&APPID=46c433f6ba7dd4d29d5718dac3d7f035',
        filter: function (weathers) {
            return jQuery.map(weathers.list, function (list) {
                return {
                    value: list.name,
                    value2: list,
                };
            });
        },
        
    },
    
});

// initialize the bloodhound suggestion engine
weathers.initialize();
jQuery('#locator-form-search').typeahead( {
	hint: true,
	highlight: true,
	minLength: 3
},
{
	name: 'cities',
	displayKey: 'value',
	source: weathers.ttAdapter(),
	templates: {
	    empty: [
	      '<div class="empty-message">',
	      'Unable to find any cities that match the current query',
	      '</div>'
	    ].join('\n'),
	    suggestion: Handlebars.compile('<p><strong>{{value2.name}}</strong> - {{value2.sys.country}}</p>')
	  }
          
});

jQuery(document).ready(function($) {
            $('#locator-form-search').keypress(function (e) {
              if (e.which == 13) {
                $(this).closest('form').submit();
                return false;
              }
            });            
});

