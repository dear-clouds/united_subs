// Docu : http://wiki.moxiecode.com/index.php/TinyMCE:Create_plugin/3.x#Creating_your_own_plugins

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('theme_shortcode');
	
	tinymce.create('tinymce.plugins.theme_shortcode', {
		// Initializes the plugin, this will be executed after the plugin has been created.
		init : function(ed, url) {
			
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mcetheme_shortcode', function() {
				ed.windowManager.open({
					file : url + '/popup-post.php',
					width : 475 + ed.getLang('theme_shortcode.delta_width', 0),
					height : 300 + ed.getLang('theme_shortcode.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url // Plugin absolute URL
				});
			});

			// Register example button
			ed.addButton('theme_shortcode', {
				title : 'theme_shortcode.desc',
				cmd : 'mcetheme_shortcode',
				image : url + '/theme-icon.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('theme_shortcode', n.nodeName == 'IMG');
			});
		},

		 // Creates control instances based in the incomming name.
		createControl : function(n, cm) {
			return null;
		},

		//Returns information about the plugin as a name/value array.
		getInfo : function() {
			return {
					longname  : 'theme_shortcode',
					author 	  : 'Parallelus',
					authorurl : 'http://para.llel.us',
					infourl   : 'http://para.llel.us',
					version   : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('theme_shortcode', tinymce.plugins.theme_shortcode);
})();


