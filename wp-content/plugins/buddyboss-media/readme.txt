=== BuddyBoss Media ===
Contributors: buddyboss
Requires at least: 3.8
Tested up to: 4.4.2
Stable tag: 3.1.9
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Your BuddyPress members can upload photos, organize them into albums, and tag their friends! On a mobile device you can easily swipe through photos with your fingers.

== Description ==

Let your users upload photos into their profiles, from their phones, tablets or laptops. Allow users to upload photos to their friend’s profiles using our tightly integrated BuddyBoss Wall plugin.

== Installation ==

1. Make sure BuddyPress is activated.
2. Visit 'Plugins > Add New'
3. Click 'Upload Plugin'
4. Upload the file 'buddyboss-media.zip'
5. Activate BuddyBoss Media from your Plugins page.

= Configuration =

1. Enable 'Activity Streams' at 'Settings > BuddyPress > Components'
2. Visit 'BuddyBoss > Media' and select your desired options.

== Changelog ==

= 3.1.9 =
* Fix - BP Edit Activity compatibility
* Fix - File uploader is opening twice
* Fix - Photo tag notifications don't clear
* FIx - Version check added for Data Migration

= 3.1.8 = 
* Tweak - Better method for loading FontAwesome
* Fix - Error on photo post deletion
* Fix - Not able to delete album
* Fix - Update message showing twice
* Fix - PHP error notices

= 3.1.7 =
* New - Added Group photo uploading
* New - Added Group photo albums
* Tweak - Tagging with more than 20 friends now displays search box
* Fix - Uploading photos opening upload popup two times
* Fix - Script conflict with BuddyPress cover image
* Fix - Load more button in grid view touching photos
* Fix - Added missing translation strings

= 3.1.6 =
* New - added option to disable Popup Upload Box
* New - bbPress Popup Upload Box added
* Fix - Global photo page grid breaking after changing thumbnail size
* Fix - Lazy image load overlap
* Fix - Database Migrate single image one-by-one

= 3.1.5 =
* New - added Title attributes

= 3.1.4 =
* Fix - mobile rotation fix
* Fix - media uplaod nonce fix
* Fix - clicking read more in activity post makes the uploaded image disappear
* Fix - PHP warnings
* Tweak - Added FontAwesome handle

= 3.1.3 =
* Fix - Original photo gets replaced by comment photo when BP Activity Stream Bump to Top is enabled
* Fix - Old photos not displaying in albums
* Fix - Migration script call for new database table not working

= 3.1.2 =
* Fix - Notifications for tagging
* Tweak - Load 2048px wide photo in desktop version
* Tweak - Hide uploads in background when upload popup is visible

= 3.1.1 =
* New - Option to permanently delete media on photo upload deletion
* Fix - Masonry JS error on album page
* Fix - Global photo page media load
* Fix - PHP undefined index warning
* Fix - Last image shown would be overlayed with +5
* Fix - Do not load image after exceed 4 count
* Fix - Load large image instead full on mobile device
* Fix - Liking a photo in photo overlay, better Ajax update integration
* Fix - PHP warning when grid has more than 4 pics
* Fix - Adding photos to the activity stream photo count is not updated until refresh
* Fix - Comment media is not appearing on global photos
* Fix - Empty photo block is showing for deleted media

= 3.1.0 =
* Fix - bbPress inactive error
* Fix - BuddyPress network activate
* Fix - Photo container img width
* Fix - Preview image height
* Fix - Activity comment upload button not appearing until refresh

= 3.0.9 =
* New - support for bbPress media attachments
* New - support for Activity Reply attachments
* New - masonry photo grid layout
* New - Allow editing media on reply edit
* Fix - php error notices
* Fix - photo overlay wiped after Ajax
* Fix - WP Job Manager upload logo conflict
* Fix - Comment media Ajax not working
* Fix - Add photo button not appearing after loading more activity
* Fix - Update comment count in photoswipe
* Fix - Update reply count on delete
* Fix - Photoswipe on global photos page
* Fix - Image persisting after removal
* Fix - Duplicate images on global photo
* Fix - Mobile device photoswipe count display
* Various CSS fixes
* New updater method
* Standard readme format

= 3.0.8 =
* Fixed bug with Readmore not loading images

= 3.0.7 =
* Fixed error during multisite activation on specific setups

= 3.0.6 =
* Disabled post update button while image is being uploaded
* Enabled post button when uploader popup is closed
* Fixed uploaded image cropping
* Fixed issues with multisite options saving
* Replaced plugin path with constant
* Added BuddyBoss Wall posted text support

= 3.0.5 =
* Updated Swedish translations, credits to Anton Andreasson
* Fixed incorrect album photo counts
* Fixed deleted photos displaying in Global Album activity post layout
* Fixed issue with image sometimes not displaying after upload
* Fixed database migration when using multisite
* Fixed PHP error notices

= 3.0.4 =
* Added "Like" (Favorite) icon to photo overlay
* Added French translations, credits to Jean-Pierre Michaud
* Improved CSS for bulk uploading
* Better theme comptability when tagging friends
* Fixed compatibility issues with Jetpack plugin
* Fixed Wall Photo privacy overriding Album privacy
* Fixed issues when deleting single image from a bulk upload
* Fixed image counts in albums (requires migration script)
* Fixed album creation timestamp
* Removed incorrect admin update notice in multisite
* "Max. Files per Batch" option now only accepts positive values
* Security patch for XSS vulnerability

= 3.0.3 =
* Added comment count in photo overlay
* Better support for Multisite activation

= 3.0.2 =
* Improved layout of 3 image uploads (small images) in activity streams
* Fixed "medium" vs "large" image sizes in activity streams

= 3.0.1 =
* Improved layout of 2 image uploads in activity streams

= 3.0.0 =
* Bulk uploading allows for multiple photo uploads at once
* Bulk uploading displays grouped photos in activity stream
* Removed post form on Photos and Albums pages, replaced with DropZone
* Added Italian translations, credits to Massimiliano Napoli
* Fix for 'bp_is_active' error while upgrading BuddyPress
* Now using jQuery in noConflict mode
* Delete tagging notifications when corresponding photos activities are deleted

= 2.0.8 =
* "Photos" navigation link now displays before "Settings"
* Tagging no longer results in a blank notification
* Plugin loading is now disabled if Activity Component is disabled
* Added missing language translations

= 2.0.7 =
* Removed dependency on BuddyPress' jQuery.cookie library
* Updated FontAwesome to version 4.3

= 2.0.6 =
* Force loading our jQuery cookie, fixes several issues
* When moving photos, dropdown displays album that photo is already in

= 2.0.5 =
* Fixed Javascript conflict with Flyzoo Chat plugin
* When uploading media into a group, activity post now adds link to the group
* Photo count in albums is now updated when photos are deleted

= 2.0.4 =
* Added Delete button to media overlay

= 2.0.3 =
* Display all photos in indexes, including those in albums
* Fixed blank space after clicking "Load More"

= 2.0.2 =
* Fixed layout at 2 column width in Grid view
* Fixed layout of global albums with certain themes

= 2.0.1 =
* Compatibility with photos uploaded in much older versions of BuddyBoss Media
* Fix related to displaying newly posted photos

= 2.0.0 =
* Photo Albums
* Friend Tagging
* Admin option to switch between Grid and Activity view
* Using native "Load More" on photos template
* Code cleanup

= 1.1.1 =
* Admin option to switch between "Medium" and "Full Size" photos in activity

= 1.1.0 =
* Better photo grid spacing
* Adding quick link to "Settings" in plugin list
* Fixed "%USER% posted a photo" text in Members directory

= 1.0.9 =
* More intuitive photo upload interface
* More intuitive Photoswipe icons
* Activity images now using "Medium" media size to reduce clutter
* On your own activity, uploads now say "You posted..."
* Changed activity text from "new picture" to "new photo"

= 1.0.8 =
* Photoswipe heading now displays status update on Photos template
* Photoswipe heading now displays status update on global Photos page

= 1.0.7 =
* Fixed photo uploading in Chrome for iOS and Android
* Fixed photo upload refresh after completion on "Photos > View" template
* PhotoSwipe heading now displays status update, and falls back to upload time/date
* Members directory listing now say 'photo uploaded' when media was user's last update

= 1.0.6 =
* Admin option to enable/disable image rotation fix
* Fixed photo uploads breaking due to server memory limit
* Fixed Heartbeat and Photoswipe conflict
* Fixed activity timestamps not having hyperlinks

= 1.0.5 =
* Fixed plugin update 'version details' conflict (for future updates)
* Added translations for BuddyBoss Media admin settings page
* Added empty index.php file to prevent bots from viewing contents

= 1.0.4 =
* Improved theme compatibility (using plugins.php template)
* Theme widgets now display on user Photos page
* CSS fix, prevents 'Add Photo' button from highlighting during photo upload

= 1.0.3 =
* Fixed image upload disappearing after 10-15 seconds, when BP "heartbeat" initiates

= 1.0.2 =
* Updated FontAwesome to version 4.2
* Updated Russian language files, credits to Ivan Dyakov
* Fixed 'pic_satus' to 'pic_status'

= 1.0.1 =
* New admin option to configure custom user photos template slug.
* New admin option to create a page for displaying all photo uploads from all users.
* Fixed Font Awesome loading over HTTPS for ports other than 443
* Updated Photo grid CSS, for better compatibility with other themes

= 1.0.0 =
* Initial Release
* Post photos to activity streams
* View photos in a mobile-friendly slider
