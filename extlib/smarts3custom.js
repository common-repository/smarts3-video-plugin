/*
jQuery(document).ready(function() {

jQuery('#add_video').click(function() {
 formfield = jQuery('#content').attr('name');
 tb_show('', '../wp-content/plugins/smarts3/admin/settings-custom.php?type=image&amp;TB_iframe=true');
 return false;
});


window.send_to_editor = function(html) {
 imgurl = jQuery('#shortcode').attr('id');
 jQuery('#content').val(imgurl);
 tb_remove();
}

});
*/

function flvproducer_insertcode (form) {
	/*
	var flv = form.flvfile.value;
	var mp4 = form.mp4file.value;
	var player = form.flvplayer.value;
	*/
	var autostart = $('input:radio[name=autostart]:checked').val();
	
	
	insertCode = '[ss3_player ';
	insertCode += 'bucket="' + form.bucket.value + '"';
	insertCode += 'video="' + form.path.value + '"';
	insertCode += 'player="' + form.player.value + '"';
	insertCode += 'height="' + form.height.value + '"';
	insertCode += 'width="' + form.width.value + '"';
	insertCode += 'expiry="' + form.expiry.value + '"';
	insertCode += 'autostart="' + autostart + '"';
	insertCode += 'controlbar="' + form.controlbar.value + '"';
	insertCode += 'bufferlength="' + form.buffer.value + '"';
	insertCode += ']';

	//insertCode = '[flvplugin flv=' + flv.replace(' ', '%20') + ' mp4=' + mp4.replace(' ', '%20') + ' player=' + player.replace(' ', '%20') + ' buffer=' + form.buffersize.value + ' autoplay=' + !form.paused.checked + ' loop=' + form.loop.checked + ' border=' + form.border.checked + ' preload=' + form.preload.checked + ' infobutton=' + !form.infobutton.checked + ' redirect=' + form.redirect.value.replace(/^\s+|\s+$/g,"").replace(' ', '%20') + ' width=' + form.width.value + ' height=' + form.height.value;

	/*
	if(form.lightbox.checked) insertCode+= ' lightbox=true';

	if(form.lightbox_default[1].checked){
		insertCode+=' lightbox_img='+form.lightbox_custom_image.value;
	}else{
		insertCode+=' lightbox_img=';
	}

	insertCode += ']';
	*/

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