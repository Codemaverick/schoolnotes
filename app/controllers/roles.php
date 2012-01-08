<?php  

	/**
	 * Index Page for this controller.
	 *
	 */
namespace app\controllers;

use app\models\Security\Role;	
use app\models\ViewModels\DashboardVM;

use \lithium\data\Connections;
use \lithium\action\Controller;

class RolesController extends Controller{

	private $dbContext;
	
	public function ___construct(array $config = array()){
		parent::__construct($config);
		
		$this->em = Connections::get('default')->getEntityManager();
		$this->dbContext = $this->em->getRepository('app\models\Security\Role');
		$this->userContext = $this->em->getRepository('app\models\Security\MembershipUser');
		
	}
	
	public function index(){
		
		$em = Connections::get('default')->getEntityManager();
		$roles = $dbContext->findAll();
		
		$data['roles'] = $roles;
		$this->set($data);
		
	}
	
	public function create()
	{	
		return $this->render();
	}
	
	public function create_new(){
		$em = Connections::get('default')->getEntityManager();
		
		$coll = new FormCollection($this->request->data['role']);
		$role = $coll->createObject('Security\\Role'); //need to escape path;
		//print_r($role);
		$em->persist($role);
		$em->flush();
		$this->redirect('/dashboard/roles/');
	}
	
	public function show($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Security\Role');
		
		$role = new Role();
		$r = $dbContext->find($Id);
		//echo var_dump($sc);
		if($r != null){
			$role = $r;
			$data = array();
			$data['role'] = $phone;
						
			$this->set($data);
		}//else throw 404
	
	}
	
	public function users(){
		$users = $this->userContext->findAll();
		$data = array();
		$data['users'] = $users;
		
		return $this->render($data);
	}
	
	
	public function assign($id){
		$roles = $this->dbContext->findAll();
		$user = $this->userContext->find($id);
		
		$data = array('roles'=>$roles, 'user'=>$user);
		return $this->render($data);
	
	}
	
	public function assign_roles(){
		print_r($this->input->post('membershipuser'));
		$coll = new FormCollection($this->input->post('membershipuser', true));
		$roles = $coll->getItem('role');
		$id = $coll->getItem('id');
		$user = $this->userContext->find($id);
		//print_r($roles);
		
		$current = $user->getRoles()->toArray();
		//print_r($current);
		foreach($current as $item){
			$role = $this->dbContext->find($item->getId());
			$user->getRoles()->removeElement($role);
			$role->getUsers()->removeElement($user);
			$this->em->persist($user);
			$this->em->persist($role);
			$this->em->flush();
		}
		
		if($roles){
			foreach($roles as $item){
				$role = $this->dbContext->find($item);
				//$user->getRoles()->add($role);
				$role->getUsers()->add($user);
				$this->em->persist($role);
				$this->em->flush();
			}
			
		}
		//print_r($res);
		redirect('/dashboard/roles/users/');
	}
	//need to enforce security here. Should only be able to edit classnotes that belong to you
	public function edit($Id)
	{
		$role = new Role();
		$r = $this->dbContext->find($Id);
		//echo var_dump($sc);
		if($r != null){
			$role = $r;
			$data = array();
			$data['role'] = $role;

			return $this->render($data);
		}else{
			//throw 404 redirect
		}
	}
	
	public function update()
	{
		$coll = new FormCollection($this->input->post('role', true));
		//var_dump($this->input->post('classnote', true));
		//$nt = $coll->createObject('ClassNote');
		
		$Id = $coll->getItem('id');
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$r = $this->dbContext->find($Id);
			$role = $coll->updateObject('Security\\Role', $r);
			//var_dump($school);
			$this->em->persist($role);
			$this->em->flush();
			
			redirect('/dashboard/roles/');
		}else{
			return $this->edit($Id);
		}
		
	}
	
	public function delete($Id)
	{
		$role = $this->dbContext->find($Id);
		
		if($role != null){
			$data = array();
			$data['role'] = $role;
	
			return $this->render($data);
		}else{
			//throw 404 redirect
		}

	}
	
	public function destroy()
	{
		$roleObj = $this->input->post('role', true);
		$coll = new FormCollection($roleObj);
			
		$Id = $coll->getItem('id');
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$r = $this->dbContext->find($Id);
			$role = $this->em->remove($r);
			$this->em->flush();
		}
		
		
		redirect('/dashboard/roles/');
	}	
	
}


?>