<?php
	$root = $_POST['root'];
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
			
			<p><b>Insert the shortcode below into your post:</b></p>
			
			<p id="shortcode">[ss3_player bucket="<?php echo $_POST['bucket']; ?>" video="<?php echo $_POST['path']; ?>" player="<?php echo $_POST['player']; ?>" 
			 height="<?php echo $_POST['height']; ?>" width="<?php echo $_POST['width']; ?>" expiry="<?php echo $_POST['expiry']; ?>" autostart="<?php echo $_POST['autostart']; ?>"
			 controlbar="<?php echo $_POST['controlbar']; ?>" bufferlength="<?php echo $_POST['buffer']; ?>"]
			 </p>					
		</div>
	</body>
</html>