<?php

use notes\security\Sentinel;
  // function isUserAuthenticated()
	//{	
	 	$authCookie = (array_key_exists('SiteToken',$_COOKIE))? $_COOKIE['SiteToken']: null;
	 	if($authCookie){
	 		//$secure = new CI_Security();
	 		//$token = $secure->xss_clean($authCookie);
	 		$user = Sentinel::getAuthenticatedUser($authCookie);
			print "<ul class='logonStatus menu'>";
			print "<li> Welcome <strong>" . $user->getFirstName() . "</strong></li>";
			print "<li><a href='/accounts/logout' title='Log Out'>Log Out</a></li>";
			print "</ul>";
		}else{
			//print "<a href='/accounts/login' class='' title='Log In'> Log In </a>";
		    echo $this->html->link('Log In', 'Accounts::login');
        }
			
	//}
    
   // isUserAuthenticated();     

?>

