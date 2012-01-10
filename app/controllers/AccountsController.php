<?php


namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;

use app\models\Security\Membership;
use app\models\Security\MembershipUser;	
use app\models\Instructor;
	
use notes\web\FormCollection;
use notes\security\Sentinel;

class AccountsController extends Controller{

	private $dbContext;
	
	public function ___construct(array $config = array()){
		parent::__construct($config);
		
		$this->em = Connections::get('default')->getEntityManager();
		
		$this->dbContext = $this->em->getRepository('app\models\School');
		$this->memContext = $this->em->getRepository('app\models\Security\MembershipUser');
	}
	
	public function register(){
	
		//return $this->render();
	
	}
	
	public function create_user(){
		
		$this->em = Connections::get('default')->getEntityManager();
		$user = $this->request->data['membershipuser'];
		$sen = new Sentinel();
		
		$memUser = $sen->createUser($user['username'],$user['password'],$user['email'], $user['firstname'], $user['lastname']); 
		
		//load user into current em context
		$newuser = $this->memContext->find($memUser->getId());
		//create instructor object
		$ins = new Instructor();
		$ins->setUser($newuser);
		$this->em->persist($ins); //persist object
		$this->em->flush();
		
		if($memUser->getId()){
			$cookie = array(
				'name' => 'SiteToken',
				'value' => $memUser->getId(),
				'expire' => 0,
				'secure' => TRUE
			);
			$this->input->set_cookie($cookie);
		}
		
		$this->redirect('Pages::index');
	}
	
	public function login(){
		
		//$data['schools'] = $this->dbContext->findAll();
		//return $this->render();
		
	}
	
	public function loginUser()
	{
		//$token = new SecureToken();
		//$tokenstr = json_encode($token);
		$coll = new FormCollection($this->request->data['usermodel']);
		$username = $coll->getItem('username');
		$pwd = $coll->getItem('password');
		
		$sen = new Sentinel();
		$usr = $sen->validateUser($username, $pwd);
		
		if($usr){
			$cookie = array(
				'name' => 'SiteToken',
				'value' => $usr->getId(),
				'expire' => 0,
				'secure' => FALSE
			);
			
			$succ = setcookie('SiteToken', $usr->getId(), 0, '/', '', FALSE);
			//echo "Return value of setting cookie: " . $succ;
			$this->redirect('/dashboard/');
		}else{
			$this->set(array('status'=>'fail'));
			return $this->render(array('template'=>'login'));
		}
		
	}
	
	public function logout(){
		$cookie = array(
				'name' => 'SiteToken',
				'value' => '',
				'expire' => time() - 3600,
				'secure' => TRUE
		);
		//$this->input->set_cookie($cookie);
		$succ = setcookie('SiteToken', '', time() - 3600, '/', FALSE);
		$this->redirect('Pages::index');
	}
	
	public function show($Id)
	{
		$school = new School();
		$sc = $this->em->find('models\School', $Id);
		//echo var_dump($sc);
		
		if($sc != null){
			$school = $sc;
			return $this->render(array('school' => $school));
		}
	}
	
	public function edit($Id)
	{
		$school = new School();
		$sc = $this->em->find('models\School', $Id);
		//echo var_dump($sc);
		
		if($sc != null){
			$school = $sc;
			return $this->render(array('school' => $school));
		}
	}
	
	public function update()
	{
		$schoolObj = $this->input->post('school', true);
		$coll = new FormCollection($schoolObj);
		
		$Id = $schoolObj['id'];
		echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$sc = $this->em->find('models\School', $Id);
			$school = $coll->updateObject('School', $sc);
			//var_dump($school);
			
			$this->em->persist($school);
			$this->em->flush();
			redirect('/schools/index');
		}else{
			return $this->edit($Id);
		}
		
	}
	
	public function delete($Id)
	{
		$school = new School();
		$sc = $this->em->find('models\School', $Id);
		//echo var_dump($sc);
		
		if($sc != null){
			$school = $sc;
			return $this->render(array('school' => $school));
		}
	}
	
	public function destroy()
	{
		$schoolObj = $this->input->post('school', true);
		$coll = new FormCollection($schoolObj);
		
		$Id = $schoolObj['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$sc = $this->em->find('models\School', $Id);
			$school = $this->em->remove($sc);
			$this->em->flush();
		}
		
		redirect('/schools/');
	}
	
	
}


?>