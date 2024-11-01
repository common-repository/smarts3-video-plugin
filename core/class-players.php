<?php
/**
 * Video Player Class for SmartS3 Video Plugin
 * @author John Morris <admin@johnmorrisonline.com>
 */
 
/*---------------------Start Class--------------------*/

if ( !class_exists('SmartS3Players') ) {
	class SmartS3Players {
	
		/**
		*JWPlayer
		*Constructs the necessary embed code for the JW Player
		*
		*@param int $id - randomly generated id to enable multiple player embeds
		*@param string $src - URL string of video source
		*@param int $height - desired height of player
		*@param int $width - desired width of player
		*@param string $poster - URL string of preview image
		*@param boolean $autostart - True/false to autostart video or not
		*@param string $controlbar - Position of controlbar. Can be set to top, bottom, over, or none
		*@param int $bufferlength - Number of seconds of the file that has to be loaded before playback starts.
		*
		*return string $results - returns the formatted embed code
		*/

		function JWPlayer($id, $src, $height, $width, $poster, $autostart, $controlbar, $bufferlength, $ltas) {
			$results = '<div style="margin: 5px 0 10px 0;">';
			$results .= '<video src="' . $src . '" height="' . $height . '" id="ss3_jw_player_' . $id . '" width="' . $width . '" poster="' . $poster . '"></video>' . "\n";
			$results .= '<script type="text/javascript">' . "\n";
			$results .= 'jwplayer("ss3_jw_player_' . $id . '").setup({' . "\n";
			$results .= '"flashplayer": "' . WP_PLUGIN_URL . '/smarts3-video-plugin/extlib/jw/player.swf",' . "\n";
			$results .= '"file": "' . $src . '",' . "\n";
			$results .= '"image": "' . $poster . '",' . "\n";
			$results .= '"controlbar": "' . $controlbar . '",' . "\n";
			$results .= '"autostart": "' . $autostart . '",' . "\n";
			
			if ( empty( $ltas ) ) {
				$results .= '"bufferlength": "' . $bufferlength . '"' . "\n";
			} else {
				$results .= '"bufferlength": "' . $bufferlength . '",' . "\n";
				$results .= '"plugins": "ltas",' . "\n";
				$results .= '"ltas.cc": "' . $ltas . '"' . "\n";
			}
					
			$results .= '});' . "\n";
			$results .= '</script>' . "\n";
			$results .= '</div>';

			return $results;
		}
		
		/**
		*VideoJS
		*Constructs the necessary embed code for the VideoJS Player
		*
		*@param string $type - the embed type the current browser supports (flash or html5)
		*@param int $id - randomly generated id to enable multiple player embeds
		*@param string $src - URL string of video source
		*@param int $height - desired height of player
		*@param int $width - desired width of player
		*@param string $poster - URL string of preview image
		*@param boolean $autostart - True/false to autostart video or not
		*@param string $controlbar - Position of controlbar. Can be set to top, bottom, over, or none
		*@param int $bufferlength - Number of seconds of the file that has to be loaded before playback starts.
		*
		*return string $results - returns the formatted embed code
		*/

		function videoJS($type, $id, $src, $height, $width, $poster, $autostart, $controlbar, $bufferlength) {
			$encoded = urlencode($src);

			$results = '<div class="video-js-box" style="margin: 3px 0 10px 0;">';
			if ( $type == 'html5' ) {
				$results .= '<video class="video-js" width="' . $width . '" height="' . $height . '" ';
				
				if ( $poster != 'false' && !empty ( $poster ) ) {
					$results .= 'poster="' . $poster . '"';
				}
				
				$results .= 'controls preload>';
				$results .= '<source src="' . $src . '" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' />';
				$results .= '</video>';
			} else {
				$results .= '<div class="player-' . $id . '" href="' . $encoded . '"';
				$results .= 'style="display:block;width:' . $width . 'px;height:' . $height . 'px;">';
				
				if ( $poster != 'false' && !empty ( $poster ) ) {
					$autostart = true;
					$results .= '<div style="background: url('. $poster .');">';
					$results .= '<img src="' . WP_PLUGIN_URL . '/smarts3-video-plugin/images/overlay-play.png" alt="Click to Play Video" style="cursor: pointer; height:' . $height . 'px; width:' . $width . 'px;" />';
					$results .= '</div>';
				}
						
				$results .= '</div>';		
				$results .= '<script language="JavaScript">';
				$results .= 'flowplayer("div.player-' . $id . '", "' . WP_PLUGIN_URL . '/smarts3-video-plugin/extlib/flowplayer/flowplayer-3.2.7.swf", {';
				$results .= 'clip:  {';
				$results .= 'autoPlay: ' . $autostart . ', ';
				$results .= 'autoBuffering: true,  ';
				$results .= 'bufferLength: ' . $bufferlength . ', ';
				$results .= 'scaling: "fit"';
				$results .= '}';
				$results .= '});';
				$results .= '</script>';
			}
			$results .= '</div>';
			
			return $results;
		}
	}
}

$players = new SmartS3Players;
?>