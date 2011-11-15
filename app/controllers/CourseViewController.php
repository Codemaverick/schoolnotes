<?php 

	/**
	 * Index Page for this controller.
	 *
	 */
namespace app\controllers;
	 
	 
use app\models\Course;
use app\models\ViewModels\CourseViewVM;	 

use \lithium\data\Connections;
use \lithium\action\Controller;
use notes\web\FormCollection;

class CourseViewController extends Controller{

	private $dbContext;
	
	public function ___construct(array $config = array()){
		parent::__construct($config);
		
		$this->em = Connections::get('default')->getEntityManager();
		$this->dbContext = $this->em->getRepository('app\models\Course');
		$this->section = $this->em->getRepository('app\models\CourseSection');
		$this->notesContext = $this->em->getRepository('app\models\ClassNote');
		$this->hwContext = $this->em->getRepository('app\models\Homework');
		$this->annContext = $this->em->getRepository('app\models\Announcement');
	}
	
	public function index($id){
		
		//Load all classnotes, 
		$model = new CourseViewVM();
	
		$model->coursesection = $this->section->find($id);
		$model->course = $model->coursesection->getCourse();
		
		$model->classnotes = $this->notesContext->findAll();
		$model->homeworks = $this->hwContext->findAll();
		$model->announcements = $this->annContext->findAll();
		
		$data['model'] = $model;
		return $this->set($data);
		
	}
	
	/* Create a course. Department Id parameter required    */
	public function create($id)
	{
		$em = Connections::get('default')->getEntityManager();
		$regVM = new RegisterCourseVM();
	
		$query = $em->createQuery('SELECT s FROM models\School s WHERE s.id = :id');
		$query->setParameter('id', 1);
		$schools = $query->getResult();
		$regVM->school = $schools[0];
		
		$dep = $this->em->getRepository('models\Department')->find($id);
		$regVM->department = $dep; 
		
		$instructors = $this->em->getRepository('models\Instructor')->findAll();
		$ins = array();
		foreach($instructors as $i){
			$ins[$i->getId()] = $i->getFullName();
		}
		
		$regVM->instructors = $ins;
		
		
		$data['model'] = $regVM;
		//echo var_dump($regVM->school);
		
		return $this->render($data);
	}
	
	public function create_new(){
		$formItems = $this->input->post('course', true);
		$coll = new FormCollection($formItems);
		$course = $coll->createObject('Course');
		//echo var_dump($course);
		
		$query = $this->em->createQuery('SELECT s FROM models\School s WHERE s.id = :id');
		$query->setParameter('id', 1);
		$schools = $query->getResult();
		$course->setSchool($schools[0]);
		
		//$course->setDepartment(null);
		
		$query = $this->em->createQuery('SELECT s FROM models\Department s WHERE s.id = :id');
		$query->setParameter('id', $formItems['department']);
		$depts = $query->getResult();
		$course->setDepartment($depts[0]);
		
		$course->setSection(null);
		
		$this->em->persist($course);
		$this->em->flush();
		redirect('/departments/courses/'.$depts[0]->getId());
		
	}
	
	public function show($id)
	{
		$this->em = Connections::get('default')->getEntityManager();
		$this->section = $this->em->getRepository('app\models\CourseSection');
		$this->notesContext = $this->em->getRepository('app\models\ClassNote');
		$this->hwContext = $this->em->getRepository('app\models\Homework');
		$this->annContext = $this->em->getRepository('app\models\Announcement');
		
		$model = new CourseViewVM();
	
		$model->coursesection = $this->section->find($id);
		
		$model->course = $model->coursesection->getCourse();
		
		$model->classnotes = $this->notesContext->findAll();
		$model->homeworks = $this->hwContext->findAll();
		$model->announcements = $this->annContext->findAll();
		$model->professor = $model->coursesection->getInstructor();
		$data = array('model'=> $model);
		
		$this->set($data);
		
	}
	
	public function manage($id){
	//requires validation  
	
		return self::show($id);
		
	}
	
	
	public function edit($Id)
	{
		$regVM = new RegisterCourseVM();
		
		$course = new Course();
		$cs = $this->em->find('models\Course', $Id);
		
		if($cs != null){
			$regVM->course = $course = $cs;
		}
			
		$query = $this->em->createQuery('SELECT s FROM models\School s WHERE s.id = :id');
		$query->setParameter('id', 1);
		$schools = $query->getResult();
		$regVM->school = $schools[0];
		
		$departments = $this->em->getRepository('models\Department')->findAll();
		$depts = array();
		foreach($departments as $d){
			$depts[$d->getId()] = $d->getName();
		}
		$regVM->departments = $depts;
		
		
		$instructors = $this->em->getRepository('models\Instructor')->findAll();
		$ins = array();
		foreach($instructors as $i){
			$ins[$i->getId()] = $i->getFullName();
		}
		
		$regVM->instructors = $ins;
		$data['model'] = $regVM;
		
		return $this->render($data);
	}
	
	public function update()
	{
		$courseObj = $this->input->post('course', true);
		$coll = new FormCollection($courseObj);
		
		$Id = $courseObj['id'];
		echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$cs = $this->em->find('models\Course', $Id);
			$course = $coll->updateObject('Course', $cs);
			
			$query = $this->em->createQuery('SELECT s FROM models\School s WHERE s.id = :id');
			$query->setParameter('id', 1);
			$schools = $query->getResult();
			$course->setSchool($schools[0]);
		
		//$course->setDepartment(null);
		
			$query = $this->em->createQuery('SELECT s FROM models\Department s WHERE s.id = :id');
			$query->setParameter('id', $courseObj['department']);
			$depts = $query->getResult();
			$course->setDepartment($depts[0]);
		
			$course->setSection(null);
			
			$this->em->persist($course);
			$this->em->flush();
			redirect('/courses/index');
		}else{
			return $this->edit($Id);
		}
		
	}
	
	public function delete($Id)
	{
		$course = new Course();
		$cs = $this->em->find('models\Course', $Id);
		//echo var_dump($sc);
		
		if($cs != null){
			$course = $cs;
			return $this->render(array('course' => $course));
		}
	}
	
	public function destroy()
	{
		$courseObj = $this->input->post('course', true);
		$coll = new FormCollection($courseObj);
		
		$Id = $courseObj['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$cs = $this->em->find('models\Course', $Id);
			$course = $this->em->remove($cs);
			$this->em->flush();
		}
		
		redirect('/courses/');
	}
	
	
}


?>