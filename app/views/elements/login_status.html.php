<?php

use notes\security\Sentinel;
use notes\security\RoleManager;

  // function isUserAuthenticated()
	//{	
	 	$authCookie = (array_key_exists('SiteToken',$_COOKIE))? $_COOKIE['SiteToken']: null;
	 	if($authCookie){
	 		//$secure = new CI_Security();
	 		//$token = $secure->xss_clean($authCookie);
	 		$user = Sentinel::getAuthenticatedUser($authCookie);
			print "<ul class='menu'>";
			print "<li><p class='pull-right'> Welcome <strong>" . $user->getFirstName() . "</strong></p></li>";
			
			if(RoleManager::IsUserInRole($user,'Administrator' ))
				print "<li><a href='/admin/' title='Admin'>Admin</a></li>";
			//print "Welcome <strong>" . $user->getFirstName() . "</strong>";
			print "<li><a href='/accounts/logout' title='Log Out'>Log Out</a></li>";	
			print "</ul>";
		}else{
			//print "<a href='/accounts/login' class='' title='Log In'> Log In </a>";
		    echo $this->html->link('Log In', '/accounts/login');
        }
			
	//}
    
   // isUserAuthenticated();     

?>

