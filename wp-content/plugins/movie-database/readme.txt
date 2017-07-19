=== Movie Database ===
Contributors: Psynoxis
Donate link: http://www.heimkino-praxis.com/movie-database/
Tags: movie, movies, cinema, home cinema, movie theater, movie database
Requires at least: 4.0
Tested up to: 4.5
Stable tag: 1.0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a movie database to WordPress. You can manage your movie collection and show everyone, which movies you were watching recently.

== Description ==

This plugin is made for home cineasts who like to have comprehensive control over their movie collection and detailed information about their movie consumption, including when, how often, and with whom they watched a movie.

Features:

* Extended statistics about the movies you were watching in your home cinema
* Manage movies you own (sources) as well as movies you lent out from someone
* Personal rating for the movie itself and the quality of a source
* Use built in Wikipedia access to get missing information
* What would you like to watch in the near future? Use the wishlist!
* Some tools to find bad quality sources, unseen sources or best movies

If you add a screening or source, type the movie's name and pick the entry from the list. If there is nothing to pick (meaning, the movie is not yet in the database), a new movie will be created automatically.

== Installation ==

1. Upload the folder "movie-database" to "/wp-content/plugins/"
2. Activate the plugin through the "Plugins" menu in WordPress
3. Check out the "Movie Database" menu item in your admin menu
4. After some time, add the widget to your frontend, if you like

== Frequently Asked Questions ==

= How can I delete a movie? =

Right now, you can't. Movies cannot be deleted, since there could be screenings or sources which point to the movie (even if there are none). Just edit the movie and change its name to any other movie.

= I have two friends with the same name. How can the plugin distinguish between them? =

Write your friend's names like Michael@SomeGuy1, Michael@SomeOtherGuy and so on. Only the part before the @ sign will be visible.

== Screenshots ==

1. List of your latest screenings
2. Fast way to add a screening (and also a new movie, if it is not yet in the database)
3. List of all sources (aka. Blu-rays, DVDs)
4. Statistics about your movie database

== Changelog ==

= 1.0.6 =
* Fixed a bug that prevented loading of Wikipedia content on secure HTTPS websites

= 1.0.5 =
* Fixed a bug where frontend widget did not show any movies, if output of sources of type "file" was disabled

= 1.0.4 =
* Fixed a bug where rating stars were invisible in frontend widgets
* Fixed view of plugin dashboard and forms for small screens

= 1.0.3 =
* Updated headline styles of main view
* Changed admin menu icon to icon font symbol
* Changed rating star icons to icon font symbols

= 1.0.2 =
* Widget for latest sources outputs if source is 3D

= 1.0.1 =
* The id textfield left of the movie title is no longer visible in forms

= 1.0 =
* First public version

== Upgrade Notice ==

= 1.0.3 =
* Fixed multiple output of screenings in the widget, if there are multiple sources of a movie

= 1.0.2 =
* Fixed default layout of sidebar widgets

= 1.0.1 =
* Fixes a bug with ratings (stars) in tables, caused by changes in WordPress 3.9
* Improved movie selection in screenings and sources forms
* Fixed some positioning problems with the title dropdown

= 1.0 =
You should install this because it can save kittens.