<?php
	$root = $_POST['root'];
	require_once( 'class-shortcode-generator.php' );
	require_once( $root . '/wp-load.php' );
	
	$options = get_option('smarts3');
	$jwcheck = file_exists( WP_PLUGIN_DIR . '/smarts3-video-plugin/extlib/jw/jwplayer.js' );
	
	$url = $_POST['url'];
	$parts = parse_url($url);
	$essentials = explode('/', $parts['path']);
	$bucket = $essentials[1];
	$path = str_replace('/' . $bucket . '/', '', $parts['path']);	
?>
<html>
	<head>
		<title>SmartS3 Shortcode Generator</title>
		
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('wpurl'); ?>/wp-admin/css/wp-admin.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('wpurl'); ?>/wp-admin/css/global.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('wpurl'); ?>/wp-admin/css/colors-fresh.css" />
		<link rel="stylesheet" type="text/css" href="admin.css" />
		
		<script>				
			function flvproducer_insertcode (form) {			
				if ( form.autostart.checked ) {
					var autostart = 'true';
				} else {
					var autostart = 'false';
				}
							
				insertCode = '[ss3_player ';
				insertCode += 'bucket="' + form.bucket.value + '" ';
				insertCode += 'video="' + form.path.value + '" ';
				insertCode += 'player="' + form.player.value + '" ';
				insertCode += 'height="' + form.height.value + '" ';
				insertCode += 'width="' + form.width.value + '" ';
				insertCode += 'expiry="' + form.expiry.value + '" ';
				insertCode += 'autostart="' + autostart + '" ';
				insertCode += 'controlbar="' + form.controlbar.value + '" ';
				insertCode += 'bufferlength="' + form.buffer.value + '" ';
				insertCode += 'image="' + form.image.value + '"';
				insertCode += ']';

				myField = parent.document.getElementById('content');
				xval = myField.value;

				var wpeditor = parent.tinyMCE.getInstanceById ('content');

				if (wpeditor) {
					wpeditor.execCommand ("mceInsertContent", true, insertCode);
				}
				if (myField) {
					if (xval == myField.value) {
						var selstart = 1;
						try {
							myField.selectionStart;
						} catch (err) {selstart = 0;}
						if (document.selection) {
							try {
								myField.focus ()
								sel = parent.document.selection.createRange();
								sel.text = insertCode;
							} catch (err) {}
						} else if (selstart) {
							try {
								var startPos = myField.selectionStart;
								var endPos = myField.selectionEnd;
								myField.value = myField.value.substring (0, startPos) + insertCode + myField.value.substring (endPos, myField.value.length);
							} catch (err) {}
						} else {
							try {
								myField.value += insertCode;
							} catch (err) {}
						}
					}
				}
			}
		</script>

	</head>
	
	<body>
		<div class="wrap s3m-pop">
			<div id="icon-options-general" class="icon32"></div><h2>SmartS3 Shortcode Generator</h2>
			
			<p><b>Customize your default settings below:</b></p>
			<p>URL: <?php echo $url; ?></p>
			
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="generate-shortcode">
				<input type="hidden" name="page" value="3" />
				<input type="hidden" name="root" value="<?php echo $root; ?>" />
				<input type="hidden" name="scheme" value="<?php echo $parts['scheme']; ?>" />
				<input type="hidden" name="host" value="<?php echo $parts['host']; ?>" />
				<table>
					<tr style="height: 35px;">
						<td>Bucket:</td>
						<td><input type="text" name="bucket" value="<?php echo $bucket; ?>" /></td>
					</tr>
					<tr style="height: 35px;">
						<td>File Path:</td>
						<td><input type="text" name="path" value="<?php echo $path; ?>" /></td>
					</tr>
					<tr style="height: 35px;">
						<td style="width: 250px;">Video Player:</td>
						<td>
							<select name="player">
								<option value="vjs" <?php if ( $options['player'] == 'vjs' ) { echo 'selected="selected"'; } ?>>VideoJS Player</option>
								<?php if ( $jwcheck == TRUE ) : ?><option value="jw" <?php if ( $options['player'] == 'jw' ) { echo 'selected="selected"'; } ?>>JW Player</option><?php endif; ?>
							</select>
						</td>
					</tr>
					<tr style="height: 35px;">
						<td>Player Height:</td>
						<td><input type="text" name="height" value="<?php echo $options['height']; ?>" /> px</td>
					</tr>
					<tr style="height: 35px;">
						<td>Player Width:</td>
						<td><input type="text" name="width" value="<?php echo $options['width']; ?>" /> px</td>
					</tr>
					<tr style="height: 35px;">
						<td>Video Link Expiration</td>
						<td><input type="text" name="expiry" value="<?php echo $options['expiry']; ?>" /> minutes</td>
					</tr>
					<tr style="height: 35px;">
						<td>AutoPlay</td>
						<td><input type="checkbox" name="autostart" value="true" /></td>
					</tr>
					<tr style="height: 35px;">
						<td style="width: 250px;">Control Bar:</td>
						<td>
							<select name="controlbar">
								<option value="bottom">Bottom</option>
								<option value="over">Over</option>
								<option value="none">None</option>
							</select>
						<span style="font-size: 10px; color: #ababab;">Note: Only affects the JW Player if used.</span></td>
					</tr>
					<tr style="height: 35px;">
						<td>Buffer Length</td>
						<td><input type="text" name="buffer" value="10" /> seconds</td>
					</tr>
					
					<tr style="height: 35px;">
						<td>Custom Image URL:</td>
						<td><input type="text" name="image" value="" /></td>
					</tr>
					
					<tr style="height: 35px;"><td></td><td></td></tr>
					<tr style="height: 35px;">
						<td></td>
						<td style="text-align: right; width: 350px;"><input type="button" class="button-primary" value="Insert Shortcode" onclick='flvproducer_insertcode (this.form);parent.tb_remove();' /></td>
					</tr>
					</tr>
				</table>
			</form>
		
		</div>
	</body>
</html>