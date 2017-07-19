=== Calendarize it! for WordPress ===
Author: Alberto Lau (RightHere LLC)
Author URL: http://plugins.righthere.com/calendarize-it/
Tags: WordPress, Calendar, Event, Recurring Events, Arbitrary Recurring Events, Venues, Organizers, jQuery
Requires at least: 3.9
Tested up to: 4.4.2
Stable tag: 4.1.3.69163


== DESCRIPTION ==
Calendarize it! - a powerful Calendar and Event plugin for WordPress.

The main features are: 

- Easy Point and Click interface to add new events
- Preview when entering event in wp-admin (single event)
- Support for Recurring Events
- Show Individual Calendars per user in WordPress- Advanced filtering (Custom Taxonomies)- Sidebar Widget for Upcoming Events
- Sidebar Widget for Mini Calendar - Event List per day, per week, monthly
- Support for Custom Fields for Events- Creating and manage Venues, Organizers and Calendars- Support for Shortcodes - Support for Custom Post Types
- Detailed Event Page- Detailed Venue Page
- Google Map integration for Events and Venues
- Support for internationalization

Lots of free add-ons and paid add-ons. Go to http://calendarize.it for more information. Or view the Downloads section in Calendarize it!

== INSTALLATION ==

1. Upload the 'calendarize-it' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In the menu you will find Calendarize it!. 

When you have installed and activated the plugin you will see a Dashboard notification asking you to enter the license key and download the English Help for Calendarize it! In the Help you will find important information on all major features in the plugin.

You should also review the Get Started menu on http://calendarize.it. It contains examples with all Shortcodes. You will also find advanced arguments that can be used with the shortcodes.


== GET STARTED WITH CALENDARIZE IT! ===

We recommend users to use the Automatic Setup that you will see in the Dashboard after installing and activating Calendarize it!. You can always change the names of the pages that are used as templates afterwards.

If you are looking for a more specialized view than the basic calendar go to http://calendarize.it and check out the many options in the Get Started menu. You will all the shortcodes including the advanced arguments that can be used.

Do not forget to enter your license key in the Options Panel and download the English Help for Calendarize it! You will find very useful information on all major features in Calendarize it! and all the add-ons.


== FREQUENTLY ASKED QUESTIONS ==

If you have any questions or trouble using this plugin you are welcome to contact us through our profile on Codecanyon (http://codecanyon.net/user/RightHere)

Or visit our Help Center at https://righthere.zendesk.com you can also send an email to support@righthere.com.


== CHANGELOG ==
Version 4.1.3.69163 - April 1, 2016
* Update: Add Meta Fields dropdown to the Post Meta Visual Composer Element
* Compatibility Fix: Moose theme and Moose-Child theme. Template name is showing instead of the Event or Taxonomy, and the corresponding troubleshooting option is making the name of the event show in the menu multiple times.
* Compatibility Fix: Events in Month View not translated when using WPML

Version 4.1.2.68720 - March 17, 2016
* New Feature: Added Troubleshooting option to increase the priority of the save_post hook; as a workaround for a case where a third party i crashing on the save_post hook and preventing the calendar to generate required metadata (Events not showing in the calendar, and there is no Javascript error).
* Compatibility Fix: Change classes where the constructor has the same name as the class to __construct (PHP 7 compatibility).
* Bug Fixed: Troubleshooting option to disable update notification for NON Options panel is not working.
* Bug Fixed: Avoid loading micro data for the same event more than once
* Bug Fixed: PHP warning in some sites when inserting the Upcoming Events Widget shortcode
* Bug Fixed: In the Upcoming Events Widget (server mode), when using the words argument, the link is no longer showing. Added filter hook “upcoming_events_description” to allow manipulation of the Upcoming Events description. It passes the following arguments: the modified description, the original excerpt, the word count and the event object.
* Bug Fixed: Calendar crashes on bag timezone settings.
* Update: Automatically add micro data to Event Details Page. Added option to disable automatically adding micro data to the Event Details Page.

Version 4.1.1.68359 - March 2, 2016
* New Feature: When combining the attributes render_events=“0” and month_event_image=“1” the image will be rendered, but not the title or time of the event (or event container)

Version 4.1.0.68239 - February 26, 2016
* Bug Fixed: Emails with a dash in the domain name will not render as links 
* Bug Fixed: Previous version fixes broke drop down behaviour for Event Grid View
* Update: With debug mode on (Troubleshooting), when editing an event, show the count of recurring records
* Update: Repack Javascripts

Version 4.0.9.68173 - February 24, 2016
* Bug Fixed: Adjusted position of Month and Year in mobile view
* Bug Fixed: Remove PHP warnings related to the Single Template Title fix
* Bug Fixed: Events set on April 30, are showing correctly in the Month View, but are displayed on May 1 in the Accordion Upcoming Events Widget. 
* Bug Fixed: When both “Preload Data” and “Single event shows template title instead of event” are set to YES, the events in a Organizer page shows the Organizer name instead of the Event name.
* Bug Fixed: Removed PHP warnings related to rnoe variable not set.
* Bug Fixed: Multiple field labels are not rendering when not placed in a custom details box
* Bug Fixed: When using the Taxonomy drop down in Month View, selecting a taxonomy (term) resets the calendar date
* Bug Fixed: Upcoming Events Widget with date range is not rendering date range
* Bug Fixed: Removed the dash when there is no time set
* Update: Added class field to custom fields layout to allow setting a custom class for the field
* New Feature: Added support for Event Ticket Box in Visual Composer (Requires Event Ticket WooCommerce add-on)
* Update: Minify CSS
* Update: Minify Javascript
* Update: Increase Javascript version

Version 4.0.8.67641 - February 9, 2016
* Bug Fixed: rhc_conditional_content shortcode is not rendering shortcodes (Visual Composer)
* Bug Fixed: February 1, 2016 events not showing when set as ALL DAY
* Bug Fixed: Events set on April 30, are showing correctly in different calendar views, but are rendered as May 1 in the Accordion Upcoming Events Widget
* Bug Fixed: When both preload and “Single event shows template title instead of event” option are set to YES, the events in a Organizer page show the Organizer name instead of the Event name.
* Update: Styling of Social Connection networks updated
* Update: Minify Javascript
* Update: Month View Title in mobile view hiding in some websites
* Update: Minify CSS
* New Feature: Added support for future release of Event Tickets (WooCommerce) add-on for Calendarize it!

Version 4.0.7.67103 - January 28, 2016
* New Feature: Added an option to customize the Events Archive permalink slug. Notice events will render in the order that your theme specifies, most likely not using the event start date, but rather the event publish date.

Version 4.0.7.67060 - January 27, 2016
* Bug Fixed: Disable Event Link on event list is occurring always, should be take place when the option is actually selected
* Update: Minify Javascript
* Update: Update Javascript version

Version 4.0.6.67043 - January 27, 2016
* Bug Fixed: Added a fix for label mapping. Changed a anonymous function to a named function
* Bug Fixed: When disable title option is active, remove the a tag from the event list title and added end time to Event List View (default box)
* Bug Fixed: Tooltip target for links
* Compatibility Fix: In WordPress 4.4 Taxonomy Term meta added with Visual Composer are not showing any values
* Compatibility Fix: Added a troubleshooting button to re-run he WordPress 4.4 taxonomy metadata upgrade (converting old metadata to new format introdced with WordPress 4.4)
* Update: Fixed styling for Social Networks when using RSVP Box (requires RSVP Events add-on)
* Update: Updated Visual Composer templates
* Update: Added _switcher to have only YES/NO or ON/OFF buttons in Options Panel

Version 4.0.5.66384 - January 9, 2016
* Bug Fixed: Added a self rescue procedure where saving an event will remove corrupted (UNTIL) recurring rule data, that prevents both backend and frontend from rendering events
* Bug Fixed: Calendar color not getting applied when the bg color or text color meta field is not set
* Bug Fixed: post_meta_boxes, hide group input type was not working as expected, group was to getting hidden
* Bug Fixed: Google ics feed is generating duplicate records in Calendarize it! when using External Event Sources add-on
* Bug Fixed: ics feed is not parsing correctly at Google calendar when using ampersand in the organizer name
* New Feature: Allow applying default event fields to Custom Post Types other than Events 
* New Feature: Added an option to disable the Visual Composer module (troubleshooting tab)

Version 4.0.4.66173 - December 31, 2015
* New Feature: Added support for Taxonomy Counter Widget. New icons and styles (requires the Taxonomy Counter Widget add-on)
* New Feature: Added support for using the Taxonomy Image as fallback image if the taxonomy image URL field is empty (requires Taxonomy Image add-on)
* Bug Fixed: When not using Week Numbers, the first cell is too wide
* Bug Fixed: Basic Week view on mobile devices is not showing cells belonging to a different month
* Bug Fixed: Issue when viewing an AgendaView on a mobile device
* Bug Fixed: When a recurring event is set, trying to add a arbitrary repeat date will change the recurring date settings
* Bug Fixed: Term Image not showing in Events Map View (dialog). If both term image URL is set and Taxonomy Image is used the Taxonomy Image will take precedence

Version 4.0.3.65917 - December 15, 2015
* Bug Fixed: Server Side Static Events are not taking into consideration the event removal by Event End attribute.
* Bug Fixed: Remove PHP warning from log on WordPress 4.4. Related to old Taxonomy Meta Data prior to WordPress 4.4.
* Bug Fixed: Event Title started to show HTML code in all default views

Version 4.0.2.65881 - December 10, 2015
* Bug Fixed: Encoded characters are showing in calendar views
* Bug Fixed: PHP warning in Taxonomy related to is_custom_taxonomy flag
* Bug Fixed: Clear internal Calendarize it! cache on update, so that fixes that affect cached elements gets applied.
* Compatibility Fix: Added a renounce procedure to copy Term Meta Data to the built in WordPress Term Meta Data released with WordPress 4.4.
* New Feature: Added troubleshooting feature to allow turning OFF all add-ons at once (this is useful if a add-on is causing an error, which results in the user not being able to apply a fix by updating add-ons. By turning off all add-ons the user can go to Downloads and apply any pending updates, and then turn ON the add-ons again).
* New Feature: Added SVG icons for the new Event and Taxonomy Counter Widget add-on.

Version 4.0.1.65768 - December 4, 2015
* Bug Fixed: The Automatic Calendar content option should be ON by default for the native event custom post type 
* Bug Fixed: Hyphen and apostrophe is showing as code in events titles
* Bug Fixed: When Custom Tooltip Details is selected, and the tooltip settings have no fields, it should not display the default Start and End Date. Instead it should not output the content unless the user adds fields.
* Update: Singular label for events custom post type updated.

Version 4.0.0.65729 - December 2, 2015
* New Feature: Added support for the popular Visual Composer plugin. If your theme supports Visual Composer and you have the plugin installed in your website, you can now build your Event Details Box, Venue Details Box and Organizer Details Box layouts with Visual Composer. Choose from 8 bundled layouts or build your own custom layouts choosing from 34 different elements (Visual Composer is NOT bundled with Calendarize it!)
* New Feature: Added support for 16 additional OAuth websites in Social Connection module
New Feature: Added filter rhc_feature_access_capabilities to allow add-ons to add more capabilities to the Feature Access option tab
* Bug Fixed: Google Maps warning about sensor attribute being depreciated
* Bug Fixed: When upcoming only is used, and grid_norepeat, and daily recurring event, the recurring event is not displaying in the Events Grid View
* Bug Fixed: Temporarily disable the GEO field from ics. Google is no longer ignoring the field, instead it fails to load
* Bug Fixed: When mixing an Month View or Week View calendar with Event Grid View in the same page, the event titles gets overwritten in the Month View or Week View when the Event Grid View loads more data
* Bug Fixed: Disabling the automatic elements for event post type is not working
* Bug Fixed: Events Grid View started showing strange data and time format (Events Grid View add-on)
* Compatibility Fix: When using the Metro Pro theme, the canonical URL is wrong and Facebook shares get incorrect page data (debug screen added info about the theme)

Version 3.5.8.64519 - October 31, 2015
* Bug Fixed: Catch a Javascript error where an invalid recurring UNTIL date format will crash the calendar completely
* New Feature: Added feature for selecting different Google Map styles in Options > Template Settings (Requires the free Map Styles for Calendarize it! add-on).

Version 3.5.7.64488 - October 29, 2015
* Bug Fixed: When Events does not have time postmeta detail box field is defaulting to some random field
* Bug Fixed: Crash in debug module

Version 3.5.6.64349 - October 27, 2015
* New Feature: Added the event_click attribute. It takes the following values “fc_click” or “fc_click_no_action”
* Update: Added the event_click option to the Calendarize Shortcode tab in the Options menu.

Version 3.5.5.64307 - October 26, 2015
* New Feature: Added the fixed_title attribute and options or replacing event title (and hiding the time) in Month View.
* Bug Fixed: PHP warning in the recurring events dialog, when the first day option is not set
* Update: Added icons/fonts for additional Social Networks in the Social Connection module

Version 3.5.4.64186 - October 21, 2015
* New Feature: Added support for new attribute render_events. To be used in combination with the Match Background option (month_event_image="0" matchbackground="1” render_events=“0”). This will allow you to create a calendar showing vacant/occupied days.

Version 3.5.3.64178 - October 20, 2015
* Bug Fixed: Remove minimum height for tooltip.
* Compatibility Fix: Single Event Page is showing the Event Template title instead of the actual event title (Moose - Creative Multi-Purpose Theme from Themeforest.net, Item no. 12059290)
* Compatibility Fix: Added support for using Event Top Image from Calendarize it! as background image with event title on single Event Details Page (Moose - Creative Multi-Purpose Theme from Themeforest.net, Item no. 12059290)
* Compatibility Fix: Taxonomy Page is showing the Taxonomy Template title instead of the actual Taxonomy term name (Moose - Creative Multi-Purpose Theme from Themeforest.net, Item no. 12059290)
* Bug Fixed: Javascript error when saving some of the recur rules.

Version 3.5.2.64156 - October 18, 2015
* Bug Fixed: When using Custom Template from options for single event, the description is duplicated
* Bug Fixed: When setting a repeat date and changing the time, the main event times get reset (related to last release of new rrule javascript)

Version 3.5.1.64067 - October 14, 2015
* New Feature: Added separate option for disabling Google MAP API in the frontend and backend
* Update: Added more info to debug screen. 
* Update: Repack JavaScript with new rrule JavaScript
* Update: When using a Taxonomy filter the main calendar element will now have the rho-has-tax-filter class
* Update: Added og:image to single page top image for Facebook sharing
* Update: Added open graph (Facebook) meta data to single pages
* Bug Fixed: Double byte characters (foreign characters) are not correctly encoded in the Accordion Upcoming Events Widget
* Bug Fixed: The Google Map inside the Accordion Upcoming Events Widget is not showing on some sites. Added troubleshooting option to force output of the Google Map libraries.

Version 3.5.0.63809 - October 2, 2015
* Bug Fixed: Event Details Boxes are not showing on Community Events submitted events
* Bug Fixed: Ampersand in certain fields is triggering a php warning in Event Lists
* Bug Fixed: Close icon not showing in the dialog for removing repeat dates and exclude dates
* Bug Fixed: Remove strange animation from metabox dialog

Version: 3.4.9.63724 - September 30, 2015
* Bug Fixed: When the current day shows in the FLAT UI Calendar, but is in another month, the title shows the incorrect month.
* Update: Change the “Ending Hour” label to “At event end” in Upcoming Events Widget settings

Version 3.4.8.63700 - September 29, 2015
* Bug Fixed: Upcoming Events Widget simple list template not catching the date format, and label is incorrect
* Bug Fixed: Upcoming Events Widget, when the event is set to link to ‘none’, the widget was still linking
* Update: Allowing receiving add-on Payments with Bitcoins and Alipay through Stripe.com.

Version 3.4.7.63575 - September 25, 2015
* Update: Test if the PHP version is too older template functions to avoid PHP crash on websites with pre PHP 5.3.
* Bug Fixed: Javascript error on Taxonomy Filter drop down in some sites
* Bug Fixed: Add the rhc_postmeta shortcode
* Bug Fixed: When using the Social Sharing Panel, the share button in a dynamically loaded Event Details Box does not link to the recurring event date only the original
* Bug Fixed: When using the Social Sharing Panel, the share button in a dynamically loaded Event Details Box does not contain the title of the event
* Bug Fixed: When the show all Post Types option is set, and the shortcode post_type arg is not set, not all the Taxonomies and Terms show only those belonging to the event_post_type.
* Update: Added option in Troubleshooting tab to disable update notification, which shows on non Calendarize it! wp-admin pages.
* New Feature: rhc_gmap shortcode for use inside an event. Renders a single Google map with multiple Venues assigned to the event.
* New Feature: Added rendering control attributes for the following shortcodes: calendarizeit and rhc_static_upcoming_events. The attributes are conditional_tag and capability
* New Feature: Allow enabling Calendarize it! Image Metaboxes for other Custom Post Types, allow enabling layout options in Custom Post Types, allow setting a custom content template to use in events or other Custom Post Types for content layout.

Version 3.4.6.62529 - September 2, 2015
* Bug Fixed: Missing code for Taxonomy rendering
* Bug Fixed: On static Upcoming Events Shortcode, events are displayed with all the terms of other events checked
* Bug Fixed: Added CSS fix for Custom Buttons, were suddenly too wide in tooltip after recent update
* New Feature: Added _select and _hidden to Taxonomy meta form. Added ISO3166 countries for passing Country name to Eventbrite (Requires Eventbrite Tickets for Calendarize it! add-on) 

Version 3.4.5.621112 - August 25, 2015
* Bug Fixed: Use Calendar Event List (Extended Details) time format for the Event List in FLAT UI Calendar Widget.
* Bug Fixed: Removed horizontal scrollbar on Add New Events page in wp-admin.
* New Feature: Added support for new value for the attribute defaultview (WeekEventList)

Version 3.4.4.61848 - August 19, 2015
* Bug Fixed: The bundled custom fields are set with a default date and time format that is overwriting custom values in the Options panel.
* Update: Added the Excerpt to the Description field of the ics generated file (this is for supporting description when using feed in Google Calendar).

Version 3.4.3.61734 - August 14, 2015
* New Feature: Added shortcode attribute max_events to limit the number of events rendered. Please notice that this feature is not compatible with pagination. This attribute supports the Event Grid View add-on.
* New Feature: Added support for Eventbrite add-on for Calendarize it!
* Bug Fixed: When the match background option is active, Grid View does not render (javascript error)
* Bug Fixed: In mobile view events from other months should not be displayed in Month View.
* Bug Fixed: Some events are not showing. For example April 30, 2016 events that are not recurring, do not show on Month View.
* Update: Updated styling on buttons for Edit Events in frontend (requires Community Events add-on)

Version 3.4.2.60206 - July 10, 2015
* Bug Fixed: The “showothermonth” option is causing the event list to only show one event

Version 3.4.1.60143 - July 9, 2015
* Bug Fixed: When attribute “showothermonth” or the feature is enabled in the Options Panel, sometimes old events show in the Events Grid View.
* Bug Fixed: FLAT UI Calendar Widget showing last day of multi-day event, but it should only be showing the starting date
* Bug Fixed: In certain conditions the event list is showing empty date labels (no events)
* Bug Fixed: Events Map View the sidelist was empty when loading map, when the list is large. Only appeared when resizing the screen
* Update: Adding Social Connection styling to main plugin
* Update: Changed event post type to NOT be hierarchical by default and added an option to make it hierarchical. This parameter was crashing the backend on sites with very large data sets.

Version 3.4.0.59001 - May 15, 2015
* New Feature: Added attribute tax_filter_multiple. By default the value is “1”. If set to “0” in Taxonomy drop down filters, only one value can be selected, not multiple. 
* Bug Fixed: When using a translated version of Calendarize it!, and switching from Month View to Event List, the month is not showing the correct language.
* Update: Repack Javascript and CSS

Version: 3.3.9.58832 - May 6, 2015
* Bug Fixed: Misspelled label: Set Featured Image - updated language .po files
* Bug Fixed: Tooltip on hover and close tooltip on title leave options are not working on Firefox.
* Bug Fixed: Some themes pagination are broken when Calendarize it! is active (get_queried_object before template_redirect causes a canonical redirect)
* Bug Fixed: In the Upcoming Events Widget, when using server side, when using date range, the range is not correctly rendered
* Bug Fixed: An dialog not styled is rendering before the calendar and hiding when page is ready
* New Feature: Added option to hide time in Month View either by shortcode attribute “month_hide_time” or by setting in Options.
* New Feature: Added option to show details in FLAT UI Calendar Widget with attribute “widget_autohover” and “widget_autoclick”

Version 3.3.8.58495 - April 24, 2015
* New Feature: New attributes left_trim_date and right_trim_date to be used with the calendarizeit shortcode. Both take an integer value from 1 to 28 and will trim the calendar month view. Example left_trim_date=“15” will show the month view with the week that contains date 15 and forward. right_trim_date=“21” will show the month view with the last week in the view being the one containing date 21. You can also combine the two attributes. 

Version 3.3.7.58412 - April 24, 2015
* Update: Move the option to enable External Event Sources feeds in Taxonomies to the Event Sources tab in Options.
* Improvement: Replaced add_query_arg() due to an XSS vulnerability issue that affects many WordPress plugins and themes. Please observe that before the function could be accessed the user had to be an Administrator, meaning that the potential issue was not available to the public.

Version 3.3.6.58276 - April 23, 2015
* Update: Improved Calendarize it! Month View Print CSS
* Update: Added info related to Event Tempalte integration to debug screen
* Bug Fixed: If the post_type attribute is not specifically set for the rhc_source and feed=“” is used, the External Event Sources taxonomies are not displayed on some sites.
* Bug Fixed: When using Events Map View upcoming only by end date, events that started before the view date are not showing.
* Bug Fixed: Removed some PHP warnings showing when using taxonomy label translation add-on.
* Compatibility Fix: Partial compatibility fix for qTranslate plugin. The qTranslate slug plugin is also needed.
* Compatibility Fix: Allow the Taxonomy page image to fallback to the Term Thumbnail image (provided by third party plugin Term Thumbnail).
* New Feature: Added code to allow Taxonomy meta data to the Upcoming Events Widget template. For example, adding an HTML tag with class taxonomy-venue-city, will put the venue city meta inside the tag, wrapped with a span tag.
* New Feature: Added option to enable author_name field in the Upcoming Events Widget
* New Feature: Added option to show External Event Sources in Taxonomy pages. Until now Taxonomy pages were hardcoded to only show local events.
* New Feature: Added option to Troubleshooting tab to disable the author drop down in the Upcoming Events Widget. It will show a text field instead. This is useful for sites that have too many users to display in the widget settings page.
* New Feature: Added rel=“nofollow” to share button, so that the ical feed does not get indexed by Google search engine robots.

Version 3.3.5.57582 - April 6, 2015
* New Feature: Added attribute allday_group which takes values “color” or “order”. It will group all day events in the same day by color or by menu_order field from the edit Event screen (Attributes meatball).
* New Feature: Added the allday_group attribute to the Calendarize shortcode tab under the Options menu
* New Feature: Option to disable the image in the tooltip. Also works with the shortcode attribute “tooltip_image”, which takes the values “1” or “0”.
* Update: Rescan sources and updated the language files with latest strings (wp-content/plugins/calendarize-it/languages/)
* Bug Fixed: Do not enable the Events post type archive since there is no defined template for this
* Bug Fixed: When a recurring event is limited with end date, events recurring in the end date are not included
* Bug Fixed: Javascript error when disable force browser cache set to yes
* Bug Fixed: In Upcoming Events Widget, using server load method, when using word count 0 it is displaying full description when it show none.
* Bug Fixed: In Upcoming Events Widget, using server load method, the .rhc-event-link class, the href attribute is not set with the URL like the ajax load method

Version 3.3.4.57447 - March 24, 2015
* New Feature: Added option to disable Taxonomies in the backend Event List. Some sites report very slow loading times in the backend Event List.
* New Feature: Added support for new shortcode attribute “showothermonth” which takes values “1” or “0” and allows to render or not render events in Month View in dates that are not in the current month. Also added the feature in the Options panel.
* Bug Fixed: Number of weeks in the Month View was incorrectly calculated. Options was passing a string, where the javascript expected an integer.
* Bug Fixed: When using Preload data, a calendar with External Event Sources would cause a javascript error when switching to Event List View.
* Bug Fixed: Organizational Microdata had an extra http://
* Bug Fixed: When feed attribute is set to “1” , only show Taxonomies associated to External Event Sources in the Taxonomy Filter dropdown (requires Taxonomy Filter add-on). 
* Bug Fixed: In Upcoming Events Widget, with Server load method the data and time format is ignored
* Bug Fixed: Custom Taxonomies with underscore in the slug, in Events Map View, where not transferred from the non-fullscreen view drop down filter to the fullscreen drop down filter bar.
* Update: Preload Data off by default (Troubleshooting feature)
* Update: Added an option that will avoid trimming the day names in the UI calendar widget.

Version 3.3.3.57244 - March 14, 2015
* New Feature: Option to set “Event List View” date title format
* New Feature: Allow setting a Details Box date format per event (This is useful when you want to have a different date format for different languages)
* Bug Fixed: supe is missing the “first date in range” premiere option. 
* Bug Fixed: Implemented premiere “first date in range” in Server side Upcoming Events Widget
* Bug Fixed: Details Box not showing in Grid View when preload data is active (requires Event Grid View add-on)
* Bug Fixed: Remove php warning in iCal feed
* Bug Fixed: When using Microdata and load Server in Upcoming Events Widget, the default template is displaying garbage date
* Bug Fixed: Server side render is not displaying the same layout as Ajax
* Bug Fixed: Upcoming Events Widget overlapping the Server side Upcoming Events Widget

Version: 3.3.2.57155 - March 12, 2015
* Update: Added a modification to post_info shortcode so that the new Upcoming Events shortcode can make use of it in its template. Added a Widget template that mimics the Event List View
* Update: Added filter and modifications so that the External Event Sources can also preload events from External feeds
* Update: Added javascript for handing preloaded External Event Sources
* New Feature: Allow preloading (Server side) the first set of data in a calendar view. If events are loading slow you can disable this feature in the Troubleshooting tab (Events Ajax Preload Data). You can also add an attribute to the shortcode, which overrules the default setting (preload=“0” or preload=“1”)
* New Feature: Allow preloading (Server side) of Upcoming Events Widget
* New Feature: Added the auto word, premiere and feed attributes for static events
* Compatibility Fix: When using the Taxonomy Filter add-on drop-downs force the same Taxonomies in the fullscreen view of the Events Map View.
* Bug Fixed: ics feed not showing recurring events when preloading
* Bug Fixed: Tooltip start time not reflecting the actual event time
* Bug Fixed: CSS conflict in Month View for mobile devices
* Bug Fixed: Avoid loading cached events multiple times when using multiple instances of calendars
* Bug Fixed: When show image is selected in the Upcoming Events Widget with Server side loading the image was not showing
* Bug Fixed: Added a filter clause to allow the WordPress get_term method to return terms from a specific post type, so that the Taxonomy Filter add-on drop-downs does not show terms from post types that are not listed in the calendar.

Version 3.3.1.56826 - February 25, 2015
* Compatibility Fix: Prevent WP Super Cache from breaking the Calendar Ajax
* Bug Fixed: When Custom Taxonomy Filters are used in the minimized Map View, the fullscreen Map Filters disappear.
* Bug Fixed: Venue Details Page is showing http:// even though the field is empty. If the field is empty nothing should be shown
* New Feature: Added new values for the gotodate attribute: next_week, previous_week, next_month, previous_month. Also supports adding integer numbers 1, 2, 3 etc.
* New Feature: Added new attribute local_tz with integer value 1. Add this to the Calendarize it! shortcode and the visitor will see events in their local time zone. This is very useful when you have a calendar with online seminar/conference calls etc.

Version 3.3.0.56712 - February 23, 2015
* Bug Fixed: iCal ics file, empty lines are not supported by all applications
* Bug Fixed: iCal ics file, skipping events that do not have the event start field defined, as many applications will break
* Bug Fixed: iCal, Google will not parse Calendarize it! iCal feed when using “Add URL”
* Bug Fixed: iCal, foreign characters not showing when using “Add URL” on Google Calendar
* Bug Fixed: Current iCal code validated 100 out of 100 on a couple of online validators
* Bug Fixed: When clicking on a recurring event in Upcoming Events Widget, it was not linking to the Event Details Page.
* Bug Fixed: Too much margin is breaking 2 columns in the rhc_color_key shortcode of the Event Color by Taxonomy add-on.
* Compatibility Fix: Divi Theme. Event Details Page showing sidebar event when template page is set to NO sidebar.
* Update: Added wp_options row count to the debug screen
* Update: When assigning multiple Taxonomies (Venues and Organizers) to an event they should be displayed on individual line in Event Details Box.
* Update: Added Access-Control-Allow-Headers to try allow calendar in an iframe
* Update: Added event_skip shortcode argument. When defined and used in the event list it will not render the amount of events defined in the argument.
* Update: Repack javascript. Trim past weeks not evaluated correctly in the minified version of the javascript.
* New Feature: Added option in Troubleshooting tab to load un-minified javascript
* New Feature: Hiding Other Months on mobile

Version 3.2.9.56224 - February 6, 2015
* Bug Fixed: Update notification not showing on some websites
* Bug Fixed: When choosing “Disable Event Link”, upcoming event links are opening an empty page
* Improvement: Instead of going to update-core.php directly attempt a plugin update when clicking on update now.
* Compatibility Fix: Bridge and Bridge Child WordPress theme (Themeforest) not showing the title in the Event Details Page
* New Feature: New arguments norepeat and grid_norepeat. Use case: Avoid repeating recurring events in Grid View, but preserving them in other views use grid_norepeat=“1”. Apply to all views use norepeat=“1”.
* Update: When using Taxonomy Filter drop down navigation set background to transparent

Version 3.2.8.55980 - January 30, 2015
* Bug Fixed: PHP warning in Tooltip (Month View)
* Bug Fixed: When the Taxonomy page does not have the protocol, the Taxonomy page generates the URL incorrectly (appends the sites own domain in front)
* Bug Fixed: When using the week mode fixed the events sometimes would not render in the last days of the month
* Bug Fixed: When the Tooltip hover action is enabled, hide the tooltip when the mouse leave the tooltip
* Bug Fixed: PHP warning when saving meta data

Version 3.2.7.55699 - January 24, 2015
* Update: Removed fixed height on Event Page Top Image
* Update: Make General Settings tab load first in the Options menu
* New Feature: Add a filter to allow to give values to fc_color, fc_text, fc_link and fc_link_target
* New Feature: Provide an optional website name to use instead of the link to show as link instead of the URL for long URLs that break the layout (Event Details Box and Venue Details Box)
* New Feature: Added loading animations and update notification to download section
* Bug Fixed: Latest changes where not replacing tags when empty
* Big Fixed: PHP warning when used with Easy Translation Manager for WordPress

Version 3.2.6.55237 - January 13, 2015
* Bug Fixed: Remove PHP warnings related to deleting cache
* Bug Fixed: When the URL is empty in a recurring event the first event correctly renders the title without a link, but the recurring instances are rendering with a link to an empty URL
* Bug Fixed: When using Taxonomy Filter add-on (dropdown filters) and Grid View add-on, the filter is loading events too far in the future, sometimes the first use of the filter doesn’t work, but a second attempt loads events.
* Bug Fixed: Upcoming Events are not catching translated values
* Bug Fixed: Remove some microdata related to PHP warnings
* Update: Added missing strings to localization (translation)
* Update: Change z-index value on Tooltip in Month View, as some themes hide it behind the calendar.
* New Feature: Option to add rel=nofollow on the Venue website link
* New Feature: When the nofollow option is set on Venue, also apply the nofollow to the dynamic custom fields
* New Feature: Option to add rel=nofollow to the Organizer taxonomy
* Update: Repack Javascript for release
* Update: Repack CSS for release

Version 3.2.5.55096 - December 29, 2014
* Bug Fixed: Avoid some PHP warning related to file caching
* Bug Fixed: When using quick edit the cache is not cleared
* Bug Fixed: Google Map not showing on Venue page
* Bug Fixed: In the Map drop down filter the address is showing instead of the name of the Venue
* Bug Fixed: Options Panel crashing (internal 500) on ISS
* Bug Fixed: The Calendar Widget is not coloring multiple day events, only the first day
* Compatibility Fix: wp-views plugin breaks the admin menu layout when creating a new event
* Update: Undo loading gmap3 with the regular JS, that is not needed on other pages
* Update: Styling for Taxonomy drop downs
* New Feature: Add support for the nofollow field
* New Feature: Added a troubleshooting option to fix events that cannot be deleted or edited by admin after upgrading to WordPress 4.1

Version 3.2.4.54970 - December 10, 2014
* Compatibility Fix: Some sites have SHORTINIT defined and are not installing the rhc capabilities, causing users not to be able to access the Options menu
* Bug Fixed: When switching from month to week or day, the view is set to the first day of the month, where it should load the window range that contains todays date
* Bug Fixed: Calendar crashing when using version 1 of the theme integration
* Update: Report a greater Option Panel version (do not show Coupon field for free add-ons)
* Update: Adjusted Font size for FLAT UI Calendar Widget 
* New Feature: Added support for triggering tooltip at mouse over in Month View (Calendarize Shortcode tab under Tooltip Behavior)
* New Feature: Added tooltip_on_hover argument for Calendarize it! shortcode to manually enable on hover behavior

Version 3.2.3.54920 - December 4, 2014
* Bug Fixed: Styles not loaded on single Event Details Page when scripts on demand is active
* Bug Fixed: Filter drop downs in wp-admin was out of position
* Bug Fixed: Order drop down filter alphabetically for event list in wp-admin
* New Feature: Added support for schema.org (structured data interoperability) to Event Details Page, Venue Details Page and Organizer (name, startDate, endDate, location, address, geo, telephone, url, image, hasMap)
* New Feature: Added support for schema.org (structured data interoperability) to list of events rendered noscript with Calendar.
* New Feature: Added support for the Term Thumbnail plugin to Venues, Organizers, Calendars and any Custom Taxonomy created with Capabilities and Taxonomies add-on.
* New Feature: Term Thumbnail image will be used if image is not set in Taxonomy (Venues)

Version 3.2.2.54885 - November 27, 2014
* Bug Fixed: Date picker not styled in Upcoming Events Widget wp-admin
* Bug Fixed: If a date end is for some reason not set update crashes
* Bug Fixed: PHP crashing when date fields has NaN values
* Bug Fixed: Avoid a Javascript error on null Google feed description
* Bug Fixed: No Events message showing when applying filter.
* Update: Handle the Ajax earlier in WordPress to avoid processing hooks that will not be used
* Update: Options Panel Horizontal Tabs (WordPress style)
* Update: Taxonomy Links ON by default (General Settings tab)
* New Feature: Client side caching. File caching in an effort to improve event delivery speed
* New Feature: Modified Ajax calls to pass a value for file caching. Enabled file caching for all Ajax calls. Added setting for filling the .htaccess values for file caching (Events Cache tab)
* New Feature: Added a Clear Cache Button (Events Cache tab)
* New Feature: Added option to load Scripts and Styles on demand (General Settings tab)
* New Feature: Added the rhc_timetable class for showing the title in the next line in the tooltip. This is only applicable when using the rhc_timetable class in the shortcode [calendarizeit defaultview="month" class="rhc_timetable" timeformat_month="h(:mm)TT { - h(:mm)TT}"]
* New Feature: Added a style for the next_upcoming time meta
* New Feature: Added Coupon Code field in wp-admin Shop
* Compatibility Fix: Replace all post_info shortcodes with rhc_post_info shortcodes. If post_info was used in a custom template or post, it will now need to be changed to rhc_post_info

Version 3.2.1.54744 - November 13, 2013
* Bug Fixed: Events that do not start or end in the window range are left out
* Bug Fixed: On update some sites wp-admin are crashing because the site contains invalid event start or end
* Bug Fixed: Some unidentified javascript library is overwriting Calendarize it! in_array javascript function and causing an infinite loop, breaking or slowing down the calendar rendering
* New Feature: Added troubleshooting option to clear all events and custom post type background color and text color
* New Feature: Added Organizer to iCal feed
* Compatibility Fix: Some unidentified plugin or theme is taking over the post_info shortcode tag
* Update: Moved the Taxonomies are links to the General Settings tab
* Update: Updated the reported Options Panel to 2.7.2

Version 3.2.0.54643 - November 3, 2014
* New Feature: Implementing a new server side RECURR library, which should provide faster events loading, and also opening for the possibility for rendering static widgets that contain recurring events properly.
* New Feature: Implement settings for External Event Sources caching response
* New Feature: Added support for Taxonomy Filter drop down (requires add-on)
* Update: If PHP 5.3 requirement is not met, fallback to prevent previous Ajax version
* Update: Added option to reinstall and generate recur data
* Update: Render a list of events in noscript tag for visitors browsing without javascript (Improvement for SEO) 
* Update: Added rhc_noscript filter to allow the External Event Sources to hook into the noscript tag and add External Event Source links
* Bug Fixed: In Upcoming Events Widget, clicking on image or titles does not match the same link target
* Bug Fixed: Missing argument in a filter needed for Community Events (requires add-on)

Version 3.1.4.54516 - October 28, 2014
* New Feature: Modifications so that the Color by Event can add classes to the events for manual customization, and also added some modifications so that the add-on Events Color by Taxonomy can hook into all taxonomies both default (Calendar, Venue, Organizer) and custom taxonomies. 
* Bug Fixed: Removed PHP warning
* Bug Fixed: Image dynamic details on event list does not link to Detailed Event Page.
* Bug Fixed: Individual layout changes to Event Details, Venue Details and Tooltip Details are not saving
* Update: Added description for the shortcode argument version of the hiddendays option

Version 3.1.3.54458 - October 23, 2014
* Compatibility Fix: A plugin is preventing Calendarize it! from saving Meta fields data
* Update: Added troubleshooting menu_position for changing the Calendarize it! menu position to solve conflicts where other plugins overwrite the Calendarize it! menu position.
* Update: Added a trigger viewLeave for a grid view fix
* Bug Fix: Add charset to events Ajax call, to try prevent a network error on IE and certain hosts
* Bug Fix: Past day setup is not showing yesterdays events
* Bug Fix: Upcoming Events with a range date was showing a dash when it should not
* Bug Fix: When using the Calendar filter, reset the view to the starting date
* Bug Fix: $.ajax is not working like $.post and several random issues were caused by this change. Grid not showing details, events not loaded etc.
* Bug Fix: Missing text domains for Internationalization
* Bug Fix: Event List arrows not working on a non-stacking setting
* Bug Fix: When a lot of filters have been chosen the container doesn’t expand

Version 3.1.2.54370 - October 15, 2014
* New Feature: Added shortcode argument eventlistpastdays, which allows to set an event list for example 180 days in the past from current date
* Compatibility Fix: Ajax based themes. Added a functionality to the visibility check option, so it also tests for Ajax loaded calendars that are missing to be inited.
* Bug Fixed: Added unique CSS selectors to FLAT UI Calendar Widget to avoid conflicts with other CSS

Version 3.1.1.54340 - October 12, 2014
* Bug Fixed: When the Excerpt is inserted in the Custom Fields for Details Box it doesn’t render in the single Event Details Box or Event List

Version 3.1.0.54190 - October 3, 2014
* Bug Fixed: Empty Taxonomy meta are leaving empty space in the wp-admin layout builder for Event Details, Venue Details etc.
* Bug Fixed: When selecting some checkboxes in the filter, but then clicking the Apply All button, the selected boxes disappear
* Bug Fixed: When applying a filter, Event Grid View boxes does not render any meta-data (requires Event Grid View add-on)
* Bug Fixed: In the Upcoming Events Widget, all day events are hiding the date portion where it should only hide the time container
* Bug Fixed: Line height adjusted in CSS for details boxes (affected by last update)
* Bug Fixed: Navigation buttons not properly aligned in mobile view
* Bug Fixed: The day name when clicking on the FLAT UI Calendar Widget always show Saturday

Version 3.0.9.54103 - September 24, 2014
* Bug Fixed: Do not show comma when an empty taxonomy field is shown on the detail box, when multiple terms are checked for that event and one term meta is empty.
* Bug Fixed: On Event List View, when not using stacking, and clicking back arrow it is jumping to the first day of the month or just not doing anything at all.
* New Feature: Render External Sources optional Google Map into the Venue link (requires External Event Sources add-on)
* Update: Javascript minified for release.


Version 3.0.8.54079 - September 23, 2014
* Compatibility Fix: Rollback a theme compatibility fix to its original state, and add a internal fix so that only certain themes the change will apply.
* Compatibility Fix: Bootstrap fix for icons
* Bug Fixed: Horizontal Options tabs not working on Firefox and mobile browsers
* Bug Fixed: Some themes are breaking the Custom Fields Metabox in the wp-admin
* Bug Fixed: On certain conditions, the year filter is added to the calendar and a javascript is returned when loading a page with the calendar button
* Bug Fixed: Multiple Organizers in the Event List are rendered without spacing

Version 3.0.7.53794 - September 12, 2014
* Bug Fixed: Chrome, Safari and Firefox on Mac opening FLAT UI Calendar local events in new tab and new window when using link target _blank

Version 3.0.6.53778 - September 12, 2014
* Bug Fixed: FLAT UI Calendar Widget next and previous month arrows in iPad (tablet)
* Bug Fixed: FLAT UI Calendar Widget not possible to use previous month arrow
* Bug Fixed: Month View was trimming past weeks always (this is a feature that can be enabled in the Options Panel)
* Bug Fixed: YouTube link were not rendering as Videos on Events (This works in WordPress Pages and Posts)
* Bug Fixed: On some themes pagination in the frontend is redirecting to home

Version 3.0.5.53754 - September 11, 2014
* Update: Remove registration URL option 2 from Troubleshooting
* Update: When changing month on FLAT UI Calendar Widget (hide the event list)
* Update: Increase Javascript version no. 
* Update: CSS styling for FLAT UI Calendar Widget in mobile view
* Bug Fixed: When all headers are empty set top margin to zero
* Bug Fixed: The list of Events in FLAT UI Calendar Widget are not following the target set on links
* Update: Minify CSS and Javascript with latest changes and bug fixes

Version 3.0.4.53557 - September 4, 2014
* Compatibility Fix: Options Panel Javascript error on WordPress 4.0
* Bug Fixed: Customize menu under Appearance breaks when the Upcoming Events Widget is loaded
* Bug Fixed: Alignment of Taxonomies in Calendar filter
* Update: Repack Javascript

Version 3.0.3.53542 - September 3, 2014
* Update: CSS update for FLAT UI Calendar Widget
* Update: Added a commented out fix for when Bootstrap is present in the wp-admin 
* Compatibility Fix: Version 2 event template settings for IdolVersion 1.0.7
* Compatibility Fix: Idol Theme (themeforest)
* Bug Fixed: Do not use javascript:void(0) in iCal file
* Bug Fixed: Calendar Filtering not working on Google Grid View (requires Google Grid View add-on)
* Bug Fixed: Minor CSS update for mobile navigation
* Bug Fixed: When UI themes were removed the recurring dates GUI lost its styles
* Bug Fixed: Width of recurring date settings in date settings dialog on event edit page
* Bug Fixed: It was not possible to set a recurring date with multiple byvalue rules. Example it was not possible to set the 1st and 3rd Saturday and 7pm and 9pm.
* Bug Fixed: Remove icon styles to avoid extra icons in the Custom Fields Admin Metabox

Version 3.0.2.53409 - August 21, 2014
* Update: Updated Calendarize it! icon in wp-admin
* Bug Fixed: When Social Panels add-on is not present, the FLAT UI Calendar Widget list returns a Javascript error when clicking on a date.
* Bug Fixed: When the title of a FLAT UI Calendar Widget Event List is a no-link, the color is set to white in a white background
* Update: Repack minified Javascript and CSS files

Version 3.0.1.53392 - August 18, 2014
* Bug Fixed: When text color is not set, widget color is not set. 
* Bug Fixed: When dynamic tooltip is set, but no layout is set, default layout is not loading
* Bug Fixed: “Page not found” error when page with upcoming events widget template is crawled by Search Engines.
* Update: Repacked Javascript and CSS with latest fixes

Version 3.0.0.53378 - August 15, 2014
* New Feature: Updated Event Calendar Widget (free add-on FLAT UI Calendar Widget). Click on events in calendar and events appear below the calendar. Mouse over event and Time and Venue details appear. Click event and event excerpt appear. Integrates with Social Sharing Panel add-on (share events to Facebook, Twitter, Google+ and LinkedIn). iCal file download. Static or Interactive Google Map feature.
* New Feature: Event List days ahead. Similar to Months ahead, but in days. Allows showing an Event List View only one day at a time. This can be used for creating a Event List View showing todays events.
* New Feature: When Upcoming Only is active, added option to trim (hide) the past weeks from the month view.
* Bug Fixed: Remove the non-dynamic tooltip content when using dynamic content. It looks bad and confusing on slow loading sites. 
* Bug Fixed: Upcoming only is not showing all events on the current day.
* Update: Show URL instead of javascript:void(0);
* Update: Minimize javascript and CSS

Version 2.9.9.1.53103 - August 3, 2014
* Bug Fixed: Custom Fields icons disappear WordPress prior to version 3.9.1
* Update: New Custom Fields default for Event Details, Venue Details, Tooltip Details, Grid View Details and Slideshow Details

Version 2.9.9.53055 - August 1, 2014
* Update: Remove UI themes from frontend and backend
* Update: Remove choose default UI theme drop down from Options Panel. UI themes are no longer used in Calendarize it!
* Optimization: Moved content of last minute fixes to calendarize.css
* Optimization: Switched to minified CSS
* Optimization: Switched to minified JS
* Optimization: Reorganizing to reduce number of javascript files
* Optimization: Add minified javascript to reduce number of javascript files loaded
* Optimization: Clear unused resources
* Compatibility: Wrapped Calendar dialog checkboxes and iCal text area in label tag, for WCAG 2.0 Level A requirement
* Compatibility: Applied more WCAG 2.0 Level A requirements
* Bug Fixed: When removed UI-themes, backend close and arrow icons were gone. Replaced with the ones from WordPress
* Bug Fixed: Syntax error unclosed media
* Bug Fixed: When general settings disable event link is enabled, clicking on event causes javascript error
* Bug Fixed: Missing date format mapping file
* Bug Fixed: External Event Sources not loaded on FLAT UI Widget list on day click.
* New Feature: Adding optional pre-loader to FLAT UI Widget 
* New Feature: Added option to apply the_content filter to the event single page content
* New Feature: Added a filter to allow customizing which details box get restored to default

Version 2.9.8.52520 - July 16 2014
* Update: When External Event Sources add-on is used, show date and time contained on its own tag each for separate styling
* Update: Load Event List template only when calendar is used
* Update: Allow the posted_arguments in the calendar shortcode
* New Feature: Pass the view name on local events for further add-on filtering 
* Bug Fixed: Arguments like author and author_name are part of WP core and not caught by the calendar

Version 2.9.7.51976 - July 5, 2014
* Bug Fixed: PHP warnings, when using Upcoming Events Widget as shortcode in a page
* Bug Fixed: PHP warnings triggered by other plugins
* Bug Fixed: Visibility check feature not working when multiple calendars are used
* Compatibility Fix: Avoid other plugins/themes overwriting the local icon
* Improvement: Premiere works as real premiere, or optionally show a repeated event only one time
* New Feature: Added cope to handle External Event Sources add-on no link option. 

Version 2.9.6.51808 - July 2, 2014
* Update: Added support for showing external feed, created with External Event Sources add-on, in local Calendarize it! iCal feed.

Version 2.9.5.51712 - June 30, 2014
* Bug Fixed: WordPress Featured Image broken. Enqueue script in the right place.

Version 2.9.4.51693 - June 29, 2014
* New Feature: Added option to set Default Featured Event Image in Options > Media settings tab
* SEO Fixed: Taxonomy pages where reporting the canonical and shortlink of the page template and not the term links
* Compatibility Fix: WordPress SEO by Yoast. Taxonomy pages were not displaying the description and link configured with WordPress SEO by Yoast.

Version 2.9.3.514356 - June 23, 2014
* Bug Fixed: Current time showing on All Day events
* Bug Fixed: Remove some internal fields from postmeta drop down in Custom Layout Metabox
* Compatibility Fix: When using qTranslate events only show on default language on Calendar and Upcoming Events Widget.
* Compatibility Fix: ISS compatibility fix. Enabled troubleshooting option to change the temp folder to uploads
* New Feature: next_day_threshold option and argument. Possible values 0-12. Specifies how much an event can get past midnight without displaying on the next day. 
* New Feature: Added Calendarize it! Role Manager to Options Panel.
* Update: Enable fc_range_start and fc_range_end as usable postmeta values for the event details box, apply a date format, and bug fixed time, when an interval is set so that it is the ending hour of the last recurring event.
* Update: Remove header icons from Options Panel

Version 2.9.2.51174
* Update: Replace jquery.live (depreciated on jquery 1.7) with jquery.on in the script that handles the calendar metabox in the backend.
* Update: Added some filters and modified the Admin a bit to support the backend Options add-on.
* Update: Added a default value to the theme option
* Update: Added method transitionStarted to fullcalendar, in preparation for the Google Grid View add-on.
* New Feature: Support for Google Grid View add-on for Calendarize it!
* New Feature: Social Connection menu for Facebook, Twitter, Google+, LinkedIn and Microsoft Live API keys. This can be used by all add-ons that require API keys.
* Bug Fixed: Duplicated taxonomy on tooltip. Terms were given the taxonomy ID, rather than a specific term ID
* Bug Fixed: PHP warning when Community Events add-on is active.
* Bug Fixed: Not possible to uncheck terms in the Calendar taxonomy filter
* Bug Fixed: Icons not showing in Member Profile add-on

Version 2.9.1.50641 - June 6, 2014
* Compatibility Fix: Some themes are not properly setting the body_class
* Bug Fixed: Prevent rendering the same event multiple times on the Event List when stacking in on
* New Feature: Added “Removed ended” option for Upcoming Event List.

Version 2.9.0.50593 - June 5, 2014
* New Feature: Option to change the event list range (currently it is monthly)
* New Feature: Event List Stacking behavior. Shortcode argument eventliststack=“1” or “0”
* New Feature: Allow passing eventlistscrolloffset to the Shortcode to control how early or late the auto load triggers. Greater values delay autoload and smaller values trigger autoload earlier. Negative values allowed.
* New Feature: Upcoming only option apply to all views
* Improvement: Added “rhc_query_post_status” filter to control what post_status is passed to the events query
* Improvement: Add a filter for automatically loading some theme meta field names. Improved the version 2 single page template loading to be less intrusive for better theme integration.
* Compatibility Fix: Handle a situation where something rewrites the wp_query object and does not return it to its original state, causing Calendarize it! to load version 1 of the Custom Taxonomy Template
* Compatibility Fix: Added compatibility fixes for Enfold - Responsive Multi-Purpose Theme (Themeforest).
* Compatibility Fix: When using Gantry Framework and Community Events add-on, taxonomy drop-downs disappear. 
* New Feature: Hierarchical filter. Options and shortcode argument will display only terms that are children of the displayed fullCalendar defined taxonomy term
* Bug Fixed: Handle a situation where plugins or themes takeover the main query object and  does not return it to its original state.
* Bug Fixed: When using multiple calendars and Match Background Color all calendars are affected
* Bug Fixed: When using dot in time syntax, the time is rounded to hours. Minutes are not recognized in the tooltip
* Bug Fixed: Clear cache when options are saved
* Bug Fixed: Remove some PHP warnings on the tooltip, when wp_debug true
* Bug Fixed: iCal button not showing in tooltip when using Dynamic Tooltip content loading

Version 2.8.9.49905 - May 22, 2014
* Compatibility Fix: Support for Empire II - WordPress Theme (Themeforest)
* Bug Fixed: In Event List View when not loading extended details the a tag for taxonomies is not rendered inside the intended span
* New Feature: Added support for a Default Custom Taxonomy template
* New Feature: Allow the Custom Taxonomies to use the version 2 template
* New Feature: Allow configuration of version 2 templates for Custom Taxonomies

Version 2.8.8.49838 - May 21, 2014
* New Feature: Allow developer to add anchor to tags to widget templates with class rhc-event-link in order to add custom links to the widget template
* Update: Updated language files
* Update: Allow using the column date format in basicWeek mobile view
* Bug Fixed: Remove debugging code
* Bug Fixed: CSS issue in Calendar filter

Version 2.8.7.49709 - May 17, 2014
* New Feature: Added a filter so that the Capabilities and Taxonomies add-on can filter out taxonomies from the Calendar filter box (month view). This requires the Capabilities and Taxonomies add-on.

Version 2.8.6.49701 - May 16, 2014
* Update: Improved CSS in Calendar filter for better compatibility with mobile devices
* Bug Fixed: Disable Calendar links was not working
* Bug Fixed: Option to enable or disable Custom Detail Layout in Tooltip is always enabled no matter what option is selected.
* Bug Fixed: Taxonomy terms are duplicated in Details Box.
* Bug Fixed: Allow the Taxonomy link option to also enable/disable the Tooltip Taxonomy link when not using the Dynamic Tooltip Content. 

Version 2.8.5.49517 - May 11, 2014
* Bug Fixed: Show day number on basic week view when viewed on mobile devices
* Compatibility Fix: Wrapped init procedures for easier initialization by themes, which loads content with Ajax.

Version 2.8.4.49482 - May 9, 2014
* Compatibility Fix: Plugins that are changing the return value of is_admin are causing Calendarize it! add-ons to crash, due to admin libraries not being loaded (Setting in Troubleshooting tab).
* Bug Fixed: CSS update scroll on calendar filter (overflow:) to better support mobile devices.

Version 2.8.3.49322 - May 6, 2014
* Update: Add recurring data to Event URL’s making it easier for users to share events that are recurring. 
* Bug Fixed: Event list details was broken when details were added to the cache

Version 2.8.2.49256 - April 29, 2014
* Bug Fixed: Enable feed argument in Upcoming Events Widget (shortcode). If feed=“0” is used events from External Events add-on will not be shown (feed=“1” will allow events)
* Bug Fixed: Month header jumping when changing from current month to non current month
* Compatibility Fix: Added an option to suppress unwanted content that is rendered by plugins using the “the_content” filter to append content to posts and pages, without verifying the post (troubleshooting tab)

Version 2.8.1.49226 - April 28, 2014
* Bug Fixed: Pages in drop down under Options > Template Settings were not sorted alphabetical
* Bug Fixed: When custom field is datetime, but event is ALL Day, set Date format and not Date time.

Version 2.8.0.49197 - April 25, 2014
* New Feature: Added the excerpt to the postmeta custom fields. 
* New Feature: Added quick icon for excerpt in custom field metabox
* Update: Extended Details optimization. Avoid loading details on every view change
* Bug Fixed: When custom tooltip layout is not set, and the custom dynamic tooltip is enabled, the ajax was querying every time the cursor was hovering the event.
* Update: Add the Event List details to the cache

Version 2.7.9 rev49019 - April 21, 2014
* Bug Fixed: Missing new lines breaking some application import features
* Bug Fixed: Match Background color feature is ending too early for very long spanning events.

Version 2.7.8 rev48814 - April 13, 2014
* Compatibility Fix: When NextGEN gallery is active images can not be uploaded
* Compatibility Fix: When clicking the NextGEN insert icon, a php error is shown in the dialog
* New Feature: Option to enable shortcode argument so that they can be passed through the page URL.

Version 2.7.7 rev48793 - April 10, 2014
* Compatibility Fix: Prevent WPML or other plugins using pre_get_posts from breaking Venue Page
* Bug Fixed: Prevent Month View image overlapping
* Bug Fixed: Month View Image not showing when switching views

Version 2.7.6 rev48786 - April 10, 2014
* New Feature: Support for featured image in Month View (enable feature in Options > Calendarize Shortcode and Month View)
* New Feature: Added separate option to enable Month View Image metabox
* Update: When either the Month View metabox or image option for Month View is set enable the image on the event Ajax data.
* Bug Fixed: Javascript error on Event List View after previous update. Increased version no. of Javascript to force non-cached file.

Version 2.7.5 rev48751 - April 10, 2014
* Update: New optimization feature Ajax data shrink for faster loading of Events (can be disabled in Options > Troubleshoot)
* Bug Fixed: When using the Match Events color feature, applying a filter does not reset the background color

Version 2.7.4 rev48555 - April 3, 2014
* Bug Fixed: Post info metabox was not showing on some Custom Post Types where it was enabled.
* Update: Increase Options Panel version no.
* Bug Fixed: Prevent php warning in Options Panel
* Bug Fixed: Super Admin in WordPress Multisite are getting Demo Mode error message
* Bug Fixed: Super Admin in WordPress Multisite can not save settings in Options.

Version 2.7.3 rev48332 - March 31, 2014
* Bug Fixed: Prevent some javascript error when post extra info goes into a bad state
* Bug Fixed: Remove empty space in dynamic tooltip when custom fields data is not entered
* Update: Change line height in new Calendar Widget.

Version 2.7.2 rev48275 - March 28, 2014
* Update: Added support for the new FLAT UI inspired Calendar Widget (free download).
* Bug Fixed: FLAT UI widget not translating month and day name
* Bug Fixed: iCal button space showing under FLAT UI Calendar widget

Version 2.7.1 rev48158 - March 26, 2014
* New Feature: Added buttons to restore specific default layouts individually (Event Details Box, Venue Details Box, Tooltip Details Box).

Version 2.7.0 rev47975 - March 25, 2014
* New Feature: Added a Upcoming Events Widget template with date range
* New Feature: Added a Skip Months feature in Calendar view.
* New Feature: Option to match the month view day cell background color with the event background color
* New Feature: Added support for dynamic Tooltip content (build your own layout)
* New Feature: Option to replace all events Custom Fields with the default template
* Bug Fixed: jQuery conflict fixed causing Sidelist on Events Map View add-on not to show
* Bug Fixed: Can not delete own events in draft status
* Bug Fixed: Improved styling for Social Network buttons in mobile view
* Bug Fixed: Super Admin on WordPress Multisite can not save Options in Calendarize it! 

Version 2.6.7 rev47746 - March 3, 2014
* Update: Changing spacing in custom buttons in wp-admin
* Update: Changed line height on navigation buttons

Version 2.6.6 rev47499 - February 24, 2014
* Bug Fixed: When clicking on the image in tooltip, not getting the correct recurring event instance.
* New Feature: Show version no. of latest installed add-on and available add-on version
* New Feature: Added support for displaying banner ads by category (requires Events Map View add-on and Advertising Options add-on)
* Update: Colors updated on ON and OFF switch in wp-admin to match new colors
* Update: Color for default event updated to match the new default color scheme for Calendarize it!
* Update: Updated Options Panel to version 2.6.0

Version 2.6.5 rev47386 - February 17, 2014
* Update: Added icon fonts for Calendar navigation
* New Feature: Added some arguments so that the External Event Sources (add-on) can be filtered by Author
* Update: If inserting Custom Field with post meta data fc_allday, replace the value with Yes or No.
* Update: Improved navigation for mobile devices when in month view.

Version 2.6.4 rev47073 — February 12, 2014
* New Feature: Added a settings link in the plugin list
* New Feature: Redirect to Option on plugin activation (this is done in order to get customers to enter the license key and download the Help)
* New Feature: Redirect to License tab on Activation
* New Feature: Message will be displayed in Options Panel if the Help is not installed and allow the user to dismiss the message permanently
* New Feature: Message will be displayed in Options Panel if the Initial Setup has not been performed: Create Event and Venue templates and create Calendar page with [calendarizeit] shortcode.
* New Feature: Show list of pages that uses Calendarize it! shortcode (Options Panel)
* New Feature: Updated default theme for Calendarize it! buttons (FLAT UI)
* Update: Add close icon to iCal dialog
* Update: Adjust color of close icon on Calendar filter dialog
* Update: Change Calendar filter tabs 
* Bug Fixed: iCal feed download fixed on individual events.
* Update: Changed iCal Feed dialog,  that appear when you click the button in the Event Details Box, to be the same as when you click the iCal button in the Month View.

Version 2.6.3 rev44259 - January 9, 2014
* Update: Map View Optimization (improved load speed for Map View add-on)
* Update: Added a comment for changing the post info shortcode
* Update: Adjust CSS for Auto Publish add-on
* Bug Fixed: Adjust Featured Event Image in pop-up
* Bug Fixed: Premiere parameter was not applied to the rhc_upcoming_events shortcode

Version 2.6.2 rev43952 - January 1, 2014
* Compatibility Update: Added code to compensate for undetermined situation where the “no upcoming events” message is also shown when events are appearing.
* Bug Fix: Weekly recurring events were not showing on December 29, 30, 31 or January 1.

Version 2.6.1 rev43717 - December 23, 2013
* Update: Change Calendarize it! event default color
* Bug Fixed: Title alignment off
* Bug Fixed: Rename the pre-loader icon font to avoid conflicts with other plugins and themes that have not namespaced icomoon.
* New Feature: New and improved layout for Month View on mobile devices
* New Feature: Adding a mobile .fc-small class and code for handling calendar rendering on mobile (Setting in Options Panel)
* Bug Fixed: Make multi day events span correctly in mobile view

Version 2.6.0 rev43685 - December 21, 2013
* New Feature: Allow External Event Sources add-on to define its own tooltip link target.

Version 2.5.9 rev43680 - December 19, 2013
* Update: Changed styling of tooltip to better support mobile devices
* Update: Tooltip will pick up the color from the event in the Month View

Version 2.5.8 rev43502 - December 17, 2013
* Compatibility Fix: Renamed the spinner (pre-loader) font-face (icomoon) to avoid conflict with other plugins and themes.
* Bug Fixed: CSS Styling issues fixed in wp-admin (WordPress 3.8 compatibility)
* Update: Added name-spacing to font-face icon (icomoon) to avoid conflict with other plugins and themes. 
* Update: Optimization reduce the size of the plugin on memory per page load

Version 2.5.7 rev43111 - December 11, 2013
* Update: Improved layout for Social Network icons on iPad and Tablets. 

Version 2.5.6 rev43031 - December 10, 2013
* Bug Fixed: Moved misplaced tip html that breaks the styles with Twitter Boostrap 3
* Bug Fixed: php warning in troubleshooting tab
* Bug Fixed: Upcoming Events Widget targeting _blank on some events
* Update: Increase the Options Panel version (support for callback on Social Login Options)
* New Feature: Added support for Social Media login (Facebook, Twitter, Google+, LinkedIn and Microsoft Live)

Version 2.5.5 rev42214 - November 22, 2013
* Bug Fixed: Alignment of text in bubble on Google Map (Venue Details)
* Bug Fixed: Using a custom postmeta in post info fields returns a strange format in the wp-admin.
* Update: Allow pop option esc_attr for escaping html in options fields.
* Update: Redundant check, do not can get image scr if attachment id is not valid
* New Feature: Added a filter to add postmeta options to post info metabox form
* New Feature: Modify post info so that button add-on can be applied to a postmeta type (used for Community Events add-on)
* New Feature: Added option to set a default set of values for the Layout Options Metabox (applicable to new events)

Version 2.5.4 rev42165 - November 15, 2013
* Bug Fixed: Type error in textColor breaks the Event Color by Calendar add-on
* New Feature: Added new Role Manager field type for setting plugin capabilities per User Role

Version 2.5.3 rev42049 - November 12, 2013
* Bug Fixed: Incorrect localization fixed
* Bug Fixed: Font size of the Event Details Box title can not be edited with the CSS Editor
* Bug Fixed: When loading ends, remove min-height from view, as it sometimes creates unwanted space.
* New Feature: New FLAT UI Calendar Widget
* New Feature: Added support for customizing the FLAT UI Calendar Widget with the CSS Editor
* Update: Clear Event Cache on post (event) delete
* Update: Removing embed of Google font Lato in CSS
* Update: Embedding Google Lato font (The default Lato font can be changed with the CSS Editor. 600+ Google Fonts available)

Version 2.5.2 rev41962 - November 8, 2013
* Bug Fixed: Allow php on Widget Templates
* Bug Fixed: A space about 5px is added between the top view and the start of the lists of events. 
* Bug Fixed: Problems generating rhc post meta data
* Bug Fixed: FLAT UI missing modal shadows
* Bug Fixed: Saved events not showing in Calendar
* Bug Fixed: Events not appearing the first time they are saved

Version 2.5.1 rev41876 - November 6, 2013
* New Feature: Upcoming Events Widget allow to specify removing events by ending hour
* New Feature: Added an Agenda like template for Upcoming Events Widget
* New Feature: Specify Media source size for the image in the Events Details Box
* Update: Added in comments a sample for using ending time in the Upcoming Events Widget
* Bug Fixed: Used a theme specific selector to hide unused spaces in the Upcoming Events Widget
* Bug Fixed: Add fallback sql delete in case truncate fails for clearing the cache table. Fixes events not updating in the frontend
* Update: Added CSS for check box type on metabox save
* Update: Changed the namespace to FLAT UI styles

Version 2.5.0 rev41852 - November 4, 2013
* New Feature: Added the parameter “days in the past” to the Upcoming Events Widget, to allow showing x number of days passed.
* New Feature: Added feature in Options Panel that allow to hide specific weekdays from the Calendar.
* New Feature: Allowing to enable the Details Metabox for other post types.
* Compatibility Fix: Added a troubleshooting option for theme integration. It helps fixing issues with themes that store layout information in the Post Meta Data.
* Update: Separate scripts and styles loading to a separate class.
* Update: Added a filter for triggering advertising banners based on taxonomy filters (Requires Map View add-on).
* Bug Fixed: Prevent several “Strict Standards: Non-static method” php warnings on single events pages.
* Bug Fixed: Event list broken
* Bug Fixed: wp hook is not fired in the wp-admin
* Bug Fixed: $post_types array
* Bug Fixed: Prevent a php warning in the Calendar widget drop down on strict php settings.
* Update: Added hook rhc_calendar_metabox_post_types to allow specifying what post type gets the calendarize metabox (besides options)
* Update: Apply some important changes to pass local feeds slug and term_id needed for matching ads (Requires Map View add-on).
* Update: Improved support for theme meta data in the template, when the theme uses get_post_custom instead of get_post_meta
* Update: Added hook save_post_meta_boxes to chain save_post actions better. Fixes a bug where the end date was replaced with the start date
* Update: Upgrade to fullCalendar 1.64
* Update: Added option to specify single days NOT to show in Calendar

Version 2.4.9 rev41734 - October 30, 2013
* Bug Fixed: Added a check to prevent agenda views from crashing. 0 is not a valid minute slot value
* Bug Fixed: remove ob_gzhandler from the Ajax. Apparently many hosting providers are not handling this very well.
* Update: Added iCal Location and Geo Event properties based on the rhc build in venue
* Update: Added a close button to the iCal feed tooltip. Close icon was lost when changing from jQuery UI dialog to tooltip

Version 2.4.8 rev41688 - October 28, 2013
* Bug Fixed: Replace brackets in some sites that break in the admin when the Ajax URL contains brackets
* Bug Fixed: If site uses SSL, load the https version of Google Maps library
* Bug Fixed: Saving bracket in week title not working in front end (this is when setting date/time format in the Options Panel)
* Update: Make email and website in the Organizer page hyperlinks
* Improvement: Added some filters for better time zone support.

Version 2.4.7 rev41610 - October 23, 2013
* Bug Fixed: Custom Fields metabox broken after W3C validation
* Bug Fixed: Sorting of 2 column elements broken in custom fields metabox
* Bug Fixed: Calendar filter broken after W3C validation

Version 2.4.6 rev41581 - October 23, 2013
* Improvement: W3C HTML5 validation.
* Improvement: Gzip compression if supported by browser compress events data
* Improvement: CSS minified
* Improvement: Moved location (load) of some JS and CSS files for improved load time.
* Update: Removed duplicate unused resources
* Update: Cleanup, will not use init_in_footer, remove code for edit view mode since not used
* Update: Remove unused JS
* Update: Convert iCal dates to UTC according to the WordPress settings GMT offset.
* Bug Fixed: On All Day events, exdate most be date and not date time.

Version 2.4.5 rev41505 - October 21, 2013
* Bug Fix: WordPress 3.7 compatibility. Permalinks for the Event details pages are broken in WordPress 3.7. If you still experience issues after updating re-save your WordPress permalink settings and the fix will be applied.
* Bug Fixed: Problem with recurring events in Upcoming Event List.
* New Feature: Added troubleshooting feature to try catching PHP warnings in the Ajax output (When to use: When the calendar is rendered, but events doesn't seem to load)
* New Feature: Added new troubleshooting feature to allow specifying page ids where the Calendarize it! JS and CSS should be loaded. Important: If left empty it will load on all pages as the JS and CSS is needed for the Sidebar Widget. If you know that you are only using Calendarize it! on a specific page and also using the Sidebar Widget on a specific page you can use this feature to reduce load time.

Version 2.4.4 rev41417 - October 19, 2013
* New Feature: Implemented Ajax response caching for improvement performance.
* New Feature: Added taxonomy term rendering to upcoming events widget template.
* New Feature: Optimization of the Events query.
* New Feature: Added French .mo and .po files to /languages/ folder. Will load Calendarize it! in French if WPLANG is set to fr_FR in wp-config.php. 
* Update: Make the Upcoming Events Widget fetch events from the hour zero, so that at least same day upcoming events are cached.
* Bug Fixed: Only show upcoming events in sidelist (requires Events Map View add-on).
* Bug Fixed: Remove some extra quotes from the template
* Bug Fixed: When loading calendar in Event List view, ajax was called twice. The first one was an invalid event fetch.
* Bug Fixed: Do not apply the font Lato on the wp-admin
* Bug Fixed: Link in sidebar Widget opening Event in two tabs on some browsers.

Version 2.4.3 rev41161 - October 14, 2013
* Update: Event Details box and Venue Details box font updated to Lato (Matching RSVP Events, Ratings and Reviews and Events Map View add-ons)
* Bug Fixed: When clicking on rrule settings, browser jumps to the top of the page (Recurring events interface)
* Bug Fixed: When loading the WordPress jQuery-UI set non-conflict so any Bootstrap button returns back the old button defined by jQuery-UI, which is what is used in the metabox in the admin.

Version 2.4.2 rev41012 - October 12, 2013
* Update: Added a single event template content filter for post processing of the Event content template (needed when loading add-ons like RSVP Events)

Version 2.4.1 rev41037 - October 10, 2013
* Update: Correctly implement rh_enqueue_script, which is for loading the latest version of a script within our own plugins. 
* Bug Fixed: CSS fix for IE9 and IE10
* Update: Identify External Event Sources (added external_feed property to event object)
* Update: Mark local events, not remote
* New Feature: Added option to load the dynamic version of the Event Details Box in the Event List (Ajax loading). Feature can be enabled in the Options Panel > Calendarize Shortcode panel.
* New Feature: Added backend option to change the date, time and datetime format of the dates in the extended details box on the Event List view.

Version 2.4.0 rev40745 - October 4, 2013
* Bug Fixed: Critical update. Sites with no add-ons installed crash

Version 2.3.9 rev40737 - October 4, 2013
* Bug Fixed: Remove a fix that we added for very few sites, that actually breaks more sites. Related to PHP warnings in Ajax.

Version 2.3.8 rev40705 - October 4, 2013
* Bug Fixed: Upcoming Events not showing when using taxonomy arguments in shortcode. This affects the Venue page too.

Version 2.3.7 rev40593 - October 3, 2013
* Bug Fixed: Removed php warning
* Bug Fixed: Prevent Firefox from opening two tabs when clicking on tooltip Event title.
* Bug Fixed: Widget template Agenda Like - no repeat was broken.
* Update: Set minimum height on sidebar widget in order to show pre-loader.
* Update: Remove the Shortcode template Option tab (this feature has been depreciated after the new templates was introduced)

Version 2.3.6 rev40541 - October 2, 2013
* New Feature: Added support for Social Auto Publish Metabox (requires Social Auto Publish add-on)
* New Feature: Added core procedure to insert End Date into Widget template
* New Feature: Added jQuery UI Mouse to the dependency (requires Community Events add-on)
* Update: Adjusted side list font and size
* Update: Adjusted items fonts and line height

Version 2.3.5 rev40453 - September 29, 2013
* Bug Fixed: Local events not showing properly in the Upcoming Events Widget
* Bug Fixed: Label changed in Default Event Fields tab (Second Date Format field should be Time Format)

Version 2.3.4 rev40437 - September 27, 2013
* Bug Fixed: If any php warning is generated on the Ajax call the calendar breaks. Avoid this by capturing and suppressing warnings on the Ajax using ob.

Version 2.3.3 rev40399 - September 26, 2013
* Update: Moved taxonomy filter from Calendarize Shortcode tab in the Options Panel to the Google Map View tab (requires Map View add-on)

Version 2.3.2 rev40391 - September 26, 2013
* Update: Added version no. inside CSS import to try and overcome a Chrome cache problem

Version 2.3.1 rev40376 - September 25, 2013
* Bug Fixed: Show unlimited number of Pages on the Template Settings drop down.
* Update: Adjusted CSS for Upcoming Events Widget.

Version 2.3.0 rev40373 - September 24, 2013
* New Feature: Added new pre-loader. Webkit browsers will show a spinner, which uses CSS3 animations. Other browsers fallback to an hourglass icon.
* New Feature: Added support for events in Google Map (requires Map View add-on).
* New Feature: Added year and month taxonomy filter (requires Map View add-on)
* New Feature: Added option to disable taxonomies from filter bar through shortcode argument "tax_filter_skip" using comma separated taxonomy slug (requires Map View add-on)
* New Feature: Added support for External Event Sources showing in Upcoming Events Widget (requires External Event Sources add-on)
* Update: Change direct query for get_posts, some sites seem to be blocking direct query.
* Update: Added support for Bootstrap 3.0 (FLAT UI)
* Bug Fixed: When General Settings > Disable link is "yes", do not show event title in tooltip as link as it confuses the user.
* Compatibility Fix: In WPML show calendar events in the language of the page that defined the [calendarizeit] shortcode.

Version 2.2.9 rev39716 - September 9, 2013
* Bug Fixed: When option "Show multi months events" is ON, old events are showing on the events list when repeat date is set.

Version 2.2.8 rev39500 - September 5, 2013
* Bug Fixed: Event not showing when the last event is a repeat date event, and it is the first calendar day of the view
* Bug Fixed: Javascript error on pre WordPress 3.5 admin
* Update: Added an event for post rendering callbacks (currently does nothing and it is provided for future add-ons)
* New Feature: Added option to load the WordPress jQuery UI files.

Version 2.2.7 rev39258 - August 26, 2013
* New Feature: Added new Shortcode making it possible to display a calendar based on the current user logged in. Use [calendarizeit author="current_user"]

Version 2.2.6 rev39168 - August 23, 2013
* Bug Fixed: When adding an event the drop downs for selecting click action are blank (WordPress 3.6)

Version 2.2.5 rev39081 - August 22, 2013
* Bug Fixed: "Get Directions" link in Venue Details Box was broken
* Update: Make e-mail link and website URL render as links in the Agenda List (Venue details)
* Update: Output multiple venues in separate lines if added to the same event.

Version 2.2.4 rev38933 - August 18, 2013
* New Feature: Added support for using WPML (WPML makes a copy of all posts and pages. This will prevent Events from showing up as duplicates in the calendar)

Version 2.2.3 rev38900 - August 14, 2013
* Bug Fixed: Prevent some php warnings
* Bug Fixed: Error in Firefox when modifying a custom field
* Update: Improve CSS styles for certain themes
* Update: Add support for new Map View add-on

Version 2.2.2 rev38819 - August 12, 2013
* Bug Fixed: Prevent php warning
* Update: Added jQuery-UI 1.10.3 for WordPress 3.6 support

Version 2.2.1 rev38684 - August 6, 2013
* Bug Fixed: Events are removed from the Upcoming Events Widget too early

Version 2.2.0. rev38631 - August 2, 2013
* New Feature: Enable Capability filtering for register taxonomies, so that taxonomy capabilities can be customized (requires Capability and Taxonomy add-on for Calendarize it! is installed)

* New Feature: Add filter for event capabilities setup

Version 2.1.9 rev38603 - August 1, 2013
* New Feature: Added filters for Calendar Taxonomy Color Support (add-on needed)

Version 2.1.8 rev38595 - July 31, 2013
* Update: Support dot "." in time fields
* Update: Added the option to change the API registration URL and implement it.

Version 2.1.7 rev38548 - July 30, 2013
* Bug Fixed: When Venue and Organizer taxonomies are disabled, do not output related taxonomy meta fields in post info.
* Bug Fixed: Error when Calendar taxonomy is disabled.
* Update: Add some filters for the no vscroll add-on.

Version 2.1.6 rev38527 - July 26, 2013
* Update: Rollback point: added support for add-ons to customize custom post info types. Initially for Custom Buttons.

Version 2.1.5 rev38499 - July 24,2013
* Update: Add filter for add-ons to be able to add custom post info field rendering methods
* New Feature: Allow adding quick access button with filter

Version 2.1.4 rev38424 - July 22, 2013
* New Feature: Provided alternate accordion script for site themes that are breaking the Twitter Bootstrap accordion used in the Visual CSS Edtior
* Update: Reduced the space between tabs in the Calendar filter so that it is possible to fit more taxonomies.

Version 2.1.3 rev38415 - July 19, 2013
* New Feature: Added support for use of [btn_ical_feed] shortcode in custom fields. Will allow you to create a feed for a single event for Google Calendar or iCal.

Version 2.1.2 rev38110 - July 8, 2013
* Bug Fixed: Tooltip in Firefox was mispositioned

Version 2.1.1 rev37861 - July 1, 2013
* Bug Fixed: Event Sources filter by taxonomy is not working when used in a shortcode
* Bug Fixed: Filter by calendar only works when using the calendar filter button

Version 2.1.0 rev37701 - June 26, 2013
* Update: Behavior change, let the CSS Editor have control of the Event and Venue details boxes
* Update: Center Event and Venue boxes when not set to 100% width

Version 2.0.9 rev37669 - June 25, 2013
* New Feature: Added option (Troubleshooting) to load Javascripts in the footer
* Update: Compatibility fix for some themes where CSS is breaking event positioning in the calendar
* Update: Missing textdomains for Internationalization (translation) has been added

Version 2.0.8 rev37530 - June 21, 2013
* New Feature: Add troubleshooting option to load bootstrap in the footer in an attempt to prevent a jQuery-ui/boostrap conflict with buttons (this is for the CSS Editor)
* Bug Fixed: Visibility check script jQuery dependency.
* Bug Fixed: Line height decimals should not be removed.

Version 2.0.7 rev37479 - June 19, 2013
* Update: Add a default line height to boxes labels
* Bug Fixed: Remove several php warnings
* Update: In wp-admin load js only on rhc admin screens (fixing conflict with Revolution Slider)

Version 2.0.6 rev37191 - June 18, 2013
* Improvement: Added class for a 640px width browser in order to make the calendar navigation and header look nicer in themes where the calendar is inserted on a page with a sidebar.
* New Feature: Added a global option to enable/disable Google Map zoom with mouse wheel.

Version 2.0.5 rev37111 - June 6, 2013
* Bug Fixed: Event and Taxonomy pages not loading content or post info boxes on some themes and plugins that make use of wp_reset_query()
* Bug Fixed: Taxonomy pages should not show external feed (feed from External Event Sources add-on)
* Bug Fixed: Venue Detail Box not showing right venue detail on newly created events
* Update: When creating new posts set the post info box post id to the newly created event.

Version 2.0.4 rev37015 - June 5, 2013
* Bug Fixed: Prevent rhc template loader from taking over non-rhc taxonomy templates.

Version 2.0.3 rev36966 - June 4, 2013
* Update: Add style to compensate for some themes that are breaking the mobile styles on the calendar.
* Update: Compatibility fix, IE8 breaks when upcoming widgets are loaded.

Version 2.0.2 rev36833 - June 1, 2013
* Update: Modified the registration tab so that it uses its own capability. Modified implementation so that Options now require rhc_options instead of manage_options and rhc_license for registration (you need to deactivate and activate the plugin in order to insert he new capabilities)
* Bug Fixed: Problem with [calendarize feed=1] shortcode used with External Event Sources add-on fixed.

Version 2.0.1 rev36824 - May 30, 2013
* Update: Added support for translating values in custom fields, by adding a variable eg. _($instance['Event Details'],'rhc'). You will need to manually add the translation string (this can easily be done if you use our Easy Translation Manager).
* New Feature: Paid Add-ons and Free Add-ons in Downloads (require entering a valid License Key)

Version 2.0.0 rev36624 - May 23, 2013
* New Feature: Added Visual CSS Editor for advanced styling of Calendarize it!
* New Feature: Added Downloads section for installing add-ons and skins (templates)
* New Feature: Allow specifying the zoom value for the Google Map
* New Feature: Detail Venue Box added
* New Feature: Detail Event Box added
* New Feature: Added option to disable a shortcode based on meta_key, implemented this on the venue box and added guy to events to enable/disable venue box
* New Feature: Added .mo and .po files for Italian support
* New Feature: Added metaboxes in wp-admin for Top image on Event Details Page and Event Details box image.
* New Feature: Implemented Top image on Events Details Page and Event Details box (single event template)
* New Feature: Implemented a Visual Layout Selector for custom fields
* New Feature: Implemented new interface for adding custom fields to the Detail Event Box and the Detail Venue Box
* New Feature: Added button to save Default Templates for Detail Event Box and Detail Venue Box
* New Feature: Added button for resetting custom event fields and custom venue fields
* New Feature: Added Contextual Help for Calendarize it!
* New Feature: Added option to enable week numbers and replace the week number label
* New Feature: New navigation for mobile devices (iPhone and Smartphones)
* New Feature: Added Shortcodes [eventpage], [venuepage] and [organizerpage] for use with frameworks like Thesis (Important: The Shortcodes are NOT to be used inside a Post or Page content, as this might crash the website. They are exclusively to be used directly in the templates, or in the Thesis template editor). Install the free add-on "Calendarize it! Content Shortcodes" in order to use the three shortcodes. 
* Update: Moved calendar initialization to the head of the page
* Update: iCal dialog has been rewritten and added option to download .ics file.
* Update: Updated Options Panel to latest version 2.3.1
* Update: fullCalender updated to 1.6.1
* Bug Fixed: Changing the month in the calendar widget was affecting other calendarize instances on the same page
* Bug Fixed: Calendar Widget events spanning more than a day in the next months first days where also rendering in the main month.
* Bug Fixed: First day not considered on the Widget
* Bug Fixed: Compatibility fix. Avoid extending the JS array.prototype object, which in combination with some other plugins seems to overwrite Array methods.

Version 1.3.6 rev36001 - April 24, 2013
* New Feature: Added the taxonomy and terms parameters to the Upcoming Events Widget admin, so that custom taxonomies can be specified as filer in the widget.

Version 1.3.5 rev36001 - April 14 2013
* Bug Fixed: Problem with some parameters in the Upcoming Events Widget Shortcode has been fixed.

Version 1.3.4 rev35967 - April 12, 2013
* Update: Fixed some CSS on Venue and Event Details Page.
* Update: Fixed some CSS related to mobile device support.

Version 1.3.3 rev35961 - April 10, 2013
* New Feature: Allow using the taxonomy and terms argument in the shortcode for upcoming events.
* Update: CSS fixes on the event page and venue page.

Version 1.3.2 rev35791 - April 5, 2013
* Bug Fixed: On events with a long duration, the event was not showing if a repeat date is set, and the event does not start on the same month.

Version 1.3.1 rev35763 - April 4, 2013
* Bug Fixed: Version 2 (template settings) was replacing the Category Archive template.
* Bug Fixed: Use slug in Calendar, Venue or Organizer argument instead of ID.
* Update: Moving map on Venue page
* Update: Event Details Page CSS updated

Version 1.3.0 rev35657 - April 2, 2013
* Update: Fixed issue with responsiveness related to month and navigation
* Update: Fixed issue with Print CSS

Version 1.2.9 rev35442 - March 26, 2013
* Update: Fixed some CSS styling issues on the venue page

Version 1.2.8 rev35248 - March 23, 2013
* New Feature: Add placeholder for print styles and option to disable print styles
* New Feature: Print CSS
* Update: Cleaning up tooltip font size and spacing
* Update: Cleaning up event details page font size and spacing

Version 1.2.7 rev35017 - March 15, 2013
* Bug Fixed: Handle a situation where the event list links where not doing anything when target was not set. Now default is _self.

Version 1.2.6 rev33938 - February 11, 2013
* New Feature: Update Options Panel with Auto Update
* New Feature: Allow download of ics file
* New Feature: Enable shortcode for a single event feed
* New Feature: Enable choosing post types in the upcoming event widgets (this makes the add-on obsolete)
* New Feature: Added styling Modal A option to check more post types and option to choose widget templates
* New Feature: Add additional template widgets where the agenda like data box will not be shown if the same date as previous event date.
* New Feature: Added Modal B widget agents (repeat and no repeat)
* Ne Feature: Implement option to use ajax to fetch events, instead of server side loading of the event in the upcoming events widget
* Update: Adjust fluid content, and fixed agenda box width
* Bug Fixed: Removed debugging code
* Bug Fixed: Missing localization string and incorrect text domain
* Bug Fixed: Correctly disable overlay
* Bug Fixed: When both coordinates and address is set, prefer coordinates
* Bug Fixed: js error when adding a non recurring event
* Bug Fixed: Make the admin show the first day of the week, same as the fronted, and also the labels
* Update: Added new Spanish translation file
* Update: Increase gmap version number to force cache
* Update: Added argument to allow ical feed to display single event
* Update: Force new style.css
* Update: Add a class to differentiate widget calendar from main calendar
* Update: Add specificity to selector to try avoid theme overwriting calendar

Version 1.2.5 rev32988 - January 21, 2013
* Bug Fixed: The old events fix was completely changing the start data of events in the upcoming events.
* Bug Fixed: jQuery.live is depreciated, updated js libraries.

Version 1.2.4 rev31652 - December 26, 2012
* Update: Disable date formatting for Custom Field info
* Update: English .po and .mo files with new labels
* Bug Fixed: Interoperability fix: Let WordPress handle the menu position, as fixed positions have a risk of already be claimed by other plugins.
* Bug Fixed: Use the datetime of the end and start date rather than just the time. Then the programmer can choose what format to display
* New Feature: New function that will output a repeat date following the event list fullcalendar date format
* New Feature: Added the day and month names to the function so the output can be localized
* New Feature: New function for easier setup of the event template when manually setting it: get_repeat_start_date($post_id,$date_format)

Version 1.2.3 rev30654 - November 27, 2012
* Bug Fixed: Date not showing on the admin in Firefox (PC)
* Bug Fixed: Prevent php warning
* New Feature: Allow specifying alternate event source
* New Feature: Added rdate to iCalendar
* Update: Implement the prev and next label settings when generating the cal shortcode
* Update: Enable the field for changing the prev and next button text

Version 1.2.2 rev29705 - November 2, 2012
* New Feature: Allow setting a content wrap on Pages used as templates
* Update: Simplify templates, replace php functions with shortcodes, so that templates can optionally be fully setup at the template page
* New Feature: Added option to enable thumbnail support in case the theme don't
* New Feature: Added option to specify the page id to which the widget links to by default
* Update: Remove spaces from organizer template as they get converted to <p> and </br>
* Update: Separated the event list js code for easier maintenance
* Bug Fixed: If the address is empty do not display the address label in the tooltip
* Bug Fixed: If website field is empty, don't show the field
* Bug Fixed: Remove extra space when fields are empty
* Bug Fixed: Do not show map if all required fields for map are empty
* Bug Fixed: One event list, when address venue or organizer is empty, do not show the label
* Bug Fixed: Do not show description on event list if it is empty (double border lines)
* Bug Fixed: Multiple day events, incorrectly displayed on IE9 and old Firefox. Technical: IE is not capable of using date string yyyy-mm-dd on new Date(date string) odd.
* Bug Fixed: Added an option to ignore a WordPress recommendation, so that event does not return a 404 on sites with plugins or themes that also ignores this recommendation
* Bug Fixed: Load options before init to catch the new ignore standard troubleshooting setting

Version 1.2.1 rev29610 - October 27, 2012
* Bug Fixed: Google calendar treats dtend exclusively 
* Bug Fixed: Modify in_array function, on certain conditions events do not show on any browser but Firefox.
* Bug Fixed: Compatibility fix, added id to a div with postbox class, as it seams that cardamom theme js needs the id or else it crashes.
* Bug Fixed: First date should not contain date into in the URL
* Bug Fixed: Non recurring events that have repeat dates, do not repeat if the start date and end interval is not in the current view date range.
* New Feature: Option to disable link in calendar pop-up
* New Feature: Added option to turn on or off the debug menu


Version 1.2.0 rev29423 - October 19, 2012
* New Feature: Added support for Exceptions when creating recurring events
* New Feature: Added support for arbitrary recurring events
* New Feature: Added option to specify calendar URL to link the upcoming events widget
* Bug Fixed: Adjusted margin on "Calendar" and "Today" button
* Bug Fixed: Show correct date of repeat instance info fields on event page when clicking on a repeat event. 
* Bug Fixed: When choosing to filter by several taxonomies (it was only filtering by 1 taxonomy)
* Updated: Layout fixed for WordPress 3.5


Version 1.1.4 rev29164 - September 23, 2012
* New Feature: Provided an option to display all Calendarize It! Post Types in the main calendar
* Bug Fixed: Add Organizer image and HTML content

Version 1.1.3 rev29014 - August 31, 2012
* Bug Fixed: Make sure featured image is used for events
* Bug Fixed: $.curCSS is depreciated in jQuery 1.8, updated full calendar.js
* Improvement: Optional Tooltip title link disable or enable
* Bug Fixed: All Day events where showing time in start and end dates in popup
* Bug Fixed: Option to enable/disable ical button on the calendar widget

Version 1.1.2 rev28899 - August 18, 2012
* New Feature: Render short codes in before/after template HTML; added shortcode rhc_sidebar for adding sidebars to the template
* New Feature: Option to make taxonomies into fields, hyperlinks to the taxonomy page
* Update: Allow the parameter to be 'false' so that the specified template does not render any sidebar
* Update: Missing text domain on the words: Start, End and Address in the pop-up
* Update: Added optional rewrite procedures for sites with problems with permalinks, updated Options Panel, pushed plugin init to after_theme_setup for theme integration support. Added default organizers template, include code (but not enabled) for handling calendar inside a tab
* Bug Fixed: Multiple day events were only highlighted the first day in the calendar widget
* Bug Fixed: When the end date time is less than start time it was incorrectly calculating the number of days
* Bug Fixed: Upcoming Events Widget, when event is all day, time should not display
* Bug Fixed: On most themes, the image pushes the content on the event list
* Bug Fixed: Prevent CSS3 transition from modifying the event rendering behavior

Version 1.1.1 rev28549 - August 1, 2012
* Bug Fixed: Frontend breaking when showing Calendar and Upcoming Events Widget at the same time
* Update: jQuery updated to version 1.8.22
* New Feature: Option to disable built-in Taxonomies from Options

Version 1.1.0 rev28238 - July 27, 2012
* New Feature: Provide option to disable loading Calendarize It! templates
* New Feature: Hide dialog when pressing escape key
* New Feature: Support for iCal (OSX Calendar) and Google Calendar feed
* New Feature: Allow to set iCal parameters
* New Feature: Added better support for setting time and data format 
* New Feature: Added month and day names to the Options Panel
* New Feature: Enable default options in Calendar in widget
* New Feature: Implement day and month names in upcoming events widget from Shortcode options
* New Feature: Included Spanish .mo files
* Update: Modified widget for current rule event, changed date format to full calendar format to support only one date format
* Update: Added new language strings in .po and .mo files
* Bug Fixed: Provide a custom URL for the calendar link (implemented non-default event and calendar display slugs)
* Bug Fixed: Recurring events that repeat many times where being excluded from the upcoming events widget
* Bug Fixed: Recurring events only showing in Chrome. rule UNTIL, if time not set, should include that days event in recurring events
* Bug Fixed: Missing end date time, added formatting to info box inside the admin so it looks like the frontend
* Bug Fixed: Upcoming events not showing on Internet Explorer, Firefox and Safari
* Bug Fixed: Spacing on Upcoming Events widget
* Bug Fixed: Default time format with 2 digit minutes
* Bug Fixed: When any of the taxonomy slugs is left empty in the options panel, in WordPress 3.4.1 every pages becomes not found
* Bug Fixed: Missing textdomain for "Every year", "Custom Interval", "No access"


Version 1.0.2 rev27083 - July 7, 2012
* Bug Fixed: HTML entries in event title
* Bug Fixed: Set first day of the week was not working
* Bug Fixed: Typographical error "Wednsday" changed to "Wednesday" in drop down for choosing start day of the week
* New Feature: Added backend options to customizing month, week, day and event list time formats. As well as title, column, event time and agenda axis
* New Feature: Added sort by date in the event admin
* New Feature: Allow hookup of external jQuery UI themes (this allows you to easily add your own jQuery UI themes by using the http://jqueryui.com/themeroller/. It is important that you add a CSS Scope (.rhcalendar) when exporting the theme in order to limit the usage of the CSS to Calendarize it)
* New Feature: Allow hookup of external templates (this allow you to update the plugin without overwriting any customizations you have made to the templates)
* New Feature: Provide configuration options for agenda view
* Update: added latest strings to localization files

Version 1.0.1 rev26587 - June 30, 2012
* Bug Fixed: Incorrect localization function giving warning
* Bug Fixed: Start and End date subtitle where not being localized
* Update: Added filters to event list in wp-admin
* Update: Added load text domain for Calendarize
* Update: Added base files for translation (/languages)
* Update: Added argument to control the start and end formats in the event list

Version 1.0.0 rev26066 - June 21, 2012
* First release.


== SOURCES - CREDITS & LICENSES ==

We have used the following open source projects, graphics, fonts, API's or other files as listed. Thanks to the author for the creative work they made.

1) FullCalendar jQuery plugin
   http://arshaw.com/fullcalendar/

DISCLAIMER: FullCalendar is great for displaying events, but it isn't a complete solution for event content-management. Beyond dragging an event to a different time/day, you cannot change an event's name or other associated data. It is up to you to add this functionality through FullCalendar's event hooks.

2) jQuery UI ThemeRoller
   http://jqueryui.com/themeroller/


