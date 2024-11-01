=== Plugin Name ===
Contributors: jgwhite33
Donate link: http://www.dealpixel.com/wp-amazon-ads/
Tags: amazon, affiliate, listing, product, multi-author, revenue share, ads, monetize
Requires at least: 2.5
Tested up to: 4.4.2
Stable tag: trunk

WP Amazon Ads - allows you to easily insert Amazon product listings into your WP posts, and earn commission from sales.

== Description ==

Allows you to insert a listing of related Amazon products, on the single post page by using a custom field called amazon_search and inserting simple code in your template file.
The listings are completely customizable according to parameters defined in the admin panel. If you include an Amazon Associate ID, you can even earn commission! Also allows you to share revenue with your authors on a multi-author blog. Whoever wrote the post gets credit in the listings. Creates a custom field on the author profile pages so they can input their campaign ID. Whoever wrote the post gets credit in the listing.

A few of the features:

*   Specify the search with a custom field in the post called amazon_search
*   Allows you to use the Amazon Associate Network
*   Allows multi-author blogs to share revenue, you can even specify the percentage to share
*   Can share revenue with the author of the post if you desire
*   Uses advanced search parameters
*   Display is easily customizable
*   Hides the affiliate link to Amazon

== Installation ==

WP Amazon Ads is installed like any other Wordpress plugin.

1) Download the latest package from the downloads page (http://wordpress.org/extend/plugins/wp-amazon-ads/).

2) Upload the whole directory into your wordpress plugins directory (usually, yoursite/wp-content/plugins). The plugin must reside in a sub-folder called "wp-amazon-ads" (lower-case!) as supplied in the zip file, else it WON’T WORK

3) Go into the Wordpress admin panel, find Plugins and WP Amazon Ads should be listed. Click Activate to activate!


Using WP Amazon Ads


1) You can also get the listings by placing the following code in your template file for your single post. Usually called single.php. Place it inside the loop. I like to place it right after the_content tag.

`<?php if(function_exists('wp_amazon_ads')) {wp_amazon_ads($post->ID);}?>`

* After you edit your template file then all you have to do is add a custom field to the post called amazon_search. Set the value for what you are searching for.

ex:
Name: amazon_search
Value: ipod

3) View the post and you should see the listing show up.

4) Go to the "WP Amazon Ads" admin panel under the Settings dropdown, and modify what you would like.

5) For multi-author blogs, each author needs to enter their campaign ID on their profile page in the input field added at the bottom.

Notes: 
* If the amazon_search custom field is not used or blank then the ads will not be displayed.


== Frequently Asked Questions ==

= I don't see the mulit-author settings. =

You must be using Wordpress V2.8 or higher.

= Why should I contribute or leave the powered by link? =

Because you're a cool person and like to show your appreciation.

== Screenshots ==

1. View on a Post
2. View of Admin Panel

== Changelog ==

= 1.0 =
* No changes, first released version.

= 1.1 =
* Minor bug fixes.

= 1.2 =
* Missed a bug.

= 1.3 =
* Minor bug fixes.

= 1.4 =
* Tested on latest version of Wordpress.