<?php 

	// initialisation des bases
	include_once 'init.php';
	include_once 'private.php';

	PM_GEST_PAGE_SESSION( function() {
	
		
		switch( $_SESSION['action'] ) {
			case 'login' :	include_once 'login.php'; break;
			case 'regis' :	include_once 'regis.php'; break;
			case 'admin' :	include_once 'admin.php'; break;
			case 'users' :	include_once 'users.php'; break;
			case 'error' :	include_once 'error.php'; break;
			default:
				include_once 'first.php';
		}
		
	
	});
?>