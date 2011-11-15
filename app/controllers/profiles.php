<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\Profile;
use models\Instructor;
use models\OfficeHour;
use models\PhoneNumber;
use models\ViewModels\ProfileVM;
use \Doctrine\Common\Collections\ArrayCollection;	 

class Profiles extends Controller{

	private $dbContext;
	private $userId;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\Profile');
		$this->iContext = $this->em->getRepository('models\Instructor');
		$this->phoneContext = $this->em->getRepository('models\PhoneNumber');
		$this->officeContext = $this->em->getRepository('models\OfficeHour');
		$this->userId = 1;
	
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
	
	public function show()
	{
		//should be logged in, do not need to get id from querystring
		
		$model = $this->getProfileView();
		$data = array('model'=> $model);
		
		return $this->render($data);
		
	}
	
	public function edit()
	{
		//should be logged in, do not need to get id from querystring
		$model = $this->getProfileView();
		$data = array('model'=> $model);
		
		return $this->render($data);

	}
	
	public function update()
	{
		$insObj = $this->input->post('instructor', true);
		$insColl = new FormCollection($insObj);
		
		$prObj = $this->input->post('profile', true);
		$prColl = new FormCollection($prObj);
		
		echo var_dump($prObj);
		
		$insId = $insObj['id'];
		
		//get the instructor
		$pv = $this->getProfileView();
		$prf = $pv->profile;
		if(!$prf->getInstructor()){ //new profile. All new profiles require instructors
			$prf = new Profile();
			$prf->setInstructor($pv->instructor);
			$this->em->persist($prf);
			$this->em->flush();
			
			$prf = $prColl->updateObject('Profile', $prf);
		}
		
		if($prColl->getItem('phoneNumber')){
			//means that a phone number was added or edited.
			//first, remove all phone numbers
			$query = $this->em->createQuery('SELECT p FROM models\PhoneNumber p WHERE p.profile = :profile');
			$query->setParameter('profile', $prf);
			$results = $query->getResult();
			
			if($results){
				foreach($results as $num){
					$this->em->remove($num);
				}
				$this->em->flush();
			}
			//create new phone numbers
			$ph = new PhoneNumber();
			$ph->setNumber($prColl->getItem('phoneNumber'));
			$ph->setProfile($prf);
			$this->em->persist($ph);
			$this->em->flush();

		}
		
		if($prColl->getItem('officeHour')){
			//means that an office hour was added or edited.
			//first, remove all office hours
			$query = $this->em->createQuery('SELECT oh FROM models\OfficeHour oh WHERE oh.profile = :profile');
			$query->setParameter('profile', $prf);
			$results = $query->getResult();
			
			if($results){
				foreach($results as $hr){
					$this->em->remove($hr);
				}
				$this->em->flush();
			}
			//create new phone numbers
			$officeH = new OfficeHour();
			$officeH->setStartTime(new DateTime('now'));
			$endtime = new DateTime('now');
			$endtime->add(new DateInterval('PT1H'));
			$officeH->setEndTime($endtime);
			$officeH->setProfile($prf);
			$this->em->persist($officeH);
			$this->em->flush();			
		}
		
		//Upload stub
		//TODO:Upload
		
		redirect('/dashboard/profiles/show');
		
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
	
	private function getProfileView(){
		
		$model = new ProfileVM();
		$model->instructor = $this->iContext->find($this->userId);
		
		$query = $this->em->createQuery('SELECT p FROM models\Profile p WHERE p.instructor = :ins');
		$query->setParameter('ins', $model->instructor);
		$results = $query->getResult();
		if(is_array($results)&&(count($results) > 0)){
			$model->profile = $results[0];
		}else{
			$model->profile = new Profile();
		}
				
		return $model;

	}
	
	
}


?>