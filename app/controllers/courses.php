<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\Course;
use models\ViewModels\RegisterCourseVM;	 

class Courses extends Controller{

	private $dbContext;
	private $configSettings;
	
	public function __construct()
	{
		parent::__construct();
		
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){
			redirect('/accounts/login');
		}
		
		$this->dbContext = $this->em->getRepository('models\Course');
		$this->configSettings = ApplicationSettings::getConfiguration();
		
	}
	
	public function index(){
		
		$data['courses'] = $this->dbContext->findAll();
		return $this->render($data);
		
	}
	
	/* Create a course. Department Id parameter required    */
	public function create($id)
	{
		$regVM = new RegisterCourseVM();
		$regVM->school = $this->configSettings->getSchool();
		
		$dep = $this->em->getRepository('models\Department')->find($id);
		$regVM->department = $dep; 
		
		$instructors = $this->em->getRepository('models\Instructor')->findAll();
		$ins = array();
		foreach($instructors as $i){
			$ins[$i->getId()] = $i->getUser()->getFullName();
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
	
	public function show($Id)
	{
		$course = new Course();
		$cs = $this->em->find('models\Course', $Id);
		//echo var_dump($sc);
		
		if($cs != null){
			$course = $cs;
			return $this->render(array('course' => $course));
		}
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