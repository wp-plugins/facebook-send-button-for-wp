<?php
/*
Plugin Name: Facebook Send Button for WP
Plugin URI: http://www.darkomitrovic.com/wp-plugin/facebook-send-button/
Description: Add the Facebook Send Button to your wordpress.
Version: 1.1
Author: Darko Mitrovic
Author URI: http://www.darkomitrovic.com/
License: GPL2
*/

function send_button($content)
{	
	//if POST & PAGE checked
	if (get_option('send_button_post') == 'yes' && get_option('send_button_page') == 'yes') {
		if((is_single) || (is_page())){
			$content .= '<div id="fb-root"></div>
			<script src="http://connect.facebook.net/en_US/all.js#appId=101834286544733&amp;xfbml=1"></script>
			<fb:send href="'.get_permalink().'" font="'.get_option('send_button_font').'" colorscheme="'.get_option('send_button_colorscheme').'"></fb:send>';
		}
	}
	//if POST checked
	else if (get_option('send_button_post') == 'yes' && (is_single()) ) {
			$content .= '<div id="fb-root"></div>
			<script src="http://connect.facebook.net/en_US/all.js#appId=101834286544733&amp;xfbml=1"></script>
			<fb:send href="'.get_permalink().'" font="'.get_option('send_button_font').'" colorscheme="'.get_option('send_button_colorscheme').'"></fb:send>';
	}
	//if PAGE checked
	else if (get_option('send_button_page') == 'yes' && (is_page()) ) {
			$content .= '<div id="fb-root"></div>
			<script src="http://connect.facebook.net/en_US/all.js#appId=101834286544733&amp;xfbml=1"></script>
			<fb:send href="'.get_permalink().'" font="'.get_option('send_button_font').'" colorscheme="'.get_option('send_button_colorscheme').'"></fb:send>';
	}
	//NON checked
	else {
		$content .= '';
	}
		return $content;
}

add_action('the_content', 'send_button');




/* Runs when plugin is activated */
register_activation_hook(__FILE__,'send_button_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'send_button_remove' );

function send_button_install() {
	/* Creates new database field */
	add_option("send_button_colorscheme", 'light', '', 'yes');
	add_option("send_button_font", '', '', 'yes');
	add_option("send_button_post", 'yes', '', 'yes');
	add_option("send_button_page", 'yes', '', 'yes');
}

function send_button_remove() {
	/* Deletes the database field */
	delete_option('send_button_colorscheme');
	delete_option('send_button_font');
}




if ( is_admin() ){
	/* Call the html code */
	add_action('admin_menu', 'send_button_admin_menu');
	
	function send_button_admin_menu() {
	add_options_page('Facebook Send Button Options', ' FB Send Button', 'administrator',
	'send-button', 'send_button_html_page');
	}
}




function send_button_html_page() {
?>
			
<div class="wrap">
	<form method="post" action="options.php" id="options">
	<?php wp_nonce_field('update-options'); ?>
	<div id="icon-options-general" class="icon32">
	<br />
	</div>	
	<h2>Facebook Send Button</h2>
	
	<div class="postbox-container" style="width:100%;">
		<div class="metabox-holder">
			<div class="postbox">
			
				<h3 class="hndle"><span>Facebook Send Button Options</span></h3>
				
				<div style="margin:20px;">
					<p>
						<label>Color Scheme</label>
						<div style="margin:-35px 0 0 120px;">
						<select name="send_button_colorscheme">
							<option value="light" <?php if (get_option('send_button_colorscheme') == 'light') {echo 'selected="selected"';} ?>>light</option>
							<option value="dark" <?php if (get_option('send_button_colorscheme') == 'dark') {echo 'selected="selected"';} ?>>dark</option>
						</select>
						</div>
					</p>

					<p>
						<label>Font</label>
						<div style="margin:-35px 0 0 120px;">
						<select name="send_button_font">
							<option value="" <?php if (get_option('send_button_font') == '') {echo 'selected="selected"';} ?>>&nbsp;</option>
							<option value="arial" <?php if (get_option('send_button_font') == 'arial') {echo 'selected="selected"';} ?>>arial</option>
							<option value="lucida grande" <?php if (get_option('send_button_font') == 'lucida grande') {echo 'selected="selected"';} ?>>lucida grande</option>
							<option value="segoe ui" <?php if (get_option('send_button_font') == 'segoe ui') {echo 'selected="selected"';} ?>>segoe ui</option>
							<option value="tahoma" <?php if (get_option('send_button_font') == 'tahoma') {echo 'selected="selected"';} ?>>tahoma</option>
							<option value="trebuchet ms" <?php if (get_option('send_button_font') == 'trebuchet ms') {echo 'selected="selected"';} ?>>trebuchet ms</option>
							<option value="verdana" <?php if (get_option('send_button_font') == 'verdana') {echo 'selected="selected"';} ?>>verdana</option>
						</select>
						</div>
					</p>

					<p>
						<label>Show Button in</label>
						<div style="margin:-27px 0 0 120px;">
							<input name="send_button_post" type="checkbox" value="yes" <?php if (get_option('send_button_post') == 'yes') {echo 'checked="checked"';} ?> />
							<label>Posts</label>
							<input name="send_button_page" type="checkbox" value="yes" <?php if (get_option('send_button_page') == 'yes') {echo 'checked="checked"';} ?> /> 
							<label>Pages</label>
						</div>
					</p>
				</div>
				
			</div>
		</div>
	</div>

	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="send_button_colorscheme,send_button_font,send_button_post,send_button_page" />
	
	<div class="submit"><input type="submit" class="button-primary"  value="<?php _e('Save Changes') ?>" /></div>
	
	</form>
</div>

<?php
}
?>