<?php
/*
Plugin Name: BP External Activity
Plugin URI: http://wordpress.org/extend/plugins/bp-external-activity/
Description: Allows admins to import data from an arbitrary RSS feed into their BuddyPress sitewide activity stream
Version: 1.0
Requires at least: WordPress 2.9.1 / BuddyPress 1.2
Tested up to: WordPress 2.9.2 / BuddyPress 1.3 trunk
License: GNU/GPL 2
Author: Boone Gorges
Author URI: http://teleogistic.net
*/

/* Based in part on Andy Peatling's BP External Group Blogs */

/*
	$external_activity_feeds must be populated with the details of each feed you'd like to import into the stream. feed_url is the URL of the RSS or Atom feed. feed_action is the template for the activity action message; it should contain two instances of %s, the first of which represents the user name and the second of which represents the link title. Enter whatever you'd like for component and type. show_text is the text that appears in the activity filter dropdown menu.
*/


	$external_activity_feeds = array(
		array(
			'feed_url' => 'http://commons.gc.cuny.edu/wiki/index.php?title=Special:RecentChanges&feed=atom',
			'feed_action' => '%s edited the wiki page %s',
			'component' => 'wiki',
			'type' => 'wiki_edit',
			'show_text' => __( 'Show Wiki Edits', 'bp-external-activity' )
			),
		array(
			'feed_url' => 'http://feeds.delicious.com/v2/rss/boonebgorges?count=15',
			'feed_action' => '%s posted the link %s on Delicious',
			'component' => 'delicious',
			'type' => 'new_delicious_link',
			'show_text' => __( 'Show Delicious Links', 'bp-external-activity' )
			),
	);




/* Only load the plugin functions if BuddyPress is loaded and initialized. */
function bp_external_activity_init() {
	require( dirname( __FILE__ ) . '/bp-external-activity.php' );
}
add_action( 'bp_init', 'bp_external_activity_init' );


/* On activation register the cron to refresh external blog posts. */
function bp_external_activity_activate() {
	wp_schedule_event( time(), 'hourly', 'bp_external_activity_cron' );
}
register_activation_hook( __FILE__, 'bp_external_activity_activate' );

/* On deacativation, clear the cron. */
function bp_external_activity_deactivate() {
	wp_clear_scheduled_hook( 'bp_external_activity_cron' );

	/* Remove all external blog activity */
	if ( function_exists( 'bp_activity_delete' ) )
		bp_activity_delete( array( 'type' => 'external_activity' ) );
}
register_deactivation_hook( __FILE__, 'bp_external_activity_deactivate' );

?>