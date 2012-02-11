<?php  	

namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;


use app\models\Homework, models\CourseSection, models\Instructor;	
use app\models\ViewModels\DashboardVM;
use app\models\ViewModels\CourseVM;
use app\models\ViewModels\CourseViewVM;	

use notes\web\FormCollection;
use \DateTime;

class HomeworksController extends Controller{

	private $dbContext;
	private $prof;
	
	public function ___construct(array $config = array()){
		parent::__construct($config);
		/*
		$em = Connections::get('default')->getEntityManager();
		$this->dbContext = $em->getRepository('app\models\Homework');
		$this->prof = $this->dbContext->find(1); //temp default professor
		$this->sContext = $this->em->getRepository('app\models\CourseSection');
		*/
	}
	
	public function index($courseId, $section){
		
		$em = Connections::get('default')->getEntityManager();
		
		$username = $this->request->params['username'];
		$model = CourseViewVM::loadHWView($username, $section);
		
		$data = array('model'=> $model);
		$this->render(array('layout'=>'profiles'));
	}
	
	public function create($id)
	{
		$em = Connections::get('default')->getEntityManager();
		$sContext = $em->getRepository('app\models\CourseSection');
		$section = $sContext->find($id);
		$data = array();
		$data['section'] = $section;
		
		$this->set($data);
	}
	
	public function create_new(){
		
		$sen = new Sentinel();	
		$user = $sen->getLoggedInUser();
		
		if(!$user){
			$this->redirect('Accounts::login');
		}
		
		$em = Connections::get('default')->getEntityManager();
		$sContext = $em->getRepository('app\models\CourseSection');
		$coll = new FormCollection($this->request->data['homework']);
		//var_dump($this->input->post('classnote', true));
		$hw = $coll->createObject('Homework');
		//var_dump($note);
		$sec = $coll->getItem('section');
		$section = $sContext->find($sec);
		$hw->setCourseSection($section);
	
		//try catch block?
		$hw->setDateDue(new DateTime($coll->getItem('dateDue')));
		$hw->setDateCreated(new DateTime("now"));
		$hw->setCreatedBy($user);
		//var_dump($note->getDateCreated());
		
		$em->persist($hw);
		$em->flush();
		$this->redirect('/dashboard/courseview/show/' . $section->getId());
	}
	
	public function show($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Homework');
		
		$homework = new Homework();
		$hw = $dbContext->find($Id);
		//echo var_dump($sc);
		if($hw != null){
			$homework = $hw;
			$data = array();
			$data['homework'] = $homework;
			$data['section'] = $homework->getCourseSection();			
			$data['course'] = $homework->getCourseSection()->getCourse();
			//var_dump($section->getCourse());
			
			$this->set($data);
		}//else throw 404
	
	}
	
	public function listAll(){
		$user = $this->request->params['user'];
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Homework');
		$userContext = $em->getRepository('app\models\Security\MembershipUser');
		$classContext = $em->getRepository('app\models\CourseSection');
		//$instructor
		//ideally, should be as simple as this
		$query2 = $em->createQuery('SELECT s FROM app\models\Instructor s WHERE s.user = :usr');
		$query2->setParameter('usr', $user);
		$results = $query2->getResult();
		$instr = $results[0];
		
		$prof = $userContext->find($user->getId());
		$query = $em->createQuery('SELECT h FROM app\models\Homework h WHERE h.createdBy = :usr');
		$query->setParameter('usr', $instr);
		$homeworks = $query->getResult();
		
		//get list of classes taught by this professor
		$query3 = $em->createQuery('SELECT cs FROM app\models\CourseSection cs WHERE cs.instructor = :ins');
		$query3->setParameter('ins', $instr);
		$courses = $query3->getResult();
		
		$query4 = $em->createQuery('SELECT pr FROM app\models\Profile pr WHERE pr.instructor = :ins');
		$query4->setParameter('ins', $instr);
		$pResults = $query4->getResult();

			
		$dashVM = new DashboardVM();
		$dashVM->professor = $results[0];
		if($pResults){
			$dashVM->profile = $pResults[0];
		}
		
		$data['model'] = $dashVM;
		$data['homeworks'] = $homeworks;
		$data['courses'] = $courses;
		
		$this->set($data);
		$this->render(array('layout'=>'profiles'));
	}
	
	//need to enforce security here. Should only be able to edit classnotes that belong to you
	public function edit($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Homework');
		$sContext = $em->getRepository('app\models\CourseSection');
		
		$hw = $this->getHomework($Id);
		
		if($hw != null){
			$data = array();
			$data['homework'] = $hw;
			$section = $sContext->find($hw->getCourseSection()->getId());
			$data['section'] = $section;

			$this->set($data);
		}else{
			//throw 404 redirect
		}
	}
	
	public function update()
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Homework');
		
		$coll = new FormCollection($this->request->data['homework']);
		//var_dump($this->input->post('classnote', true));
		//$nt = $coll->createObject('ClassNote');
		
		$Id = $coll->getItem('id');
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$hw = $dbContext->find($Id);
			$homework = $coll->updateObject('Homework', $hw);
			//var_dump($school);
			
			$hw->setDateDue(new DateTime($coll->getItem('dateDue')));
			$em->persist($homework);
			$em->flush();
			
			$sec = $coll->getItem('section');
			$section = $sContext->find($sec);
			$this->redirect('/dashboard/courseview/show/' . $section->getId());
		}else{
			return self::edit($Id);
		}
		
	}
	
	public function delete($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Homework');
		
		$homework = $this->getHomework($Id);
		
		if($homework != null){
			$data = array();
			$data['homework'] = $homework;
			$section = $this->sContext->find($homework->getCourseSection()->getId());
			$data['section'] = $section;

			$this->set($data);
		}else{
			//throw 404 redirect
		}

	}
	
	public function destroy()
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Homework');
		$sContext = $em->getRepository('app\models\CourseSection');
		
		$hwObj = $this->request->data['homework'];
		$coll = new FormCollection($hwObj);
		//var_dump($hwObj);
		
		$Id = $coll->getItem('id');
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$hw = $dbContext->find($Id);
			$homework = $em->remove($hw);
			$this->em->flush();
		}
		
		$sec = $coll->getItem('section');
		$section = $sContext->find($sec);
		$this->redirect('/dashboard/courseview/show/' . $section->getId());
	}
	
	private function getHomework($Id){
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Homework');
		
		$hw = $this->dbContext->find($Id);
		
		if($hw != null){
			return $hw;
		}else{
			return null;
		}
	}

	
}


?>