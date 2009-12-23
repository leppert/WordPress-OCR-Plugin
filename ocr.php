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
		if(getimagesize($image_path)){ //only go through the steps for OCR if the file is an image
			$temp_image = $upload_dir.'/ocr_image.tif'; //tesseract requires a tiff
			$temp_text 	= $upload_dir.'/ocr_text';
			$command 	= get_option('ocr_imagemagick_path').' -resize '.get_option('ocr_resize_amount').'% '.$image_path.' '.$temp_image.' && '.get_option('ocr_tesseract_path').' '.$temp_image.' '.$temp_text.' && cat '.$temp_text.'.txt && rm -f '.$temp_text.'.txt '.$temp_image;
			$ocr_text 	= shell_exec($command);
			add_post_meta( $image_id, 'ocr_text', $ocr_text, true );
		}
	}
	
	function SubMenuItem(){
		add_submenu_page( 'plugins.php', 'OCR Plugin Configuration', 'OCR Plugin', 'administrator', __FILE__, array( $this, 'SettingsPage' ) );
		add_action( 'admin_init', array( $this, 'RegisterSettings' ) );
	}
	
	function RegisterSettings() {
		register_setting( 'ocr-settings-group', 'ocr_imagemagick_path' );
		register_setting( 'ocr-settings-group', 'ocr_tesseract_path' );
		register_setting( 'ocr-settings-group', 'ocr_resize_amount' );
	}
	
	function SettingsPage(){
		?>
		<div class="wrap">
			<h2>OCR Settings</h2>
			<form method="post" action="options.php">
			    <?php settings_fields( 'ocr-settings-group' ); ?>
			    <table class="form-table">
			    	<tr valign="top">
			    		<th scope="row">Absolute Path to <a target="_blank" href="http://www.imagemagick.org">ImageMagick's</a> <a target="_blank" href="http://www.imagemagick.org/script/convert.php">convert</a><br><i style="font-size:10px;">(ex: /opt/local/bin/convert)</i></th>
			    		<td><input type="text" name="ocr_imagemagick_path" value="<?php echo get_option('ocr_imagemagick_path'); ?>" /></td>
			    	</tr>
			    	<tr valign="top">
			    		<th scope="row">Absolute Path to <a target="_blank" href="http://code.google.com/p/tesseract-ocr/">Tesseract</a><br><i style="font-size:10px;">(ex: /opt/local/bin/tesseract)</i></th>
			    		<td><input type="text" name="ocr_tesseract_path" value="<?php echo get_option('ocr_tesseract_path'); ?>" /></td>
			    	</tr>
			    	<tr valign="top">
			    		<th scope="row">Resize percentage<br><i style="font-size:10px;">A higher % might lead to more accurate OCR but will take longer to calculate. Default = 200%</i></th>
			    		<td><input type="text" name="ocr_resize_amount" value="<?php echo get_option('ocr_resize_amount'); ?>" />%</td>
			    	</tr>
			    </table>
			    <p class="submit">
			    	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			    </p>
			</form>
		</div>
		<?php
	}
}

if(!$ocr_plugin){ $ocr_plugin = new OCR(); }
add_action( 'add_attachment', 	array( $ocr_plugin, 'AnalyzeImage' ) );
add_action( 'admin_menu', 		array( $ocr_plugin, 'SubMenuItem' ) );