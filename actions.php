<?php
	include_once 'init.php';
	PM_GEST_PAGE_SESSION( function() {
		$POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$_SESSION['action'] = $POST['action'];
		PM_REFRESH();
	});	


?>