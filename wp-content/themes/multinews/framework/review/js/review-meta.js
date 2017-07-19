jQuery(document).ready(function($) {
    $('.review_styles_checkboxes').sortable({
        placeholder: "rs-sort-placeholder",
        //handle: ".mgh-handle"
        update: function(event, ui) {
           var neworder =  $(this).sortable('toArray');
            console.log(neworder);
            $('.review_style_order').val(neworder);
        }
    });

/*
                        var all_score = ($('.mom_cr_single_score').length)-1;
                        all_score = all_score*100;
                        var score = 0;
                        $('.mom_cr_single_score').each( function() {
                            score += Number($(this).val());
                        });
                        score = score/all_score*100;
                        score = Math.round(score);
                        $('.reveiw-final-score').val(score);
*/

// Review Criteria
    $('#wpa_loop-review-criterias').sortable({
        placeholder: "rs-sort-criterias",
        handle: ".rsc-sort-handle"
    });
    
});