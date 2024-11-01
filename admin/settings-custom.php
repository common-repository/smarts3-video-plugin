<?php
	$page = $_POST['page'];
	
	if ( empty ( $page ) ) {
		include('settings-custom-step-one.php');
	} elseif ( $page == 2 ) {
		include('settings-custom-step-two.php');
	} elseif ( $page == 3 ) {
		include('settings-custom-step-three.php');
	}
?>