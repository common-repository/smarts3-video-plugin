<?php
/*
Plugin Name: SmartS3 Video Plugin
Plugin URI: http://johnmorrisonline.com/smarts3
Description: Easily embed videos from Amazon S3 in the JW Player using authenticated and expiring URLs.
Author: John Morris
Version: 0.5.7
Author URI: http://www.johnmorrisonline.com
*/

//Require all necessary files
require_once( dirname(__FILE__) . '/core/s3/sdk.class.php' );
require_once( dirname(__FILE__) . '/core/class-functions.php' );
require_once( dirname(__FILE__) . '/core/class-authentication.php' );
require_once( dirname(__FILE__) . '/core/class-browser.php');
require_once( dirname(__FILE__) . '/core/class-detection.php');
require_once( dirname(__FILE__) . '/core/class-players.php' );
require_once( dirname(__FILE__) . '/admin/settings-default.php' );

/**
 * Main Class for SmartS3 Video Plugin
 * @author John Morris <admin@johnmorrisonline.com>
 */
 
/*---------------------Start Class--------------------*/

if ( !class_exists( 'SmartS3' ) ) {
	class SmartS3 {
	
		//Enqueue all our necessary javascripts
		function loadScripts() {
			wp_register_script('ss3-jwplayer-script', WP_PLUGIN_URL . '/smarts3-video-plugin/extlib/jw/jwplayer.js');
			wp_register_script('ss3-videojs-script', WP_PLUGIN_URL . '/smarts3-video-plugin/extlib/videojs/video.js');
			wp_register_script('ss3-flowplayer-script', WP_PLUGIN_URL . '/smarts3-video-plugin/extlib/flowplayer/flowplayer-3.2.6.min.js');
			wp_register_script('ss3-upload-script', WP_PLUGIN_URL.'/smarts3-video-plugin/extlib/smarts3custom.js', array('jquery','media-upload','thickbox'));
				
			if ( !is_admin() ) { 
			   wp_enqueue_script('ss3-jwplayer-script');
			   wp_enqueue_script('ss3-videojs-script');
			   wp_enqueue_script('ss3-flowplayer-script');
			}
			
			if ( is_admin() ) {
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_script('ss3-upload-script');
			}
		}
		
		function loadStyles() {
			$videoJsUrl = WP_PLUGIN_URL . '/smarts3-video-plugin/extlib/videojs/video-js.css';
			$videoJsFile = WP_PLUGIN_DIR . '/smarts3-video-plugin/extlib/videojs/video-js.css';
			if ( file_exists($videoJsFile) ) {
				wp_register_style('videoJsStyleSheet', $videoJsUrl);
				wp_enqueue_style( 'videoJsStyleSheet');
			}
		}
		
		function forcePrint() {
			echo '<script type="text/javascript" charset="utf-8">VideoJS.setupAllWhenReady();</script>';
			//echo '<script src="' . WP_PLUGIN_URL . '/smarts3/extlib/flowplayer/flowplayer-3.2.6.min.js"></script>';
		}
		
		function embedVideo($player, $src, $accesskey, $secretkey, $cname, $bucket, $height, $width, $poster, $autostart, $controlbar, $bufferlength, $expiry, $ltas) {
			global $funcs;
			global $auth;
			global $detect;
			global $players;
			
			$type = $detect->getType();
			$authURL = $auth->getAuthenticatedURL( $src, $accesskey, $secretkey, $cname, $bucket, $expiry );
			$id = rand(1, 100);
			
			if ( $player == 'jw' ) {
				$results = $players->JWPlayer( $id, $authURL, $height, $width, $poster, $autostart, $controlbar, $bufferlength, $ltas );
			} elseif ( $player == 'vjs' ) {
				$results = $players->videoJS($type, $id, $authURL, $height, $width, $poster, $autostart, $controlbar, $bufferlength);
			}
			
			return $results;
		}
		
		function setOptions($postid, $player, $src, $bucket, $height, $width, $poster, $autostart, $controlbar, $bufferlength, $expiry, $ltas) {
			global $funcs;
			
			$options = get_option('smarts3');
			$accesskey = $options['access_key'];
			$secretkey = $options['secret_key'];
			$cname = 'no';
			
			if ( empty ( $poster ) ) {
				$poster = $funcs->getPoster($postid);
			}
						
			if ( empty($player) ) {
				$player = $options['player'];
			}
			
			if ( empty($bucket) ) {
				$bucket = $options['bucket'];
			}
			
			if ( empty($height) ) {
				$height = $options['height'];
			}
			
			if ( empty($width) ) {
				$width = $options['width'];
			}
			
			if ( empty($expiry) ) {
				$expiry = $options['expiry'];
			}
			
			if ( empty($ltas) ) {
				$ltas = $options['ltas'];
			}
			
			$expiry = $expiry . ' minutes';
						
			$results = $this->embedVideo($player, $src, $accesskey, $secretkey, $cname, $bucket, $height, $width, $poster, $autostart, $controlbar, $bufferlength, $expiry, $ltas);
			
			return $results;
		}
		
		function mediaButtons() {
			$title = esc_attr( __( 'SS3 Video Plugin' ) );
			$root = get_bloginfo('wpurl');
			
			echo '<a href="' . WP_PLUGIN_URL . '/smarts3-video-plugin/admin/settings-custom.php?root=' . ABSPATH . '&amp;iframe&amp;TB_iframe=true&amp;" id="add_video" class="thickbox" title="' . $title . '"><img src="' . WP_PLUGIN_URL . '/smarts3-video-plugin/images/logo.png" alt="' . $title . '" width="16" height="16" /></a>';
		}
	}
}

$smartS3 = new SmartS3;

//Shortcode handler
function smartS3Shortcode($atts, $content = null) {
	global $post, $smartS3;
	
	extract(shortcode_atts(array(
		'postid' => $post->ID,
		'player' =>'',
		'bucket' =>'',
		'video' => '',
		'height' => '',
		'width' => '',
		'image' => '',
		'autostart' => 'false',
		'controlbar' => 'bottom',
		'bufferlength' => '10',
		'expiry' => '',
		'ltas' => '',
		), $atts));
	
	$results = $smartS3->setOptions($postid, $player, $video, $bucket, $height, $width, $image, $autostart, $controlbar, $bufferlength, $expiry, $ltas);
	
	return $results;
}

//Actions
add_action( 'init', array( 'SmartS3', 'loadScripts' ) );
add_action( 'wp_print_styles', array( 'SmartS3', 'loadStyles' ));
add_action( 'wp_head', array( 'SmartS3', 'forcePrint') );
add_action( 'admin_menu', array('SmartS3Admin', 'admin_menu') );
add_action( 'media_buttons', array('SmartS3', 'mediaButtons'), 1000 );

//Shortcodes
add_shortcode( 'ss3_player', 'smartS3Shortcode' );
?>