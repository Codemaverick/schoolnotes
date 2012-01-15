<?php  

	/**
	 * Index Page for this controller.
	 *
	 */
namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;

use app\models\Instructor;
use app\models\Security\Role;

use notes\security\RoleManager;
use notes\security\Sentinel;
use notes\web\FormCollection;	
use \Doctrine\Common\Collections\ArrayCollection; 

class InstructorsController extends Controller{

	private $dbContext;
	
	public function ___construct(array $config = array())
	{
		parent::__construct($config);
		
		$this->dbContext = $this->em->getRepository('app\models\Instructor');
		$this->memContext = $this->em->getRepository('app\models\Security\MembershipUser');
		
		$this->configContext = $this->em->getRepository('app\models\Configuration');
		$res = $this->configContext->findAll();
		$this->configSettings = $res[0];

		
		$sen = new Sentinel();
		$user = $sen->getLoggedInUser();
		
		if(!$user){
			$this->redirect('/accounts/login');

		}
		
	}
	
	public function index(){
		
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Instructor');
		$data['instructors'] = $dbContext->findAll();
		
		return $this->set($data);
		
	}
	
	public function create()
	{
		$sen = new Sentinel();
		$user = $sen->getLoggedInUser();
		
		if(!$user){
			$this->redirect('/accounts/login');

		}
		$data = array('school'=>$this->configSettings->getSchool());
		
		return $this->set($data);
	}
	
	public function create_new(){
		
		$sen = new Sentinel();
		$user = $sen->getLoggedInUser();
		if(!$user){ $this->redirect('/accounts/login'); }
		
		$em = Connections::get('default')->getEntityManager();
		
		$user = $this->request->data['membershipuser'];
		$coll = new FormCollection($this->request->data['instructor']);
		$sen = new Sentinel();
		
		$memUser = $sen->createUser($user['username'],$user['password'],$user['email'], $user['firstname'], $user['lastname']); 
		
		//load user into current em context
		$newuser = $this->memContext->find($memUser->getId());
		//create instructor object
		$ins = new Instructor();
		$ins->setUser($newuser);
		$ins->setOffice($coll->getItem('office'));
		$em->persist($ins); //persist object
		$em->flush();
		
		$this->redirect('/instructors/index');
		
	}
	
	public function show($Id)
	{
		$sen = new Sentinel();
		$user = $sen->getLoggedInUser();
		if(!$user){ $this->redirect('/accounts/login'); }
		
		$instructor = new Instructor();
		$em = Connections::get('default')->getEntityManager();
		$ins = $em->find('app\models\Instructor', $Id);
		//echo var_dump($sc);
		
		if($ins != null){
			$instructor = $ins;
			$this->set(array('instructor' => $instructor, 'user'=>$ins->getUser()));
		}
	}
	
	public function edit($Id)
	{
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){ $this->redirect('/accounts/login'); }
		
		$em = Connections::get('default')->getEntityManager();
		$roleContext = $em->getRepository('app\models\Security\Role');
		$instructor = new Instructor();
		$ins = $em->getRepository('app\models\Instructor')->find($Id);
		$deptList = $em->getRepository('app\models\Department')->findAll();
		//echo var_dump($sc);
		$depts = array();
		foreach($deptList as $d){
			$depts[$d->getId()] = $d->getName();
		}
		
		$userRoles = $roleContext->findAll();
		$roles = array();
		foreach($userRoles as $r){
			$roles[$r->getId()] = $r->getRoleName();
		}
		
		//regular user role
		$selectedRole = null;
		if($ins->getUser()->getRoles()->count() > 0){
			$userRoles = $ins->getUser()->getRoles();
			$selectedRole = $userRoles[0];
		}else{
			$selectedRole = $roleContext->findOneBy(array('roleName'=>'User'));
		}
		
		$role_options = array('id'=>'user_role', 'value' => $selectedRole->getId());
		$dept_options = array('id'=>'instructor_department', 'value' => $ins->getDepartments()->get(0));
		
		if($ins != null){
			$instructor = $ins;
			$this->set(array('instructor' => $instructor, 
							'user'=>$ins->getUser(), 
							'departments'=> $depts, 
							'roles' => $roles,
							'role_options'=> $role_options
						));
		}

	}
	
	public function update()
	{
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){ $this->redirect('/accounts/login'); }
		
		$mUserParams = $this->request->data['membershipuser'];
		$mUserCollection = new FormCollection($mUserParams);
		
		$insParams = $this->request->data['instructor'];
		$insCollection = new FormCollection($insParams);
		
		$insID = $insCollection->getItem('id');
		//echo "Instructor Id = : " . $userID;

		$em = Connections::get('default')->getEntityManager();
		$instructor = $em->getRepository('app\models\Instructor')->find($insID);
		$userContext = $em->getRepository('app\models\Security\MembershipUser');
		$mUser = $instructor->getUser();
		$currentRoles = $mUser->getRoles();
		
		//department - for now, only one department is allowed
		$userDep = $em->getRepository('app\models\Department')->find($insCollection->getItem('department'));
		foreach($instructor->getDepartments() as $dep){
			$instructor->getDepartments()->removeElement($dep);
		}
		$em->persist($instructor);
		$em->flush();
		
		$instructor->addDepartment($userDep);
		$em->persist($instructor);
		
		//echo "Current number of roles is : " . count($currentRoles);
		
		if(count($currentRoles) > 0){
			foreach($currentRoles as $cRole)
				RoleManager::removeUserFromRole($mUser, $cRole);
		}
	
		$currentRoles = $mUser->getRoles();
		//echo "Current number of roles after remove is : " . count($currentRoles);
		
		$roleID = $mUserCollection->getItem('role');
		$mUserRole = $em->getRepository('app\models\Security\Role')->find($roleID);
		
		$mUpdatedUser = $mUserCollection->updateObject('MembershipUser', $mUser);
		$mUpdatedUser->getRoles()->add($mUserRole);
		$em->persist($mUpdatedUser);
		$em->flush();
		
		RoleManager::addUsersToRole(array($mUser), $mUserRole);
		
		
		
		$this->redirect('/instructors/index');
		
	}
	
	public function delete($Id)
	{
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){ $this->redirect('/accounts/login'); }

		$em = Connections::get('default')->getEntityManager();
		$instructor = new Instructor();
		$ins = $em->find('app\models\Instructor', $Id);
		//echo var_dump($sc);
		
		if($ins != null){
			$instructor = $ins;
			$data = array('instructor' => $instructor, 'user'=>$ins->getUser());
			return $this->set($data);
		}
	}
	
	public function destroy()
	{
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){ $this->redirect('/accounts/login'); }

		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Instructor');
		$insObj = $this->request->data('instructor', true);
		$coll = new FormCollection($insObj);
		
		$Id = $insObj['id'];
		$sen = new Sentinel();
		//echo "Id of object is " . $Id;
		
		if($Id != null){
			$ins = $dbContext->find($Id);
			$username = $ins->getUser()->getUsername();
			$instructor = $em->remove($ins);
			$em->flush();
			
			//remove associated user
			$sen->deleteUser($username); 
		}
		
		$this->redirect('Instructors::index'); 
	}
	
	
}


?>