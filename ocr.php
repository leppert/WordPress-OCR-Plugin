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


/**
 * Include the WordpressPluginFramework.
 */
require_once( "wordpress-plugin-framework.php" ); 



/**
 * DemoPlugin - Simple plugin class used to demonstrate the WordpressPluginFramework.
 *
 * This class creates a simple plugin that demonstrates the capabilities of the WordpressPluginFramework.
 * Currently abilities demonstrated include:
 *
 *    1. Deriving a plugin from the WordpressPluginFramework base class.
 *    2. Creating options for the plugin.
 *    3. Initializing the plugin.
 *    4. Creating content blocks for the plugin's administration page.
 *    5. Registering the plugin's administration page with Wordpress.
 * 
 * @package wordpress-plugin-framework
 * @author Keith Huster
 */
class OCR extends DemoPlugin_WordpressPluginFramework
{
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
	
   // ---------------------------------------------------------------------------
   // Methods used to display content block within the plugin administration page.
   // ---------------------------------------------------------------------------

   /**
	 * HTML_DisplayPluginDescriptionBlock() - Displays the "Plugin Description" content block.
	 *
	 * This function generates the markup required to display the specified content block.
	 *
	 * @param void      None.
	 * 
    * @return void     None.  	 
	 * 
	 * @access private  Access via internal callback only.
	 * @author Keith Huster
	 */
   function HTML_DisplayPluginDescriptionBlock()
   {
      ?>
      <p>Just a simple simple demonstration to verify the Wordpress Plugin Framework is working...</p>
      <?php
   }

   /**
	 * HTML_DisplayPluginOptionsDisplayedBlock() - Displays the "Plugin Options Displayed" content block.
	 *
	 * This function generates the markup required to display the specified content block.
	 *
	 * @param void      None.
	 * 
    * @return void     None.  	 
	 * 
	 * @access private  Access via internal callback only.
	 * @author Keith Huster
	 */
   function HTML_DisplayPluginOptionsDisplayedBlock()
   {
      $this->DisplayPluginOption( 'myTextboxOption' );
	  ?>
	  <br>
	  <p class="submit"><input type="submit" name="submit" value="<?php _e('Update options &raquo;'); ?>" /></p>
	  <br>
	  <?php
	  $this->DisplayPluginOption( 'myTextboxOption2' );
   }

   /**
	 * HTML_DisplayPluginOptionsListedBlock() - Displays the "Plugin Options Listed" content block.
	 *
	 * This function generates the markup required to display the specified content block.
	 *
	 * @param void      None.
	 * 
    * @return void     None.  	 
	 * 
	 * @access private  Access via internal callback only.
	 * @author Keith Huster
	 */
   function HTML_DisplayPluginOptionsListedBlock()
   {
      $optionsArray = $this->GetOptionsArray();
      
      if( is_array( $optionsArray ) )
      {
         ?>
         <table>
            <thead>
               <tr>
                  <th>Option Name</th>
                  <th>Option Type</th>
                  <th>Option Value</th>
                  <th>Option Description</th>
                  <th>Option Values Array</th>
               </tr>
            </thead>
            <tbody>
               <?php
               foreach( $optionsArray AS $optionKey=>$optionValueArray )
               {
               ?>
                  <tr>
                     <td><?php echo( $optionKey ); ?></td>
                     <td><?php echo( $this->GetOptionType( $optionKey ) ); ?></td>
                     <td><?php echo( $this->GetOptionValue( $optionKey ) ); ?></td>
                     <td><?php echo( $this->GetOptionDescription( $optionKey ) ); ?></td>
                     <td><?php echo( $this->GetOptionValuesArray( $optionKey ) ); ?></td>
                  </tr>
               <?php 
		      }
		      ?>
		      </tbody>
		   </table>
		   <?php
      }
   }

   /**
	 * HTML_DisplayPluginHelloWorldBlock() - Displays the "Hello World!" content block.
	 *
	 * This function generates the markup required to display the specified content block.
	 *
	 * @param void      None.
	 * 
    * @return void     None.  	 
	 * 
	 * @access private  Access via internal callback only.
	 * @author Keith Huster
	 */
   function HTML_DisplayPluginHelloWorldBlock()
   {
      ?>
      <p>Hello World!</p>
      <?php
   }
}



/**
 * Demonstration of creating a plugin utilizing the WordpressPlugin Framework.
 */
if( !$ocrPlugin  )
{
  // Create a new instance of your plugin that utilizes the WordpressPluginFramework and initialize the instance.
  $ocrPlugin = new OCR();
  $ocrPlugin->Initialize( 'A plugin for extracting the text from attached images using OCR via tesseract',
                             '0.01',
                             'wordpress-plugin-framework',
                             'demo-plugin' );
  
  // Add all of the options specific to your plugin then register the options with the Wordpress core.
  $ocrPlugin->AddOption( $ocrPlugin->OPTION_TYPE_TEXTBOX,
                            'myTextboxOption',
                            'Hello!',
                            'Simple textbox option for your plugin:' );
/*
  $ocrPlugin->AddOption( $ocrPlugin->OPTION_TYPE_TEXTBOX,
                            'myTextboxOption2',
                            'Hello!2',
                            'Simple textbox option for your plugin2:' );
*/
  $ocrPlugin->AddOption( $ocrPlugin->OPTION_TYPE_CHECKBOX,
                            'myCheckboxOption',
                            $ocrPlugin->CHECKBOX_UNCHECKED,
                            'Simple checkbox option for your plugin.' );
  
  $ocrPlugin->RegisterOptions( __FILE__ );
  
  // Add all of the custom content blocks to your plugin's administration page then register your
  // plugin's administration page with the Wordpress core.
  //   - Note: The SIDEBAR and MAIN content blocks will be displayed in the order they are added.
  //   - Note: The SIDEBAR content blocks must be added prior to the MAIN content blocks for proper formatting.
  //   - e.x.
  //              -- MAIN CONTENT AREA --             -- SIDEBAR CONTENT AREA --
  //              -----------------------             --------------------------
  //              'block-description'                 'block-hello-world'
  //              'block-options-displayed'           'block-hello-again'
  //              'block-options-listed'
  $ocrPlugin->AddAdministrationPageBlock( 'block-description',
                                             'Plugin Description',
                                             $ocrPlugin->CONTENT_BLOCK_TYPE_MAIN,
                                             array($ocrPlugin, 'HTML_DisplayPluginDescriptionBlock') );
  $ocrPlugin->AddAdministrationPageBlock( 'block-options-displayed',
                                             'Plugin Options Displayed',
                                             $ocrPlugin->CONTENT_BLOCK_TYPE_MAIN,
                                             array($ocrPlugin, 'HTML_DisplayPluginOptionsDisplayedBlock') );
  
  $ocrPlugin->RegisterAdministrationPage( $ocrPlugin->PARENT_MENU_PLUGINS,
                                             $ocrPlugin->ACCESS_LEVEL_ADMINISTRATOR,
                                             'OCR Plugin',
                                             'OCR Plugin Options Page',
                                             'orc-plugin-options' );
	add_action ( 'add_attachment', array( $ocrPlugin, 'AnalyzeImage' ) );
}

?>
