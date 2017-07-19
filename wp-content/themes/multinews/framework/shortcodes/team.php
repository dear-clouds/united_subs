<?php
function mom_team($atts, $content) {
	extract(shortcode_atts(array(
		'style'=>'',
		'image'=>'',
		'name'=>'',
		'title'=>'',
		'desc'=>'',
		'column'=>'',
		'twitter'=>'',
		'facebook'=>'',
		'google'=>'',
		'linkedin'=>'',
		'youtube'=>'',
		'vimeo'=>'',
		'digg'=>'',
		'flickr'=>'',
		'picasa'=>'',
		'skype'=>'',
		'tumblr'=>''
		
		), $atts));
		ob_start();
	?>
	<?php
	if ($column == 2) {
		$class ="one_half";
	} elseif ($column == 3) {
		$class ="one_third";
	} elseif ($column == 4) {
		$class ="one_fourth";
	} elseif ($column == 5) {
		$class ="team_fifth";
	}
if ($style == 'plain') {
	$style = $style."_team_member";
} else {
	$style = '';
}

	?>
            <div class="team_member team_member<?php echo $column; ?> <?php echo $class; ?> <?php echo $style; ?>">
                <div class="member_img">
                    <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
                </div>
                <div class="member_info">
                    <h3 class="mname"><?php echo $name; ?></h3>
                    <h4 class="mtitle"><?php echo $title; ?></h4>
                    <p><?php echo $desc; ?></p>
                </div>
                <div class="member_social">
                    <ul>
			<?php if ($twitter != '') { ?>
				<li class="twitter"><a href="<?php echo $twitter; ?>"></a></li>
			<?php } ?>
			<?php if ($facebook != '') { ?>
				<li class="facebook"><a href="<?php echo $facebook; ?>"></a></li>
			<?php } ?>
			<?php if ($google != '') { ?>
				<li class="google"><a href="<?php echo $google; ?>"></a></li>
			<?php } ?>
			<?php if ($skype != '') { ?>
				<li class="skype"><a href="<?php echo $skype; ?>"></a></li>
			<?php } ?>
			<?php if ($linkedin != '') { ?>
				<li class="linkedin"><a href="<?php echo $linkedin; ?>"></a></li>
			<?php } ?>
			<?php if ($youtube != '') { ?>
				<li class="youtube"><a href="<?php echo $youtube; ?>"></a></li>
			<?php } ?>
			<?php if ($vimeo != '') { ?>
				<li class="vimeo"><a href="<?php echo $vimeo; ?>"></a></li>
			<?php } ?>
			<?php if ($digg != '') { ?>
				<li class="digg"><a href="<?php echo $digg; ?>"></a></li>
			<?php } ?>
			<?php if ($flickr != '') { ?>
				<li class="flickr"><a href="<?php echo $flickr; ?>"></a></li>
			<?php } ?>
			<?php if ($picasa != '') { ?>
				<li class="picasa"><a href="<?php echo $picasa; ?>"></a></li>
			<?php } ?>
			<?php if ($tumblr != '') { ?>
				<li class="tumblr"><a href="<?php echo $tumblr; ?>"></a></li>
			<?php } ?>
                    </ul>
                </div>
            </div> <!--Team Member-->

<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;

}

add_shortcode('team', 'mom_team');
