<?php
	$root = $_GET['root'];
	require_once( 'class-shortcode-generator.php' );
	require_once( $root . '/wp-load.php' );
	
	$options = get_option('smarts3');
	
?>
<html>
	<head>
		<title>SmartS3 Shortcode Generator</title>
		
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('wpurl'); ?>/wp-admin/css/wp-admin.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('wpurl'); ?>/wp-admin/css/global.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('wpurl'); ?>/wp-admin/css/colors-fresh.css" />
		<link rel="stylesheet" type="text/css" href="admin.css" />
		

	</head>
	
	<body>
		<div class="wrap s3m-pop">
			<div id="icon-options-general" class="icon32"></div><h2>SmartS3 Shortcode Generator</h2>
			
			<p><b>Insert the URL of your video file below:</b></p>
			
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" />
				<input type="hidden" name="page" value="2" />
				<input type="hidden" name="root" value="<?php echo $_GET['root']; ?>" />
				<table>
					<tr>
						<td><input type="text" name="url" size="60" /></td>
						<td><input type="submit" class="button" value="Next Step" /></td>
					</tr>
				</table>
			</form>
		
		</div>
	</body>
</html>