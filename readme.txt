=== edshelf Widget ===
Tags: edshelf, education, edtech, collection, apps, tools, embed, widget
Contributors: edshelf, mikeleeorg
Tested up to: 3.5
Requires at least: 2.9
Stable Tag: 0.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a shortcode and template tag for embedding an edshelf widget onto your site.

== Description ==

[edshelf](http://edshelf.com) helps you find the most effective educational tools for your specific needs. You can also create collections of tools you like, or browse collections created by others.

This plugin provides a shortcode so you can easily embed an edshelf widget onto your site.

The shortcode is: `[edshelf-collection-widget id="NNNN" height="YYY" type="TTTT"]`

The template tag is: `edshelf_collection_widget( NNNN, YYYY, 'TTTT' );`

Where `NNNN` is the ID of the collection you want to embed, `YYY` is the height of the widget in pixels, and `TTTT` is the type of widget. You can get this ID from the collection on edshelf, in the Widget module at the bottom of the right column. The choices for the type of widget are "full" (the default setting), "compact", or "list".

== Installation ==

1. Download and unzip the plugin file.
1. Upload the `edshelf-widgets` folder into your `/wp-content/plugins/` directory.
1. Go to the Plugins section of your WordPress admin and activate the "edshelf Widgets" plugin.
1. Go to [edshelf](http://edshelf.com/) and view a collection you want to embed.
1. Look for the Widget module at the bottom of the right column. In that module will be some code.
1. Look for a 4 or 5-digit number in that code. That number is the ID number of the collection.
1. Go to the blog post or page on which you want to embed this collection widget.
1. Type in the following WordPress shortcode in the text editor: `[edshelf-collection-widget id="NNNN" height="YYY" type="TTTT"]`.
1. The settings are: `NNNN` is the collection ID you just found. `YYY` is the height of the widget in pixels. `TTTT` is the type of widget, where your choices are "full" (the default setting), "compact", or "list".
1. Or use the template tag `edshelf_collection_widget( $id, $height, '$type' );` if you are familiar with PHP.
1. And you're done!

== Frequently Asked Questions ==

= Do I need to use this plugin to embed an edshelf widget? =

If you want to embed this widget within a blog post, then yes. The WordPress text editor strips out JavaScript by default. Since the edshelf widget's embed code uses JavaScript, simply copying and pasting the embed code seen on edshelf will not work.

This widget gives you the next best thing: a shortcode for your blog posts and pages that will automatically embed the edshelf widget for you.

If you know PHP, a template tag is also available.

= I only see one widget. Is that it? =
Yes, edshelf only has one widget so far. More will be coming. Stay tuned!

= How tall can I make the widget? =
As tall as you want!

= How can I set the width of the widget? =
We don't offer that option yet, but the widget will automatically stretch to 100% of whatever space you put it in - so if you know HTML and CSS, you can just set the width of the parent container holding this widget.

= Can I embed more than one widget to a page? =
Sorry, not yet. Our widget will not work properly if you try to embed more than one to a page. We will fix this in a later release.

= Is this widget available in other languages? =
Sorry, not yet. We do intend to offer multiple language support in the future though.

= Where can I go for more help? =
If you need additional assistance, email us at [support@edshelf.com](mailto:support@edshelf.com).

== Changelog ==

None yet.