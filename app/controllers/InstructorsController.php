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
		$ins = $em->find('app\models\Instructor', $Id);
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
		$regUser = $roleContext->findOneBy(array('roleName'=>'User'));
		$role_options = array('id'=>'user_role', 'value' => $regUser->getId());
		
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

		$em = Connections::get('default')->getEntityManager();
		$deptContext = $em->getRepository('app\models\Department');
		$instructor = $this->request->data['instructor'];
		$coll = new FormCollection($instructor);
		$userColl = new FormCollection($this->request->data['membershipuser']);
		
		$Id = $instructor['id'];
		$sen = new Sentinel();
				//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$ins = $em->find('app\models\Instructor', $Id);
			$userId = $ins->getUser()->getId();
			$mUser = $em->getRepository('app\models\Security\MembershipUser')->find($userId);
			$oldRoles = $mUser->getRoles();
			
			//if user previously had roles, remove them
			foreach($oldRoles as $r){
				//RoleManager::removeUserFromRole($mUser, $r);
			}
			
			$userUpd = $userColl->updateObject('MembershipUser',$mUser);
			//print_r($userUpd->getRoles());
			
			//$insUpd = $coll->updateObject('Instructor', $ins);
			
			//$dept = $deptContext->find($coll->getItem('department'));
			
			//get selected role
			//$selectedRole = $em->getRepository('app\models\Security\Role')->find($userColl->getItem('role'));
			
			//$this->redirect('/instructors/index');
			exit();
		}else{
			return $this->edit($Id);
		}
		
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