=== Plugin Name ===
Contributors: formasfunction
Donate link: http://formasfunction.com
Tags: ocr, images, optical text recognition, attachments
Requires at least: 2.9
Tested up to: 2.9
Stable tag: 0.01

A plugin for extracting the text from attached images using OCR via Tesseract.

== Description ==

A plugin for extracting the text from attached images using OCR via Tesseract.
This plugin adds a field to each image upload named 'OCR Text' containing the recognized text characters within the file.
This text can then be edited for accuracy and added to images to improve search and SEO results.
Requires both Tesseract (http://code.google.com/p/tesseract-ocr/) and ImageMagick (http://www.imagemagick.org) installed on the server.

== Installation ==
1. Install Tesseract OCR on your server (http://code.google.com/p/tesseract-ocr/)
2. Install ImageMagick on your server (http://www.imagemagick.org)
3. Upload `ocr.php` to the `/wp-content/plugins/` directory
4. Activate the plugin through the 'Plugins' menu in WordPress
5. Configure the plugin through 'Plugins > OCR Plugin' in the sidebar menu in WordPress

== Changelog ==

= 0.01 =
Initial Release.