<?php  	

namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;


use app\models\Homework, models\CourseSection, models\Instructor;	
use app\models\ViewModels\DashboardVM;
use app\models\ViewModels\CourseVM;

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
		$course = $this->em->getRepository('models\Course')->find($courseId);
		$section = $this->sContext->find($section);
		$hw = $this->dbContext->findAll(); //retrieve the id of the current semester
		
		$data['homeworks'] = $hw;
		return $this->render($data);
		
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