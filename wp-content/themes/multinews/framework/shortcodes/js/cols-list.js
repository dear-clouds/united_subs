(function() {
    tinymce.PluginManager.add('columns', function( editor, url ) {
        editor.addButton( 'columns', {
            type: 'listbox',
            text: 'Columns',
            id : 'mom_cols_ed',
            icon: false,
            onselect: function(v) {
                //console.log(this.value());
                selected = tinyMCE.activeEditor.selection.getContent();
                var content = '';

                        if(this.value() == 'row'){
                            
                            if( selected ){
                                content =  '[mom_row]'+selected+'[/mom_row]';
                            }else{
                                content =  '[mom_row][/mom_row]';
                            }
                            
                        }

                        if(this.value() == 'one_half'){
                            
                            if( selected ){
                                content =  '[one_half]'+selected+'[/one_half]';
                            }else{
                                content =  '[one_half][/one_half]';
                            }
                            
                        }

                       if(this.value() == 'one_half_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[one_half_last]'+selected+'[/one_half_last]';
                            }else{
                                content =  '[one_half_last][/one_half_last]';
                            }
                            
                        }

                        if(this.value() == 'one_third'){
                            
                            if( selected ){
                                content =  '[one_third]'+selected+'[/one_third]';
                            }else{
                                content =  '[one_third][/one_third]';
                            }
                            
                        }

                       if(this.value() == 'one_third_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[one_third_last]'+selected+'[/one_third_last]';
                            }else{
                                content =  '[one_third_last][/one_third_last]';
                            }
                            
                        }

                        if(this.value() == 'one_fourth'){
                            
                            if( selected ){
                                content =  '[one_fourth]'+selected+'[/one_fourth]';
                            }else{
                                content =  '[one_fourth][/one_fourth]';
                            }
                            
                        }

                       if(this.value() == 'one_fourth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[one_fourth_last]'+selected+'[/one_fourth_last]';
                            }else{
                                content =  '[one_fourth_last][/one_fourth_last]';
                            }
                            
                        }

                        if(this.value() == 'one_fifth'){
                            
                            if( selected ){
                                content =  '[one_fifth]'+selected+'[/one_fifth]';
                            }else{
                                content =  '[one_fifth][/one_fifth]';
                            }
                            
                        }

                       if(this.value() == 'one_fifth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[one_fifth_last]'+selected+'[/one_fifth_last]';
                            }else{
                                content =  '[one_fifth_last][/one_fifth_last]';
                            }
                            
                        }

                        if(this.value() == 'one_sixth'){
                            
                            if( selected ){
                                content =  '[one_sixth]'+selected+'[/one_sixth]';
                            }else{
                                content =  '[one_sixth][/one_sixth]';
                            }
                            
                        }

                       if(this.value() == 'one_sixth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[one_sixth_last]'+selected+'[/one_sixth_last]';
                            }else{
                                content =  '[one_sixth_last][/one_sixth_last]';
                            }
                            
                        }

                        if(this.value() == 'two_third'){
                            
                            if( selected ){
                                content =  '[two_third]'+selected+'[/two_third]';
                            }else{
                                content =  '[two_third][/two_third]';
                            }
                            
                        }

                       if(this.value() == 'two_third_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[two_third_last]'+selected+'[/two_third_last]';
                            }else{
                                content =  '[two_third_last][/two_third_last]';
                            }
                            
                        }

                        if(this.value() == 'two_fourth'){
                            
                            if( selected ){
                                content =  '[two_fourth]'+selected+'[/two_fourth]';
                            }else{
                                content =  '[two_fourth][/two_fourth]';
                            }
                            
                        }

                       if(this.value() == 'two_fourth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[two_fourth_last]'+selected+'[/two_fourth_last]';
                            }else{
                                content =  '[two_fourth_last][/two_fourth_last]';
                            }
                            
                        }

                        if(this.value() == 'two_fifth'){
                            
                            if( selected ){
                                content =  '[two_fifth]'+selected+'[/two_fifth]';
                            }else{
                                content =  '[two_fifth][/two_fifth]';
                            }
                            
                        }

                       if(this.value() == 'two_fifth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[two_fifth_last]'+selected+'[/two_fifth_last]';
                            }else{
                                content =  '[two_fifth_last][/two_fifth_last]';
                            }
                            
                        }

                        if(this.value() == 'two_sixth'){
                            
                            if( selected ){
                                content =  '[two_sixth]'+selected+'[/two_sixth]';
                            }else{
                                content =  '[two_sixth][/two_sixth]';
                            }
                            
                        }

                       if(this.value() == 'two_sixth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[two_sixth_last]'+selected+'[/two_sixth_last]';
                            }else{
                                content =  '[two_sixth_last][/two_sixth_last]';
                            }
                            
                        }

                        if(this.value() == 'three_fourth'){
                            
                            if( selected ){
                                content =  '[three_fourth]'+selected+'[/three_fourth]';
                            }else{
                                content =  '[three_fourth][/three_fourth]';
                            }
                            
                        }

                       if(this.value() == 'three_fourth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[three_fourth_last]'+selected+'[/three_fourth_last]';
                            }else{
                                content =  '[three_fourth_last][/three_fourth_last]';
                            }
                            
                        }

                        if(this.value() == 'three_fifth'){
                            
                            if( selected ){
                                content =  '[three_fifth]'+selected+'[/three_fifth]';
                            }else{
                                content =  '[three_fifth][/three_fifth]';
                            }
                            
                        }

                       if(this.value() == 'three_fifth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[three_fifth_last]'+selected+'[/three_fifth_last]';
                            }else{
                                content =  '[three_fifth_last][/three_fifth_last]';
                            }
                            
                        }

                        if(this.value() == 'three_sixth'){
                            
                            if( selected ){
                                content =  '[three_sixth]'+selected+'[/three_sixth]';
                            }else{
                                content =  '[three_sixth][/three_sixth]';
                            }
                            
                        }

                       if(this.value() == 'three_sixth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[three_sixth_last]'+selected+'[/three_sixth_last]';
                            }else{
                                content =  '[three_sixth_last][/three_sixth_last]';
                            }
                            
                        }

                        if(this.value() == 'four_fifth'){
                            
                            if( selected ){
                                content =  '[four_fifth]'+selected+'[/four_fifth]';
                            }else{
                                content =  '[four_fifth][/four_fifth]';
                            }
                            
                        }

                       if(this.value() == 'four_fifth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[four_fifth_last]'+selected+'[/four_fifth_last]';
                            }else{
                                content =  '[four_fifth_last][/four_fifth_last]';
                            }
                            
                        }

                        if(this.value() == 'four_sixth'){
                            
                            if( selected ){
                                content =  '[four_sixth]'+selected+'[/four_sixth]';
                            }else{
                                content =  '[four_sixth][/four_sixth]';
                            }
                            
                        }

                       if(this.value() == 'four_sixth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[four_sixth_last]'+selected+'[/four_sixth_last]';
                            }else{
                                content =  '[four_sixth_last][/four_sixth_last]';
                            }
                            
                        }

                        if(this.value() == 'five_sixth'){
                            
                            if( selected ){
                                content =  '[five_sixth]'+selected+'[/five_sixth]';
                            }else{
                                content =  '[five_sixth][/five_sixth]';
                            }
                            
                        }

                       if(this.value() == 'five_sixth_last'){
                            
                            if( selected ){
                                //If text is selected when button is clicked
                                //Wrap shortcode around it.
                                content =  '[five_sixth_last]'+selected+'[/five_sixth_last]';
                            }else{
                                content =  '[five_sixth_last][/five_sixth_last]';
                            }
                        }
                        editor.insertContent(content);

            },
            values: [
            {text: 'Row', value: 'row'},

            {text: 'one_half', value: 'one_half'},
            {text: 'one_half_last', value: 'one_half_last'},

            {text: 'one_third', value: 'one_third'},
            {text: 'one_third_last', value: 'one_third_last'},

            {text: 'one_fourth', value: 'one_fourth'},
            {text: 'one_fourth_last', value: 'one_fourth_last'},
            
            {text: 'one_fifth', value: 'one_fifth'},
            {text: 'one_fifth_last', value: 'one_fifth_last'},
            
            {text: 'one_sixth', value: 'one_sixth'},
            {text: 'one_sixth_last', value: 'one_sixth_last'},
            
            {text: 'two_third', value: 'two_third'},
            {text: 'two_third_last', value: 'two_third_last'},
            
            {text: 'two_fourth', value: 'two_fourth'},
            {text: 'two_fourth_last', value: 'two_fourth_last'},

            {text: 'two_fifth', value: 'two_fifth'},
            {text: 'two_fifth_last', value: 'two_fifth_last'},

            {text: 'two_sixth', value: 'two_sixth'},
            {text: 'two_sixth_last', value: 'two_sixth_last'},

            {text: 'three_fourth', value: 'three_fourth'},
            {text: 'three_fourth_last', value: 'three_fourth_last'},

            {text: 'three_fifth', value: 'three_fifth'},
            {text: 'three_fifth_last', value: 'three_fifth_last'},

            {text: 'three_sixth', value: 'three_sixth'},
            {text: 'three_sixth_last', value: 'three_sixth_last'},
            
            {text: 'four_fifth', value: 'four_fifth'},
            {text: 'four_fifth_last', value: 'four_fifth_last'},

            {text: 'four_sixth', value: 'four_sixth'},
            {text: 'four_sixth_last', value: 'four_sixth_last'},

            {text: 'five_sixth', value: 'five_sixth'},
            {text: 'five_sixth_last', value: 'five_sixth_last'},

            
            ]
        });
    });
})();