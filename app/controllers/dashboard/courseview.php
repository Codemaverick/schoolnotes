<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\Course;
use models\ViewModels\CourseViewVM;	 

class CourseView extends Controller{

	private $dbContext;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\Course');
		$this->section = $this->em->getRepository('models\CourseSection');
		$this->notesContext = $this->em->getRepository('models\ClassNote');
		$this->hwContext = $this->em->getRepository('models\Homework');
		$this->annContext = $this->em->getRepository('models\Announcement');
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
		return $this->render($data);
		
	}
	
	/* Create a course. Department Id parameter required    */
	public function create($id)
	{
		$regVM = new RegisterCourseVM();
	
		$query = $this->em->createQuery('SELECT s FROM models\School s WHERE s.id = :id');
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
		$model = new CourseViewVM();
	
		$model->coursesection = $this->section->find($id);
		
		$model->course = $model->coursesection->getCourse();
		
		$model->classnotes = $this->notesContext->findAll();
		$model->homeworks = $this->hwContext->findAll();
		$model->announcements = $this->annContext->findAll();
		
		$data = array('model'=> $model);
		
		return $this->render($data);
		
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