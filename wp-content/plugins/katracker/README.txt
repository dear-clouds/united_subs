=== KaTracker ===
Contributors: xnicoco
Tags: media, torrent, file, tracker
Requires at least: 3.0.1
Tested up to: 4.5
Stable tag: 2.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The only full and all powerful, complete bittorrent tracker and torrent file management integration for wordpress.

== Description ==

A complete bittorrent tracker and torrent management integration for wordpress, make a bittorrent tracker within 5 minutes!
The tracker engine is based uppon the mysql version of peertracker (https://github.com/JonnyJD/peertracker), and was changed to match wordpress standards and functions.
The plugin includes as well as tracker functionality, a torrent management system for wordpress, allowing to upload and manage torrent files inside wordpress directly.
Due to wordpress limitations the cleanup system works hourly (without an option to change) for now.

= Main Features =
* Upload and manage torrent files
* Use a private tracker wich tracks only torrents uploaded to it, or an open tracker that tracks every torrent announced to it.
* Use shortcodes to include a torrent in post, or to list all torrents available
* Recent torrent widget
* Torrent thumbnails
* And more.

= For Theme Developers =
* an option to include your own implementation and css of the widget and the shortcode in your theme directory.

= License Notes =
* This plugin is offered for free, and I put a lot of efforts to make it a really good solution. The only thing I ask is if you can link back in a review and show me what you've done with it (you don't have to, but I'll appreciate it). That way I'll see how it is used and will know how to improve it, and also be a little bit proud of my work :)
* Most of the tracker is licensed under GPLv2 License, but the tracker core and the torrent file class are licensed under GPLv3 or later license.
I've included that license file as well as GPLv3 in the main plugin directory, and added a special notes in the header of every file using that license.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/katracker` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings-)Katracker screen to configure the tracker and torrent management settings
Note that torrents view best in list view and not in grid view.

= Requirements =
* php 5.3 or later

= View uploaded torrents =
To view a single torrent use the [torrent] shortcode, you can tweak the shortcode with the following attributes:
<ul><li>id=(torrent id) *required</li>
<li>stats=(1 or 0, shows torrent stats)</li>
<li>files=(1 or 0, shows a torrent file list)</li></ul>

To view a list of uploaded torrents, use the [torrents] shortcode:

<ul><li>id=(list of torrent ids seperated by commas)</li>
<li>category=(if set, lists the torrents in a specific category, otherwise lists all categories)</li>
<li>stats=(1 or 0, shows torrent stats)</li>
<li>files=(1 or 0, shows a torrent file list)</li></ul>
By default shows all enabled torrents.

= For wordpress theme developers =
* If you want to override the widget or the shortcode implementations and stylesheets, don't edit the files in the plugin directory as they will revert every time the plugin is updated. Instead, include in your theme directory a copy of the following files:
* For the widget: katracker-widget.php and katracker-widget.css
* For the shortcode: katracker-shortcode.php and katracker-shortcode.css

== Screenshots ==

1. The torrents view
2.
3. Admin options
4.
5.

== Changelog ==
= 1.0.9 =
* Fixed statistics in admin page
* Minor bug fixes

= 1.0.8 =
* Bug fixes (note to self: do not commit after 2AM)

= 1.0.7 =
* Simplified magnet links support
* Bug fixes and minor improvements

= 1.0.6 =
* Better internationalizing support

= 1.0.5 =
* Shortcodes contain statistics by default now
* Improved shortcodes backend structure

= 1.0.4 =
* Changed filenames, so there is better support to override plugins file in wordpress themes.

= 1.0.3 =
* Fixed seed/peer statistics

= 1.0 =
* First version to see light in wordpress, Hip Hip-Horray!!!

== Upgrade Notice ==
