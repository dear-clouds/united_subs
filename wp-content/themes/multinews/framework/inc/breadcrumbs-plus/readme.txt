=== Breadcrumbs Plus ===
Contributors: albertochoa
Plugin URI: http://snippets-tricks.org/proyectos/breadcrumbs-plus-plugin/
Donate link: http://snippets-tricks.org
Tags: navigation, menu, breadcrumb, breadcrumbs, bbpress, forum
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 0.3

An easy template tag for showing a breadcrumb menu on your site.

== Description ==

*Breadcrumbs Plus* provide links back to each previous page the user navigated through to get to the current page or - in hierarchical site structures - the parent pages of the current one.

It gives you a new template tag called `breadcrumbs_plus()` that you can place anywhere in your template files.

= Frameworks =

* Genesis
* Hybrid
* Nifty
* Thematic
* Thesis

= Plugins =

* bbPress

= Localization =

* English - (en_EN)
* French - (fr_FR)
* Italian - (it_IT)
* Polish - (pl_PL) by Artur Omazda
* Spanish - (es_ES)

== Installation ==

1. Upload `breadcrumb-plus` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Add the appropriate code to your template files.

== Frequently Asked Questions ==

= How do I add it to my theme? =

You would use this call:

`
<?php if ( function_exists( 'breadcrumbs_plus' ) ) breadcrumbs_plus( array( 'singular_post_taxonomy' => 'category' ) ); ?>
`

== Changelog ==

= 0.4 =
* Added support for bbPress Plugin
* Cleaned up the code

= 0.3 =
* Added Polish language
* Added support for Genesis Theme
* Added support for custom post types and taxonomies
* Added support for hierarchies
* Added support for WordPress 3.1's post type archives
* Added readme.html file

= 0.2 =
* Added support for Date (Day, Month and Year)
* Added CSS for Style Title, Homelink and Separator
* Cleaned up the code

= 0.1 =
* First public release
