<div class="search-box">
    <form role="search" method="get" class="search-form mom-search-form" action="<?php echo home_url();?>">
            <input type="search" class="search-field sf" value="<?php _e('Search', 'framework'); ?>" name="s" title="<?php _e('Search for:', 'framework') ?>" onfocus="if(this.value=='<?php _e('Search', 'framework') ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e('Search', 'framework') ?>';">
    <button type="submit" class="search-submit" value="Search"></button>
    <?php if(defined('ICL_LANGUAGE_CODE')) { ?><input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/><?php } ?>
    </form>
</div>