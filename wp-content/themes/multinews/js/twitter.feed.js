/*
 * Design Chemical jQuery Twitter Feed Plugin Tutorial
 * Copyright (c) 2012 Design Chemical
 * http://www.designchemical.com/blog/index.php/premium-jquery-plugins/jquery-social-media-tabs-plugin/
 * Version 1.0 (19-12-2012)
 */
 
(function($){

	TwitterFeedObject = function(el, options) {
		this.create(el, options);
	};
	
	$.extend(TwitterFeedObject.prototype, {

		create: function(el, options) {
			
			// Set the default options
			this.defaults = {
				id: '', // enter username, twitter list ID or search keyword
				retweets: true, // include/exclude retweets
				replies: true, // include/exclude replies
				avatar: true, // include/exclude user avatar
				results: 10, // number of results to display
				images: '', // large w: 786 h: 346, thumb w: 150 h: 150, medium w: 600 h: 264, small w: 340 h 150
				tweetId: '' // twitter username for share links
			};
			
			var o = $.extend(true,this.defaults,options);
			
			// Add ul tag to target element
			$(el).append('<ul class="stream"></ul>');

			// Set Twitter API url
			var url = 'https://api.twitter.com/1/statuses/user_timeline.json?screen_name='+o.id+'&count='+o.results+'&include_entities=true&include_rts='+o.retweets+'&exclude_replies='+ o.replies+'&callback=?';
			
			// Check if search feed & change API url if true
			var cq = o.id.split('#');
			if(cq.length > 1){
				var rts = o.retweets == false ? '+exclude:retweets' : '' ;
				url = 'https://search.twitter.com/search.json?q='+encodeURIComponent(cq[1])+rts+'&rpp='+o.results+'&include_entities=true&result_type=mixed';
			}
			
			// jQuery AJAX call to Twitter API
			jQuery.ajax({
				url: url,
				cache: true,
				dataType: 'jsonp',
				success: function(a){
					
					if(cq.length > 1){a = a.results} ;
	
					$.each(a, function(i,item){
						if(i < o.results){
							var html = '<li>', 
								d = item.created_at,
								user = cq.length > 1 ? item.from_user : item.user.screen_name,
								name = cq.length > 1 ? item.from_user_name : item.user.name,
								avatar = cq.length > 1 ? item.profile_image_url : item.user.profile_image_url ;
								
							html += o.avatar == true ? '<a href="http://www.twitter.com/'+user+'" class="thumb"><img src="'+avatar+'" alt="" /></a>' : '' ;
							html += '<a href="http://www.twitter.com/'+user+'" class="user"><strong>'+name+'</strong> @'+user+'</a>';
							html += linkify(item.text);
							
							// Show images if images: true
							if(o.images != '' && item.entities.media){
								$.each(item.entities.media, function(i,media){
									html += '<a href="'+media.media_url+'" class="twitter-image"><img src="'+media.media_url+':'+o.images+'" alt="" /></a>';
								});
							}
							
							// Add share links
							html += '<span class="section-share">'+shareLink(item.title,item.id_str,o.tweetId)+'</span>';
							
							// Get time since
							d = d != '' ? html += '<span class="date">'+nicetime(new Date(d).getTime())+'</span></li>' : '' ;
						}
						
						// Add twitter feed items to stream
						$('.stream',el).append(html).slideDown();
					});
				},
				complete: function(){
					
					// Code to open new popup window for share links + open other links in new browser tab
					$('.stream a',el).click(function(e){
						if($(this).parent().hasClass('section-share')){
							var u = $(this).attr('href');
							window.open(u,'sharer','toolbar=0,status=0,width=626,height=436');
							return false;
						} else {
							if(external){this.target = '_blank';}
						}
					});
				}
			});
		}
	});
	
	$.fn.dcTwitterFeed = function(options, callback){
		var d = {};
		this.each(function(){
			var s = $(this);
			d = s.data("twitterfeed");
			if (!d){
				d = new TwitterFeedObject(this, options, callback);
				s.data("twitterfeed", d);
			}
		});
		return d;
	};
	
	// Function to convert URLs in twitter feed text to links
	function linkify(text){
		text = text.replace(
			/((https?\:\/\/)|(www\.))(\S+)(\w{2,4})(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/gi,
			function(url){
				var full_url = !url.match('^https?:\/\/') ? 'http://' + url : url ;
				return '<a href="' + full_url + '">' + url + '</a>';
			}
		);
		text = text.replace(/(^|\s)@(\w+)/g, '$1@<a href="http://www.twitter.com/$2">$2</a>');
		text = text.replace(/(^|\s)#(\w+)/g, '$1#<a href="http://twitter.com/search/%23$2">$2</a>');
		return text;
	}
	
	// Creates share links
	function shareLink(st,sq,tweetId){
		var s = '';
		var intent = 'https://twitter.com/intent/';
			s = '<a href="'+intent+'tweet?in_reply_to='+sq+'&via='+tweetId+'" class="share-reply"></a>';
			s += '<a href="'+intent+'retweet?tweet_id='+sq+'&via='+tweetId+'" class="share-retweet"></a>';
			s += '<a href="'+intent+'favorite?tweet_id='+sq+'" class="share-favorite"></a>';
		return s;
    }
	
	// Function to convert date to relative date
	function nicetime(a){
		a = $.browser.msie ? a.replace(/(\+\S+) (.*)/, '$2 $1') : a ;
		var d = Math.round((+new Date - a) / 1000), fuzzy;
		var chunks = new Array();
			chunks[0] = [60 * 60 * 24 * 365 , 'year'];
			chunks[1] = [60 * 60 * 24 * 30 , 'month'];
			chunks[2] = [60 * 60 * 24 * 7, 'week'];
			chunks[3] = [60 * 60 * 24 , 'day'];
			chunks[4] = [60 * 60 , 'hr'];
			chunks[5] = [60 , 'min'];
		var i = 0, j = chunks.length;
		for (i = 0; i < j; i++) {
			s = chunks[i][0];
			n = chunks[i][1];
			if ((xj = Math.floor(d / s)) != 0)
				break;
		}
		fuzzy = xj == 1 ? '1 '+n : xj+' '+n+'s';
		if (i + 1 < j) {
			s2 = chunks[i + 1][0];
			n2 = chunks[i + 1][1];
			if ( ((xj2 = Math.floor((d - (s * xj)) / s2)) != 0) )
				fuzzy += (xj2 == 1) ? ' + 1 '+n2 : ' + '+xj2+' '+n2+'s';
		}
		fuzzy += ' ago';
		return fuzzy;	
    }
	
})(jQuery);