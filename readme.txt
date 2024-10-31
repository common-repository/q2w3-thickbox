=== Q2W3 Thickbox ===
Contributors: Max Bond
Tags: images, thickbox, gallery, pop-up, popup, window, q2w3
Requires at least: 2.8.0
Tested up to: 3.2.1
stable tag: trunk

This plugin enables thickbox pop-up window on thumbnail images. Minimal system requirments WP 2.8.0 and PHP 5.

== Description ==

Thickbox is a small javascript library for displaying images or other web content in a popup window. It is already bundled with Wordpress.
You may see how thickbox works on WordPress admin pages (all popup windows are thickbox-enabled there).  

This plugin allows you to enable thickbox for public WordPress pages.
As soon as plugin is installed, all your thumbnail images will be opened in popup window.
WordPress galleries will also be thickbox supported, but in order to operate correctly, gallery shorttag should be used with link=&quot;file&quot; attribute ([&nbsp;gallery link="file"&nbsp;]).
In gallery mode, popup window will have navigation links to next and previos images.

Popup window title is taken from images "alt" attribute.

What are the differences from other similar plugins?

To enable thickbox window you must set class="thickbox" attribute to a link element. 
I saw plugins with complex php functions to proccess post content for setting this attributes or 
plugins that required manual edit of your posts to enable thickbox functionality. 
This plugin is different - it uses small jQuery code for setting all needed classes and attributes.
You may change this jQuery code on a plugin's settings page. It means you may completely change plugin default behavior. 
All you need is a basic jQuery knowledge.

Vist plugin homepage to see how it works.

Supported languages: English, Russian, Hindi (thanks to Ashish Jha).

== Installation ==

1. Check minimal system requirements: WordPress 2.8.0, PHP 5.0.0.
2. Unzip and upload `q2w3-thickbox` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

== Screenshots ==

1. Plugin settings page