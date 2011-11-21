<?php  

namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;

use app\models\Course;
use app\models\ViewModels\RegisterCourseVM;	
use notes\utilities\ApplicationSettings;

use notes\web\FormCollection;
use notes\security\Sentinel;
use \DateTime; 

class CoursesController extends Controller{

	private $dbContext;
	private $configSettings;
	
	public function ___construct(array $config = array())
	{
		parent::__construct($config);
		
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){
			$this->redirect('/accounts/login');
		}
		
		$this->dbContext = $this->em->getRepository('app\models\Course');
		$this->configSettings = ApplicationSettings::getConfiguration();
		
	}
	
	public function index(){
		
		$em = Connections::get('default')->getEntityManager();
		
		$dbContext = $em->getRepository('app\models\Course');
		$data['courses'] = $dbContext->findAll();
		$this->set($data);
		
	}
	
	/* Create a course. Department Id parameter required    */
	public function create($id)
	{
		$em = Connections::get('default')->getEntityManager();
		
		$regVM = new RegisterCourseVM();
		$configSettings = ApplicationSettings::getConfiguration();
		$regVM->school = $configSettings->getSchool();
		
		$dep = $em->getRepository('app\models\Department')->find($id);
		$regVM->department = $dep; 
		
		$instructors = $em->getRepository('app\models\Instructor')->findAll();
		$ins = array();
		foreach($instructors as $i){
			$ins[$i->getId()] = $i->getUser()->getFullName();
		}
		
		$regVM->instructors = $ins;
		
		$data['model'] = $regVM;
		//echo var_dump($regVM->school);
		
		$this->set($data);
	}
	
	public function create_new(){
	
		$em = Connections::get('default')->getEntityManager();
		
		$formItems = $this->request->data['course'];
		
		$coll = new FormCollection($formItems);
		$course = $coll->createObject('Course');
		//echo var_dump($course);
		
		$query = $em->createQuery('SELECT s FROM app\models\School s WHERE s.id = :id');
		$query->setParameter('id', 1);
		$schools = $query->getResult();
		$course->setSchool($schools[0]);
		
		//$course->setDepartment(null);
		
		$query = $em->createQuery('SELECT s FROM app\models\Department s WHERE s.id = :id');
		$query->setParameter('id', $formItems['department']);
		$depts = $query->getResult();
		$course->setDepartment($depts[0]);
		
		$course->setSection(null);
		
		$em->persist($course);
		$em->flush();
		$this->redirect('/departments/courses/'.$depts[0]->getId());
		
	}
	
	public function show($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		
		$course = new Course();
		$cs = $em->find('app\models\Course', $Id);
		//echo var_dump($sc);
		
		if($cs != null){
			$course = $cs;
			$this->set(array('course' => $course));
		}
	}
	
	public function edit($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		
		$regVM = new RegisterCourseVM();
		
		$course = new Course();
		$cs = $em->find('app\models\Course', $Id);
		
		if($cs != null){
			$regVM->course = $course = $cs;
			$regVM->department = $cs->getDepartment();
		}
		/*	
		$query = $em->createQuery('SELECT s FROM app\models\School s WHERE s.id = :id');
		$query->setParameter('id', 1);
		$schools = $query->getResult();
		$regVM->school = $schools[0];*/
		
		/*$departments = $em->getRepository('app\models\Department')->findAll();
		$depts = array();
		foreach($departments as $d){
			$depts[$d->getId()] = $d->getName();
		}*/
		
		
		
		$instructors = $em->getRepository('app\models\Instructor')->findAll();
		$ins = array();
		foreach($instructors as $i){
			$ins[$i->getId()] = $i->getUser()->getFullName();
		}
		
		$regVM->instructors = $ins;
		$data['model'] = $regVM;
		
		$this->set($data);
	}
	
	public function update()
	{
		$em = Connections::get('default')->getEntityManager();
		
		$courseObj = $this->request->data['course'];
		$coll = new FormCollection($courseObj);
		
		$Id = $courseObj['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$cs = $em->find('app\models\Course', $Id);
			$course = $coll->updateObject('Course', $cs);
			
			$sch = $course->getDepartment()->getSchool();
			
			/*$query = $em->createQuery('SELECT s FROM app\models\School s WHERE s.id = :id');
			$query->setParameter('id', $sch->getId());
			$schools = $query->getResult();
			$course->setSchool($schools[0]);*/
		
		//$course->setDepartment(null);
			$course->setSchool($sch);
			/*
			$query = $em->createQuery('SELECT s FROM app\models\Department s WHERE s.id = :id');
			$query->setParameter('id', $courseObj['department']);
			$depts = $query->getResult();
			$course->setDepartment($depts[0]);
			*/
			if(!$course->getSection())
			$course->setSection(null);
			
			$em->persist($course);
			$em->flush();
			$this->redirect('Courses::index');
		}else{
			return $this->edit($Id);
		}
		
	}
	
	public function delete($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		
		$course = new Course();
		$cs = $em->find('app\models\Course', $Id);
		//echo var_dump($sc);
		
		if($cs != null){
			$course = $cs;
			return $this->set(array('course' => $course));
		}
	}
	
	public function destroy()
	{
		$em = Connections::get('default')->getEntityManager();
		
		$courseObj = $this->request->data['course'];
		$coll = new FormCollection($courseObj);
		
		$Id = $courseObj['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$cs = $em->find('app\models\Course', $Id);
			$course = $em->remove($cs);
			$em->flush();
		}
		
		$this->redirect('/courses/');
	}
	
	
}


?>