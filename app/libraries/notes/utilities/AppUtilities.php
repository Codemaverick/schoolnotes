<?php  

namespace notes\utilities;

use \lithium\data\Connections;
use \lithium\action\Controller;

use models\Security\Membership;
use models\Security\MembershipUser;
use models\Semester;
use models\Configuration;

use \DateTime;
 
class AppUtilities{
	
	public static function getCurrentSemester(){
		
		$em = Connections::get('default')->getEntityManager();	
		//$semContext = $doctrine->em->getRepository('models\Semester');
		$curr = new DateTime('now');
		
		$query = $em->createQuery('SELECT s FROM app\models\Semester s WHERE :current BETWEEN s.startDate AND s.endDate');
		$query->setParameter('current', $curr->format('Y-m-d'));
		$sem = $query->getResult();
		if($sem){
			return $sem[0];
		}else{
			return null;
		}
	}
	
}

?>