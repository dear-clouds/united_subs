jQuery( document ).ready(function($){
  $('body').on('click', 'a.mom-addon-activate', function(e) {
    e.preventDefault();
        var t = $(this);
        var plugin = $(this).data('plugin');
        jQuery.ajax({
        type: "post",
        url: momAjaxAddon.url,
        dataType: 'html',
        data: "action=mom_addon_activate&nonce="+momAjaxAddon.nonce+"&plugin="+plugin,
      beforeSend: function() {
            t.parent().find('.spinner').fadeIn();
      },
      success: function(data){
            t.parent().find('.spinner').fadeOut();
            t.text(momAjaxAddon.deactivate_text);
            t.removeClass('mom-addon-activate').addClass('mom-addon-deactivate');
            t.parents('.mom-addons-extension').find('.status').removeClass('inactive').addClass('active').text(momAjaxAddon.active_text);
      }
    }); 
  });

  $('body').on('click', 'a.mom-addon-deactivate', function(e) {
    e.preventDefault();
        var t = $(this);
        var plugin = $(this).data('plugin');
        jQuery.ajax({
        type: "post",
        url: momAjaxAddon.url,
        dataType: 'html',
        data: "action=mom_addon_deactivate&nonce="+momAjaxAddon.nonce+"&plugin="+plugin,
      beforeSend: function() {
            t.parent().find('.spinner').fadeIn();
      },
      success: function(data){
            t.parent().find('.spinner').fadeOut();
            t.text(momAjaxAddon.activate_text);
            t.removeClass('mom-addon-deactivate').addClass('mom-addon-activate');
            t.parents('.mom-addons-extension').find('.status').removeClass('active').addClass('inactive').text(momAjaxAddon.inactive_text);
      }
    }); 
  });

  $('body').on('click', 'a.mom-addon-update', function(e) {
    e.preventDefault();
        var t = $(this);
        var plugin = $(this).data('plugin');
        var plugin_source = $(this).data('plugin_source');
        jQuery.ajax({
        type: "post",
        url: momAjaxAddon.url,
        dataType: 'html',
        data: "action=mom_addon_update&nonce="+momAjaxAddon.nonce+"&plugin_source="+plugin_source+"&plugin="+plugin,
      beforeSend: function() {
            t.addClass('updated');
      },
      success: function(data){
            t.removeClass('updated');
            t.html('<i class="dashicons dashicons-yes"></i>'+momAjaxAddon.updated_text);
      }
    }); 
  });

});