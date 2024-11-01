<?php
/**
 * Functions Class for SmartS3 Video Plugin
 * @author John Morris <admin@johnmorrisonline.com>
 */
 
/*---------------------Start Class--------------------*/

if ( !class_exists('SmartS3Functions') ) {
	class SmartS3Functions {

		function getPoster($postid) {
			if ( current_theme_supports('post-thumbnails') && has_post_thumbnail($postid) ) {
				$id = get_post_thumbnail_id( $postid );
				$src = wp_get_attachment_image_src( $id, 'full' );
				$results = $src[0];
			} else {
				$results = get_post_meta($postid, 'image', true);
			}

			return $results;
		}
	}
}

$funcs = new SmartS3Functions;
?>