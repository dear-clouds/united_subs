<?php
/**
 * Class for managing plugin data
 */
class mom_su_Data {

	/**
	 * Constructor
	 */
	function __construct() {}

	/**
	 * Shortcode groups
	 */
	public static function groups() {
		return apply_filters( 'mom_su/data/groups', array(
				'all'     => __( 'All', 'theme' ),
				'content' => __( 'Content', 'theme' ),
				'box'     => __( 'Box', 'theme' ),
				'media'   => __( 'Media', 'theme' ),
				'gallery' => __( 'Gallery', 'theme' ),
				'data'    => __( 'Data', 'theme' ),
				'other'   => __( 'Other', 'theme' )
			) );
	}

	/**
	 * Border styles
	 */
	public static function borders() {
		return apply_filters( 'mom_su/data/borders', array(
				'none'   => __( 'None', 'theme' ),
				'solid'  => __( 'Solid', 'theme' ),
				'dotted' => __( 'Dotted', 'theme' ),
				'dashed' => __( 'Dashed', 'theme' ),
				'double' => __( 'Double', 'theme' ),
				'groove' => __( 'Groove', 'theme' ),
				'ridge'  => __( 'Ridge', 'theme' )
			) );
	}

	/**
	 * Font-Awesome icons
	 */
	public static function icons() {
		return apply_filters( 'mom_su/data/icons', array( 'adjust', 'adn', 'align-center', 'align-justify', 'align-left', 'align-right', 'ambulance', 'anchor', 'android', 'angle-double-down', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'apple', 'archive', 'arrow-circle-down', 'arrow-circle-left', 'arrow-circle-o-down', 'arrow-circle-o-left', 'arrow-circle-o-right', 'arrow-circle-o-up', 'arrow-circle-right', 'arrow-circle-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'arrows', 'arrows-alt', 'arrows-h', 'arrows-v', 'asterisk', 'automobile', 'backward', 'ban', 'bank', 'bar-chart-o', 'barcode', 'bars', 'beer', 'behance', 'behance-square', 'bell', 'bell-o', 'bitbucket', 'bitbucket-square', 'bitcoin', 'bold', 'bolt', 'bomb', 'book', 'bookmark', 'bookmark-o', 'briefcase', 'btc', 'bug', 'building', 'building-o', 'bullhorn', 'bullseye', 'cab', 'calendar', 'calendar-o', 'camera', 'camera-retro', 'car', 'caret-down', 'caret-left', 'caret-right', 'caret-square-o-down', 'caret-square-o-left', 'caret-square-o-right', 'caret-square-o-up', 'caret-up', 'certificate', 'chain', 'chain-broken', 'check', 'check-circle', 'check-circle-o', 'check-square', 'check-square-o', 'chevron-circle-down', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'child', 'circle', 'circle-o', 'circle-o-notch', 'circle-thin', 'clipboard', 'clock-o', 'cloud', 'cloud-download', 'cloud-upload', 'cny', 'code', 'code-fork', 'codepen', 'coffee', 'cog', 'cogs', 'columns', 'comment', 'comment-o', 'comments', 'comments-o', 'compass', 'compress', 'copy', 'credit-card', 'crop', 'crosshairs', 'css3', 'cube', 'cubes', 'cut', 'cutlery', 'dashboard', 'database', 'dedent', 'delicious', 'desktop', 'deviantart', 'digg', 'dollar', 'dot-circle-o', 'download', 'dribbble', 'dropbox', 'drupal', 'edit', 'eject', 'ellipsis-h', 'ellipsis-v', 'empire', 'envelope', 'envelope-o', 'envelope-square', 'eraser', 'eur', 'euro', 'exchange', 'exclamation', 'exclamation-circle', 'exclamation-triangle', 'expand', 'external-link', 'external-link-square', 'eye', 'eye-slash', 'facebook', 'facebook-square', 'fast-backward', 'fast-forward', 'fax', 'female', 'fighter-jet', 'file', 'file-archive-o', 'file-audio-o', 'file-code-o', 'file-excel-o', 'file-image-o', 'file-movie-o', 'file-o', 'file-pdf-o', 'file-photo-o', 'file-picture-o', 'file-powerpoint-o', 'file-sound-o', 'file-text', 'file-text-o', 'file-video-o', 'file-word-o', 'file-zip-o', 'files-o', 'film', 'filter', 'fire', 'fire-extinguisher', 'flag', 'flag-checkered', 'flag-o', 'flash', 'flask', 'flickr', 'floppy-o', 'folder', 'folder-o', 'folder-open', 'folder-open-o', 'font', 'forward', 'foursquare', 'frown-o', 'gamepad', 'gavel', 'gbp', 'ge', 'gear', 'gears', 'gift', 'git', 'git-square', 'github', 'github-alt', 'github-square', 'gittip', 'glass', 'globe', 'google', 'google-plus', 'google-plus-square', 'graduation-cap', 'group', 'h-square', 'hacker-news', 'hand-o-down', 'hand-o-left', 'hand-o-right', 'hand-o-up', 'hdd-o', 'header', 'headphones', 'heart', 'heart-o', 'history', 'home', 'hospital-o', 'html5', 'image', 'inbox', 'indent', 'info', 'info-circle', 'inr', 'instagram', 'institution', 'italic', 'joomla', 'jpy', 'jsfiddle', 'key', 'keyboard-o', 'krw', 'language', 'laptop', 'leaf', 'legal', 'lemon-o', 'level-down', 'level-up', 'life-bouy', 'life-ring', 'life-saver', 'lightbulb-o', 'link', 'linkedin', 'linkedin-square', 'linux', 'list', 'list-alt', 'list-ol', 'list-ul', 'location-arrow', 'lock', 'long-arrow-down', 'long-arrow-left', 'long-arrow-right', 'long-arrow-up', 'magic', 'magnet', 'mail-forward', 'mail-reply', 'mail-reply-all', 'male', 'map-marker', 'maxcdn', 'medkit', 'meh-o', 'microphone', 'microphone-slash', 'minus', 'minus-circle', 'minus-square', 'minus-square-o', 'mobile', 'mobile-phone', 'money', 'moon-o', 'mortar-board', 'music', 'navicon', 'openid', 'outdent', 'pagelines', 'paper-plane', 'paper-plane-o', 'paperclip', 'paragraph', 'paste', 'pause', 'paw', 'pencil', 'pencil-square', 'pencil-square-o', 'phone', 'phone-square', 'photo', 'picture-o', 'pied-piper', 'pied-piper-alt', 'pied-piper-square', 'pinterest', 'pinterest-square', 'plane', 'play', 'play-circle', 'play-circle-o', 'plus', 'plus-circle', 'plus-square', 'plus-square-o', 'power-off', 'print', 'puzzle-piece', 'qq', 'qrcode', 'question', 'question-circle', 'quote-left', 'quote-right', 'ra', 'random', 'rebel', 'recycle', 'reddit', 'reddit-square', 'refresh', 'renren', 'reorder', 'repeat', 'reply', 'reply-all', 'retweet', 'rmb', 'road', 'rocket', 'rotate-left', 'rotate-right', 'rouble', 'rss', 'rss-square', 'rub', 'ruble', 'rupee', 'save', 'scissors', 'search', 'search-minus', 'search-plus', 'send', 'send-o', 'share', 'share-alt', 'share-alt-square', 'share-square', 'share-square-o', 'shield', 'shopping-cart', 'sign-in', 'sign-out', 'signal', 'sitemap', 'skype', 'slack', 'sliders', 'smile-o', 'sort', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-asc', 'sort-desc', 'sort-down', 'sort-numeric-asc', 'sort-numeric-desc', 'sort-up', 'soundcloud', 'space-shuttle', 'spinner', 'spoon', 'spotify', 'square', 'square-o', 'stack-exchange', 'stack-overflow', 'star', 'star-half', 'star-half-empty', 'star-half-full', 'star-half-o', 'star-o', 'steam', 'steam-square', 'step-backward', 'step-forward', 'stethoscope', 'stop', 'strikethrough', 'stumbleupon', 'stumbleupon-circle', 'subscript', 'suitcase', 'sun-o', 'superscript', 'support', 'table', 'tablet', 'tachometer', 'tag', 'tags', 'tasks', 'taxi', 'tencent-weibo', 'terminal', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'thumb-tack', 'thumbs-down', 'thumbs-o-down', 'thumbs-o-up', 'thumbs-up', 'ticket', 'times', 'times-circle', 'times-circle-o', 'tint', 'toggle-down', 'toggle-left', 'toggle-right', 'toggle-up', 'trash-o', 'tree', 'trello', 'trophy', 'truck', 'try', 'tumblr', 'tumblr-square', 'turkish-lira', 'twitter', 'twitter-square', 'umbrella', 'underline', 'undo', 'university', 'unlink', 'unlock', 'unlock-alt', 'unsorted', 'upload', 'usd', 'user', 'user-md', 'users', 'video-camera', 'vimeo-square', 'vine', 'vk', 'volume-down', 'volume-off', 'volume-up', 'warning', 'wechat', 'weibo', 'weixin', 'wheelchair', 'windows', 'won', 'wordpress', 'wrench', 'xing', 'xing-square', 'yahoo', 'yen', 'youtube', 'youtube-play', 'youtube-square' ) );
	}

	/**
	 * Animate.css animations
	 */
	public static function animations() {
		return apply_filters( 'mom_su/data/animations', array( 'flash', 'bounce', 'shake', 'tada', 'swing', 'wobble', 'pulse', 'flip', 'flipInX', 'flipOutX', 'flipInY', 'flipOutY', 'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInUpBig', 'fadeInDownBig', 'fadeInLeftBig', 'fadeInRightBig', 'fadeOut', 'fadeOutUp', 'fadeOutDown', 'fadeOutLeft', 'fadeOutRight', 'fadeOutUpBig', 'fadeOutDownBig', 'fadeOutLeftBig', 'fadeOutRightBig', 'slideInDown', 'slideInLeft', 'slideInRight', 'slideOutUp', 'slideOutLeft', 'slideOutRight', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'bounceOut', 'bounceOutDown', 'bounceOutUp', 'bounceOutLeft', 'bounceOutRight', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'lightSpeedIn', 'lightSpeedOut', 'hinge', 'rollIn', 'rollOut' ) );
	}

	/**
	 * Examples section
	 */
	public static function examples() {
		return apply_filters( 'mom_su/data/examples', array(
				'basic' => array(
					'title' => __( 'Basic examples', 'theme' ),
					'items' => array(
						array(
							'name' => __( 'Accordions, spoilers, different styles, anchors', 'theme' ),
							'id'   => 'spoilers',
							'code' => plugin_dir_path( mom_su_PLUGIN_FILE ) . '/inc/examples/spoilers.example',
							'icon' => 'tasks'
						),
						array(
							'name' => __( 'Tabs, vertical tabs, tab anchors', 'theme' ),
							'id'   => 'tabs',
							'code' => plugin_dir_path( mom_su_PLUGIN_FILE ) . '/inc/examples/tabs.example',
							'icon' => 'folder'
						),
						array(
							'name' => __( 'Column layouts', 'theme' ),
							'id'   => 'columns',
							'code' => plugin_dir_path( mom_su_PLUGIN_FILE ) . '/inc/examples/columns.example',
							'icon' => 'th-large'
						),
						array(
							'name' => __( 'Media elements, YouTube, Vimeo, Screenr and self-hosted videos, audio player', 'theme' ),
							'id'   => 'media',
							'code' => plugin_dir_path( mom_su_PLUGIN_FILE ) . '/inc/examples/media.example',
							'icon' => 'play-circle'
						),
						array(
							'name' => __( 'Unlimited buttons', 'theme' ),
							'id'   => 'buttons',
							'code' => plugin_dir_path( mom_su_PLUGIN_FILE ) . '/inc/examples/buttons.example',
							'icon' => 'heart'
						),
						array(
							'name' => __( 'Animations', 'theme' ),
							'id'   => 'animations',
							'code' => plugin_dir_path( mom_su_PLUGIN_FILE ) . '/inc/examples/animations.example',
							'icon' => 'bolt'
						),
					)
				),
				'advanced' => array(
					'title' => __( 'Advanced examples', 'theme' ),
					'items' => array(
						array(
							'name' => __( 'Interacting with posts shortcode', 'theme' ),
							'id' => 'posts',
							'code' => plugin_dir_path( mom_su_PLUGIN_FILE ) . '/inc/examples/posts.example',
							'icon' => 'list'
						),
						array(
							'name' => __( 'Nested shortcodes, shortcodes inside of attributes', 'theme' ),
							'id' => 'nested',
							'code' => plugin_dir_path( mom_su_PLUGIN_FILE ) . '/inc/examples/nested.example',
							'icon' => 'indent'
						),
					)
				),
			) );
	}

	/**
	 * Shortcodes
	 */
	public static function shortcodes( $shortcode = false ) {
		$shortcodes = apply_filters( 'mom_su/data/shortcodes', array(
				/*
				// heading
				'heading' => array(
					'name' => __( 'Heading', 'theme' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'theme' ),
							),
							'default' => 'default',
							'name' => __( 'Style', 'theme' ),
							'desc' => __( 'Choose style for this heading', 'theme' ) . '%mom_su_skins_link%'
						),
						'size' => array(
							'type' => 'slider',
							'min' => 7,
							'max' => 48,
							'step' => 1,
							'default' => 13,
							'name' => __( 'Size', 'theme' ),
							'desc' => __( 'Select heading size (pixels)', 'theme' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'theme' ),
								'center' => __( 'Center', 'theme' ),
								'right' => __( 'Right', 'theme' )
							),
							'default' => 'center',
							'name' => __( 'Align', 'theme' ),
							'desc' => __( 'Heading text alignment', 'theme' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 200,
							'step' => 10,
							'default' => 20,
							'name' => __( 'Margin', 'theme' ),
							'desc' => __( 'Bottom margin (pixels)', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Heading text', 'theme' ),
					'desc' => __( 'Styled heading', 'theme' ),
					'icon' => 'h-square'
				),
				// tabs
				'tabs' => array(
					'name' => __( 'Tabs', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'theme' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'theme' ),
							'desc' => __( 'Choose style for this tabs', 'theme' ) . '%mom_su_skins_link%'
						),
						'active' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Active tab', 'theme' ),
							'desc' => __( 'Select which tab is open by default', 'theme' )
						),
						'vertical' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Vertical', 'theme' ),
							'desc' => __( 'Show tabs vertically', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( "[%prefix_tab title=\"Title 1\"]Content 1[/%prefix_tab]\n[%prefix_tab title=\"Title 2\"]Content 2[/%prefix_tab]\n[%prefix_tab title=\"Title 3\"]Content 3[/%prefix_tab]", 'theme' ),
					'desc' => __( 'Tabs container', 'theme' ),
					'example' => 'tabs',
					'icon' => 'list-alt'
				),
				// tab
				'tab' => array(
					'name' => __( 'Tab', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'default' => __( 'Tab name', 'theme' ),
							'name' => __( 'Title', 'theme' ),
							'desc' => __( 'Enter tab name', 'theme' )
						),
						'disabled' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Disabled', 'theme' ),
							'desc' => __( 'Is this tab disabled', 'theme' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'theme' ),
							'desc' => __( 'You can use unique anchor for this tab to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This tab will be activated and scrolled in', 'theme' )
						),
						'url' => array(
							'default' => '',
							'name' => __( 'URL', 'theme' ),
							'desc' => __( 'You can link this tab to any webpage. Enter here full URL to switch this tab into link', 'theme' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self'  => __( 'Open link in same window/tab', 'theme' ),
								'blank' => __( 'Open link in new window/tab', 'theme' )
							),
							'default' => 'blank',
							'name' => __( 'Link target', 'theme' ),
							'desc' => __( 'Choose how to open the custom tab link', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Tab content', 'theme' ),
					'desc' => __( 'Single tab', 'theme' ),
					'note' => __( 'Did you know that you need to wrap single tabs with [tabs] shortcode?', 'theme' ),
					'example' => 'tabs',
					'icon' => 'list-alt'
				),
				// spoiler
				'spoiler' => array(
					'name' => __( 'Spoiler', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'default' => __( 'Spoiler title', 'theme' ),
							'name' => __( 'Title', 'theme' ), 'desc' => __( 'Text in spoiler title', 'theme' )
						),
						'open' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Open', 'theme' ),
							'desc' => __( 'Is spoiler content visible by default', 'theme' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'theme' ),
								'fancy' => __( 'Fancy', 'theme' ),
								'simple' => __( 'Simple', 'theme' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'theme' ),
							'desc' => __( 'Choose style for this spoiler', 'theme' ) . '%mom_su_skins_link%'
						),
						'icon' => array(
							'type' => 'select',
							'values' => array(
								'plus'           => __( 'Plus', 'theme' ),
								'plus-circle'    => __( 'Plus circle', 'theme' ),
								'plus-square-1'  => __( 'Plus square 1', 'theme' ),
								'plus-square-2'  => __( 'Plus square 2', 'theme' ),
								'arrow'          => __( 'Arrow', 'theme' ),
								'arrow-circle-1' => __( 'Arrow circle 1', 'theme' ),
								'arrow-circle-2' => __( 'Arrow circle 2', 'theme' ),
								'chevron'        => __( 'Chevron', 'theme' ),
								'chevron-circle' => __( 'Chevron circle', 'theme' ),
								'caret'          => __( 'Caret', 'theme' ),
								'caret-square'   => __( 'Caret square', 'theme' ),
								'folder-1'       => __( 'Folder 1', 'theme' ),
								'folder-2'       => __( 'Folder 2', 'theme' )
							),
							'default' => 'plus',
							'name' => __( 'Icon', 'theme' ),
							'desc' => __( 'Icons for spoiler', 'theme' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'theme' ),
							'desc' => __( 'You can use unique anchor for this spoiler to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This spoiler will be open and scrolled in', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Hidden content', 'theme' ),
					'desc' => __( 'Spoiler with hidden content', 'theme' ),
					'note' => __( 'Did you know that you can wrap multiple spoilers with [accordion] shortcode to create accordion effect?', 'theme' ),
					'example' => 'spoilers',
					'icon' => 'list-ul'
				),
				// accordion
				'accordion' => array(
					'name' => __( 'Accordion', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( "[%prefix_spoiler]Content[/%prefix_spoiler]\n[%prefix_spoiler]Content[/%prefix_spoiler]\n[%prefix_spoiler]Content[/%prefix_spoiler]", 'theme' ),
					'desc' => __( 'Accordion with spoilers', 'theme' ),
					'note' => __( 'Did you know that you can wrap multiple spoilers with [accordion] shortcode to create accordion effect?', 'theme' ),
					'example' => 'spoilers',
					'icon' => 'list'
				),
				// divider
				'divider' => array(
					'name' => __( 'Divider', 'theme' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'top' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show TOP link', 'theme' ),
							'desc' => __( 'Show link to top of the page or not', 'theme' )
						),
						'text' => array(
							'values' => array( ),
							'default' => __( 'Go to top', 'theme' ),
							'name' => __( 'Link text', 'theme' ), 'desc' => __( 'Text for the GO TOP link', 'theme' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'theme' ),
								'dotted'  => __( 'Dotted', 'theme' ),
								'dashed'  => __( 'Dashed', 'theme' ),
								'double'  => __( 'Double', 'theme' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'theme' ),
							'desc' => __( 'Choose style for this divider', 'theme' )
						),
						'divider_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#999999',
							'name' => __( 'Divider color', 'theme' ),
							'desc' => __( 'Pick the color for divider', 'theme' )
						),
						'link_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#999999',
							'name' => __( 'Link color', 'theme' ),
							'desc' => __( 'Pick the color for TOP link', 'theme' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 40,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'theme' ),
							'desc' => __( 'Height of the divider (in pixels)', 'theme' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 200,
							'step' => 5,
							'default' => 15,
							'name' => __( 'Margin', 'theme' ),
							'desc' => __( 'Adjust the top and bottom margins of this divider (in pixels)', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Content divider with optional TOP link', 'theme' ),
					'icon' => 'ellipsis-h'
				),
				// spacer
				'spacer' => array(
					'name' => __( 'Spacer', 'theme' ),
					'type' => 'single',
					'group' => 'content other',
					'atts' => array(
						'size' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 800,
							'step' => 10,
							'default' => 20,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Height of the spacer in pixels', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Empty space with adjustable height', 'theme' ),
					'icon' => 'arrows-v'
				),
				// highlight
				'highlight' => array(
					'name' => __( 'Highlight', 'theme' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'background' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#DDFF99',
							'name' => __( 'Background', 'theme' ),
							'desc' => __( 'Highlighted text background color', 'theme' )
						),
						'color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#000000',
							'name' => __( 'Text color', 'theme' ), 'desc' => __( 'Highlighted text color', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Highlighted text', 'theme' ),
					'desc' => __( 'Highlighted text', 'theme' ),
					'icon' => 'pencil'
				),
				// label
				'label' => array(
					'name' => __( 'Label', 'theme' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'theme' ),
								'success' => __( 'Success', 'theme' ),
								'warning' => __( 'Warning', 'theme' ),
								'important' => __( 'Important', 'theme' ),
								'black' => __( 'Black', 'theme' ),
								'info' => __( 'Info', 'theme' )
							),
							'default' => 'default',
							'name' => __( 'Type', 'theme' ),
							'desc' => __( 'Style of the label', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Label', 'theme' ),
					'desc' => __( 'Styled label', 'theme' ),
					'icon' => 'tag'
				),
				// quote
				'quote' => array(
					'name' => __( 'Quote', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'theme' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'theme' ),
							'desc' => __( 'Choose style for this quote', 'theme' ) . '%mom_su_skins_link%'
						),
						'cite' => array(
							'default' => '',
							'name' => __( 'Cite', 'theme' ),
							'desc' => __( 'Quote author name', 'theme' )
						),
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Cite url', 'theme' ),
							'desc' => __( 'Url of the quote author. Leave empty to disable link', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Quote', 'theme' ),
					'desc' => __( 'Blockquote alternative', 'theme' ),
					'icon' => 'quote-right'
				),
				// pullquote
				'pullquote' => array(
					'name' => __( 'Pullquote', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'theme' ),
								'right' => __( 'Right', 'theme' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'theme' ), 'desc' => __( 'Pullquote alignment (float)', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Pullquote', 'theme' ),
					'desc' => __( 'Pullquote', 'theme' ),
					'icon' => 'quote-left'
				),
				// dropcap
				'dropcap' => array(
					'name' => __( 'Dropcap', 'theme' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'theme' ),
								'flat' => __( 'Flat', 'theme' ),
								'light' => __( 'Light', 'theme' ),
								'simple' => __( 'Simple', 'theme' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'theme' ), 'desc' => __( 'Dropcap style preset', 'theme' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 5,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'theme' ),
							'desc' => __( 'Choose dropcap size', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'D', 'theme' ),
					'desc' => __( 'Dropcap', 'theme' ),
					'icon' => 'bold'
				),
				// frame
				'frame' => array(
					'name' => __( 'Frame', 'theme' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'theme' ),
								'center' => __( 'Center', 'theme' ),
								'right' => __( 'Right', 'theme' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'theme' ),
							'desc' => __( 'Frame alignment', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => '<img src="http://lorempixel.com/g/400/200/" />',
					'desc' => __( 'Styled image frame', 'theme' ),
					'icon' => 'picture-o'
				),
				// row
				'row' => array(
					'name' => __( 'Row', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( "[%prefix_column size=\"1/3\"]Content[/%prefix_column]\n[%prefix_column size=\"1/3\"]Content[/%prefix_column]\n[%prefix_column size=\"1/3\"]Content[/%prefix_column]", 'theme' ),
					'desc' => __( 'Row for flexible columns', 'theme' ),
					'icon' => 'columns'
				),
				// column
				'column' => array(
					'name' => __( 'Column', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'size' => array(
							'type' => 'select',
							'values' => array(
								'1/1' => __( 'Full width', 'theme' ),
								'1/2' => __( 'One half', 'theme' ),
								'1/3' => __( 'One third', 'theme' ),
								'2/3' => __( 'Two third', 'theme' ),
								'1/4' => __( 'One fourth', 'theme' ),
								'3/4' => __( 'Three fourth', 'theme' ),
								'1/5' => __( 'One fifth', 'theme' ),
								'2/5' => __( 'Two fifth', 'theme' ),
								'3/5' => __( 'Three fifth', 'theme' ),
								'4/5' => __( 'Four fifth', 'theme' ),
								'1/6' => __( 'One sixth', 'theme' ),
								'5/6' => __( 'Five sixth', 'theme' )
							),
							'default' => '1/2',
							'name' => __( 'Size', 'theme' ),
							'desc' => __( 'Select column width. This width will be calculated depend page width', 'theme' )
						),
						'center' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Centered', 'theme' ),
							'desc' => __( 'Is this column centered on the page', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Column content', 'theme' ),
					'desc' => __( 'Flexible and responsive columns', 'theme' ),
					'note' => __( 'Did you know that you need to wrap columns with [row] shortcode?', 'theme' ),
					'example' => 'columns',
					'icon' => 'columns'
				),
				// list
				'list' => array(
					'name' => __( 'List', 'theme' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'theme' ),
							'desc' => __( 'You can upload custom icon for this list or pick a built-in icon', 'theme' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'theme' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( "<ul>\n<li>List item</li>\n<li>List item</li>\n<li>List item</li>\n</ul>", 'theme' ),
					'desc' => __( 'Styled unordered list', 'theme' ),
					'icon' => 'list-ol'
				),
				// button
				'button' => array(
					'name' => __( 'Button', 'theme' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => get_option( 'home' ),
							'name' => __( 'Link', 'theme' ),
							'desc' => __( 'Button link', 'theme' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same tab', 'theme' ),
								'blank' => __( 'New tab', 'theme' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'theme' ),
							'desc' => __( 'Button link target', 'theme' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'theme' ),
								'flat' => __( 'Flat', 'theme' ),
								'ghost' => __( 'Ghost', 'theme' ),
								'soft' => __( 'Soft', 'theme' ),
								'glass' => __( 'Glass', 'theme' ),
								'bubbles' => __( 'Bubbles', 'theme' ),
								'noise' => __( 'Noise', 'theme' ),
								'stroked' => __( 'Stroked', 'theme' ),
								'3d' => __( '3D', 'theme' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'theme' ), 'desc' => __( 'Button background style preset', 'theme' )
						),
						'background' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#2D89EF',
							'name' => __( 'Background', 'theme' ), 'desc' => __( 'Button background color', 'theme' )
						),
						'color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFFFF',
							'name' => __( 'Text color', 'theme' ),
							'desc' => __( 'Button text color', 'theme' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'theme' ),
							'desc' => __( 'Button size', 'theme' )
						),
						'wide' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Fluid', 'theme' ), 'desc' => __( 'Fluid buttons has 100% width', 'theme' )
						),
						'center' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Centered', 'theme' ), 'desc' => __( 'Is button centered on the page', 'theme' )
						),
						'radius' => array(
							'type' => 'select',
							'values' => array(
								'auto' => __( 'Auto', 'theme' ),
								'round' => __( 'Round', 'theme' ),
								'0' => __( 'Square', 'theme' ),
								'5' => '5px',
								'10' => '10px',
								'20' => '20px'
							),
							'default' => 'auto',
							'name' => __( 'Radius', 'theme' ),
							'desc' => __( 'Radius of button corners. Auto-radius calculation based on button size', 'theme' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'theme' ),
							'desc' => __( 'You can upload custom icon for this button or pick a built-in icon', 'theme' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Icon color', 'theme' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'theme' )
						),
						'text_shadow' => array(
							'type' => 'shadow',
							'default' => 'none',
							'name' => __( 'Text shadow', 'theme' ),
							'desc' => __( 'Button text shadow', 'theme' )
						),
						'desc' => array(
							'default' => '',
							'name' => __( 'Description', 'theme' ),
							'desc' => __( 'Small description under button text. This option is incompatible with icon.', 'theme' )
						),
						'onclick' => array(
							'default' => '',
							'name' => __( 'onClick', 'theme' ),
							'desc' => __( 'Advanced JavaScript code for onClick action', 'theme' )
						),
						'rel' => array(
							'default' => '',
							'name' => __( 'Rel attribute', 'theme' ),
							'desc' => __( 'Here you can add value for the rel attribute.<br>Example values: <b%value>nofollow</b>, <b%value>lightbox</b>', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Button text', 'theme' ),
					'desc' => __( 'Styled button', 'theme' ),
					'example' => 'buttons',
					'icon' => 'heart'
				),
				// service
				'service' => array(
					'name' => __( 'Service', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Service title', 'theme' ),
							'name' => __( 'Title', 'theme' ),
							'desc' => __( 'Service name', 'theme' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'theme' ),
							'desc' => __( 'You can upload custom icon for this box', 'theme' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'theme' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'theme' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 128,
							'step' => 2,
							'default' => 32,
							'name' => __( 'Icon size', 'theme' ),
							'desc' => __( 'Size of the uploaded icon in pixels', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Service description', 'theme' ),
					'desc' => __( 'Service box with title', 'theme' ),
					'icon' => 'check-square-o'
				),
				// box
				'box' => array(
					'name' => __( 'Box', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Box title', 'theme' ),
							'name' => __( 'Title', 'theme' ), 'desc' => __( 'Text for the box title', 'theme' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'theme' ),
								'soft' => __( 'Soft', 'theme' ),
								'glass' => __( 'Glass', 'theme' ),
								'bubbles' => __( 'Bubbles', 'theme' ),
								'noise' => __( 'Noise', 'theme' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'theme' ),
							'desc' => __( 'Box style preset', 'theme' )
						),
						'box_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Color', 'theme' ),
							'desc' => __( 'Color for the box title and borders', 'theme' )
						),
						'title_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFFFF',
							'name' => __( 'Title text color', 'theme' ), 'desc' => __( 'Color for the box title text', 'theme' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Radius', 'theme' ),
							'desc' => __( 'Box corners radius', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Box content', 'theme' ),
					'desc' => __( 'Colored box with caption', 'theme' ),
					'icon' => 'list-alt'
				),
				// note
				'note' => array(
					'name' => __( 'Note', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'note_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFF66',
							'name' => __( 'Background', 'theme' ), 'desc' => __( 'Note background color', 'theme' )
						),
						'text_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Text color', 'theme' ),
							'desc' => __( 'Note text color', 'theme' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Radius', 'theme' ), 'desc' => __( 'Note corners radius', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Note text', 'theme' ),
					'desc' => __( 'Colored box', 'theme' ),
					'icon' => 'list-alt'
				),
				// expand
				'expand' => array(
					'name' => __( 'Expand', 'theme' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'more_text' => array(
							'default' => __( 'Show more', 'theme' ),
							'name' => __( 'More text', 'theme' ),
							'desc' => __( 'Enter the text for more link', 'theme' )
						),
						'less_text' => array(
							'default' => __( 'Show less', 'theme' ),
							'name' => __( 'Less text', 'theme' ),
							'desc' => __( 'Enter the text for less link', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 1000,
							'step' => 10,
							'default' => 100,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Height for collapsed state (in pixels)', 'theme' )
						),
						'hide_less' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Hide less link', 'theme' ),
							'desc' => __( 'This option allows you to hide less link, when the text block has been expanded', 'theme' )
						),
						'text_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Text color', 'theme' ),
							'desc' => __( 'Pick the text color', 'theme' )
						),
						'link_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#0088FF',
							'name' => __( 'Link color', 'theme' ),
							'desc' => __( 'Pick the link color', 'theme' )
						),
						'link_style' => array(
							'type' => 'select',
							'values' => array(
								'default'    => __( 'Default', 'theme' ),
								'underlined' => __( 'Underlined', 'theme' ),
								'dotted'     => __( 'Dotted', 'theme' ),
								'dashed'     => __( 'Dashed', 'theme' ),
								'button'     => __( 'Button', 'theme' ),
							),
							'default' => 'default',
							'name' => __( 'Link style', 'theme' ),
							'desc' => __( 'Select the style for more/less link', 'theme' )
						),
						'link_align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'theme' ),
								'center' => __( 'Center', 'theme' ),
								'right' => __( 'Right', 'theme' ),
							),
							'default' => 'left',
							'name' => __( 'Link align', 'theme' ),
							'desc' => __( 'Select link alignment', 'theme' )
						),
						'more_icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'More icon', 'theme' ),
							'desc' => __( 'Add an icon to the more link', 'theme' )
						),
						'less_icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Less icon', 'theme' ),
							'desc' => __( 'Add an icon to the less link', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'This text block can be expanded', 'theme' ),
					'desc' => __( 'Expandable text block', 'theme' ),
					'icon' => 'sort-amount-asc'
				),
				// lightbox
				'lightbox' => array(
					'name' => __( 'Lightbox', 'theme' ),
					'type' => 'wrap',
					'group' => 'gallery',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'iframe' => __( 'Iframe', 'theme' ),
								'image' => __( 'Image', 'theme' ),
								'inline' => __( 'Inline (html content)', 'theme' )
							),
							'default' => 'iframe',
							'name' => __( 'Content type', 'theme' ),
							'desc' => __( 'Select type of the lightbox window content', 'theme' )
						),
						'src' => array(
							'default' => '',
							'name' => __( 'Content source', 'theme' ),
							'desc' => __( 'Insert here URL or CSS selector. Use URL for Iframe and Image content types. Use CSS selector for Inline content type.<br />Example values:<br /><b%value>http://www.youtube.com/watch?v=XXXXXXXXX</b> - YouTube video (iframe)<br /><b%value>http://example.com/wp-content/uploads/image.jpg</b> - uploaded image (image)<br /><b%value>http://example.com/</b> - any web page (iframe)<br /><b%value>#my-custom-popup</b> - any HTML content (inline)', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( '[%prefix_button] Click Here to Watch the Video [/%prefix_button]', 'theme' ),
					'desc' => __( 'Lightbox window with custom content', 'theme' ),
					'icon' => 'external-link'
				),
				// lightbox content
				'lightbox_content' => array(
					'name' => __( 'Lightbox content', 'theme' ),
					'type' => 'wrap',
					'group' => 'gallery',
					'atts' => array(
						'id' => array(
							'default' => '',
							'name' => __( 'ID', 'theme' ),
							'desc' => sprintf( __( 'Enter here the ID from Content source field. %s Example value: %s', 'theme' ), '<br>', '<b%value>my-custom-popup</b>' )
						),
						'width' => array(
							'default' => '50%',
							'name' => __( 'Width', 'theme' ),
							'desc' => sprintf( __( 'Adjust the width for inline content (in pixels or percents). %s Example values: %s, %s, %s', 'theme' ), '<br>', '<b%value>300px</b>', '<b%value>600px</b>', '<b%value>90%</b>' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 600,
							'step' => 5,
							'default' => 40,
							'name' => __( 'Margin', 'theme' ),
							'desc' => __( 'Adjust the margin for inline content (in pixels)', 'theme' )
						),
						'padding' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 600,
							'step' => 5,
							'default' => 40,
							'name' => __( 'Padding', 'theme' ),
							'desc' => __( 'Adjust the padding for inline content (in pixels)', 'theme' )
						),
						'text_align' => array(
							'type' => 'select',
							'values' => array(
								'left'   => __( 'Left', 'theme' ),
								'center' => __( 'Center', 'theme' ),
								'right'  => __( 'Right', 'theme' )
							),
							'default' => 'center',
							'name' => __( 'Text alignment', 'theme' ),
							'desc' => __( 'Select the text alignment', 'theme' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Background color', 'theme' ),
							'desc' => __( 'Pick a background color', 'theme' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Text color', 'theme' ),
							'desc' => __( 'Pick a text color', 'theme' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Text color', 'theme' ),
							'desc' => __( 'Pick a text color', 'theme' )
						),
						'shadow' => array(
							'type' => 'shadow',
							'default' => '0px 0px 15px #333333',
							'name' => __( 'Shadow', 'theme' ),
							'desc' => __( 'Adjust the shadow for content box', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Inline content', 'theme' ),
					'desc' => __( 'Inline content for lightbox', 'theme' ),
					'icon' => 'external-link'
				),
				// tooltip
				'tooltip' => array(
					'name' => __( 'Tooltip', 'theme' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'light' => __( 'Basic: Light', 'theme' ),
								'dark' => __( 'Basic: Dark', 'theme' ),
								'yellow' => __( 'Basic: Yellow', 'theme' ),
								'green' => __( 'Basic: Green', 'theme' ),
								'red' => __( 'Basic: Red', 'theme' ),
								'blue' => __( 'Basic: Blue', 'theme' ),
								'youtube' => __( 'Youtube', 'theme' ),
								'tipsy' => __( 'Tipsy', 'theme' ),
								'bootstrap' => __( 'Bootstrap', 'theme' ),
								'jtools' => __( 'jTools', 'theme' ),
								'tipped' => __( 'Tipped', 'theme' ),
								'cluetip' => __( 'Cluetip', 'theme' ),
							),
							'default' => 'yellow',
							'name' => __( 'Style', 'theme' ),
							'desc' => __( 'Tooltip window style', 'theme' )
						),
						'position' => array(
							'type' => 'select',
							'values' => array(
								'north' => __( 'Top', 'theme' ),
								'south' => __( 'Bottom', 'theme' ),
								'west' => __( 'Left', 'theme' ),
								'east' => __( 'Right', 'theme' )
							),
							'default' => 'top',
							'name' => __( 'Position', 'theme' ),
							'desc' => __( 'Tooltip position', 'theme' )
						),
						'shadow' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Shadow', 'theme' ),
							'desc' => __( 'Add shadow to tooltip. This option is only works with basic styes, e.g. blue, green etc.', 'theme' )
						),
						'rounded' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Rounded corners', 'theme' ),
							'desc' => __( 'Use rounded for tooltip. This option is only works with basic styes, e.g. blue, green etc.', 'theme' )
						),
						'size' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'theme' ),
								'1' => 1,
								'2' => 2,
								'3' => 3,
								'4' => 4,
								'5' => 5,
								'6' => 6,
							),
							'default' => 'default',
							'name' => __( 'Font size', 'theme' ),
							'desc' => __( 'Tooltip font size', 'theme' )
						),
						'title' => array(
							'default' => '',
							'name' => __( 'Tooltip title', 'theme' ),
							'desc' => __( 'Enter title for tooltip window. Leave this field empty to hide the title', 'theme' )
						),
						'content' => array(
							'default' => __( 'Tooltip text', 'theme' ),
							'name' => __( 'Tooltip content', 'theme' ),
							'desc' => __( 'Enter tooltip content here', 'theme' )
						),
						'behavior' => array(
							'type' => 'select',
							'values' => array(
								'hover' => __( 'Show and hide on mouse hover', 'theme' ),
								'click' => __( 'Show and hide by mouse click', 'theme' ),
								'always' => __( 'Always visible', 'theme' )
							),
							'default' => 'hover',
							'name' => __( 'Behavior', 'theme' ),
							'desc' => __( 'Select tooltip behavior', 'theme' )
						),
						'close' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Close button', 'theme' ),
							'desc' => __( 'Show close button', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( '[%prefix_button] Hover me to open tooltip [/%prefix_button]', 'theme' ),
					'desc' => __( 'Tooltip window with custom content', 'theme' ),
					'icon' => 'comment-o'
				),
				// private
				'private' => array(
					'name' => __( 'Private', 'theme' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Private note text', 'theme' ),
					'desc' => __( 'Private note for post authors', 'theme' ),
					'icon' => 'lock'
				),
				// youtube
				'youtube' => array(
					'name' => __( 'YouTube', 'theme' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'theme' ),
							'desc' => __( 'Url of YouTube page with video. Ex: http://youtube.com/watch?v=XXXXXX', 'theme' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Player width', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Player height', 'theme' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'theme' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'theme' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'theme' ),
							'desc' => __( 'Play video automatically when page is loaded', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'YouTube video', 'theme' ),
					'example' => 'media',
					'icon' => 'youtube-play'
				),
				// youtube_advanced
				'youtube_advanced' => array(
					'name' => __( 'YouTube Advanced', 'theme' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'theme' ),
							'desc' => __( 'Url of YouTube page with video. Ex: http://youtube.com/watch?v=XXXXXX', 'theme' )
						),
						'playlist' => array(
							'default' => '',
							'name' => __( 'Playlist', 'theme' ),
							'desc' => __( 'Value is a comma-separated list of video IDs to play. If you specify a value, the first video that plays will be the VIDEO_ID specified in the URL path, and the videos specified in the playlist parameter will play thereafter', 'theme' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Player width', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Player height', 'theme' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'theme' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'theme' )
						),
						'controls' => array(
							'type' => 'select',
							'values' => array(
								'no' => __( '0 - Hide controls', 'theme' ),
								'yes' => __( '1 - Show controls', 'theme' ),
								'alt' => __( '2 - Show controls when playback is started', 'theme' )
							),
							'default' => 'yes',
							'name' => __( 'Controls', 'theme' ),
							'desc' => __( 'This parameter indicates whether the video player controls will display', 'theme' )
						),
						'autohide' => array(
							'type' => 'select',
							'values' => array(
								'no' => __( '0 - Do not hide controls', 'theme' ),
								'yes' => __( '1 - Hide all controls on mouse out', 'theme' ),
								'alt' => __( '2 - Hide progress bar on mouse out', 'theme' )
							),
							'default' => 'alt',
							'name' => __( 'Autohide', 'theme' ),
							'desc' => __( 'This parameter indicates whether the video controls will automatically hide after a video begins playing', 'theme' )
						),
						'showinfo' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show title bar', 'theme' ),
							'desc' => __( 'If you set the parameter value to NO, then the player will not display information like the video title and uploader before the video starts playing.', 'theme' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'theme' ),
							'desc' => __( 'Play video automatically when page is loaded', 'theme' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'theme' ),
							'desc' => __( 'Setting of YES will cause the player to play the initial video again and again', 'theme' )
						),
						'rel' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Related videos', 'theme' ),
							'desc' => __( 'This parameter indicates whether the player should show related videos when playback of the initial video ends', 'theme' )
						),
						'fs' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show full-screen button', 'theme' ),
							'desc' => __( 'Setting this parameter to NO prevents the fullscreen button from displaying', 'theme' )
						),
						'modestbranding' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => 'modestbranding',
							'desc' => __( 'This parameter lets you use a YouTube player that does not show a YouTube logo. Set the parameter value to YES to prevent the YouTube logo from displaying in the control bar. Note that a small YouTube text label will still display in the upper-right corner of a paused video when the user\'s mouse pointer hovers over the player', 'theme' )
						),
						'theme' => array(
							'type' => 'select',
							'values' => array(
								'dark' => __( 'Dark theme', 'theme' ),
								'light' => __( 'Light theme', 'theme' )
							),
							'default' => 'dark',
							'name' => __( 'Theme', 'theme' ),
							'desc' => __( 'This parameter indicates whether the embedded player will display player controls (like a play button or volume control) within a dark or light control bar', 'theme' )
						),
						'https' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Force HTTPS', 'theme' ),
							'desc' => __( 'Use HTTPS in player iframe', 'theme' )
						),
						'wmode' => array(
							'default' => '',
							'name'    => __( 'WMode', 'theme' ),
							'desc'    => sprintf( __( 'Here you can specify wmode value for the embed URL. %s Example values: %s, %s', 'theme' ), '<br>', '<b%value>transparent</b>', '<b%value>opaque</b>' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'YouTube video player with advanced settings', 'theme' ),
					'example' => 'media',
					'icon' => 'youtube-play'
				),
				// vimeo
				'vimeo' => array(
					'name' => __( 'Vimeo', 'theme' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'theme' ), 'desc' => __( 'Url of Vimeo page with video', 'theme' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Player width', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Player height', 'theme' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'theme' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'theme' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'theme' ),
							'desc' => __( 'Play video automatically when page is loaded', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Vimeo video', 'theme' ),
					'example' => 'media',
					'icon' => 'youtube-play'
				),
				// screenr
				'screenr' => array(
					'name' => __( 'Screenr', 'theme' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'default' => '',
							'name' => __( 'Url', 'theme' ),
							'desc' => __( 'Url of Screenr page with video', 'theme' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Player width', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Player height', 'theme' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'theme' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Screenr video', 'theme' ),
					'icon' => 'youtube-play'
				),
				// dailymotion
				'dailymotion' => array(
					'name' => __( 'Dailymotion', 'theme' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'default' => '',
							'name' => __( 'Url', 'theme' ),
							'desc' => __( 'Url of Dailymotion page with video', 'theme' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Player width', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Player height', 'theme' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'theme' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'theme' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'theme' ),
							'desc' => __( 'Start the playback of the video automatically after the player load. May not work on some mobile OS versions', 'theme' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#FFC300',
							'name' => __( 'Background color', 'theme' ),
							'desc' => __( 'HTML color of the background of controls elements', 'theme' )
						),
						'foreground' => array(
							'type' => 'color',
							'default' => '#F7FFFD',
							'name' => __( 'Foreground color', 'theme' ),
							'desc' => __( 'HTML color of the foreground of controls elements', 'theme' )
						),
						'highlight' => array(
							'type' => 'color',
							'default' => '#171D1B',
							'name' => __( 'Highlight color', 'theme' ),
							'desc' => __( 'HTML color of the controls elements\' highlights', 'theme' )
						),
						'logo' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show logo', 'theme' ),
							'desc' => __( 'Allows to hide or show the Dailymotion logo', 'theme' )
						),
						'quality' => array(
							'type' => 'select',
							'values' => array(
								'240'  => '240',
								'380'  => '380',
								'480'  => '480',
								'720'  => '720',
								'1080' => '1080'
							),
							'default' => '380',
							'name' => __( 'Quality', 'theme' ),
							'desc' => __( 'Determines the quality that must be played by default if available', 'theme' )
						),
						'related' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show related videos', 'theme' ),
							'desc' => __( 'Show related videos at the end of the video', 'theme' )
						),
						'info' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show video info', 'theme' ),
							'desc' => __( 'Show videos info (title/author) on the start screen', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Dailymotion video', 'theme' ),
					'icon' => 'youtube-play'
				),
				// audio
				'audio' => array(
					'name' => __( 'Audio', 'theme' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'File', 'theme' ),
							'desc' => __( 'Audio file url. Supported formats: mp3, ogg', 'theme' )
						),
						'width' => array(
							'values' => array(),
							'default' => '100%',
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Player width. You can specify width in percents and player will be responsive. Example values: <b%value>200px</b>, <b%value>100&#37;</b>', 'theme' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'theme' ),
							'desc' => __( 'Play file automatically when page is loaded', 'theme' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'theme' ),
							'desc' => __( 'Repeat when playback is ended', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Custom audio player', 'theme' ),
					'example' => 'media',
					'icon' => 'play-circle'
				),
				// video
				'video' => array(
					'name' => __( 'Video', 'theme' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'File', 'theme' ),
							'desc' => __( 'Url to mp4/flv video-file', 'theme' )
						),
						'poster' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Poster', 'theme' ),
							'desc' => __( 'Url to poster image, that will be shown before playback', 'theme' )
						),
						'title' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Title', 'theme' ),
							'desc' => __( 'Player title', 'theme' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Player width', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Player height', 'theme' )
						),
						'controls' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Controls', 'theme' ),
							'desc' => __( 'Show player controls (play/pause etc.) or not', 'theme' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'theme' ),
							'desc' => __( 'Play file automatically when page is loaded', 'theme' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'theme' ),
							'desc' => __( 'Repeat when playback is ended', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Custom video player', 'theme' ),
					'example' => 'media',
					'icon' => 'play-circle'
				),
				// table
				'table' => array(
					'name' => __( 'Table', 'theme' ),
					'type' => 'mixed',
					'group' => 'content',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'CSV file', 'theme' ),
							'desc' => __( 'Upload CSV file if you want to create HTML-table from file', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( "<table>\n<tr>\n\t<td>Table</td>\n\t<td>Table</td>\n</tr>\n<tr>\n\t<td>Table</td>\n\t<td>Table</td>\n</tr>\n</table>", 'theme' ),
					'desc' => __( 'Styled table from HTML or CSV file', 'theme' ),
					'icon' => 'table'
				),
				// permalink
				'permalink' => array(
					'name' => __( 'Permalink', 'theme' ),
					'type' => 'mixed',
					'group' => 'content other',
					'atts' => array(
						'id' => array(
							'values' => array( ), 'default' => 1,
							'name' => __( 'ID', 'theme' ),
							'desc' => __( 'Post or page ID', 'theme' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same tab', 'theme' ),
								'blank' => __( 'New tab', 'theme' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'theme' ),
							'desc' => __( 'Link target. blank - link will be opened in new window/tab', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => '',
					'desc' => __( 'Permalink to specified post/page', 'theme' ),
					'icon' => 'link'
				),
				// members
				'members' => array(
					'name' => __( 'Members', 'theme' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'message' => array(
							'default' => __( 'This content is for registered users only. Please %login%.', 'theme' ),
							'name' => __( 'Message', 'theme' ), 'desc' => __( 'Message for not logged users', 'theme' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#ffcc00',
							'name' => __( 'Box color', 'theme' ), 'desc' => __( 'This color will applied only to box for not logged users', 'theme' )
						),
						'login_text' => array(
							'default' => __( 'login', 'theme' ),
							'name' => __( 'Login link text', 'theme' ), 'desc' => __( 'Text for the login link', 'theme' )
						),
						'login_url' => array(
							'default' => wp_login_url(),
							'name' => __( 'Login link url', 'theme' ), 'desc' => __( 'Login link url', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Content for logged members', 'theme' ),
					'desc' => __( 'Content for logged in members only', 'theme' ),
					'icon' => 'lock'
				),
				// guests
				'guests' => array(
					'name' => __( 'Guests', 'theme' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Content for guests', 'theme' ),
					'desc' => __( 'Content for guests only', 'theme' ),
					'icon' => 'user'
				),
				// feed
				'feed' => array(
					'name' => __( 'RSS Feed', 'theme' ),
					'type' => 'single',
					'group' => 'content other',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'theme' ),
							'desc' => __( 'Url to RSS-feed', 'theme' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Limit', 'theme' ), 'desc' => __( 'Number of items to show', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Feed grabber', 'theme' ),
					'icon' => 'rss'
				),
				// menu
				'menu' => array(
					'name' => __( 'Menu', 'theme' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'name' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Menu name', 'theme' ), 'desc' => __( 'Custom menu name. Ex: Main menu', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Custom menu by name', 'theme' ),
					'icon' => 'bars'
				),
				// subpages
				'subpages' => array(
					'name' => __( 'Sub pages', 'theme' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3, 4, 5 ), 'default' => 1,
							'name' => __( 'Depth', 'theme' ),
							'desc' => __( 'Max depth level of children pages', 'theme' )
						),
						'p' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Parent ID', 'theme' ),
							'desc' => __( 'ID of the parent page. Leave blank to use current page', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'List of sub pages', 'theme' ),
					'icon' => 'bars'
				),
				// siblings
				'siblings' => array(
					'name' => __( 'Siblings', 'theme' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3 ), 'default' => 1,
							'name' => __( 'Depth', 'theme' ),
							'desc' => __( 'Max depth level', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'List of cureent page siblings', 'theme' ),
					'icon' => 'bars'
				),
				// document
				'document' => array(
					'name' => __( 'Document', 'theme' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Url', 'theme' ),
							'desc' => __( 'Url to uploaded document. Supported formats: doc, xls, pdf etc.', 'theme' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Viewer width', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Viewer height', 'theme' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'theme' ),
							'desc' => __( 'Ignore width and height parameters and make viewer responsive', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Document viewer by Google', 'theme' ),
					'icon' => 'file-text'
				),
				// gmap
				'gmap' => array(
					'name' => __( 'Gmap', 'theme' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Map width', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Map height', 'theme' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'theme' ),
							'desc' => __( 'Ignore width and height parameters and make map responsive', 'theme' )
						),
						'address' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Marker', 'theme' ),
							'desc' => __( 'Address for the marker. You can type it in any language', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Maps by Google', 'theme' ),
					'icon' => 'globe'
				),
				// slider
				'slider' => array(
					'name' => __( 'Slider', 'theme' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'theme' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'theme' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'theme' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'theme' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'theme' ),
								'image'      => __( 'Full-size image', 'theme' ),
								'lightbox'   => __( 'Lightbox', 'theme' ),
								'custom'     => __( 'Slide link (added in media editor)', 'theme' ),
								'attachment' => __( 'Attachment page', 'theme' ),
								'post'       => __( 'Post permalink', 'theme' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'theme' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'theme' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'theme' ),
								'blank' => __( 'New window', 'theme' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'theme' ),
							'desc' => __( 'Open links in', 'theme' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'theme' ), 'desc' => __( 'Slider width (in pixels)', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'theme' ), 'desc' => __( 'Slider height (in pixels)', 'theme' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'theme' ),
							'desc' => __( 'Ignore width and height parameters and make slider responsive', 'theme' )
						),
						'title' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show titles', 'theme' ), 'desc' => __( 'Display slide titles', 'theme' )
						),
						'centered' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Center', 'theme' ), 'desc' => __( 'Is slider centered on the page', 'theme' )
						),
						'arrows' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Arrows', 'theme' ), 'desc' => __( 'Show left and right arrows', 'theme' )
						),
						'pages' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Pagination', 'theme' ),
							'desc' => __( 'Show pagination', 'theme' )
						),
						'mousewheel' => array(
							'type' => 'bool',
							'default' => 'yes', 'name' => __( 'Mouse wheel control', 'theme' ),
							'desc' => __( 'Allow to change slides with mouse wheel', 'theme' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'theme' ),
							'desc' => __( 'Choose interval between slide animations. Set to 0 to disable autoplay', 'theme' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'theme' ), 'desc' => __( 'Specify animation speed', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Customizable image slider', 'theme' ),
					'icon' => 'picture-o'
				),
				// carousel
				'carousel' => array(
					'name' => __( 'Carousel', 'theme' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'theme' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'theme' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'theme' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'theme' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'theme' ),
								'image'      => __( 'Full-size image', 'theme' ),
								'lightbox'   => __( 'Lightbox', 'theme' ),
								'custom'     => __( 'Slide link (added in media editor)', 'theme' ),
								'attachment' => __( 'Attachment page', 'theme' ),
								'post'       => __( 'Post permalink', 'theme' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'theme' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'theme' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'theme' ),
								'blank' => __( 'New window', 'theme' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'theme' ),
							'desc' => __( 'Open links in', 'theme' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 100,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Carousel width (in pixels)', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 20,
							'max' => 1600,
							'step' => 20,
							'default' => 100,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Carousel height (in pixels)', 'theme' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'theme' ),
							'desc' => __( 'Ignore width and height parameters and make carousel responsive', 'theme' )
						),
						'items' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Items to show', 'theme' ),
							'desc' => __( 'How much carousel items is visible', 'theme' )
						),
						'scroll' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1, 'default' => 1,
							'name' => __( 'Scroll number', 'theme' ),
							'desc' => __( 'How much items are scrolled in one transition', 'theme' )
						),
						'title' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show titles', 'theme' ), 'desc' => __( 'Display titles for each item', 'theme' )
						),
						'centered' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Center', 'theme' ), 'desc' => __( 'Is carousel centered on the page', 'theme' )
						),
						'arrows' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Arrows', 'theme' ), 'desc' => __( 'Show left and right arrows', 'theme' )
						),
						'pages' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Pagination', 'theme' ),
							'desc' => __( 'Show pagination', 'theme' )
						),
						'mousewheel' => array(
							'type' => 'bool',
							'default' => 'yes', 'name' => __( 'Mouse wheel control', 'theme' ),
							'desc' => __( 'Allow to rotate carousel with mouse wheel', 'theme' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'theme' ),
							'desc' => __( 'Choose interval between auto animations. Set to 0 to disable autoplay', 'theme' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'theme' ), 'desc' => __( 'Specify animation speed', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Customizable image carousel', 'theme' ),
					'icon' => 'picture-o'
				),
				// custom_gallery
				'custom_gallery' => array(
					'name' => __( 'Gallery', 'theme' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'theme' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'theme' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'theme' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'theme' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'theme' ),
								'image'      => __( 'Full-size image', 'theme' ),
								'lightbox'   => __( 'Lightbox', 'theme' ),
								'custom'     => __( 'Slide link (added in media editor)', 'theme' ),
								'attachment' => __( 'Attachment page', 'theme' ),
								'post'       => __( 'Post permalink', 'theme' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'theme' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'theme' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'theme' ),
								'blank' => __( 'New window', 'theme' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'theme' ),
							'desc' => __( 'Open links in', 'theme' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 90,
							'name' => __( 'Width', 'theme' ), 'desc' => __( 'Single item width (in pixels)', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 90,
							'name' => __( 'Height', 'theme' ), 'desc' => __( 'Single item height (in pixels)', 'theme' )
						),
						'title' => array(
							'type' => 'select',
							'values' => array(
								'never' => __( 'Never', 'theme' ),
								'hover' => __( 'On mouse over', 'theme' ),
								'always' => __( 'Always', 'theme' )
							),
							'default' => 'hover',
							'name' => __( 'Show titles', 'theme' ),
							'desc' => __( 'Title display mode', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Customizable image gallery', 'theme' ),
					'icon' => 'picture-o'
				),
				// posts
				'posts' => array(
					'name' => __( 'Posts', 'theme' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'template' => array(
							'default' => 'templates/default-loop.php', 'name' => __( 'Template', 'theme' ),
							'desc' => __( '<b>Do not change this field value if you do not understand description below.</b><br/>Relative path to the template file. Default templates is placed under the plugin directory (templates folder). You can copy it under your theme directory and modify as you want. You can use following default templates that already available in the plugin directory:<br/><b%value>templates/default-loop.php</b> - posts loop<br/><b%value>templates/teaser-loop.php</b> - posts loop with thumbnail and title<br/><b%value>templates/single-post.php</b> - single post template<br/><b%value>templates/list-loop.php</b> - unordered list with posts titles', 'theme' )
						),
						'id' => array(
							'default' => '',
							'name' => __( 'Post ID\'s', 'theme' ),
							'desc' => __( 'Enter comma separated ID\'s of the posts that you want to show', 'theme' )
						),
						'posts_per_page' => array(
							'type' => 'number',
							'min' => -1,
							'max' => 10000,
							'step' => 1,
							'default' => get_option( 'posts_per_page' ),
							'name' => __( 'Posts per page', 'theme' ),
							'desc' => __( 'Specify number of posts that you want to show. Enter -1 to get all posts', 'theme' )
						),
						'post_type' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => mom_su_Tools::get_types(),
							'default' => 'post',
							'name' => __( 'Post types', 'theme' ),
							'desc' => __( 'Select post types. Hold Ctrl key to select multiple post types', 'theme' )
						),
						'taxonomy' => array(
							'type' => 'select',
							'values' => mom_su_Tools::get_taxonomies(),
							'default' => 'category',
							'name' => __( 'Taxonomy', 'theme' ),
							'desc' => __( 'Select taxonomy to show posts from', 'theme' )
						),
						'tax_term' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => mom_su_Tools::get_terms( 'category' ),
							'default' => '',
							'name' => __( 'Terms', 'theme' ),
							'desc' => __( 'Select terms to show posts from', 'theme' )
						),
						'tax_operator' => array(
							'type' => 'select',
							'values' => array( 'IN', 'NOT IN', 'AND' ),
							'default' => 'IN', 'name' => __( 'Taxonomy term operator', 'theme' ),
							'desc' => __( 'IN - posts that have any of selected categories terms<br/>NOT IN - posts that is does not have any of selected terms<br/>AND - posts that have all selected terms', 'theme' )
						),
						// 'author' => array(
						// 	'type' => 'select',
						// 	'multiple' => true,
						// 	'values' => mom_su_Tools::get_users(),
						// 	'default' => 'default',
						// 	'name' => __( 'Authors', 'theme' ),
						// 	'desc' => __( 'Choose the authors whose posts you want to show. Enter here comma-separated list of users (IDs). Example: 1,7,18', 'theme' )
						// ),
						'author' => array(
							'default' => '',
							'name' => __( 'Authors', 'theme' ),
							'desc' => __( 'Enter here comma-separated list of author\'s IDs. Example: 1,7,18', 'theme' )
						),
						'meta_key' => array(
							'default' => '',
							'name' => __( 'Meta key', 'theme' ),
							'desc' => __( 'Enter meta key name to show posts that have this key', 'theme' )
						),
						'offset' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 1, 'default' => 0,
							'name' => __( 'Offset', 'theme' ),
							'desc' => __( 'Specify offset to start posts loop not from first post', 'theme' )
						),
						'order' => array(
							'type' => 'select',
							'values' => array(
								'desc' => __( 'Descending', 'theme' ),
								'asc' => __( 'Ascending', 'theme' )
							),
							'default' => 'DESC',
							'name' => __( 'Order', 'theme' ),
							'desc' => __( 'Posts order', 'theme' )
						),
						'orderby' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'theme' ),
								'id' => __( 'Post ID', 'theme' ),
								'author' => __( 'Post author', 'theme' ),
								'title' => __( 'Post title', 'theme' ),
								'name' => __( 'Post slug', 'theme' ),
								'date' => __( 'Date', 'theme' ), 'modified' => __( 'Last modified date', 'theme' ),
								'parent' => __( 'Post parent', 'theme' ),
								'rand' => __( 'Random', 'theme' ), 'comment_count' => __( 'Comments number', 'theme' ),
								'menu_order' => __( 'Menu order', 'theme' ), 'meta_value' => __( 'Meta key values', 'theme' ),
							),
							'default' => 'date',
							'name' => __( 'Order by', 'theme' ),
							'desc' => __( 'Order posts by', 'theme' )
						),
						'post_parent' => array(
							'default' => '',
							'name' => __( 'Post parent', 'theme' ),
							'desc' => __( 'Show childrens of entered post (enter post ID)', 'theme' )
						),
						'post_status' => array(
							'type' => 'select',
							'values' => array(
								'publish' => __( 'Published', 'theme' ),
								'pending' => __( 'Pending', 'theme' ),
								'draft' => __( 'Draft', 'theme' ),
								'auto-draft' => __( 'Auto-draft', 'theme' ),
								'future' => __( 'Future post', 'theme' ),
								'private' => __( 'Private post', 'theme' ),
								'inherit' => __( 'Inherit', 'theme' ),
								'trash' => __( 'Trashed', 'theme' ),
								'any' => __( 'Any', 'theme' ),
							),
							'default' => 'publish',
							'name' => __( 'Post status', 'theme' ),
							'desc' => __( 'Show only posts with selected status', 'theme' )
						),
						'ignore_sticky_posts' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Ignore sticky', 'theme' ),
							'desc' => __( 'Select Yes to ignore posts that is sticked', 'theme' )
						)
					),
					'desc' => __( 'Custom posts query with customizable template', 'theme' ),
					'icon' => 'th-list'
				),
				// dummy_text
				'dummy_text' => array(
					'name' => __( 'Dummy text', 'theme' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'what' => array(
							'type' => 'select',
							'values' => array(
								'paras' => __( 'Paragraphs', 'theme' ),
								'words' => __( 'Words', 'theme' ),
								'bytes' => __( 'Bytes', 'theme' ),
							),
							'default' => 'paras',
							'name' => __( 'What', 'theme' ),
							'desc' => __( 'What to generate', 'theme' )
						),
						'amount' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Amount', 'theme' ),
							'desc' => __( 'How many items (paragraphs or words) to generate. Minimum words amount is 5', 'theme' )
						),
						'cache' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Cache', 'theme' ),
							'desc' => __( 'Generated text will be cached. Be careful with this option. If you disable it and insert many dummy_text shortcodes the page load time will be highly increased', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Text placeholder', 'theme' ),
					'icon' => 'text-height'
				),
				// dummy_image
				'dummy_image' => array(
					'name' => __( 'Dummy image', 'theme' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'width' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 500,
							'name' => __( 'Width', 'theme' ),
							'desc' => __( 'Image width', 'theme' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 300,
							'name' => __( 'Height', 'theme' ),
							'desc' => __( 'Image height', 'theme' )
						),
						'theme' => array(
							'type' => 'select',
							'values' => array(
								'any'       => __( 'Any', 'theme' ),
								'abstract'  => __( 'Abstract', 'theme' ),
								'animals'   => __( 'Animals', 'theme' ),
								'business'  => __( 'Business', 'theme' ),
								'cats'      => __( 'Cats', 'theme' ),
								'city'      => __( 'City', 'theme' ),
								'food'      => __( 'Food', 'theme' ),
								'nightlife' => __( 'Night life', 'theme' ),
								'fashion'   => __( 'Fashion', 'theme' ),
								'people'    => __( 'People', 'theme' ),
								'nature'    => __( 'Nature', 'theme' ),
								'sports'    => __( 'Sports', 'theme' ),
								'technics'  => __( 'Technics', 'theme' ),
								'transport' => __( 'Transport', 'theme' )
							),
							'default' => 'any',
							'name' => __( 'Theme', 'theme' ),
							'desc' => __( 'Select the theme for this image', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Image placeholder with random image', 'theme' ),
					'icon' => 'picture-o'
				),
				// animate
				'animate' => array(
					'name' => __( 'Animation', 'theme' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array_combine( self::animations(), self::animations() ),
							'default' => 'bounceIn',
							'name' => __( 'Animation', 'theme' ),
							'desc' => __( 'Select animation type', 'theme' )
						),
						'duration' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 1,
							'name' => __( 'Duration', 'theme' ),
							'desc' => __( 'Animation duration (seconds)', 'theme' )
						),
						'delay' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 0,
							'name' => __( 'Delay', 'theme' ),
							'desc' => __( 'Animation delay (seconds)', 'theme' )
						),
						'inline' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Inline', 'theme' ),
							'desc' => __( 'This parameter determines what HTML tag will be used for animation wrapper. Turn this option to YES and animated element will be wrapped in SPAN instead of DIV. Useful for inline animations, like buttons', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'content' => __( 'Animated content', 'theme' ),
					'desc' => __( 'Wrapper for animation. Any nested element will be animated', 'theme' ),
					'example' => 'animations',
					'icon' => 'bolt'
				),
				// meta
				'meta' => array(
					'name' => __( 'Meta', 'theme' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'key' => array(
							'default' => '',
							'name' => __( 'Key', 'theme' ),
							'desc' => __( 'Meta key name', 'theme' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'theme' ),
							'desc' => __( 'This text will be shown if data is not found', 'theme' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'theme' ),
							'desc' => __( 'This content will be shown before the value', 'theme' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'theme' ),
							'desc' => __( 'This content will be shown after the value', 'theme' )
						),
						'post_id' => array(
							'default' => '',
							'name' => __( 'Post ID', 'theme' ),
							'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'theme' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'theme' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'theme' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'Post meta', 'theme' ),
					'icon' => 'info-circle'
				),
				// user
				'user' => array(
					'name' => __( 'User', 'theme' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'field' => array(
							'type' => 'select',
							'values' => array(
								'display_name'        => __( 'Display name', 'theme' ),
								'ID'                  => __( 'ID', 'theme' ),
								'user_login'          => __( 'Login', 'theme' ),
								'user_nicename'       => __( 'Nice name', 'theme' ),
								'user_email'          => __( 'Email', 'theme' ),
								'user_url'            => __( 'URL', 'theme' ),
								'user_registered'     => __( 'Registered', 'theme' ),
								'user_activation_key' => __( 'Activation key', 'theme' ),
								'user_status'         => __( 'Status', 'theme' )
							),
							'default' => 'display_name',
							'name' => __( 'Field', 'theme' ),
							'desc' => __( 'User data field name', 'theme' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'theme' ),
							'desc' => __( 'This text will be shown if data is not found', 'theme' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'theme' ),
							'desc' => __( 'This content will be shown before the value', 'theme' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'theme' ),
							'desc' => __( 'This content will be shown after the value', 'theme' )
						),
						'user_id' => array(
							'default' => '',
							'name' => __( 'User ID', 'theme' ),
							'desc' => __( 'You can specify custom user ID. Leave this field empty to use an ID of the current user', 'theme' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'theme' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'theme' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'User data', 'theme' ),
					'icon' => 'info-circle'
				),
				// post
				'post' => array(
					'name' => __( 'Post', 'theme' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'field' => array(
							'type' => 'select',
							'values' => array(
								'ID'                    => __( 'Post ID', 'theme' ),
								'post_author'           => __( 'Post author', 'theme' ),
								'post_date'             => __( 'Post date', 'theme' ),
								'post_date_gmt'         => __( 'Post date', 'theme' ) . ' GMT',
								'post_content'          => __( 'Post content', 'theme' ),
								'post_title'            => __( 'Post title', 'theme' ),
								'post_excerpt'          => __( 'Post excerpt', 'theme' ),
								'post_status'           => __( 'Post status', 'theme' ),
								'comment_status'        => __( 'Comment status', 'theme' ),
								'ping_status'           => __( 'Ping status', 'theme' ),
								'post_name'             => __( 'Post name', 'theme' ),
								'post_modified'         => __( 'Post modified', 'theme' ),
								'post_modified_gmt'     => __( 'Post modified', 'theme' ) . ' GMT',
								'post_content_filtered' => __( 'Filtered post content', 'theme' ),
								'post_parent'           => __( 'Post parent', 'theme' ),
								'guid'                  => __( 'GUID', 'theme' ),
								'menu_order'            => __( 'Menu order', 'theme' ),
								'post_type'             => __( 'Post type', 'theme' ),
								'post_mime_type'        => __( 'Post mime type', 'theme' ),
								'comment_count'         => __( 'Comment count', 'theme' )
							),
							'default' => 'post_title',
							'name' => __( 'Field', 'theme' ),
							'desc' => __( 'Post data field name', 'theme' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'theme' ),
							'desc' => __( 'This text will be shown if data is not found', 'theme' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'theme' ),
							'desc' => __( 'This content will be shown before the value', 'theme' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'theme' ),
							'desc' => __( 'This content will be shown after the value', 'theme' )
						),
						'post_id' => array(
							'default' => '',
							'name' => __( 'Post ID', 'theme' ),
							'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'theme' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'theme' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'theme' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'Post data', 'theme' ),
					'icon' => 'info-circle'
				),
				// post_terms
				// 'post_terms' => array(
				// 	'name' => __( 'Post terms', 'theme' ),
				// 	'type' => 'single',
				// 	'group' => 'data',
				// 	'atts' => array(
				// 		'post_id' => array(
				// 			'default' => '',
				// 			'name' => __( 'Post ID', 'theme' ),
				// 			'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'theme' )
				// 		),
				// 		'links' => array(
				// 			'type' => 'bool',
				// 			'default' => 'yes',
				// 			'name' => __( 'Show links', 'theme' ),
				// 			'desc' => __( 'Show terms names as hyperlinks', 'theme' )
				// 		),
				// 		'format' => array(
				// 			'type' => 'select',
				// 			'values' => array(
				// 				'text' => __( 'Terms separated by commas', 'theme' ),
				// 				'br' => __( 'Terms separated by new lines', 'theme' ),
				// 				'ul' => __( 'Unordered list', 'theme' ),
				// 				'ol' => __( 'Ordered list', 'theme' ),
				// 			),
				// 			'default' => 'text',
				// 			'name' => __( 'Format', 'theme' ),
				// 			'desc' => __( 'Choose how to output the terms', 'theme' )
				// 		),
				// 	),
				// 	'desc' => __( 'Terms list', 'theme' ),
				// 	'icon' => 'info-circle'
				// ),
				// template
				'template' => array(
					'name' => __( 'Template', 'theme' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'name' => array(
							'default' => '',
							'name' => __( 'Template name', 'theme' ),
							'desc' => sprintf( __( 'Use template file name (with optional .php extension). If you need to use templates from theme sub-folder, use relative path. Example values: %s, %s, %s', 'theme' ), '<b%value>page</b>', '<b%value>page.php</b>', '<b%value>includes/page.php</b>' )
						)
					),
					'desc' => __( 'Theme template', 'theme' ),
					'icon' => 'puzzle-piece'
				),
				// qrcode
				'qrcode' => array(
					'name' => __( 'QR code', 'theme' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'data' => array(
							'default' => '',
							'name' => __( 'Data', 'theme' ),
							'desc' => __( 'The text to store within the QR code. You can use here any text or even URL', 'theme' )
						),
						'title' => array(
							'default' => '',
							'name' => __( 'Title', 'theme' ),
							'desc' => __( 'Enter here short description. This text will be used in alt attribute of QR code', 'theme' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1000,
							'step' => 10,
							'default' => 200,
							'name' => __( 'Size', 'theme' ),
							'desc' => __( 'Image width and height (in pixels)', 'theme' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 50,
							'step' => 5,
							'default' => 0,
							'name' => __( 'Margin', 'theme' ),
							'desc' => __( 'Thickness of a margin (in pixels)', 'theme' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'theme' ),
								'left' => __( 'Left', 'theme' ),
								'center' => __( 'Center', 'theme' ),
								'right' => __( 'Right', 'theme' ),
							),
							'default' => 'none',
							'name' => __( 'Align', 'theme' ),
							'desc' => __( 'Choose image alignment', 'theme' )
						),
						'link' => array(
							'default' => '',
							'name' => __( 'Link', 'theme' ),
							'desc' => __( 'You can make this QR code clickable. Enter here the URL', 'theme' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open link in same window/tab', 'theme' ),
								'blank' => __( 'Open link in new window/tab', 'theme' ),
							),
							'default' => 'blank',
							'name' => __( 'Link target', 'theme' ),
							'desc' => __( 'Select link target', 'theme' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#000000',
							'name' => __( 'Primary color', 'theme' ),
							'desc' => __( 'Pick a primary color', 'theme' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#ffffff',
							'name' => __( 'Background color', 'theme' ),
							'desc' => __( 'Pick a background color', 'theme' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'theme' ),
							'desc' => __( 'Extra CSS class', 'theme' )
						)
					),
					'desc' => __( 'Advanced QR code generator', 'theme' ),
					'icon' => 'qrcode'
				),
				// scheduler
				'scheduler' => array(
					'name' => __( 'Scheduler', 'theme' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'time' => array(
							'default' => '',
							'name' => __( 'Time', 'theme' ),
							'desc' => sprintf( __( 'In this field you can specify one or more time ranges. Every day at this time the content of shortcode will be visible. %s %s %s - show content from 9:00 to 18:00 %s - show content from 9:00 to 13:00 and from 14:00 to 18:00 %s - example with minutes (content will be visible each day, 45 minutes) %s - example with seconds', 'theme' ), '<br><br>', __( 'Examples (click to set)', 'theme' ), '<br><b%value>9-18</b>', '<br><b%value>9-13, 14-18</b>', '<br><b%value>9:30-10:15</b>', '<br><b%value>9:00:00-17:59:59</b>' )
						),
						'days_week' => array(
							'default' => '',
							'name' => __( 'Days of the week', 'theme' ),
							'desc' => sprintf( __( 'In this field you can specify one or more days of the week. Every week at these days the content of shortcode will be visible. %s 0 - Sunday %s 1 - Monday %s 2 - Tuesday %s 3 - Wednesday %s 4 - Thursday %s 5 - Friday %s 6 - Saturday %s %s %s - show content from Monday to Friday %s - show content only at Sunday %s - show content at Sunday and from Wednesday to Friday', 'theme' ), '<br><br>', '<br>', '<br>', '<br>', '<br>', '<br>', '<br>', '<br><br>', __( 'Examples (click to set)', 'theme' ), '<br><b%value>1-5</b>', '<br><b%value>0</b>', '<br><b%value>0, 3-5</b>' )
						),
						'days_month' => array(
							'default' => '',
							'name' => __( 'Days of the month', 'theme' ),
							'desc' => sprintf( __( 'In this field you can specify one or more days of the month. Every month at these days the content of shortcode will be visible. %s %s %s - show content only at first day of month %s - show content from 1th to 5th %s - show content from 10th to 15th and from 20th to 25th', 'theme' ), '<br><br>', __( 'Examples (click to set)', 'theme' ), '<br><b%value>1</b>', '<br><b%value>1-5</b>', '<br><b%value>10-15, 20-25</b>' )
						),
						'months' => array(
							'default' => '',
							'name' => __( 'Months', 'theme' ),
							'desc' => sprintf( __( 'In this field you can specify the month or months in which the content will be visible. %s %s %s - show content only in January %s - show content from February to June %s - show content in January, March and from May to July', 'theme' ), '<br><br>', __( 'Examples (click to set)', 'theme' ), '<br><b%value>1</b>', '<br><b%value>2-6</b>', '<br><b%value>1, 3, 5-7</b>' )
						),
						'years' => array(
							'default' => '',
							'name' => __( 'Years', 'theme' ),
							'desc' => sprintf( __( 'In this field you can specify the year or years in which the content will be visible. %s %s %s - show content only in 2014 %s - show content from 2014 to 2016 %s - show content in 2014, 2018 and from 2020 to 2022', 'theme' ), '<br><br>', __( 'Examples (click to set)', 'theme' ), '<br><b%value>2014</b>', '<br><b%value>2014-2016</b>', '<br><b%value>2014, 2018, 2020-2022</b>' )
						),
						'alt' => array(
							'default' => '',
							'name' => __( 'Alternative text', 'theme' ),
							'desc' => __( 'In this field you can type the text which will be shown if content is not visible at the current moment', 'theme' )
						)
					),
					'content' => __( 'Scheduled content', 'theme' ),
					'desc' => __( 'Allows to show the content only at the specified time period', 'theme' ),
					'note' => __( 'This shortcode allows you to show content only at the specified time.', 'theme' ) . '<br><br>' . __( 'Please pay special attention to the descriptions, which are located below each text field. It will save you a lot of time', 'theme' ) . '<br><br>' . __( 'By default, the content of this shortcode will be visible all the time. By using fields below, you can add some limitations. For example, if you type 1-5 in the Days of the week field, content will be only shown from Monday to Friday. Using the same principles, you can limit content visibility from years to seconds.', 'theme' ),
					'icon' => 'clock-o'
				),
*/
			) );
		// Return result
		return ( is_string( $shortcode ) ) ? $shortcodes[sanitize_text_field( $shortcode )] : $shortcodes;
	}
}

class mom_shortcodes_ultimate_Data extends mom_su_Data {
	function __construct() {
		parent::__construct();
	}
}
