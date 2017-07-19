(function() {
  tinymce.create('tinymce.plugins.sp_calendar_mce', {
    init : function(ed, url) {
      ed.addCommand('mcesp_calendar_mce', function() {
        ed.windowManager.open({
          file : spider_calendar_ajax + '?action=window',
          width : 400 + ed.getLang('sp_calendar_mce.delta_width', 0),
          height : 220 + ed.getLang('sp_calendar_mce.delta_height', 0),
          inline : 1
        }, {
          plugin_url : url
        });
      });
      ed.addButton('sp_calendar_mce', {
        title : 'Insert Spider Calendar',
        cmd : 'mcesp_calendar_mce',
		image: wdplugin_url + '/images/calendar_menu.png'
      });
    }
  });
  tinymce.PluginManager.add('sp_calendar_mce', tinymce.plugins.sp_calendar_mce);
})();