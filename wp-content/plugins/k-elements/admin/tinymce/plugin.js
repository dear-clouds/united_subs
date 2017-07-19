(function ()
{
	
	if ( parseInt(window.tinyMCE.majorVersion) > 3) {
		
		tinymce.PluginManager.add('kleoShortcodes', function(editor, url) {

			editor.addButton( 'kleo_button', function() {

				var myShortcodes = KleoShortcodes.shortcodes;
				var currentCat = "";
				var data = {
						title: 'Visual Shortcodes',
						'text': 'KLEO',
						type: 'menubutton',
						menu: []
				};

				for (var key in myShortcodes) {
					if (myShortcodes.hasOwnProperty(key)) {

						currentCat = key;
						if(key == '') {
							currentCat = "Content elements";
						}
						
						currentCat = currentCat.charAt(0).toUpperCase() + currentCat.slice(1);

						var firstLevel = {
								text: currentCat,
								value: '',
								menu: []
						};

						for (var subkey in myShortcodes[key]) {
							if (myShortcodes[key].hasOwnProperty(subkey)) {
								var secondLevel = {
										text: myShortcodes[key][subkey]['name'],
										value: myShortcodes[key][subkey]['code'],
										onclick: function(e) {
											e.stopPropagation();
												editor.insertContent(this.value());
										}       
								};

								firstLevel.menu.push(secondLevel);
							};
						}

						data.menu.push(firstLevel);
					}
				}
				return data;

			});

		});
	
	}
	else {
		
		// create kleoShortcodes plugin
		tinymce.create("tinymce.plugins.kleoShortcodes",
		{
			init: function ( ed, url )
			{
				ed.addCommand("kleoPopup", function ( a, params )
				{
					var popup = params.identifier;

					// load thickbox
					tb_show("Insert Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
				});
			},
			createControl: function ( btn, e )
			{
				if ( btn == "kleo_button" )
				{
					var a = this;

					var btn = e.createSplitButton('kleo_button', {
						title: "Insert Shortcode",
						image: KleoShortcodes.plugin_folder +"/tinymce/images/icon.png",
						icons: false
					});

					btn.onRenderMenu.add(function (c, b)
					{
						var myShortcodes = KleoShortcodes.shortcodes;

						var currentCat = "";
						c=b.addMenu({title: "Content elements"});

						for (var key in myShortcodes) {
							if (myShortcodes.hasOwnProperty(key)) {

								if(key != '' && key != currentCat) {
									currentCat = key;
									c=b.addMenu({title: currentCat.charAt(0).toUpperCase() + currentCat.slice(1)});
								}

								for (var subkey in myShortcodes[key]) {
									if (myShortcodes[key].hasOwnProperty(subkey)) {
										a.addImmediate(c, myShortcodes[key][subkey]['name'], myShortcodes[key][subkey]['code'] );
									}
								}
							}
						}

					});

					return btn;
				}

				return null;
			},
			addWithPopup: function ( ed, title, id ) {
				ed.add({
					title: title,
					onclick: function () {
						tinyMCE.activeEditor.execCommand("kleoPopup", false, {
							title: title,
							identifier: id
						})
					}
				})
			},
			addImmediate: function ( ed, title, sc) {
				ed.add({
					title: title,
					onclick: function () {
						tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
					}
				})
			}
		});

		// add kleoShortcodes plugin
		tinymce.PluginManager.add("kleoShortcodes", tinymce.plugins.kleoShortcodes);
		
	}
	
})();