=== BuddyBoss Wall ===
Contributors: buddyboss
Requires at least: 3.8
Tested up to: 4.7.2
Stable tag: 1.3.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Get the power of Facebook on BuddyPress! Your users can post Wall updates, interact with their friends, and "Like" their favorite content.

== Description ==

Turn your BuddyPress activity stream into a super interactive "Wall" that your users will instantly understand how to use after years of experience on Facebook. Let your users write on each other’s Walls and "Like" each other’s posts. Add user photo uploading with our tightly integrated BuddyBoss Media plugin.

== Installation ==

1. Make sure BuddyPress is activated.
2. Visit 'Plugins > Add New'
3. Click 'Upload Plugin'
4. Upload the file 'buddyboss-wall.zip'
5. Activate BuddyBoss Wall from your Plugins page.

= Configuration =

1. Enable 'Activity Streams' at 'Settings > BuddyPress > Components'
2. Visit 'Settings > BuddyBoss Wall' and select your desired options.

== Changelog ==

= 1.3.1 =
* Fix - Activity pagination not working on "load more"

= 1.3.0 =
* Fix - Incorrect slug when News Feed is set as default Wall tab
* Fix - Invalid regular expression at /includes/wall-hooks.php
* Fix - Formatting with site preview in activity streams
* Fix - Sitewide Activity Stream not visible if News Feed is selected from Settings
* Fix - On activity page when clicking on groups or mentions leads to a 404 error
* Fix - The hover response when multiple people like something not working correctly
* Fix - The Widget "Most Liked Activity" is not displaying for all the users on BuddyPress pages
* Fix - PHP notices
* Localization - Russian translations updated, credits to Airat Halitov

= 1.2.7 =
* Tweak - Word cap on meta description being pulled automatically with preview url
* Fix - Liked content notification not clearing
* Fix - 404 error on Wall when News Feed is set as default 
* Fix - Admin notice added when Activity component is not active
* Fix - Show admin notice if BuddyPress is not active
* Fix - PHP notices
* Fix - Deleting activity post, the attached images should be deleted
* Fix - Not able to translate the primary member profile "wall" label
* Fix - Better method for loading FontAwesome

= 1.2.6 =
* New - Added Notification for Liked Content
* Tweak - Moved settings tab into BuddyBoss menu
* Tweak - Added Fontawesome handle
* Fix - Warning: Invalid argument supplied for foreach
* Fix - BP Reorder Tabs conflict
* Fix - Privacy buttons setting not working after changing navigation tab
* Fix - Duplicate notifications
* Fix - Multiple post like notifications
* Fix - Show activity action if content is empty in notification
* Fix - Initially setting privacy should default to Everyone if not set
* Fix - Minor CSS issues

= 1.2.5 =
* Fix - missing translations
* Fix - disable photo upload button when posted link has image
* Fix - Like text and media upload button disable issue

= 1.2.4 =
* Bug fix: "Error getting likes"
* Added nofollow for embedded link content
* CSS fix for reply

= 1.2.3 =
* Switched to new Updater system
* Standard readme.txt format
* Added setting for Activity Like text
* Added setting to disable the Everyone privacy option
* Added setting to toggle the default Wall tab to News Feed
* Bug fix: out of memory error while displaying any member list
* Bug fix: some members displaying no activity

= 1.2.2 =
* Fixed friend's private/hidden group activity from showing up on the news-feed

= 1.2.1 =
* New admin option to disable URL previews
* Prevent URL preview from interfering with popular oEmbed providers
* URL preview images now link to website rather than image path in uploads directory
* URL preview links now open in new tab
* Fixed issues with decoding unusual characters in URL preview title
* Improved URL preview styling
* Improved the "Cancel" button in URL preview
* Removed privacy options for activity posts under private/hidden groups
* Replace 'Favorite' with 'Like' everywhere except when the textdomain is bbPress
* Fixed activity post text option for multisite
* Fixed issues with wall posting when Friends Component is disabled

= 1.2.0 =
* Admin option to choose between "You" or [username] for Wall posts
* Option to not use an image in URL preview (close button)
* Swedish translations updated, credits to Anton Andreasson
* URL preview image size optimization
* Fixed like and comment on replies formatting

= 1.1.9 =
* Posted link auto-loads thumbnail and excerpt from website
* Fixed Private Groups not displaying in News Feed
* Fixed Most Liked Activity widget omitting Activity with more than 9 Likes
* Removed error notices

= 1.1.8 =
* Added French language files, credits to Jean-Pierre Michaud
* Fixed Most Liked Widget not displaying
* Fixed language translation issues
* Fixed "My likes" tab count
* Removed incorrect error message when Friends Component is disabled
* Removed incorrect update notice on Multisite
* Patched XSS security vulnerability

= 1.1.7 =
* Fixed post syntax when posting on other user's Wall
* Better directory path logic for multisite

= 1.1.6 =
* Better support for Multisite activation

= 1.1.5 =
* Updated Italian language files, credits to Massimiliano Napoli
* Fixed slow query on Members directory with privacy enabled
* Added support for custom user-meta tables

= 1.1.4 =
* Added "Group Members" privacy filter for old posts in Groups

= 1.1.3 =
* Added Privacy filters for activity posts
* Added Italian language files, credits to Massimiliano Napoli
* Fixed "Load More" duplicate post display issue
* Fixed translation issue for "wrote on" and "mentioned"

= 1.1.2 =
* Adding quick link to "Settings" in plugin list
* Fixed double timestamp bug when posting into Groups

= 1.1.1 =
* Added body class "buddyboss-wall-active" for custom styling

= 1.1.0 =
* @mention Notifications now link to Mentions tab on Activity index

= 1.0.9 =
* Fixed Friend activity in the News Feed
* Fixed Group activity in the News Feed

= 1.0.8 =
* Fixed Notifications in WordPress Toolbar not clearing when clicked
* Fixed News Feed errors when BuddyPress Friends Compontent is disabled
* Fixed Wall post replies overriding the original poster
* Fixed conflict with "Bump to Top" plugin
* Improved photo upload text on Members directory

= 1.0.7 =
* Fixed replies showing 'Error getting likes'
* Fixed replies showing 'Like' link when logged out
* Fixed certain timestamps not displaying hyperlink
* Fixed Group activity text structure
* Fixed Like text getting removed when liking/unliking a parent activity
* Fixed 'Favorites' translation on Activity index 'My Likes' tab
* Fixed user mentioning another user displaying that they mentioned themself

= 1.0.6 =
* Fixed 'My Likes' tab disappearing on main Activity index

= 1.0.5 =
* Fixed plugin update 'version details' conflict (for future updates)
* Removed question mark from "Write something to Username?"
* Added translations for BuddyBoss Wall admin settings page
* Added empty index.php file to prevent bots from viewing contents

= 1.0.4 =
* The Wall, News Feed, and My Likes tabs are now translatable
* Now displaying 'Deleted User' text in activity post if user deletes account
* Fixed errors on Activity page in WordPress admin
* Rewrote wall input filter function, fixed issues with wall posts and user mentions

= 1.0.3 =
* Fixed %INITIATOR% wrote on %TARGET% wall bug
* Fixed post conflict with rtMedia plugin
* Updated Russian language files, credits to Ivan Dyakov

= 1.0.2 =
* Fixed "What's New" text showing the wrong group name in post form
* Changed "Like" button default title attribute to "Like this"
* Added translation for title attribute of "Like" button
* Added translations for Wall, News Feed, My Likes tabs

= 1.0.1 =
* You can now "Like" replies to activity posts
* Updated Swedish translations, credits to Anton Andreasson
* Fixed blank subnav appearing on first Like
* Fixed Like button causing 'Mentions' tab to double in height and width

= 1.0.0 =
* Initial Release
* Post content to other user's profiles
* See a "News Feed" from your friends and groups
* "Like" your favorite content
* "Most Liked Activity" widget
