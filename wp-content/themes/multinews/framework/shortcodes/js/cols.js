(function() {

    tinymce.create('tinymce.plugins.momcols', {

        init : function(ed, url) {
        },
        createControl : function(n, cm) {

            if(n=='momcols'){
                var mlb = cm.createListBox('momcols', {
                     title : 'Columns',
                     onselect : function(v) {


                        if(v == 'one_half'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[one_half]'+selected+'[/one_half]';
                            }else{
                                content =  '[one_half][/one_half]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'one_half_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[one_half_last]'+selected+'[/one_half_last]';
                            }else{
                                content =  '[one_half_last][/one_half_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'one_third'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[one_third]'+selected+'[/one_third]';
                            }else{
                                content =  '[one_third][/one_third]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'one_third_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[one_third_last]'+selected+'[/one_third_last]';
                            }else{
                                content =  '[one_third_last][/one_third_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'one_fourth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[one_fourth]'+selected+'[/one_fourth]';
                            }else{
                                content =  '[one_fourth][/one_fourth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'one_fourth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[one_fourth_last]'+selected+'[/one_fourth_last]';
                            }else{
                                content =  '[one_fourth_last][/one_fourth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'one_fifth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[one_fifth]'+selected+'[/one_fifth]';
                            }else{
                                content =  '[one_fifth][/one_fifth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'one_fifth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[one_fifth_last]'+selected+'[/one_fifth_last]';
                            }else{
                                content =  '[one_fifth_last][/one_fifth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'one_sixth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[one_sixth]'+selected+'[/one_sixth]';
                            }else{
                                content =  '[one_sixth][/one_sixth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'one_sixth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[one_sixth_last]'+selected+'[/one_sixth_last]';
                            }else{
                                content =  '[one_sixth_last][/one_sixth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'two_third'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[two_third]'+selected+'[/two_third]';
                            }else{
                                content =  '[two_third][/two_third]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'two_third_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[two_third_last]'+selected+'[/two_third_last]';
                            }else{
                                content =  '[two_third_last][/two_third_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'two_fourth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[two_fourth]'+selected+'[/two_fourth]';
                            }else{
                                content =  '[two_fourth][/two_fourth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'two_fourth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[two_fourth_last]'+selected+'[/two_fourth_last]';
                            }else{
                                content =  '[two_fourth_last][/two_fourth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'two_fifth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[two_fifth]'+selected+'[/two_fifth]';
                            }else{
                                content =  '[two_fifth][/two_fifth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'two_fifth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[two_fifth_last]'+selected+'[/two_fifth_last]';
                            }else{
                                content =  '[two_fifth_last][/two_fifth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'two_sixth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[two_sixth]'+selected+'[/two_sixth]';
                            }else{
                                content =  '[two_sixth][/two_sixth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'two_sixth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[two_sixth_last]'+selected+'[/two_sixth_last]';
                            }else{
                                content =  '[two_sixth_last][/two_sixth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'three_fourth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[three_fourth]'+selected+'[/three_fourth]';
                            }else{
                                content =  '[three_fourth][/three_fourth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'three_fourth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[three_fourth_last]'+selected+'[/three_fourth_last]';
                            }else{
                                content =  '[three_fourth_last][/three_fourth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'three_fifth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[three_fifth]'+selected+'[/three_fifth]';
                            }else{
                                content =  '[three_fifth][/three_fifth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'three_fifth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[three_fifth_last]'+selected+'[/three_fifth_last]';
                            }else{
                                content =  '[three_fifth_last][/three_fifth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'three_sixth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[three_sixth]'+selected+'[/three_sixth]';
                            }else{
                                content =  '[three_sixth][/three_sixth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'three_sixth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[three_sixth_last]'+selected+'[/three_sixth_last]';
                            }else{
                                content =  '[three_sixth_last][/three_sixth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'four_fifth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[four_fifth]'+selected+'[/four_fifth]';
                            }else{
                                content =  '[four_fifth][/four_fifth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'four_fifth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[four_fifth_last]'+selected+'[/four_fifth_last]';
                            }else{
                                content =  '[four_fifth_last][/four_fifth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'four_sixth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[four_sixth]'+selected+'[/four_sixth]';
                            }else{
                                content =  '[four_sixth][/four_sixth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'four_sixth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[four_sixth_last]'+selected+'[/four_sixth_last]';
                            }else{
                                content =  '[four_sixth_last][/four_sixth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                        if(v == 'five_sixth'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                content =  '[five_sixth]'+selected+'[/five_sixth]';
                            }else{
                                content =  '[five_sixth][/five_sixth]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }

                       if(v == 'five_sixth_last'){
                            selected = tinyMCE.activeEditor.selection.getContent();
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[five_sixth_last]'+selected+'[/five_sixth_last]';
                            }else{
                                content =  '[five_sixth_last][/five_sixth_last]';
                            }
                            tinymce.execCommand('mceInsertContent', false, content);
                        }


                     }
                });

                // Add some menu items
                var mom_columns = [
                                   'one_half','one_half_last',
                                   'one_third','one_third_last',
                                   'one_fourth','one_fourth_last',
                                   'one_fifth','one_fifth_last',
                                   'one_sixth','one_sixth_last',
                                   'two_third','two_third_last',
                                   'two_fourth','two_fourth_last',
                                   'two_fifth','two_fifth_last',
                                   'two_sixth','two_sixth_last',
                                   'three_fourth','three_fourth_last',
                                   'three_fifth','three_fifth_last',
                                   'three_sixth','three_sixth_last',
                                   'four_fifth','four_fifth_last',
                                   'four_sixth','four_sixth_last',
                                   'five_sixth','five_sixth_last',
                                   ];

                for(var i in mom_columns)
                    mlb.add(mom_columns[i],mom_columns[i]);

                return mlb;
            }
            return null;
        }


    });
    tinymce.PluginManager.add('momcols', tinymce.plugins.momcols);
})();