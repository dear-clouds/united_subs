function is_downloaded(id){
	if( rh_downloaded.length > 0 ){
		for( var a=0; a<rh_downloaded.length ; a++ ){
			if( id==rh_downloaded[a] ){
				return true;
			}
		}
	}
	return false;
}

function rh_in_array(needle,haystack){
	if( haystack.length > 0 ){
		for (var i in haystack) {
			if( needle==haystack[i] ){
				return true;
			}		
		}
	}
	return false;
}

function get_bundles(){
	jQuery('#install-message').empty().append('<div class="row-message"><span>Requesting downloadable content list, please wait...</span></div>');
	jQuery('#installing').fadeIn();
		
	var args = {
		action:'rh_get_bundles_'+rh_download_panel_id
	};

	if( rh_bundles.length>0 ){
		tmp = [];
		jQuery.each(rh_bundles,function(i,o){
			tmp[tmp.length]={
				id: o.id,
				type: o.type,
				name: o.name,
				recent: o.recent,
				description: o.description,
				url: o.url,
				version: o.version,
				status: o.status,
				downloaded: is_downloaded(o.id),
				addon_path: o.addon_path,
				image: o.image
			};
		});
		jQuery('#installing').hide();
		populate_bundles(tmp);
		return;
	}
	
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: args,
		success: function(data){
			jQuery('#installing').hide();
			if(data.R=='OK'){
				rh_bundles = [];
				jQuery.each(data.BUNDLES,function(i,o){			
					rh_bundles[rh_bundles.length]={
						id: o.id,
						type: o.type,
						name: o.name,
						recent: o.recent,
						description: o.description,
						url: o.url,
						version: o.version,
						status: o.status,
						downloaded: is_downloaded(o.id),
						addon_path: o.addon_path,
						image: o.image,
						item_no_1: o.item_no_1?o.item_no_1:'',
						item_no_2: o.item_no_2?o.item_no_2:''
					};
				
					data.BUNDLES[i].downloaded = is_downloaded(o.id);
				});	
				stripe_public_key = data.STRIPEKEY;
				populate_bundles(data.BUNDLES);
			}else if(data.R=='ERR'){
				jQuery('#messages').removeClass('updated').addClass('error').html(data.MSG);
			}else{
			
			}	
		},
		error: function(jqXHR, textStatus, errorThrown){
			jQuery('#installing').hide();
			jQuery('#messages').removeClass('updated').addClass('error').html('Service not available please try again later. Error status: '+textStatus+', and error message: '+errorThrown);
		},
		dataType: 'json'
	});		
}

var available_updates = 0;
var populating_bundle = false;
function populate_bundles(bundles){
	if(bundles.length>0 && !populating_bundle){
		jQuery(document).ready(function($){		
			populating_bundle = true;
			$('#bundles').isotope('remove', $('#bundles .pop-dlc-item') ).isotope('reLayout');
			var filtered_bundle = [];
			//--
			if(rh_filter=='new'){
				$.each(bundles,function(i,o){
					if( o.recent==1 ){
						filtered_bundle[ filtered_bundle.length ] = o;
					}
				});
			}else if(rh_filter=='downloaded' && rh_downloaded.length>0){
				$.each(bundles,function(i,o){
					if( is_downloaded(o.id) ){
					//if( rh_downloaded.in_array(o.id) ){
						filtered_bundle[ filtered_bundle.length ] = o;
					}
				});
			}else{
				filtered_bundle = bundles;
			}
			available_updates = 0;
			add_bundle(filtered_bundle);
		});
	}
}

function add_bundle(bundles){
	if(bundles.length>0){
		jQuery(document).ready(function($){
			o=bundles.shift();
			o.registered=false;
			o.registered_main=false;
		
			if( rh_theme || (o.item_no_1 && o.item_no_1>0 && $.inArray(o.item_no_1,rh_item_ids)>-1) ){
				o.registered_main = true;
				if(o.item_no_2 && o.item_no_2>0){
					if( $.inArray(o.item_no_2,rh_item_ids)>-1 ){
						o.registered=true;
					}
				}else{
					o.registered=true;
				}
			}					
 			
			o.iversion = '' ;
			
			if( rh_addon_details[ o.addon_path ] && rh_addon_details[ o.addon_path ].Version ){
				o.iversion = rh_addon_details[ o.addon_path ].Version;
			}
						
			var retina = typeof window.devicePixelRatio!='undefined' && window.devicePixelRatio > 1;
			var src = o.image;
			if(retina){
				arr = o.image.split('.');
				if(arr.length>=2){
					arr[arr.length-2] = arr[arr.length-2] + '@2x';		
					src = arr.join('.');
				}			
			}
	
			if( is_pending_update(o) ){
				available_updates++;
			}
	
			template = $('#pop-dlc-item-template .pop-dlc-item').clone();
			template
				.attr('id', 'pop-dlc-item-' + o.id )
				.attr('data-item_id', o.id)
				.addClass( (o.downloaded?'dlc-downloaded':'dlc-not-downloaded') )
				.addClass( (o.recent=='1'?'dlc-recent':'dlc-not-recent') )
				.addClass( (o.iversion==''?'dlc-not-installed':'dlc-installed') )
				.addClass( is_pending_update(o) ? 'dlc-update' : 'dlc-no-update' ) 
				.addClass( ('req1_' + o.item_no_1) )
				.find('.pop-dlc-name').html(o.name).end()
				.find('.pop-dlc-version').html(o.version).end()
				.find('.pop-dlc-iversion').html(o.iversion).end()
				.find('.pop-dlc-price')
					.attr('data-price', o.price)
					.attr('data-currency', o.currency)
					.html(o.price_str)
					.end()
				.find('.pop-dlc-description').html(o.description).end()
				.find('.pop-dlc-filesize').html(readablizeBytes(o.filesize)).end()
				.find('.pop-dlc-image')
					.attr('href',o.url)
					.end()
				.find('.pop-dlc-image img')
					.attr('src',src)
					.end()
				.find('.btn-visit-site')
					.attr('href',o.url)
					.end()
				.find('.btn-download')
					.attr('rel',o.id)
					.data('plugin_code',o.plugin_code)
					.on('click',function(e){download_bundle(e,this);})
					.end()
				.find('.dlc-addon-control')
					.data('addon_path',o.addon_path)
					.data('plugin_code',o.plugin_code)
					.end()
				//.appendTo('#bundles')
			;

			if(o.image==null || o.image==''){
				template.find('.pop-dlc-image').hide();
			}
		
			if(o.addon_path!=null && o.addon_path!=''){
				template.addClass('dlc-addon');	
			}
		
			if(o.addon_path==null || $.inArray(o.addon_path,rh_installed_addons)==-1 ){
				template.find('.dlc-addon-control').hide();
			}else{			
				if( $.inArray(o.addon_path,rh_active_addons)>-1 ){			
					template
						.find('.dlc-addon-control .enable-addon')
						.addClass('btn-success')
						.addClass('active')
						.end()
						.find('.dlc-addon-control .disable-addon')
						.removeClass('btn-danger')
						.removeClass('active')
						.end()
					;	
				}else{
					template
						.find('.dlc-addon-control .enable-addon')
						.removeClass('btn-success')
						.removeClass('active')
						.end()
						.find('.dlc-addon-control .disable-addon')
						.addClass('btn-danger')
						.addClass('active')
						.end()
					;				
				}
				
				template.find('.dlc-addon-control .enable-addon')
					.attr('id','btn_enable_addon_' + o.id)	
					.on('click',function(e){
						el_id = $(this).attr('id');
						plugin = $(this).parent().data('addon_path');
						plugin_code = $(this).parent().data('plugin_code');
						dlc_activate_addon( plugin, el_id, true, plugin_code );
					})
				;
				template.find('.dlc-addon-control .disable-addon')
					.attr('id','btn_disable_addon_' + o.id)	
					.on('click',function(e){
						el_id = $(this).attr('id');
						plugin = $(this).parent().data('addon_path');
						plugin_code = $(this).parent().data('plugin_code');
						dlc_activate_addon( plugin, el_id, false, plugin_code );
					})
				;
			}
		
			if( is_pending_update( o ) ){
				template.find('.btn-download label').html( template.find('.btn-download label').data('update') ); 
			}
		
			if(o.registered_main && o.registered){
				template.find('.btn-download').removeClass('disabled').addClass('btn-primary').show();
			}else{
				template.find('.btn-download').addClass('disabled').removeClass('btn-primary');
				if(!o.registered_main){
					template.find('.btn-download').addClass('pending-main-license');
				}
				if(!o.registered){
					template.find('.btn-download').addClass('pending-addon-license');
				}
			}
			
			if(o.price>0 ){
				if( o.registered ){
					template.find('.btn-purchased').show();
					template.find('.pop-discount-code').hide();
				}else{
					template.find('.btn-buynow')
						.attr('data-item_id', o.id)
						.attr('data-key',stripe_public_key)
						.attr('data-amount', parseInt(o.price*100) )
						.attr('data-currency', o.currency)
						.attr('data-name', o.name)
						.attr('data-description', o.description)
						.attr('data-image', o.image)
						.show()

					;
					
					if( o.registered_main ){
						template.find('.btn-buynow')
							.on('click',function(e){
								return stripe_buy_now(e,this);
							})
						;
						template.find('.btn-pop-discount-code')
							.on('click',function(e){
								return apply_discount_code(e,this);
							})
						;
					}else{
						template.find('.btn-buynow')
							.removeClass('btn-success')
							.addClass('disabled')
							.on('click',function(e){
								$(this).parents('.pop-dlc-item')
									.find('.main-license-message')
									.show()
							})							
						;
						$('#bundles').isotope('reLayout');
					}
				}
			}else{
				template.find('.pop-discount-code').hide();
			}

			//--	
			$('#bundles').isotope('insert', template);
			if( rh_custom_filter && $( '.req1_' + o.item_no_1 + '_filter' ).length == 0 ){
				$('.subsubsub').append('<li class="custom-filter ' + 'req1_' + o.item_no_1 + '_filter'  + '">|<a class="isotope-filter" rel="' + ('.req1_' + o.item_no_1) + '" href="javascript:void(0);">' + o.req1 + '</a></li>');
				$('.req1_' + o.item_no_1 + '_filter a').unbind('click').bind('click',function(e){
					_filter_value = $(this).attr('rel');
					$('#bundles').isotope({ filter: _filter_value });
				});
			}
		
			
			add_bundle(bundles);
		});
	}else{
		populating_bundle = false;
		if( available_updates > 0 ){
			pop_top_notification( dc_updates_available.replace('%s',available_updates), 'error' );
		}
	}		
}

function handle_stripe_token(res){
	_handle_stripe_token(res,3);
}

function _handle_stripe_token(res,retries){
	if(retries==0){
		msg = 'There was a communication error and the payment could not be confirmed.  Please contact support at support.righthere.com about dlc payment: ' + res.id;
		pop_top_notification( msg, 'error', 0 );
		return;
	}
	
	var args = {
		action:'handle_stripe_token_'+rh_download_panel_id,
		token: res.id,
		item_id: stripe_item_id,
		coupon: stripe_coupon,
		info: res
	};

	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: args,
		success: function(data){
			if(data.R=='OK'){
				//--
				rh_item_ids[rh_item_ids.length] = data.LICENSE.item_id;
				rh_license_keys[rh_license_keys.length] = data.LICENSE.license_key;
				//--
				rh_bundles = [];
				get_bundles();
			}else if(data.R=='ERR'){
				pop_top_notification( data.MSG, 'error', 0 );
			}else{
				//unknown response
				_handle_stripe_token(res,retries--);
			}	
		},
		error: function(jqXHR, textStatus, errorThrown){
			_handle_stripe_token(res,retries--);
		},
		dataType: 'json'
	});		
}

function stripe_buy_now(e,btn){
	jQuery(document).ready(function($){
		dc_btn_loading( btn, 1 );
		if( !$(btn).is('.coupon-shown') ){
			$(btn).addClass('coupon-shown');
			$(btn).closest('.pop-dlc-item').addClass('show-coupon');
			dc_btn_loading( btn, 0 );
			return false;
		}
		
		var cents = $(btn).attr('data-amount');
		if( parseInt(cents)==0 ){
			dc_btn_loading( btn, 0 );
			handle_purchase_with_gc( e,btn );
		}else{
			stripe_item_id = $(btn).attr('data-item_id');
			stripe_coupon = $(btn).attr('data-coupon')||'';
			
			$(btn).addClass('disabled');
			
			stripe_settings = {
		        key:         $(btn).attr('data-key'),
		        address:     true,
		        amount:      $(btn).attr('data-amount'),
		        currency:    $(btn).attr('data-currency'),
		        name:        $(btn).attr('data-name'),
				image:		 $(btn).attr('data-image'),
		        description: $(btn).attr('data-description'),
		        panelLabel:  $(btn).attr('data-panel_label'),
		        token:       handle_stripe_token
			};
			
			if( rh_alipay ){
				stripe_settings.alipay = true;
			}
			
			if( rh_bitcoin ){
				stripe_settings.bitcoin = true;
			}
			
			StripeCheckout.open(stripe_settings);
			setTimeout(function(){dc_btn_loading( btn, 0 );},3000);		
		}
	});
	return false;
}

function dc_btn_loading( btn, activate ){
	if( activate ){
		jQuery(btn).addClass('pop-loading');
	}else{
		jQuery(btn).removeClass('pop-loading');
	}
}

function download_bundle(e,btn){
	jQuery(document).ready(function($){
		dc_btn_loading( btn, 1 );
		if( $(btn).hasClass('disabled') ) {
			if( $(btn).hasClass('pending-main-license') ){
				$(btn).parents('.pop-dlc-item').find('.main-license-message').show();
			}else if( $(btn).hasClass('pending-addon-license') ){
				//$(btn).parents('.pop-dlc-item').find('.addon-license-message').show();
			}
			$('#bundles').isotope('reLayout');
			dc_btn_loading( btn, 0 );
			return;
		}
		$('#install-message').empty().append('<div class="row-message"><span>Downloading content...</span></div>');
		$('#installing').fadeIn();
		var id = jQuery(e.target).closest('button').attr('rel');
		
		var args = {
			action:'rh_download_bundle_'+rh_download_panel_id,
			id:id,
			plugin_code: $(btn).data('plugin_code')
		};
		
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: args,
			timeout: 360000,
			success: function(data){			
				$('#installing').hide();			
				if(data.R=='OK'){
					if( !is_downloaded(id) ){
						rh_downloaded[rh_downloaded.length]=id;
					}
					$('#messages').removeClass('error').addClass('updated').html(data.MSG);
					
					window.location.reload();
				}else if(data.R=='ERR'){
					$('#messages').removeClass('updated').addClass('error').html(data.MSG);
				}else{
					$('#messages').removeClass('updated').addClass('error').html('Invalid ajax response, please try again.');	
				}
				dc_btn_loading( btn, 0 );
			},
			error: function(jqXHR, textStatus, errorThrown){
				$('#installing').hide();
				$('#messages').removeClass('updated').addClass('error').html('Operation returned error status: '+textStatus+', and error message: '+errorThrown);
				dc_btn_loading( btn, 0 );
			},
			dataType: 'json'
		});	
	});	
}

function readablizeBytes(bytes){
	if(bytes==null||bytes=='')return'0 bytes';
	try{
	    var s = ['bytes', 'kb', 'MB', 'GB', 'TB', 'PB'];
	    var e = Math.floor(Math.log(bytes)/Math.log(1024));
	    return (bytes/Math.pow(1024, Math.floor(e))).toFixed(2)+" "+s[e];	
	}catch(e){}
	return '';
}

function dlc_activate_addon( plugin, el_id, activate, plugin_code ){
	jQuery(document).ready(function($){
		var args = {
			action:'dlc_activate_addon_'+rh_download_panel_id,
			plugin: plugin,
			plugin_code: plugin_code,
			activate: activate ? 1 : 0,
			el_id: el_id
		}

		$.post( ajaxurl, args, function(data){
			if(data.R=='OK'){
				if( activate ){
					$('#'+el_id).parent().find('.btn.enable-addon')
						.addClass('btn-success')
					;
					$('#'+el_id).parent().find('.btn.disable-addon')
						.removeClass('btn-danger')
					;
				}else{
					$('#'+el_id).parent().find('.btn.enable-addon')
						.removeClass('btn-success')
					;
					$('#'+el_id).parent().find('.btn.disable-addon')
						.addClass('btn-danger')
					;	
				}
				if(data.URL && ''!=data.URL){
					window.location.replace(data.URL);
				}else{
					window.location.reload();
				}
				return;
			}else if(data.R=='ERR'){
				pop_top_notification( data.MSG, 'error' );
			}else{
				pop_top_notification( 'Error saving, reload page and try again.', 'error' );
			}
			$('#'+el_id).parent().find('.btn.active').removeClass('active');
		}, 'json');		
	});
}

function apply_discount_code(e,btn){

	jQuery(document).ready(function($){
		dc_btn_loading( btn, 1 );
		var item_id = $(btn).closest('.pop-dlc-item').data('item_id');
		var coupon_code = $(btn).closest('.pop-dlc-item').find('.pop-discount-code-inp').val();
		var holder = $(btn).closest('.pop-dlc-item');
		if( coupon_code=='' ){
			var price = holder.find('.pop-dlc-price').data('price');
			var currency = holder.find('.pop-dlc-price').data('currency');
			price_str = price > 0 ? (price + ' ' + currency) : 'Free';
			holder.find('.pop-dlc-price').html(price_str);
			holder.find('.btn-buynow').attr('data-amount', parseInt(price*100) );
			holder.find('.btn-buynow').attr('data-coupon', '' );
			dc_btn_loading( btn, 0 );
			return;
		}
				
		var args = {
			action:'apply_coupon_'+rh_download_panel_id,
			coupon: coupon_code,
			item_id: item_id
		}
		
		$.post( ajaxurl, args, function(data){
			if(data.R=='OK'){	
				var currency = holder.find('.pop-dlc-price').data('currency');
				price_str = data.PRICE > 0 ? (data.PRICE + ' ' + currency) : 'Free';
				holder.find('.pop-dlc-price').html(price_str);
				holder.find('.btn-buynow').attr('data-amount', parseInt(data.PRICE*100) );
				holder.find('.btn-buynow').attr('data-coupon', coupon_code );
				dc_btn_loading( btn, 0 );
				if( data.MSG ) pop_top_notification( data.MSG, 'success' );
				return;
			}else if(data.R=='ERR'){
				pop_top_notification( data.MSG, 'error' );
			}else{
				pop_top_notification( 'Unknown error, reload page and try again.', 'error' );
			}
			dc_btn_loading( btn, 0 );
		}, 'json');	
		
	});	
}

function handle_purchase_with_gc( e, btn ){
	jQuery(document).ready(function($){
		dc_btn_loading( btn, 1 );
		var args = {
			action:'handle_gc_'+rh_download_panel_id,
			item_id: $(btn).attr('data-item_id'),
			coupon: $(btn).attr('data-coupon')
		};
		
		$.post( ajaxurl, args, function(data){
			if(data.R=='OK'){	
				//--
				rh_item_ids[rh_item_ids.length] = data.LICENSE.item_id;
				rh_license_keys[rh_license_keys.length] = data.LICENSE.license_key;
				//--
				rh_bundles = [];
				get_bundles();

			}else if(data.R=='ERR'){
				pop_top_notification( data.MSG, 'error' );
			}else{
				pop_top_notification( 'Unknown error, reload page and try again.', 'error' );
			}
			dc_btn_loading( btn, 0 );
		}, 'json');	
	});
}

function is_pending_update( o ){
	if( o.pending_update ) return o.pending_update;
	if( ''==o.iversion ) return false;

	if( parseInt( _versionCompare(o.version, o.iversion, {zeroExtend:true}) ) > 0 ){
		o.pending_update = true;
		return true;
	}
	return false;
}

/**
 * Compares two software version numbers (e.g. "1.7.1" or "1.2b").
 *
 * This function was born in http://stackoverflow.com/a/6832721.
 *
 * @param {string} v1 The first version to be compared.
 * @param {string} v2 The second version to be compared.
 * @param {object} [options] Optional flags that affect comparison behavior:
 *
 * @copyright by Jon Papaioannou (["john", "papaioannou"].join(".") + "@gmail.com")
 * @license This function is in the public domain. Do what you want with it, no strings attached.
 */
function _versionCompare(v1, v2, options) {
    var lexicographical = options && options.lexicographical,
        zeroExtend = options && options.zeroExtend,
        v1parts = v1.split('.'),
        v2parts = v2.split('.');
 
    function isValidPart(x) {
        return (lexicographical ? /^\d+[A-Za-z]*$/ : /^\d+$/).test(x);
    }
 
    if (!v1parts.every(isValidPart) || !v2parts.every(isValidPart)) {
        return NaN;
    }
 
    if (zeroExtend) {
        while (v1parts.length < v2parts.length) v1parts.push("0");
        while (v2parts.length < v1parts.length) v2parts.push("0");
    }
 
    if (!lexicographical) {
        v1parts = v1parts.map(Number);
        v2parts = v2parts.map(Number);
    }
 
    for (var i = 0; i < v1parts.length; ++i) {
        if (v2parts.length == i) {
            return 1;
        }
 
        if (v1parts[i] == v2parts[i]) {
            continue;
        }
        else if (v1parts[i] > v2parts[i]) {
            return 1;
        }
        else {
            return -1;
        }
    }
 
    if (v1parts.length != v2parts.length) {
        return -1;
    }
 
    return 0;
}