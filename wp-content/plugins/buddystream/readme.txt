=== BuddyStream ===
Contributors: Blackphantom
Tags: Buddypress, Twitter, Facebook, Flickr, Tweetstream, Facestream,Foursquare,Location, Google+, Soundcloud, Rss, Last.fm, Vimeo, LinkedIn, Buddystream, Apollo, Tumblr, Instagram
Requires at least: WP 2.9.1, BuddyPress 1.2.3
Tested up to: WP 4.5.2 BuddyPress 2.5.3
Stable tag: 3.2.8

== Released under the GPL license ==
http://www.opensource.org/licenses/gpl-license.php

== Description ==

!IMPORTANT!
    Replace your current cronjob for BuddyStream by the new one (see settings -> cronjob)
    The old one is broken.
    Having problems mail me at: blackphantom25@gmail.com
!IMPORTANT

BuddyStream is a BuddyPress plugin that will synchronize all of your favorite Social Networks to the BuddyPress activity stream.

The plugin setup can be hard but tried to keep it easy, operate, and for your members to use.
Each Social Network has its own admin panel where you can see which users are using the network, view cool statistics, and manage the advanced filtering settings.

Networks that the plugin currently supports:

- Instagram
- Twitter
- Flickr
- Youtube
- Last.fm
- Location

Requirements.
- PHP 5.2.1+
- CURL
- JSON
- CRONJOB access

For support and other feature request, please contact me: blackphantom25@gmail.com

== Installation ==
1. Upload this plugin to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Setup the BuddyStream plugin in the admin sidebar.
4. Done!

== Screenshots ==

== ChangeLog ==

= 3.2.8 =
* Upgraded cronjob service
* Updated compatibility with WordPress 4.x
* Updated compatibility with BuddyPress 2.x

= 3.2.7 =
* Upgraded cronjob service
* Updated compatibility with WordPress 4.0
* Updated compatibility with BuddyPress 2.1.1
* Updates css of navbar in admin settings

= 3.2.6 =
* API updates

= 3.2.5 = 
* Updated docs.
* Fixed double imports on some installations.

= 3.2.4 =
* Fixed directory separator for windows installs
* Check compatibility for new WordPress and BuddyPress

= 3.2.3 =
* Fixed error on admin settings page of Twitter
* Added setting to disable location feature. (settings -> general settings)
* Fixed network settings bar to width.
* New clean buttons in user interface in front-end
* Fixed Goolge+ importing settings

= 3.2.2 =
* !IMPORTANT! replace your cronjob command by the new one, the old one is incorrect.
* added Instagram to free version
* fixed bootstrap loading issue

= 3.2.1 =
* added images on Tweets also get imported and shown.
* added setting in "general settings" to disable Buddybox (popup for images and video's)
* fixed import for installs where plugin directory is other then wp-content (cronjob service)
* fixed double remove settings button on Facebook settings
* fixed countdown counter css issues for LinkedIn

= 3.2 =
* fixed countdown counter css issues
* fixed plugin support errors
* fixed import for installs where plugin directory is other then wp-content
* fixed other import issues

= 3.1 =
* replaced colorbox with own version
* added Instagram import
* fixed Twitter imports due SSL change
* error and notices fixed
* updated comparability with wordpress and buddypress

= 3.0.4 =
* Upgraded twitter API to new 1.1
* Error logging for Facebook
* Fixed malformed tokens for Facebook
* Fixed php short tag replacements
* Re-authetication added for expired accounts
* Cleaned-up query's

= 3.0.3 =
* Fixed Twitter import
* Fixed import queue

= 3.0.2 =
* Fixed foreach and statistics pages errors.
* Fixed location button
* Filter out activity plus tags

= 3.0.1 =
* Fixed widget
* Fixed foreach error on Foursquare admin page
* Fixed foreach error on Tumblr admin page

= 3.0 =
* Added manual link per extension
* Added option for disabling the colorbox inclusion.
* Added Thumblr extension.
* Added Foursquare extension.
* Added Location (with map) works with Foursquare and Twitter.
* Added sync central (turn on/off importing/exporting per extension)

* Removed user filters.
* Removed tour (it is now easy enough tot setup)
* Removed ShareBox
* Removed sidewide hiding (caused a lot of issue's)

* Updated new icons
* Updated Twitter API request to use 1.1
* Updated redesign admin interface adn user setting pages.
* Updated all language files

* Fixed imports for windows servers.
* Fixed widget layout.
* Fixed widget settings to not display sub-extensions.
* Fixed Social albums
* Fixed double imports


= 2.6.3.=
* Fixed vulnerability in the ShareBox

= 2.6.2 =
* Improved check for sending out to networks (now no longer conflicts with plugins like activity hashtags)
* Small CSS fix for BuddyPress 1.6 support.
* Fixed stylesheet loading issues
* Removed highcharts grap script, altenative will be implemented in 3.0

= 2.6.1 =
* Fixed power switches in network setting pages.
* Fixed new cronjob url.
* Fixed incorrect path loading for import.

= 2.6 =
* Fixed consistent typo in extensions.
* Fixed fatal error due class loading.
* Fixed typo in support link.
* Fixed correct url to support site.
* Fixed Soundcloud imports (you users need to re-authenticate)

* Added Facebook Wall extension.
* Added Facebook Pages extension.
* Added Facebook Albums extension.
* Added new language files for new Facebook extensions.
* Added better way for loading plugins files.

* Improved content exist check.
* Improved loading of core functionality in imports.

* Removed Google+ javascript due non usage.
* Removed all secondary_id checks and replaced with own.
* Removed activity delete filter since we now use own table for imports

= 2.5.13 =
* Improved cron command line (please update your current cron)
* Fixed link to members page (gave 404 when different then default)
* Fixed Youtube imports
* Fixed network settings link showing up in widget even when network is powered off.
* Fixed disable Facebook imports completely.
* Fixed disable Twitter imports completely.
* Fixed disable LinkedIn imports completely.
* Fixed members directory showing tags ex: #facebook...
* Fixed update always pushed to wall and page even when only page was chosen.

= 2.5.12 =
* Removed update check so plugin wont be downgraded.
* Extended cron with network parameter so multiple crons are possible (add network=THENETWORK) to the cronjob url.
* Prepared core for accepting extensions with parents (to extend other extensions).
* Added check to see if extension exists.
* By default import also items that are rated "friend only" can be turned of in the settings.

= 2.5.11 =
* Fixed php opening tags.
* Fixed error when user does not have Facebook pages.

= 2.5.10 =
* Added general option to turn off all css including of BuddyStream (for complete own css styling)
* ColorBox javascript now only loaded if function does not exist.
* Updated the tour, now includes general settings tab.
* Fixed ShareBox not opening in popup.
* Fixed javascript conflict in wp-admin.
* Fixed javascript undefined variables.
* Fixed RSS filter.
* Fixed RSS stats page.
* Fixed Facebook privacy settings now working.
* Fixed Facebook imports.
* Fixed buttons in interface for Internet Explorer

= 2.5.09 =
* Removed dashboard widget.
* Refactored the filters they are now stable.
* Added css classes to widget for custom styling.
* Fixed cron service license check.
* Import counters calculations are now correct.
* Colorbox integration improvement.

= 2.5.08 =
* Removed usage of simpleXml load from file for several imports.
* Fixed dashboard javascript errors.
* Fixed Flickr not importing photos with no titles
* Fixed issue with imports not importing all items due failure secondary_item_id check (now made unique per user).
* Fixed post to Facebook page(s) button shown when user did revoked authorization.
* Added configurable widget to get your users connecting there social accounts faster.

= 2.5.07 =
* Fixed Facebook video imports.
* Added core functionality to check existing content.
* Removed since => till filter so all items get imported from Facebook.

= 2.5.06 =
* Fixed imports not working due configuration error.

= 2.5.05 = 
* Added Facebook pages select on user settings (user can now choose which pages to sync.)
* Added Facebook albums select on user settings (user can now choose which albums to sync.)
* Added check so non-public items won't be imported anymore. (privacy)
* Fixed Social albums not hiding when albums feature is turned off.

= 2.5.04 =
* Fixed LinkedIn import due change LinkedIn API.
* Fixed Google+ import.
* Fixed general settings page nog saving
* Added turn all on/off buttons on general settings page.
* Added feature to move social albums under profile navigation instead of top-level.

= 2.5.03 =
* Fixed loading issue with .DS_Store file.
* Fixed version tab error.
* Fixed Facebook imports.
* Fixed Twitter username cut-off in items (fix, works only for new items).

= 2.5.02 =
* Added general setting page to turn on/off some features.
* Added extra check to make sure a activity item is not empty.
* Improved ShareBox loading and showing.

* Fixed Twitter usernames in backend.
* Fixed Facebook importing items from friends.
* Fixed Vimeo, Twitter, Facebook import
* Fixed filters
* Fixed loading of the ShareBox

= 2.5.01 =
* Fixed double declared class in certain cases.
* Fixed soundcloud set-up description

= 2.5 =
* Added Vimeo imports.
* Added Google+ imports.
* Added quickstats widget for admin dashboard.
* Added tour option for WordPress 3.3 and higher.
* Added new share buttons and counters.
* Added more core functionality.
* Added Facebook pages sync.
* Added social albums, one page to see all album (cleaner menu's)
* Added social network settings page, one page for all network settings (cleaner menu's)
* Added admin notices when networks are turned on but not yet configured.
* Added buttons to turn all networks on/off with one button.
* Added Sharebox (one pop up box for sharing activity items)

* Fixed problems with max item imports.
* Fixed problems with filters.
* Fixed user album pages.
* Fixed counters (now not counting the added hashtags of BuddyStream)

* Removed separate share buttons (replaced by sharebox) 
* Removed Zend Framework and made it really lightweight.
* Cleaned up activity items styling.
* Ported all networks to new OAuth library.
* Changed the user setting pages for better usability.
* Improved admin css.
* Replaced lightbox library.

* And more we can't remember.