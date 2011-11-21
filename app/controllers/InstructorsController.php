<?php  

	/**
	 * Index Page for this controller.
	 *
	 */
namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;

use app\models\Instructor;	 

class InstructorsController extends Controller{

	private $dbContext;
	
	public function ___construct(array $config = array())
	{
		parent::__construct($config);
		
		$this->dbContext = $this->em->getRepository('models\Instructor');
		$this->memContext = $this->em->getRepository('models\Security\MembershipUser');
		
		$this->configContext = $this->em->getRepository('models\Configuration');
		$res = $this->configContext->findAll();
		$this->configSettings = $res[0];

		
		$sen = new Sentinel();
		$user = $sen->getLoggedInUser();
		
		if(!$user){
			redirect('/accounts/login');

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
		$data = array('school'=>$this->configSettings->getSchool());
		
		return $this->render($data);
	}
	
	public function create_new(){
		$user = $this->input->post('membershipuser', true);
		$coll = new FormCollection($this->input->post('instructor', true));
		$sen = new Sentinel();
		
		$memUser = $sen->createUser($user['username'],$user['password'],$user['email'], $user['firstname'], $user['lastname']); 
		
		//load user into current em context
		$newuser = $this->memContext->find($memUser->getId());
		//create instructor object
		$ins = new Instructor();
		$ins->setUser($newuser);
		$ins->setOffice($coll->getItem('office'));
		$this->em->persist($ins); //persist object
		$this->em->flush();
		
		redirect('/instructors/index');
		
	}
	
	public function show($Id)
	{
		$instructor = new Instructor();
		$ins = $this->em->find('models\Instructor', $Id);
		//echo var_dump($sc);
		
		if($ins != null){
			$instructor = $ins;
			return $this->render(array('instructor' => $instructor, 'user'=>$ins->getUser()));
		}
	}
	
	public function edit($Id)
	{
		$instructor = new Instructor();
		$ins = $this->em->find('models\Instructor', $Id);
		//echo var_dump($sc);
		
		if($ins != null){
			$instructor = $ins;
			return $this->render(array('instructor' => $instructor, 'user'=>$ins->getUser()));
		}

	}
	
	public function update()
	{
		$instructor = $this->input->post('instructor', true);
		$coll = new FormCollection($instructor);
		$userColl = new FormCollection($this->input->post('membershipuser', true));
		
		$Id = $instructor['id'];
		$sen = new Sentinel();
				//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$ins = $this->em->find('models\Instructor', $Id);
			$username = $ins->getUser()->getUsername();
			$user = $sen->getUser($username);
			
			$userUpd = $userColl->updateObject('MembershipUser',$user);
			$insUpd = $coll->updateObject('Instructor', $ins);
			//var_dump($school);
			
			$sen->updateUser($userUpd);
			$this->em->persist($insUpd);
			$this->em->flush();
			redirect('/instructors/index');
			
		}else{
			return $this->edit($Id);
		}
		
	}
	
	public function delete($Id)
	{
		$instructor = new Instructor();
		$ins = $this->em->find('models\Instructor', $Id);
		//echo var_dump($sc);
		
		if($ins != null){
			$instructor = $ins;
			$data = array('instructor' => $instructor, 'user'=>$ins->getUser());
			return $this->render($data);
		}
	}
	
	public function destroy()
	{
		$insObj = $this->input->post('instructor', true);
		$coll = new FormCollection($insObj);
		
		$Id = $insObj['id'];
		$sen = new Sentinel();
		echo "Id of object is " . $Id;
		
		if($Id != null){
			$ins = $this->dbContext->find($Id);
			$username = $ins->getUser()->getUsername();
			$instructor = $this->em->remove($ins);
			$this->em->flush();
			
			//remove associated user
			$sen->deleteUser($username); 
		}
		
		redirect('/instructors/'); 
	}
	
	
}


?>