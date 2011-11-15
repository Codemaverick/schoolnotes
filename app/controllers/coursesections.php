<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\Course;
use models\CourseSection;
use models\ViewModels\RegisterCourseVM;	 
use models\Configuration;

class CourseSections extends Controller{

	private $dbContext;
	private $configSettings;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\CourseSection');
		$this->crsContext = $this->em->getRepository('models\Course');
		$this->configSettings = ApplicationSettings::getConfiguration();
	}
	
	public function index($dept, $courseId){
		
		$course = $this->em->getRepository('models\Course')->find($courseId);
		
		$query = $this->em->createQuery('SELECT s FROM models\CourseSection s WHERE s.course = :crs');
		$query->setParameter('crs', $course);
		$sections = $query->getResult();
		
		$semesters = $this->em->getRepository('models\Semester')->findAll();
		//echo var_dump($sections);
		
		$data['semesters'] = $semesters;
		$data['course'] = $course;
		$data['sections'] = $sections;
		
		return $this->render($data);
	}
	
	public function create($id)
	{
		//$regVM = new RegisterCourseVM();
		$regVM->school = $this->configSettings->getSchool();
		
		$course = $this->em->getRepository('models\Course')->find($id);
		$data['course'] = $course;
		
		$semester = AppUtilities::getCurrentSemester();
		$data['semester'] = $semester;
		
		$instructors = $this->em->getRepository('models\Instructor')->findAll();
		$ins = array();
		$ins[0] = "Select Professor";
		
		foreach($instructors as $i){ //ideal circumstance, pick only professors assigned to current department
			$ins[$i->getId()] = $i->getUser()->getFullName();
		}
		
		$data['instructors'] = $ins;
		
		
		//$data['model'] = $regVM;
		//echo var_dump($regVM->school);
		
		return $this->render($data);
	}
	
	public function create_new(){
		$formItems = $this->input->post('coursesection', true);
		$coll = new FormCollection($formItems);
		$section = $coll->createObject('CourseSection');
		//echo var_dump($section);
		
		$semester = $this->em->getRepository('models\Semester')->find($coll->getItem('semester'));
		$section->setCourse(null);
		$section->setInstructor(null);
		$section->setSemester($semester);
		$this->em->persist($section);
		$this->em->flush();
		
		$cId = $formItems['course'];
		$course = $this->crsContext->find($cId);
		$section->setCourse($course);
		//echo var_dump($);
		
		//$course->setDepartment(null);
		if($formItems['instructor'] > 0){
			$query = $this->em->createQuery('SELECT p FROM models\Instructor p WHERE p.id = :id');
			$query->setParameter('id', $formItems['instructor']);
			$ins = $query->getResult();
			$section->setInstructor($ins[0]);
		}else{
			$section->setInstructor(null);
		}
		
		$this->em->persist($section);
		$this->em->flush();
		redirect('/coursesections/index/'. $course->getDepartment()->getId() . "/".$course->getId());
		
	}
	
	public function show($Id)
	{
		$course = new CourseSection();
		$cs = $this->em->find('models\CourseSection', $Id);
		//echo var_dump($sc);
		
		if($cs != null){
			$data = array();
			$data['section'] = $cs;
			$data['instructor'] = $cs->getInstructor();
			$data['department'] = $cs->getCourse()->getDepartment();
			
			return $this->render($data);
		}
	}
	
	public function edit($Id)
	{
		//$regVM = new RegisterCourseVM();
		$cs = $this->em->getRepository('models\CourseSection')->find($Id);
		if($cs!= null) $data['section']= $cs;  //else return 404
		
		$courseId = $cs->getCourse()->getId();
		$course = $this->em->getRepository('models\Course')->find($courseId);
		$data['course'] = $course;
				
		$instructors = $this->em->getRepository('models\Instructor')->findAll();
		$ins = array();
		$ins[0] = "Select Professor";
		foreach($instructors as $i){
			$ins[$i->getId()] = $i->getUser()->getFullName();
		}
		
		$data['instructors'] = $ins;
		if($cs->getInstructor())
			$data['professor'] = $cs->getInstructor();
						
		return $this->render($data);
	}
	
	public function update()
	{
		
		$formItems = $this->input->post('coursesection', true);
		$coll = new FormCollection($formItems);
		
		$Id = $formItems['id'];
		echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$oldsec = $this->em->find('models\CourseSection',$Id);
			$section = $coll->updateObject('CourseSection', $oldsec);
			//echo var_dump($section);
			$section->setCourse(null);
			$section->setInstructor(null);
			$this->em->persist($section);
			$this->em->flush();
		
			$cId = $formItems['course'];
			$course = $this->em->getRepository('models\Course')->find($cId);
			$section->setCourse($course);
			//echo var_dump($);
			
			//$course->setDepartment(null);
			if($formItems['instructor'] > 0){
				$query = $this->em->createQuery('SELECT p FROM models\Instructor p WHERE p.id = :id');
				$query->setParameter('id', $formItems['instructor']);
				$ins = $query->getResult();
				$section->setInstructor($ins[0]);
			}else{
				$section->setInstructor(null);
			}
			
			$this->em->persist($section);
			$this->em->flush();

		}
		
		redirect('/coursesections/index/'. $course->getDepartment()->getId() . "/".$course->getId());
				
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
	
	private function getCurrentSemester(){
		
		$date = new DateTime('now');
		$dt = $date->format('Y-m-d H:i:s');
		$qry = "SELECT * from semester WHERE startDate <= " . $dt . " AND enddate >= " . $dt;  
		$query = $this->db->query($qry);

		if ($query->num_rows() > 0)
		{
		   $sem = new Semester();
		   foreach ($query->result() as $row)
		   {
		      $sem->setId($row->id);
		      $sem->setStartDate($row->startDate);
		      $sem->endDate($row->endDate);
		   }
		   return $sem;
		}else{
			return null;
		}
		
	}
	
	
}


?>