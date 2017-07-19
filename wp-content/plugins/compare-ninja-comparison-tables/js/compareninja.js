(function() {
   tinymce.create('tinymce.plugins.compareninja', {
      init : function(ed, url) {
         ed.addButton('compareninja', {
            title : 'Comparison Table',
            image : url + '/compareninja.png',
            onclick : function() {
   				var tableID = prompt("Table ID (from http://compareninja.com)", "");
   				if (tableID != null && tableID != '') {
   					ed.execCommand('mceInsertContent', false, '[compareninja tableid="' + tableID + '"]');
   				}
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Comparison Tables",
            author : 'Common Ninja',
            authorurl : 'http://commoninja.com',
            infourl : 'http://commoninja.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('compareninja', tinymce.plugins.compareninja);
})();