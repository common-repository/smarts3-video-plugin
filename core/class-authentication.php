<?php
/**
 * Authentication Class for SmartS3 Video Plugin
 * @author John Morris <admin@johnmorrisonline.com>
 */
 
/*---------------------Start Class--------------------*/

if ( !class_exists('SmartS3Authentication') ) {
	class SmartS3Authentication {
	
		/**
		*getAuthenticatedURL
		*Generates the authenticated Amazon S3 URL
		*
		*@param string $src - URL string of video source
		*@param string $accesskey - the Amazon S3 access key
		*@param string $secretkey - the Amazon S3 secret key
		*@param string $cname - the cname if being used
		*@param string $bucket - the default bucket
		*
		*return string $results - returns the authenticated URL
		*/

		function getAuthenticatedURL($src, $accesskey, $secretkey, $cname, $bucket, $expiry) {
			//Instantiate the S3 class
			$s3 = new AmazonS3($accesskey, $secretkey);
			
			//Grab our signed URL from Amazon S3
			$results = $s3->get_object_url($bucket, $src, $expiry);
		
			//Return the signed URL
			return $results;
		}
	}
}

$auth = new SmartS3Authentication;
?>