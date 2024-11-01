<?php
/**
 * Authentication Class for SmartS3 Video Plugin
 * @author John Morris <admin@johnmorrisonline.com>
 */
 
/*---------------------Start Class--------------------*/

if ( !class_exists('SmartS3Admin') ) {
	class SmartS3Admin {
	
		function admin_menu() {
			if(!defined('SS3TOPMENU')){
				add_menu_page('SmartS3 Video Plugin','SmartS3','administrator','ss3-video',array('SmartS3Admin', 'defaultSettings'));
				define('SS3TOPMENU','ss3-video');
			}
			
			add_submenu_page(SS3TOPMENU, 'Settings - SmartS3 Video Plugin', 'Settings', 'administrator', 'ss3-video', array('SmartS3Admin', 'defaultSettings'));
			add_submenu_page(SS3TOPMENU, 'Instructions - SmartS3 Video Plugin', 'Instructions', 'administrator', 'ss3-instructions', array('SmartS3Admin', 'instructions'));
			add_action('admin_init', array('SmartS3Admin', 'register_settings'));
		}

		function register_settings() {
			register_setting('smarts3_default_settings', 'smarts3');
		}
		
		function instructions() {
			?>
			
			<div class="wrap">
				<div id="icon-options-general" class="icon32"></div><h2>Instructions - SmartS3 Video Plugin</h2>
				<p>Instructions for using your SmartS3 Video Plugin below:</p>
				<p>The Simple S3 Video Plugin is an easy-to-use video plugin that enables you to play videos stored on Amazon S3 in the JW Player using expring URLs. It consists of 3 important features:</p>
				<p><b>1. Play Videos Stored on Amazon S3.</b> Amazon S3 is a great resource for content publishers to store, manage, and deploy content on a highly-reliable, scalable, and cost-effective platform.</p>
				<p>The down-side of Amazon S3, is it does not provide a lot, if any, built-in tools for deploying that content... which means you have to code everything yourself. The SS3 Video Plugin alleviates that problem by providing the interface to easily interact with Amazon S3 inside of WordPress and embed your videos into posts and pages.</p>
				<p><em>Bottom line: The SS3 Video Plugin allows you to embed videos from Amazon S3 without writing a single line of code.</em></p>
				<p><b>2. Play S3 Videos Using Expiring URLs.</b> Most S3 solutions require you to "unprotect" your content... which means once someone knows the URL of a video, they can pass it around and share it... and, there's nothing you can do about it. SS3 is different in that it uses expiring URLs... which means it dynamically creates a URL that expires after a set time period. So, you don't have to unprotect your content on Amazon S3 and if someone passes your video URL to a friend... that URL will eventually expire and no longer be useful.</p>
				<p>This is crucial to help protect your content and keep your bandwith charges from Amazon S3 down. No need to worry about a private video ending up on Digg and allowing the whole world to access it... and, run up your Amazon S3 bill.</p>
				<p><em>Bottom line: It helps protect your content by allowing you to keep your content protect and using expiring URLs.</em></p>
				<p><b>3. Play S3 Videos in the JW Player.</b> The JW Player is the most popular open-source flash player. It's sleek, reliable, and has numerous plugins available to extend its functionality. SS3 enables you to play your Amazon S3 videos using the JW Player... without having to install the player yourself.</p>
				<p><em>Bottom line: Simply, install and activate SS3 and the JW Player is already set up and ready to play.</em></p>
				<p>Another notable feature is <b>SS3's ability to play videos on non-flash devices (i.e. iPad, iPhone, iPod)</b>. SS3 uses and advanced flash detection kit to detect if the client computer is flash-enabled... and, if not display a video link that can be played in non-flash devices.</p>
				
				<h3>Installation</h3>
				<p>To get started using the SS3 Video Plugin, simply upload and activate the plugin. Once activated, navigate to the <a href="<?php echo bloginfo('wpurl'); ?>/wp-admin/admin.php?page=ss3-settings">Settings screen</a>, enter your Amazon S3 credentials and set your preferences.</p>
				<p>Once set, you'll notice a new "S3" icon on the Add New Post/Page in WordPress. Click this icon, and SS3 will populate a list of all the videos stored on your Amazon S3 account. Simply, press the "Select" button and SS3 will automatically generate the necessary shortcode for you. Copy and paste that shortcode into your page or post and you're all set.</p>
				
				<h3>Support</h3>
				<p>For support, visit <a href="http://johnmorrisonline.com/support">www.JohnMorrisOnline.com/support</a>.</p>
			</div>
			<?php
		}

		function defaultSettings() {
			global $funcs;
			
			$options = get_option('smarts3');
			$jwcheck = file_exists( WP_PLUGIN_DIR . '/smarts3-video-plugin/extlib/jw/jwplayer.js' );
		?>
			<div class="wrap">
				<div id="icon-options-general" class="icon32"></div><h2>Settings - SmartS3 Video Plugin</h2>
				<p>Set up your SmartS3 Video Plugin options below.</p>
				
			<form method="post" action="options.php">
			<?php settings_fields( 'smarts3_default_settings' ); ?>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">Amazon S3 Access Key:</th>
				<td><input type="text" name="smarts3[access_key]" value="<?php echo $options['access_key']; ?>" /></td>
				</tr>
				
				<tr valign="top">
				<th scope="row">Amazon S3 Secret Key:</th>
				<td><input type="password" name="smarts3[secret_key]" value="<?php echo $options['secret_key']; ?>" /></td>
				</tr>
				
				<tr valign="top">
				<th scope="row">Default Player:</th>
				<td>
					<select name="smarts3[player]">
						<option value="vjs" <?php if ( $options['player'] == 'vjs' ) { echo 'selected="selected"'; } ?>>VideoJS Player</option>
						<?php if ( $jwcheck == TRUE ) : ?><option value="jw" <?php if ( $options['player'] == 'jw' ) { echo 'selected="selected"'; } ?>>JW Player</option><?php endif; ?>
					</select>
				</td>
				</tr>
								
				<tr valign="top">
				<th scope="row">Default Bucket Name:</th>
				<td><input type="text" name="smarts3[bucket]" value="<?php echo $options['bucket']; ?>" /></td>
				</tr>
				
				<tr valign="top">
				<th scope="row">Default Player Height:</th>
				<td><input type="text" name="smarts3[height]" value="<?php echo $options['height']; ?>" /></td>
				</tr>
				
				<tr valign="top">
				<th scope="row">Default Player Width:</th>
				<td><input type="text" name="smarts3[width]" value="<?php echo $options['width']; ?>" /></td>
				</tr>
				
				<tr valign="top">
				<th scope="row">Default Video Link Expiration:</th>
				<td><input type="text" name="smarts3[expiry]" value="<?php echo $options['expiry']; ?>" /> minutes</td>
				</tr>
				
				<?php if ( $options['player'] == 'jw' ) : ?>
					<tr valign="top">
					<th scope="row">AdSolution Channel ID:</th>
					<td><input type="text" name="smarts3[ltas]" value="<?php echo $options['ltas']; ?>" /></br><small>Leave blank if you don't want show ads</small></td>
					</tr>
				<?php endif; ?>
			</table>
			
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />
			</p>
		</form>
				
			</div>
		<?php
		}
	}
}

$admin = new SmartS3Admin;
?>