jQuery(document).ready(function() {

    jQuery('.rss-tooltip').tooltipster({
        'position': 'top-left'
    });

    // Toggle content for metaboxes
    jQuery('.hndle, .handlediv').click(function() {
        jQuery(this).parent().toggleClass('closed');
        if (jQuery(this).parent().hasClass('closed')) {

        }
    });

    jQuery('.rssap-meta-box-container').hide();


    function loadPreview()
    {
        var url = jQuery('#rssap-load-preview-url').val();
        jQuery('#rssap-preview').show();
        jQuery('#rssap-preview .inside').empty().addClass('loading');
        jQuery.post(url, jQuery('#rssap-add-source-form').serialize(), function(data) {
            jQuery('#rssap-preview .inside').html(data).removeClass('loading');
        });
    }

    jQuery('.feed-preview-btn').click(function() {
        loadPreview();
        return false;
    });

    jQuery('#rssap-add-source-form').submit(function() {
        jQuery.post(
            jQuery(this).attr('action'),
            jQuery(this).serialize(),
            function(data) {
                if (data.status) {
                    window.location = data.redirect_url;
                } else {
                    displayErrors(data.errors);
                }
            },
            'json'
        );
        return false;
    });

    function displayErrors(errors)
    {
        if (!errors) return;
        var offsetTop = 0;
        jQuery.each(errors, function(name, error) {
            var elements = jQuery.find('[name="'+name+'"]');
            if (elements.length) {
                jQuery('[name="'+name+'"]').last().parents('.rssap-field-container').first().append('<p class="rssap-error-notice">'+error+'</p>');
                if (!offsetTop) {
                    offsetTop = jQuery('[name="'+name+'"]').last().parents('.rssap-field-container').first().offset().top;
                }
            }
        });
        if (offsetTop) {
            jQuery(window).scrollTop(offsetTop);
        }
    }

    function clearErrors()
    {
        jQuery('.rssap-error-notice').remove();
    }

    if (jQuery('#rssap-add-source-form').hasClass('edit')) {
        loadPreview();
    }

    jQuery('#content-extractor-btn').fancybox({
        beforeLoad: function() {
            jQuery('#content-extractor-iframe').attr('src', jQuery('#rssap-content-extractor-url').val()+'&feedUrl='+Base64.encode(jQuery('#rssap-url').val()));
            jQuery.fancybox.update();
        },
        'onClosed' : function() {
            jQuery("#content-extractor").hide();
        }
    });

    jQuery('#rssap-enable-scrapper').change(function() {
        if (jQuery(this).is(':checked')) {
            jQuery('.content-extractor-options').show();
        } else {
            jQuery('.content-extractor-options').hide();
        }
    });

    jQuery('#rssap-enable-filters').change(function() {
        if (jQuery(this).is(':checked')) {
            jQuery('.content-filter-options').show();
        } else {
            jQuery('.content-filter-options').hide();
        }
    });

    jQuery('#rssap-enable-scrapper').change();
    jQuery('#rssap-enable-filters').change();
});

function changeExtractorRule(xpath)
{
    jQuery('#content-extractor-rule').val(xpath);
}

function changeExtractorIgnoreRule(xpath)
{
    jQuery('#content-extractor-ignore-rule').val(xpath);
}