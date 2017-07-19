<?php
$maxwidth = !empty( $_POST['maxwidth'] ) && $_POST['maxwidth'] != 'auto' ? (int)$_POST['maxwidth'] : 700;
$user_id = get_current_user_id();
?>
<div class="gwa-popup" data-help="<?php echo esc_attr( isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) ? $_COOKIE['go_pricing']['settings']['help'][$user_id] : '' ); ?>">
	<div class="gwa-popup-inner"<?php echo !empty( $_POST['maxwidth'] ) && $_POST['maxwidth'] != 'auto' ? sprintf( ' style="width:%dpx;"', (int)$_POST['maxwidth'] ) : ''; ?>>
		<div class="gwa-popup-header">
			<div class="gwa-popup-header-icon-code"></div>
			<div class="gwa-popup-title"><?php _e( 'Shortcode Editor', 'go_pricing_textdomain' ); ?><small><?php _e( 'Insert Custom Shortcode', 'go_pricing_textdomain'); ?></small></div>
			<a href="#" title="<?php _e( 'Close', 'go_pricing_textdomain' ); ?>" class="gwa-popup-close"></a>
		</div>
		<div class="gwa-popup-content-wrap">
			<div class="gwa-popup-content">	
				<div class="gwa-abox">
					<div class="gwa-abox-content-wrap">
						<div class="gwa-abox-content">
							<table class="gwa-table">
								<tr>
									<th><label><?php _e( 'Shortcode', 'go_pricing_textdomain' ); ?></label></th>
									<td>
										<select name="shortcode">                                
											<option value="image"><?php _e( 'Image', 'go_pricing_textdomain' ); ?></option>
											<optgroup label="<?php esc_attr_e( 'Video', 'go_pricing_textdomain' ); ?>"></optgroup>
											<option value="youtube"><?php _e( 'Youtube Video', 'go_pricing_textdomain' ); ?></option>
											<option value="vimeo"><?php _e( 'Vimeo Video', 'go_pricing_textdomain' ); ?></option>
											<option value="screenr"><?php _e( 'Screenr Video', 'go_pricing_textdomain' ); ?></option>
											<option value="dailymotion"><?php _e( 'Dailymotion Video', 'go_pricing_textdomain' ); ?></option>
											<option value="metacafe"><?php _e( 'Metacafe Video', 'go_pricing_textdomain' ); ?></option>
											<option value="html5_video"><?php _e( 'HTML5 Video', 'go_pricing_textdomain' ); ?></option>
											<optgroup label="<?php esc_attr_e( 'Audio', 'go_pricing_textdomain' ); ?>"></optgroup>
											<option value="soundcloud"><?php _e( 'Soundcloud Audio', 'go_pricing_textdomain' ); ?></option>
											<option value="mixcloud"><?php _e( 'Mixcloud Audio', 'go_pricing_textdomain' ); ?></option>
											<option value="beatport"><?php _e( 'Beatport Audio', 'go_pricing_textdomain' ); ?></option>
											<option value="audio"><?php _e( 'HTML5 Audio', 'go_pricing_textdomain' ); ?></option>
											<optgroup label="<?php esc_attr_e( 'Other', 'go_pricing_textdomain' ); ?>"></optgroup>
											<option value="map"><?php _e( 'Google Map', 'go_pricing_textdomain' ); ?></option>
											<option value="iframe"><?php _e( 'Custom Iframe', 'go_pricing_textdomain' ); ?></option>
			                            </select>
									</td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Type of the shortcode to edit.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
							</table>
							<div class="gwa-table-separator"></div>	
							<table class="gwa-table" data-id="sc-fields" data-shortcode="<img{atts}>" data-parent-id="shortcode" data-parent-value="image">							
								<tr>
									<th><label><?php _e( 'Image', 'go_pricing_textdomain' ); ?></label></th>
									<td>
										<div class="gwa-img-upload">
											<div class="gwa-img-upload-media" style="display:none;">
												<a href="#" title="<?php esc_attr_e( 'Remove', 'go_pricing_textdomain' ); ?>" class="gwa-img-upload-media-remove"></a>
												<p><label><span class="gwa-checkbox gwa-checked" tabindex="0"><span></span><input type="checkbox" name="img-responsive" data-attr="class" tabindex="-1" value="gw-go-responsive-img" checked="checked"></span><?php _e( 'Responsive image?', 'go_pricing_textdomain' ); ?></label></p>
											</div>
											<input type="hidden" name="img-alt" data-attr="alt" value="">
											<input type="hidden" name="img-width" data-attr="width" value="">
											<input type="hidden" name="img-height" data-attr="height" value="">																					
											<div class="gwa-input-btn"><input type="text" name="img-src" data-attr="src" value=""><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="img-upload"><span class="gwa-icon-add"></span></a></div>
										</div>															
									</td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Enter an URL or select an image from the Media Library.', 'go_pricing_textdomain' ); ?></p></td>
								</tr>																							
							</table>
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_youtube{atts}]" data-parent-id="shortcode" data-parent-value="youtube">
								<tr>
									<th><label><?php _e( 'Video ID', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="yt-id" data-attr="video_id"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'ID of the video.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Height', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
									<td><input type="text" name="yt-height" data-attr="height" data-type="int"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Height of the video in pixels (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Autoplay?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="yt-autoplay" data-attr="autoplay" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play the video automatically (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
							</table>
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_vimeo{atts}]" data-parent-id="shortcode" data-parent-value="vimeo">
								<tr>
									<th><label><?php _e( 'Video ID', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="vimeo-id" data-attr="video_id"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'ID of the video.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Height', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
									<td><input type="text" name="vimeo-height" data-attr="height" data-type="int"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Height of the video in pixels (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Player Color', 'go_pricing_textdomain' ); ?></label></th>
									<td><label><div class="gwa-colorpicker gwa-colorpicker-inline" tabindex="0"><input type="hidden" name="vimeo-color" data-attr="color" data-type="alphanum" data-type-override="false"><span class="gwa-cp-picker"><span></span></span><span class="gwa-cp-label">&nbsp;</span><div class="gwa-cp-popup"><div class="gwa-cp-popup-inner"></div><div class="gwa-input-btn"><input type="text" tabindex="-1" value="<?php echo esc_attr( !empty( $col_data['main-color'] ) ? $col_data['main-color'] : '' ); ?>"><a href="#" tabindex="-1" data-action="cp-fav" title="<?php _e( 'Add To Favourites', 'go_pricing_textdomain' ); ?>"><i class="fa fa-heart"></i></a></div></div></label></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Color of the player (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>								
								<tr>
									<th><label><?php _e( 'Autoplay?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="vimeo-autoplay" data-attr="autoplay" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play the video automatically (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>								
							</table>
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_screenr{atts}]" data-parent-id="shortcode" data-parent-value="screenr">
								<tr>
									<th><label><?php _e( 'Video ID', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="screenr-id" data-attr="video_id"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'ID of the video.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Height', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
									<td><input type="text" name="screenr-height" data-attr="height" data-type="int"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Height of the video in pixels (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
							</table>
							
							<!-- Dailymotion -->
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_dailymotion{atts}]" data-parent-id="shortcode" data-parent-value="dailymotion">
								<tr>
									<th><label><?php _e( 'Video ID', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="dailymotion-id" data-attr="video_id"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'ID of the video.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Height', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
									<td><input type="text" name="dailymotion-height" data-attr="height" data-type="int"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Height of the video in pixels (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Autoplay?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="dailymotion-autoplay" data-attr="autoplay" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play the video automatically (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>								
							</table>
							<!-- /Dailymotion -->
							
							<!-- Metacafe -->
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_metacafe{atts}]" data-parent-id="shortcode" data-parent-value="metacafe">
								<tr>
									<th><label><?php _e( 'Video ID', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="metacafe-id" data-attr="video_id"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'ID of the video.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Height', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
									<td><input type="text" name="metacafe-height" data-attr="height" data-type="int"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Height of the video in pixels (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Autoplay?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="metacafe-autoplay" data-attr="autoplay" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play the video automatically (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>								
							</table>
							<!-- /Metacafe -->
							
							<!-- HTML5 Video -->
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_html5_video{atts}]" data-parent-id="shortcode" data-parent-value="html5_video">
								<tr>
									<th><label><?php _e( 'MP4 Source', 'go_pricing_textdomain' ); ?></label></th>
									<td><div class="gwa-input-btn"><input type="text" name="html5-video-mp4" data-attr="mp4_src" value=""><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="file-upload" data-file-type="video"><span class="gwa-icon-add"></span></a></div></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'MP4 source for Safari, IE9+, iPhone, iPad, Android, and WP7.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'WebM Source', 'go_pricing_textdomain' ); ?></th>
									<td><div class="gwa-input-btn"><input type="text" name="html5-video-webm" data-attr="webm_src" value=""><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="file-upload" data-file-type="video"><span class="gwa-icon-add"></span></a></div></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'WebM/VP8 file for Firefox4, Opera, and Chrome (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'OGG Source', 'go_pricing_textdomain' ); ?></label></th>
									<td><div class="gwa-input-btn"><input type="text" name="html5-video-ogg" data-attr="ogg_src" value=""><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="file-upload" data-file-type="video"><span class="gwa-icon-add"></span></a></div></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Ogg/Vorbis for older Firefox and Opera versions (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>																
								<tr>
									<th><label><?php _e( 'Poster Image URL', 'go_pricing_textdomain' ); ?></label></th>
									<td>					
										<div class="gwa-img-upload">
											<div class="gwa-img-upload-media">
												<a href="#" title="<?php esc_attr_e( 'Remove', 'go_pricing_textdomain' ); ?>" class="gwa-img-upload-media-remove"></a>		
											</div>
											<div class="gwa-input-btn"><input type="text" name="html5-video-poster" data-attr="poster_src" value=""><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="img-upload"><span class="gwa-icon-add"></span></a></div>
										</div>	
									</td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'URL of the poster image (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>									
								<tr>
									<th><label><?php _e( 'Autoplay?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="html5-video-autoplay" data-attr="autoplay" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play the video automatically (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Loop?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="html5-video-loop" data-attr="loop" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play the video infinitely (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>																
							</table>
							<!-- /HTML5 Video -->
							
							<!-- Soundcloud Audio -->
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_soundcloud{atts}]" data-parent-id="shortcode" data-parent-value="soundcloud">
								<tr>
									<th><label><?php _e( 'Track ID', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="soundcloud-id" data-attr="track_id"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'ID of the audio track.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Height', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
									<td><input type="text" name="soundcloud-height" data-attr="height" data-type="int"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Height of the audio in pixels (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Autoplay?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="soundcloud-autoplay" data-attr="autoplay" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play the audio track automatically (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>								
							</table>
							<!-- /Soundcloud Audio -->
							
							<!-- Mixcloud Audio -->
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_mixcloud{atts}]" data-parent-id="shortcode" data-parent-value="mixcloud">
								<tr>
									<th><label><?php _e( 'Track URL', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="mixcloud-id" data-attr="track_url"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'ID of the audio track.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Height', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
									<td><input type="text" name="mixcloud-height" data-attr="height" data-type="int"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Height of the audio in pixels (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>								
							</table>
							<!-- /Mixcloud Audio -->
							
							<!-- Beatport Audio -->
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_beatport{atts}]" data-parent-id="shortcode" data-parent-value="beatport">
								<tr>
									<th><label><?php _e( 'Track ID', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="beatport-id" data-attr="track_id"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'ID of the audio track.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Height', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
									<td><input type="text" name="beatport-height" data-attr="height" data-type="int"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Height of the audio in pixels (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Autoplay?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="beatport-autoplay" data-attr="autoplay" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play the audio track automatically (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>								
							</table>
							<!-- /Beatport Audio -->
							
							<!-- Google Map -->
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_map{atts}]" data-parent-id="shortcode" data-parent-value="map">
								<tr>
									<th><label><?php _e( 'Address', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="map-address" data-attr="address"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Address to be shown on map e.g. "New York, USA".', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Height', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
									<td><input type="text" name="map-height" data-attr="height" data-type="int"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Height of the iframe in pixels.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Zoom Level', 'go_pricing_textdomain' ); ?></label></th>
									<td>
										<select name="map-zoom" data-attr="zoom" data-type="int">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14" selected="selected">14</option>
											<option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
										</select>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Zoom level of the map (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr class="gwa-row-separator"></tr>																	
								<tr class="gwa-row-fullwidth">
									<th><label><?php _e( 'Marker Icon', 'go_pricing_textdomain' ); ?></label></th>
									<td>
									<div class="gwa-icon-picker">
										<div class="gwa-icon-picker-header">
											<div class="gwa-icon-picker-selected gwa-clearfix">
												<a href="#" class="gwa-icon-picker-icon" tabindex="-1" data-action="ip-bg-switch"></a>
												<input type="hidden" name="map-marker" data-attr="icon">
											</div>
										</div>
										<div class="gwa-icon-picker-content gwa-clearfix">
											<a href="#" class="gwa-icon-picker-icon gwa-current" data-action="ip-select-blank" tabindex="0" title="<?php esc_attr_e( 'None', 'go_pricing_textdomain' ); ?>"><i class="fa fa-ban"></i></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-id="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_1.png' ); ?>"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_1.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_1b.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_1c.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_2.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_2b.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_2c.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_3.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_3b.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_3c.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_4.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_4b.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_4c.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_5.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_5b.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_5c.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_6.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_6b.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_6c.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_7.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_7b.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_clean_7c.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_classic_1.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_classic_2.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_classic_3.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_classic_4.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_classic_5.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_classic_6.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_classic_7.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/pins/pin_classic_8.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select-custom" tabindex="0" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>"><i class="fa fa-plus-circle"></i></a>											
										</div>
									</div>		
									</td>
								</tr>
								<tr style="display:none;">
									<th><label><?php _e( 'Custom Icon', 'go_pricing_textdomain' ); ?></label></th>
									<td>					
										<div class="gwa-img-upload">
											<div class="gwa-img-upload-media">
												<a href="#" title="<?php esc_attr_e( 'Remove', 'go_pricing_textdomain' ); ?>" class="gwa-img-upload-media-remove"></a>		
											</div>
											<div class="gwa-input-btn"><input type="text" name="map-custom-marker" data-attr="map-icon"><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="img-upload"><span class="gwa-icon-add"></span></a></div>
										</div>	
									</td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Address marker icon.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr class="gwa-row-separator"></tr>
								<tr>
									<th><label><?php _e( 'Marker Title', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="map-title" data-attr="title"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Title attribute for marker on map (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>															
								<tr>
									<th><label><?php _e( 'Info Window Content', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="map-iw-content" data-attr="content"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Content of the info window/popup (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>															
								<tr>
									<th><label><?php _e( 'Info Window by Default?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="map-iw-show" data-attr="popup" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to show info then info window on page load (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
							</table>
							<!-- /Google Map -->
							
							<!-- Iframe -->
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_audio{atts}]" data-parent-id="shortcode" data-parent-value="audio">
								<tr>
									<th><label><?php _e( 'MP3 Source', 'go_pricing_textdomain' ); ?></label></th>
									<td><div class="gwa-input-btn"><input type="text" name="html5-audio-mp4" data-attr="mp3_src" value=""><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="file-upload" data-file-type="audio"><span class="gwa-icon-add"></span></a></div></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'MP3 source.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'OGG Source', 'go_pricing_textdomain' ); ?></label></th>
									<td><div class="gwa-input-btn"><input type="text" name="html5-audio-ogg" data-attr="ogg_src" value=""><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="file-upload" data-file-type="audio"><span class="gwa-icon-add"></span></a></div></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Ogg source (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>								
								<tr>
									<th><label><?php _e( 'WAV Source', 'go_pricing_textdomain' ); ?></th>
									<td><div class="gwa-input-btn"><input type="text" name="html5-audio-webm" data-attr="wav_src" value=""><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="file-upload" data-file-type="audio"><span class="gwa-icon-add"></span></a></div></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Wav source (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>																								
								<tr>
									<th><label><?php _e( 'Autoplay?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="html5-audio-autoplay" data-attr="autoplay" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play the audio track automatically (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Loop?', 'go_pricing_textdomain' ); ?></label></th>
									<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="html5-audio-loop" data-attr="loop" tabindex="-1" value="yes"></span></label></p></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play the audio track infinitely (optional).', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>																
							</table>
							<!-- /Iframe -->	

							<!-- Iframe -->
							<table class="gwa-table" data-id="sc-fields" data-shortcode="[go_pricing_iframe{atts}]" data-parent-id="shortcode" data-parent-value="iframe">
								<tr>
									<th><label><?php _e( 'URL', 'go_pricing_textdomain' ); ?></label></th>
									<td><input type="text" name="iframe-url" data-attr="url"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'URL of the iframe.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
								<tr>
									<th><label><?php _e( 'Height', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
									<td><input type="text" name="iframe-height" data-attr="height" data-type="int"></td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Height of the iframe in pixels.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
															
							</table>
							<!-- /Iframe -->																					
						</div>
					 </div>
				</div>
			</div>
		</div>
		<div class="gwa-popup-footer">
			<div class="gwa-popup-assets gwa-fl">
				<a href="#" data-action="insert-sc" title="<?php esc_attr_e( 'Insert Shortcode', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1"><?php esc_attr_e( 'Insert Shortcode', 'go_pricing_textdomain' ); ?></a>
			</div>
		</div>		
	</div>	
</div>