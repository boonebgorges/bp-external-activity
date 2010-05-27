=== BP External Activity ===
Contributors: boonebgorges, cuny-academic-commons
Tags: buddypress, activity, external
Requires at least: WordPress 2.9.1 / BuddyPress 1.2
Tested up to: WordPress 2.9.2 / BuddyPress 1.2.4.1
Stable Tag: 1.0

== Description ==

Allows admins to import data from an arbitrary RSS feed into their BuddyPress sitewide activity stream

The plugin imports RSS feeds every hour. You may find that you need to decrease your Simplepie cache time to make it work:
`add_filter( 'wp_feed_cache_transient_lifetime', create_function('$a', 'return 600;') );`
reduces the RSS cache to ten minutes, for example. Put that in your bp-custom.php file if you are having problems with the plugin.

At the moment, the plugin uses the Author field from the RSS feed to look for a matching author in your WP database. If it doesn't find one, it uses the unlinked text 'A user', as in 'A user edited the wiki page...'.

== Installation ==

 1. Upload the bp-external-activity directory to your WP plugins folder and activate
 2. Open loader.php and replace the sample feed data with your own

== Changelog ==

= 1.0 =
* Initial release.