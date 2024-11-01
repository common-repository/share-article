=== Share Article ===
Contributors: evosites
Donate link: http://evosites.nl
Tags: share, article, post
Requires at least: 4.4
Tested up to: 4.8
Stable tag: 1.1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily share articles from around the web on your own blog. The post includes the articles first paragraph, an image and an attribution to the source.

== Description ==

If you read something interesting on Twitter, you Retweet. If you like something on Facebook, you Share. If you read an interesting article on a website, you probably can share it to many social media accounts.

But what if you want to share the article on your own website? Share Article is a plugin that will make sharing articles from around the web a bit easier. Just copy and paste the URL and it will create a new post, saves it as draft ready for you to publish or edit if necessary.

The post will contain:

* The same title as the original, plus an attribution the source, for example: "Nice Article (via Example.com)"
* A featured image (if an image is found)
* The first paragraph of the article
* A (customizable) link to the source, for example: Read more on: example.com

== Installation ==

1. Install the plugin like you always install plugins, either by uploading it via FTP or by using the "Add Plugin" function of WordPress.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings -> Share Article to setup how you like to display the source.
4. Go to Posts -> Share Article to share an article.

== Frequently Asked Questions ==

= My post doesn't have an image / wrong title / wrong first paragraph =

The plugin tries to fetch some information from the URL you provided. It first looks at the meta-tags. If those aren't provided, it tries to get the information out of the article itself. If the original article doesn't have the meta-tags defined and the article isn't well structured, things can get messy.

= What languages are supported? =

We're from The Netherlands, so obviously the plugin is translated to Dutch. The plugin itself is written in English (not our native language, so suggestions for improvements are welcome!). Other translations aren't available. If you want to help out, give us a shout! An English .pot file is provided.

== Screenshots ==

1. Choose how to display the source, which is shown underneath the post. You can provide your own text and show the domain (example.com) or the full URL (http://example.com/article/to/share)
2. Simply past te URL from the article you want to share and click Next
3. A new post is created, saved as draft. It tries to set the title and the first paragraph. If an image is found, it is set as Featured Image. It's a regular post, so you can add tags, categories, make changes, etc.

== Changelog ==

= 1.1.3 =

* Fix include errors

= 1.1.2 =

* Made registering options more DRY
* Fixed bug when no image is found

= 1.1.1 =

* Fixed a minor bug where entering a wrong or no URL was leading to 'Sorry, you have no access to this page'. Now an more informative error message is shown

= 1.1.0 =

* Added an option to choose the target of the source link (new tab or same tab)

= 1.0 =

* Initial release



== Upgrade notice ==

= 1.0 =

* Initial release
