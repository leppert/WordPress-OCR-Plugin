<?php
/**
 *     ---------------       DO NOT DELETE!!!     ---------------
 * 
 *     Plugin Name:  OCR
 *     Plugin URI:   http://formasfunction.com/code/wordpress/ocr
 *     Description:  A plugin for extracting the text from attached images using OCR via tesseract
 *     Version:      0.01
 *     Author:       Greg Leppert
 *     Author URI:   http://formasfunction.com
 *
 *     ---------------       DO NOT DELETE!!!     ---------------
 *
 *    This is the required license information for a Wordpress plugin.
 *
 *    Copyright 2009  Greg Leppert  (email : greg@formasfunction.com)
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program; if not, write to the Free Software
 *    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *     ---------------       DO NOT DELETE!!!     ---------------
 */

class OCR {
	function AnalyzeImage($image_id){
		$upload_dir = wp_upload_dir();
		$upload_dir = $upload_dir['basedir'];
		$image_path = $upload_dir.'/'.get_post_meta($image_id, '_wp_attached_file', true);
		$temp_image = $upload_dir.'/ocr_image.tif';
		$temp_text 	= $upload_dir.'/ocr_text';
		$command 	= '/opt/local/bin/convert -resize 200% '.$image_path.' '.$temp_image.' && /opt/local/bin/tesseract '.$temp_image.' '.$temp_text.' && cat '.$temp_text.'.txt && rm -f '.$temp_text.'.txt '.$temp_image;
		$ocr_text 	= shell_exec($command);
		add_post_meta( $image_id, 'ocr_text', $ocr_text, true );
	}
	
	function SubMenuItem(){
		add_submenu_page('plugins.php', 'OCR Plugin Configuration', 'OCR Plugin', 8, __FILE__, array( $this, 'SettingsPage' ) );
	}
	
	function SettingsPage(){
		echo '<div class="wrap">';
		echo '<p>Here is where the form would go if I actually had options.</p>';
		echo '</div>';
	}
}

if(!$ocr_plugin){ $ocr_plugin = new OCR(); }
add_action( 'add_attachment', 	array( $ocr_plugin, 'AnalyzeImage' ) );
add_action( 'admin_menu', 		array( $ocr_plugin, 'SubMenuItem' ) );