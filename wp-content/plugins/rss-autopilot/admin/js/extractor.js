$(document).ready(function() {
    var allowedTags = 'div, h1, h2, h3, h4, h5, h6, section, table, main, header, img';
    var allowedTagsHover = 'div:hover, h1:hover, h2:hover, h3:hover, h4:hover, h5:hover, h6:hover, section:hover, table:hover, main:hover, header:hover, img:hover';

    $('a').click(function() {
        return false;
    });

    $('form').submit(function() {
        return false;
    });

    function updateIgnoreBlocks()
    {
        var xpath = '';
        jQuery('.rssap-div-ignore').each(function(index, item) {
            xpath += getIgnoreItemXpath(item) + ",\n";
        });

        window.parent.changeExtractorIgnoreRule(xpath);
    }

    function getIgnoreItemXpath(item)
    {
        jQuery(item).addClass('rssap-div-selected');

        var xpath = '';

        // Current element has ID
        if (jQuery(item).attr('id')) {
            xpath = '//'+jQuery(item).prop("tagName").toLowerCase()+'[@id="'+jQuery(item).attr('id')+'"]';
        } else {
            xpath = jQuery(item).prop("tagName").toLowerCase();

            var attrs = '';

            if (jQuery(item).prop("className")) {
                xpath += '[@class="'
                +jQuery(item).prop("className")
                    .replace("rssap-div-selected", "")
                    .replace("rssap-div-ignore", "")
                    .replace("rssap-div-hover", "")
                    .trim()
                +'"]';
            }

            // Add xpath index if needed
            var selector = jQuery(item).prop("tagName").toLowerCase();

            if (jQuery(item).prop("className")) {
                selector += '.'+jQuery(item).prop("className")
                    .replace("rssap-div-selected", "")
                    .replace("rssap-div-ignore", "")
                    .replace("rssap-div-hover", "")
                    .trim();
            }

            if (jQuery(selector, jQuery(item).parent()).length > 1) {
                jQuery(selector, jQuery(item).parent()).each(function(index, child) {
                    if (jQuery(child)[0] === jQuery(item)[0]) {
                        xpath += '['+(index+1)+']';
                        return;
                    }
                });
            }

            var currentElement = jQuery(item).parent();

            while (1) {
                if (!currentElement || jQuery(currentElement).prop('tagName').toLowerCase() == 'body') {
                    break;
                }
                if (jQuery(currentElement).attr('id')) {
                    xpath = jQuery(currentElement).prop("tagName").toLowerCase() + '[@id="'+jQuery(currentElement).attr('id')+'"]' + '/' + xpath;
                    break;
                } else {
                    attrs = '';
                    if (jQuery(currentElement).prop("className")) {
                        attrs = '[@class="'+jQuery(currentElement).prop("className")
                            .replace("rssap-div-selected", "")
                            .replace("rssap-div-ignore", "")
                            .replace("rssap-div-hover", "")
                            .trim()
                            +'"]';
                    }

                    xpath = jQuery(currentElement).prop("tagName").toLowerCase() + attrs +'/'+xpath;
                }
                currentElement = jQuery(currentElement).parent();
            }
            xpath = '//'+xpath;
        }

        return xpath;
    }

    jQuery(allowedTags).mousemove(function() {
        if (jQuery(allowedTagsHover, jQuery(this)).length) {
            jQuery(this).removeClass('rssap-div-hover');
        } else {
            jQuery(this).addClass('rssap-div-hover');
        }
    }).mouseout(function() {
        jQuery(this).removeClass('rssap-div-hover');
    }).click(function() {
        if (!jQuery(allowedTagsHover, jQuery(this)).length) {
            // Check if we are inside selected content block
            if (jQuery(this).parents('.rssap-div-selected').length) {

                // Check if we clicked on the ignorance block
                if (jQuery(this).hasClass('rssap-div-ignore')) {
                    // Unignore
                    jQuery(this).removeClass('rssap-div-ignore');
                    jQuery(allowedTags, jQuery(this)).removeClass('rssap-div-ignore');

                    // Update ignore box
                    updateIgnoreBlocks();
                } else {
                    // Add to ignore
                    jQuery(this).addClass('rssap-div-ignore');

                    // Update ignore box
                    updateIgnoreBlocks();
                }

            } else {
                // If not - select block
                jQuery(allowedTags).removeClass('rssap-div-selected').removeClass('rssap-div-ignore');
                jQuery(this).addClass('rssap-div-selected');

                var xpath = '';

                // Current element has ID
                if (jQuery(this).attr('id')) {
                    xpath = '//'+jQuery(this).prop("tagName").toLowerCase()+'[@id="'+jQuery(this).attr('id')+'"]';
                } else {
                    xpath = jQuery(this).prop("tagName").toLowerCase();

                    var attrs = '';

                    if (jQuery(this).prop("className")) {
                        xpath += '[@class="'
                        +jQuery(this).prop("className")
                            .replace("rssap-div-selected", "")
                            .replace("rssap-div-hover", "")
                            .trim()
                        +'"]';
                    }

                    var currentElement = jQuery(this).parent();

                    while (1) {
                        if (!currentElement || jQuery(currentElement).prop('tagName').toLowerCase() == 'body') {
                            break;
                        }
                        if (jQuery(currentElement).attr('id')) {
                            xpath = jQuery(currentElement).prop("tagName").toLowerCase() + '[@id="'+jQuery(currentElement).attr('id')+'"]' + '/' + xpath;
                            break;
                        } else {
                            attrs = '';
                            if (jQuery(currentElement).prop("className")) {
                                attrs = '[@class="'+jQuery(currentElement).prop("className")+'"]';
                            }

                            xpath = jQuery(currentElement).prop("tagName").toLowerCase() + attrs +'/'+xpath;
                        }
                        currentElement = jQuery(currentElement).parent();
                    }

                    xpath = '//'+xpath;
                }

                // Call parent window function
                window.parent.changeExtractorRule(xpath);

                updateIgnoreBlocks();
            }
        }
    });
});