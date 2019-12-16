<?php
	session_start();
	define('REFRESH', '<html><head><META http-equiv="REFRESH" content="0; url=http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] .'/"><title>refresh</title></head><body>refresh page...</body></html>');
	
	
	// PRIMAL FINCTION ----------
	
	function PM_REFRESH() { echo REFRESH; }
	
	function PM_BUTTON_ACTION( $action , $specificname=false, $classname='') {	
		return '<form action="actions.php" method="post">
		<input name="action" type="hidden" value="'. $action . '" />
		<input class="actionbutton ' . $classname . '" type="submit" value="' . ($specificname ? $specificname: $action) . '" />
		</form>';
	}
	
	function PM_IS_USER_IN_DATABASE( $code ) {
		// si l'utilisateur fait partie de la base alors
		// on execute le code sinon il retourn à la page 
		// de login
		
		// code de vérification utilisateur via mysql avant l'execution
		// $_SESSION['action'] = 'login';
		// PM_REFRESH();
		// 
		
		 $code();
		 
		 
	}
	
	function PM_GEST_PAGE_SESSION( $code ) {
	
		
		switch( PM_ISSET_SESSION() ) {
			case 'ENDSESSION': // si la session à fini son temps on le renvoi sur la page login
				$_SESSION['action'] = 'login';
				PM_REFRESH();
			break;
			case 'IDUSERNTSC': 
				// si la clé d'utilisation n'est pas valide on la regénére
				// possible si la serveur change de clé via l'administration
				$_SESSION['iduse'] = hash('adler32', session_id() . PRIVATE_KEY_SERV);
				PM_REFRESH();
			break;
			case 'ISESSIONNO': // si pas de session on va créé la session
				PM_CREAT_DEFAULT_SESSION();
				PM_REFRESH();	
			break;
			case 'ISESSIONOK':  // si tout est bon on execute le code
				PM_IS_USER_IN_DATABASE( $code );
			break;
		}
	}
	
	function PM_CREAT_DEFAULT_SESSION() {	
		$_SESSION['start'] = time(); // debut de session
		$_SESSION['end'] = time() + (7 * 24 * 60 * 60); // fin de session dans 7 jours
		$_SESSION['iduse'] = hash('adler32', session_id() . PRIVATE_KEY_SERV); //--> on ajoutera l'ID de session de la base de donnée 
		$_SESSION['action'] = ''; // normalement renvoyer l'utilisateur aux login
		$_SESSION['imusok'] = '';
	}
	
	function PM_ISSET_SESSION($action=false) {
	
		// passe 1 vérification de la validité 
		if( count($_SESSION) > 1 and 
			isset($_SESSION['start']) 	and 
			isset($_SESSION['end']) 	and
			isset($_SESSION['iduse']) 	and
			isset($_SESSION['action']) ) {
				
				//vérification du temps de session
				$time = time();
				if($_SESSION['end'] <= $time) {
					return 'ENDSESSION';
				}
				//vérification de la clé d'utilisation
				else if($_SESSION['iduse'] != hash('adler32', session_id() . PRIVATE_KEY_SERV) ) {
					return 'IDUSERNTSC';
				}

			return 'ISESSIONOK';

		}

		return 'ISESSIONNO';

	}
?>