<?php  
namespace notes\security;

use \lithium\data\Connections;
use \lithium\action\Controller;

use \Doctrine\Common\Collections\ArrayCollection;
use app\models\Security\Role;
use app\models\Security\MembershipUser;
	/**
 * RoleManager - Application Security Class
 *
 * This class object is used to define and control access to pages and controllers
 * 
 * @package		Core
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Jason Abayomi
 */
 
class RoleManager{
	
	private $applicationName;
	private $cookieName;
	private $cookieTimeOut;
	private $createPersistentCookie;
    
    function __construct()  {
		parent::__construct();
		
		/* Instantiate Doctrine's Entity manager so we don't have
		   to everytime we want to use Doctrine */
		
		//$this->doctrine = new Doctrine();
		$this->em = Connections::get('default')->getEntityManager();	
		$this->dbContext = $this->em->getRepository('app\models\Security\Role');
		$this->userContext = $this->em->getRepository('app\models\Security\MembershipUser');
	}
	
	public function addUsersToRole(array $users, $new_role){
		$em = Connections::get('default')->getEntityManager();		
		$roleContext = $em->getRepository('app\models\Security\Role');
		$userContext = $em->getRepository('app\models\Security\MembershipUser');

		$role = $roleContext->find($new_role->getId());
		
		foreach($users as $user){
			$u = $userContext->find($user->getId());
			if(!$role->getUsers()->contains($u)){
				$role->getUsers()->add($u);	
				$u->getRoles()->add($role);
				$em->persist($u);
				$em->persist($role);
				$em->flush();	
			}
		}
		
		
	}
	
	//delete user and any related user data from the DB
	public function addUsersToRoles(array $users, array $roles){
		foreach($roles as $role){
			$this->addUsersToRole($users, $role);	
		}
	}
	
	//need some paging functionality? ex: findUsersByName($str, $bool(page data/yes/no), $pageNum)
	public static function addUserToRoles($user, array $roles){
		$em = Connections::get('default')->getEntityManager();		
		$roleContext = $em->getRepository('app\models\Security\Role');
		$userContext = $em->getRepository('app\models\Security\MembershipUser');
		
		$user = $userContext->find($user->getId());
		
		foreach($roles as $role){
			$role = $roleContext->find($role->getId());
			$user->getRoles()->add($role);	
			$role->getUsers()->add($user);
			
			$em->persist($user);
			$em->persist($role);
			$em->flush();	
		}
		
		
	}
	
	public function createRole($role){
		$newrole = new Role();
		$newrole->setRoleName($role);
		
		$this->em->persist($newrole);
		$this->em->flush();
		
		return $newrole;
	}
	
	//page data?
	public static function listAllRoles(){
		$em = Connections::get('default')->getEntityManager();		
		$context = $em->getRepository('app\models\Security\Role');		
		return $context->findAll();
	}
	
	//get info for currently logged on user. Optional. Pass unique identifer
	public function listUsersInRole($str){
		$em = Connections::get('default')->getEntityManager();		
		$context = $em->getRepository('app\models\Security\Role');
		$role = $context->findBy(array('roleName'=>$str));
		
		return $role->getUsers();	
	
	}
	
	public static function removeUserFromRole(MembershipUser $u, Role $r){
		$em = Connections::get('default')->getEntityManager();		
		$roleContext = $em->getRepository('app\models\Security\Role');
		$userContext = $em->getRepository('app\models\Security\MembershipUser');
		
		$role = $roleContext->find($r->getId());
		$user = $userContext->find($u->getId());
		
		if($role->getUsers()->count() > 0){
			//echo "Role getUsers does have more than one user";
			$role->getUsers()->removeElement($user);
			$user->getRoles()->removeElement($role);
			
			$em->flush();
		}
	}
	
	//remove a user
	public static function removeUsersFromRole(array $users, Role $r){
		$em = Connections::get('default')->getEntityManager();	
		$roleContext = $em->getRepository('app\models\Security\Role');
		$userContext = $em->getRepository('app\models\Security\MembershipUser');

		$role = $roleContext->find($r->getId());
		
		if(!$role) return;
		foreach($users as $u){
			$user = $userContext->find($u->getId());
			$role->getUsers()->removeElement($user);
			$user->getRoles()->removeElement($role);
		}
		
		$this->em->persist($role);
		$this->em->flush();
	}
	
	public static function IsUserInRole($user, $roleName){
		$em = Connections::get('default')->getEntityManager();	
		$roleContext = $em->getRepository('app\models\Security\Role');
		$userContext = $em->getRepository('app\models\Security\MembershipUser');
		
		$user = $userContext->find($user->getId());
		$role = $roleContext->findOneBy(array('roleName' => $roleName));
		$isInRole = false;
		
		if(($role)&&($user->getRoles()->count() > 0)){
			$roles = $user->getRoles();
			foreach($roles as $r){
				if($r->getId() == $role->getId())
				$isInRole = true;
			}
			//echo "Does it contain?" . $contains;
			return $isInRole;
		}else{
			return false;
		} 
		
	}
	
}


?>