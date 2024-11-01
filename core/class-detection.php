<?php
/**
 * Detection Class for SmartS3 Video Plugin
 * @author John Morris <admin@johnmorrisonline.com>
 */
 
/*---------------------Start Class--------------------*/

if ( !class_exists('SmartS3Detection') ) {
	class SmartS3Detection {
		
		function detectBrowser() {
			$detect = new Browser();
			$browser = $detect->getBrowser();
			
			return $browser;
		}
		
		function detectVersion() {
			$detect = new Browser();
			$version = $detect->getVersion();
			
			return $version;
		}
		
		function determineVideoType() {
			$browser = $this->detectBrowser();
			$version = $this->detectVersion();
		
			if ( $browser ==  'Internet Explorer') {
				if ( $version >= 9 ) {
					$type = 'flash';
				} else {
					$type = 'flash';
				}
			} elseif ( $browser ==  'Firefox' ) {
				$type = 'flash';
			} elseif ( $browser ==  'Chrome' ) {
				$type = 'flash';
			} elseif ( $browser ==  'Safari' ) {
				if ( $version >= 3.1 ) {
					$type = 'html5';
				} else {
					$type = 'flash';
				}
			} elseif ( $browser ==  'Opera' ) {
				$type = 'flash';
			} elseif ( $browser ==  'Android' ) {
				$type = 'flash';
			} elseif ( $browser ==  'iPad' ) {
				$type = 'html5';
			} elseif ( $browser ==  'iPhone' ) {
				$type = 'html5';
			} elseif ( $browser ==  'iPod' ) {
				$type = 'html5';
			} else {
				$type = 'unsupported';
			}
			
			return $type;
		}
		
		function getType() {
			$type = $this->determineVideoType();
						
			return $type;
		}	
	}
}

$detect = new SmartS3Detection;
?>