<?php 
	/**
 * Sentinel - Application Security Class
 *
 * This class object is used to define and control access to pages and controllers
 * 
 * @package		Core
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Jason Abayomi
 */
namespace notes\security;

use \lithium\data\Connections;

use app\models\Security\Membership;
use app\models\Security\MembershipUser;

 
class Sentinel{
	
	private $enablePasswordReset;
	private $enablePasswordRetrieval;
	private $requireQuestionAndAnswer;
	private $maxInvalidPasswordAttempts;
	private $dbConfig;
    
    function __construct()  {
		
		/* Instantiate Doctrine's Entity manager so we don't have
		   to everytime we want to use Doctrine */

		$this->em = Connections::get('default')->getEntityManager();

		$this->dbContext = $this->em->getRepository('app\models\Security\Membership');
		$this->userContext = $this->em->getRepository('app\models\Security\MembershipUser');
	}
			
	function createUser($username, $pwd, $email, $firstname = '', $lastname = ''){//
		$mem = new Membership();
		$mUsr = new MembershipUser();
		
		//$mem->setUserName($username);
		$mUsr->setUserName($username);
		
		$salt = $this->generatePasswordSalt();
		$hashPwd = crypt($pwd, $salt);
		
		if($firstname != '')
			 $mUsr->setFirstName($firstname);
	
		if($lastname != '') 
			$mUsr->setLastName($lastname);
		
		$mUsr->setPassword($hashPwd);
		$mUsr->setEmail($email);
		$this->em->persist($mUsr);
		$this->em->flush();

		$mem->setUserId($mUsr->getId());
		$mem->setPassword($hashPwd);
		$mem->setEmail($email);
		$mem->setPasswordSalt($salt);
		$mem->setCreateDate(new DateTime('now'));
		
		$this->em->persist($mem);
		$this->em->flush();
		
		return $mUsr;
	}
	
	//delete user and any related user data from the DB
	function deleteUser($str){
		$res = $this->userContext->findBy(array('username'=>$str));
		
		if($res){
			$user = $res[0];
			$this->em->remove($user);
			$mem = $this->dbContext->findBy(array('userId'=>$user->getId()));
			$this->em->remove($mem[0]);
			$this->em->flush();
		
			return $usr;
		}else{
			return null;
		}
	}
	
	//need some paging functionality? ex: findUsersByName($str, $bool(page data/yes/no), $pageNum)
	function findUsersByName($str){
		$usr = $this->userContext->findBy(array('username'=>$str));
		
		return ($usr) ? $usr : null;
	}
	
	function generatePasswordSalt(){
		$base64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$salt = '$2a$07$';

		for($i=0; $i<25; $i++)
		{
    		$salt .= $base64[rand(0,61)];
		}

		return $salt.'$';
	}
	
	//page data?
	function listAllUsers(){
		return $this->dbContext->findAll();
	}
	
	//get info for currently logged on user. Optional. Pass unique identifer
	function getUser($str){
		$usr = $this->userContext->findBy(array('username'=>$str));
		return ($usr) ? $usr[0] : null ;
	}
	
	function updateUser(MembershipUser $user){
		$curr = $this->dbContext->find($user->getId());
		$this->em->persist($user);
		$this->em->flush();
	}
	
	//log a user in
	function validateUser($user, $pwd){
		//blowfish encryption
		//1. Retrieve password salt
		$results = $this->userContext->findBy(array('username'=>$user));
		//print_r($usr);
		if(!$results)
			return null;
		$usr = $results[0];
		$memberResults = $this->dbContext->findBy(array('userId'=>$usr->getId()));
		
		$member = $memberResults[0];
		$hashPwd = crypt($pwd, $member->getPasswordSalt());;
		
		return ($member->getPassword() == $hashPwd) ? $usr : null;
	}
	
	function enablePasswordReset($val){
		$this->enablePasswordReset =$val;
	}
	
	function enabledPasswordRetrieval($val){
		$this->enablePasswordRetrieval = $val;
	}
	
	function requireQuestionAndAnswer($val){
		$this->requireQuestionAndAnswer = $val;
	}
	
	function maxInvalidPasswordAttempts($num){
		$this->maxInvalidPasswordAttempts = $num;
	}
	
	public function getLoggedInUser(){
		$authCookie = (array_key_exists('SiteToken',$_COOKIE))? $_COOKIE['SiteToken']: null;
		if($authCookie){
			//$secure = new CI_Security();
	 		//$token = $secure->xss_clean($authCookie);
			$user = $this->userContext->find($authCookie);
			return $user;
		}else{
			return null;
		}
		
	}

	public static function getAuthenticatedUser(){
		//isUserAuthenticated
		$authCookie = (array_key_exists('SiteToken',$_COOKIE))? $_COOKIE['SiteToken']: null;
		if($authCookie){
			//$secure = new CI_Security();
	 		//$token = $secure->xss_clean($authCookie);
	 		
	 		$em = Connections::get('default')->getEntityManager();
			$user = $em->getRepository('app\models\Security\MembershipUser')->find($authCookie);
			return $user;
		}else{
			return null;
		}
		
	}
	
	public static function getUserInfo($username){
		
	 	$em = Connections::get('default')->getEntityManager();		
	 	$context = $em->getRepository('app\models\Security\MembershipUser');
		$usr = $context->findBy(array('username'=>$username));
		return ($usr) ? $usr[0] : null ;		
	}
	
	
	public static function loadInstructor($username, $model){
		$em = Connections::get('default')->getEntityManager();		
	 	$context = $em->getRepository('app\models\Security\MembershipUser');
	 	$user = $context->findOneBy(array('username'=>$username));
	 	
		$query = $em->createQuery('SELECT s FROM app\models\Instructor s WHERE s.user = :usr');
		$query->setParameter('usr', $user);
		$results = $query->getResult();
		$model->professor = $results[0]; 
	 	
	 	$query2 = $em->createQuery('SELECT pr FROM app\models\Profile pr WHERE pr.instructor = :ins');
		$query2->setParameter('ins', $model->professor);
		$pResults = $query2->getResult();
			
		$model->profile = $pResults ? $pResults[0] : null;	
		
		return $model; 	
	}
	
	
}


?>