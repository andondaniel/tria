=== NS Featured Posts ===
Contributors: rabmalin
Donate link: http://wordpress.org/plugins/ns-featured-posts/
Tags: post, custom post type, custom, posts, meta, plugin, featured, featured-post
Requires at least: 3.5.1
Tested up to: 3.9.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin for making posts, pages or custom post types featured. User can enable/disable Featured for selected post types.

== Description ==

<h3>NS Featured Posts</h3>This plugin add checkbox for each list item. You can easily check /  uncheck the Featured. Checking the Featured will set the meta value 'yes' for meta key '_is_ns_featured_post'. From plugin settings, you can choose to which post types you want Featured functionality.

= Using in theme =
This plugin only set / unset the meta key for asigned post. You need to implement it in your theme to get Featured functionality.

Example:
$query = new WP_Query( array( 'meta_key' => '_is_ns_featured_post', 'meta_value' => 'yes' ) );
This will fetch the list of post which are checked as Featured.


== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' Plugin Dashboard
1. Select 'ns-featured-posts.zip' from your computer
1. Upload
1. Activate the plugin on the WordPress Plugin Dashboard
1. Place the 'NS Featured Posts Widget' into a Widget area through the 'Appearance -> Widgets' menu in WordPress.

= Using FTP =

1. Extract 'ns-featured-posts.zip' to your computer
1. Upload the 'ns-featured-posts' directory to your 'wp-content/plugins' directory
1. Activate the plugin on the WordPress Plugins dashboard
1. Place the 'NS Featured Posts Widget' into a Widget area through the 'Appearance -> Widgets' menu in WordPress.


== Frequently Asked Questions ==

= There is something cool you could add... =

Nice, make a post on the [Support Forum](http://wordpress.org/support/plugin/ns-featured-posts "NS Featured Posts Support") and let us know. We are always looking for ways to improve our plugins.

== Screenshots ==

1. Admin Settings page
2. Example of featured in Post listing

== Changelog ==

= 1.0.1 =
* Add Featured Posts Widget
* Bug fixes

= 1.0.0 =
* Initial release

== Upgrade Notice ==
NS Featured Posts

