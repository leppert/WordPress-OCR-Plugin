=== OCR ===
Contributors: formasfunction
Donate link: http://formasfunction.com
Tags: ocr, optical text recognition, images, attachments, media
Requires at least: 2.9
Tested up to: 2.9
Stable tag: 0.1.0

A plugin for extracting text from attached images using OCR via Tesseract.

== Description ==

A plugin for extracting text from attached images using [OCR](http://en.wikipedia.org/wiki/Optical_character_recognition) via [Tesseract](http://code.google.com/p/tesseract-ocr/).
This plugin adds a field to each image upload named 'OCR Text' containing the recognized text characters within the file.
This text can then be edited for accuracy and added to images to improve search and SEO results.

The OCR plugin requires [PHP5](http://php.net/) and two command line utilities: 
[ImageMagick](http://www.imagemagick.org) for preparing the images and [Tesseract](http://code.google.com/p/tesseract-ocr/) for the actual OCR.
These utilities must be manually installed on your server and executable by PHP. **This process, and consequently this plugin, is recommended only for advanced users.**

== Installation ==
1. Install Tesseract OCR on your server (http://code.google.com/p/tesseract-ocr/)
2. Install ImageMagick on your server (http://www.imagemagick.org)
3. Upload `ocr.php` to the `/wp-content/plugins/` directory
4. Activate the plugin through the `Plugins` menu in WordPress
5. Configure the plugin through the `Plugins > OCR` link in the sidebar menu in WordPress

== Frequently Asked Questions ==

= What is Tesseract OCR and where do I get it? =

Tesseract OCR is an open source [optical character recognition](http://en.wikipedia.org/wiki/Optical_character_recognition) library that
the WordPress OCR plugin uses to extract text from images.
The library as well as installation instructions can be found at
http://code.google.com/p/tesseract-ocr/

= How do I know if / where I have Tesseract installed on my server? =

Linux:

1. SSH into your server and type `which tesseract`.
2. If Tesseract is installed and in your shell environment PATH the terminal should return a path similar to `/opt/local/bin/tesseract`.
3. Place this path in the configuration of the OCR plugin through the `Plugins > OCR` link in the sidebar menu in WordPress

= What is ImageMagick and where do I get it? =

ImageMagick is a an open source, server side, image manipulation library.
The WordPress OCR plugin requires the `convert` utility specifically.
The library as well as installation instructions can be found at
http://www.imagemagick.org

= How do I know if / where I have ImageMagick installed on my server? =

Linux:

1. SSH into your server and type `which convert`.
2. If ImageMagick is installed and in your shell environment PATH the terminal should return a path similar to `/opt/local/bin/convert`.
3. Place this path in the configuration of the OCR plugin through the `Plugins > OCR` link in the sidebar menu in WordPress

= Why does OCR require ImageMagick? =

Tesseract is only compatible with [TIFF](http://en.wikipedia.org/wiki/Tagged_Image_File_Format) images.
Therefor, when a web formatted image (JPG, GIF, PNG, etc) is uploaded, a temporary TIFF image must be created via 
ImageMagick in order for Tesseract to detect the text within the image. This TIFF is discarded once the OCR has been completed.

= Where is the detected text stored? =

The text detected by the OCR plugin is added to the image as a [custom field](http://codex.wordpress.org/Custom_Fields) named `ocr_text`.
See http://codex.wordpress.org/Custom_Fields for instructions on using the `ocr_text` field in your templates.

= Where can I edit the detected text? =

The text detected by the OCR plugin is available in a text area labeled 'OCR Text' both in the 'Add an Image'
model while attaching an image to a post and while editing a previously uploaded image under the 'Media' section of your WordPress install.

= What is the 'Resize percentage' configuration option? =

The OCR plugin is tailored to detecting text in images with ~12pt text at 72dpi.
ImageMagick is used to upscale the temporary TIFF images fed to Tesseract as Tesseract is generally more accurate with
larger type, even if it's been upscaled from a smaller source. If you wish to disable this option simply set this
configuration option to `100%` and no resizing will occur.

= Will the OCR plugin work on versions of WordPress other than 2.9? =
Possibly. The OCR plugin simply hasn't been tested on any other versions.

== Changelog ==

= 0.1.0 =
Initial Release.