<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\School, models\Department, models\Instructor, models\Semester;	
use models\ViewModels\AdminVM, models\ViewModels\AdminCoursesVM;
use models\ViewModels\CourseVM;

class Admin extends Controller{

	private $dbContext;
	private $prof;
	private $configSettings;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\School');
		$this->userContext = $this->em->getRepository('models\Security\MembershipUser'); //temp default professor
		$this->configContext = $this->em->getRepository('models\Configuration');
		$res = $this->configContext->findAll();
		$this->configSettings = $res[0];
		
		$user = Sentinel::getAuthenticatedUser();
		if($user){
			$this->dbContext = $this->em->getRepository('models\Instructor');
			
			$query = $this->em->createQuery('SELECT s FROM models\Instructor s WHERE s.user = :usr');
			$query->setParameter('usr', $user);
			$results = $query->getResult();
			$this->prof = $results[0]; //temp default professor
		}else{
			redirect('/accounts/login');
		}
		
	}
	
	public function index(){
		
		$adminVM = new AdminVM();
		$depts = $this->em->getRepository('models\Department')->findAll();
		$adminVM->departments = $depts;
		$adminVM->school = $this->configSettings->getSchool();
		$data = array('model'=>$adminVM);
		//$adminVM->instructors = $this->em->getRepository('models\Instructor')->findAll();
	
		return $this->render($data);
		
	}
	
	public function assign_roles($id){
		$user = $this->userContext->find($id);
		$roles = $this->em->getRepository('models\Security\Role')->findAll();
		$data = array('user'=> $user, 'roles'=> $roles);
		
		
		return $this->render($data);
	}
	
		
	public function assign_courses($id){
		//first, get a list of all courses
		$data = array();
		$acVM = new AdminCoursesVM();
		
		$acVM->semester = $this->em->getRepository('models\Semester')->find($id);
		if($acVM->semester){
			$data['model'] = $acVM;
		}
		
		$acVM->courses = $this->em->getRepository('models\Course')->findAll();
		return $this->render($data);
		
	}
	
	public function assign(){
		$courses = $this->input->post('courses');
		$semId = $this->input->post('semesterId');
		
		$semContext = $this->em->getRepository('models\Semester');
		$semester = $semContext->find($semId);
		
		//first remove any previously assigned courses
		if($semester->getCourses()->count() > 0){
			$semester->getCourses()->clear();
			$this->em->persist($semester);
			$this->em->flush();
		}
		
		//echo var_dump($courses);
		$crsContext = $this->em->getRepository('models\Course');
		
		if(count($courses) > 0){
			foreach($courses as $crs){
				$course = $crsContext->find($crs);
				$semester->getCourses()->add($course);
			}
			$this->em->persist($semester);
			$this->em->flush();
		}
		redirect('/admin/semesters/');
	}
	
	public function semesters(){
		$data = array();
		$data['semesters'] = $this->em->getRepository('models\Semester')->findAll();
		return $this->render($data);

	}
	
	public function courses($semesterId, $courseId){
		$semester = $this->em->getRepository('models\Semester')->find($semesterId);
		$course = $this->em->getRepository('models\Course')->find($courseId);

		$query = $this->em->createQuery('SELECT s FROM models\CourseSection s WHERE s.course = :crs and s.semester = :sem');
		$query->setParameter('crs', $course);
		$query->setParameter('sem', $semester);
		$sections = $query->getResult();
		
		$data = array();
		$data['semester'] = $semester;
		$data['course'] = $course;
		$data['sections'] = $sections;
		
		return $this->render($data);
	}
		
}


?>