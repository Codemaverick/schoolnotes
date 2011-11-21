<?php  

namespace app\controllers;
	
use app\models\Profile;
use app\models\Instructor;
use app\models\OfficeHour;
use app\models\PhoneNumber;
use app\models\ViewModels\ProfileVM;
use app\models\CourseViewVM;
use \Doctrine\Common\Collections\ArrayCollection;

use \lithium\data\Connections;
use \lithium\action\Controller;	
use notes\web\FormCollection;
use notes\security\Sentinel; 
use app\models\Security\MembershipUser;	

class ProfilesController extends Controller{

	private $dbContext;
	private $userId;
	
	public function ___construct(array $config = array()){
		parent::__construct($config);
		
		$this->dbContext = $this->em->getRepository('models\Profile');
		$this->iContext = $this->em->getRepository('models\Instructor');
		$this->phoneContext = $this->em->getRepository('models\PhoneNumber');
		$this->officeContext = $this->em->getRepository('models\OfficeHour');
		$this->userId = 1;
	
	}
	/*
	public function index($id){
		
		$sen = new Sentinel();
		$user = $sen->getLoggedInUser(); 
		
		if(!$user){
			$this->redirect("Accounts::LogOn");
		}
		
		$em = Connections::get('default')->getEntityManager();
		$sContext = $em->getRepository('app\models\CourseSection');
		$model = new CourseViewVM();
	
		$model->coursesection = $this->section->find($id);
		$model->course = $model->coursesection->getCourse();
		
		$model->classnotes = $this->notesContext->findAll();
		$model->homeworks = $this->hwContext->findAll();
		$model->announcements = $this->annContext->findAll();
		
		$data['model'] = $model;
		return $this->render($data);
		
	}
	*/
	/*	
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
	*/
	public function show()
	{
		//should be logged in, do not need to get id from querystring
		$sen = new Sentinel();
		$user = $sen->getLoggedInUser(); 
		
		if(!$user){
			$this->redirect("Accounts::LogOn");
		}
		
		//$em = Connections::get('default')->getEntityManager();
		$model = $this->getProfileView($user);
		$data = array('model'=> $model);
		
		$this->set($data);
		
	}
	
	public function edit()
	{
		//should be logged in, do not need to get id from querystring
		$sen = new Sentinel();
		$user = $sen->getLoggedInUser(); 
		
		if(!$user){
			$this->redirect("Accounts::LogOn");
		}
		
		$model = $this->getProfileView($user);
		$data = array('model'=> $model);
		
		$this->set($data);

	}
	
	public function update()
	{
		$sen = new Sentinel();
		$user = $sen->getLoggedInUser(); 
		
		if(!$user){
			$this->redirect("Accounts::LogOn");
		}
		
		$insObj = $this->request->data['instructor'];
		$insColl = new FormCollection($insObj);
		
		$prObj = $this->request->data['profile'];
		$prColl = new FormCollection($prObj);
		
		$insId = $insObj['id'];
		$em = Connections::get('default')->getEntityManager();
		//get the instructor
		$pv = $this->getProfileView($user);
		$prf = $pv->profile;
		if(!$prf->getInstructor()){ //new profile. All new profiles require instructors
			$prf = new Profile();
			$prf->setInstructor($pv->instructor);
			$em->persist($prf);
			$em->flush();
		}
		$prf = $prColl->updateObject('Profile', $prf);
		
		if($prColl->getItem('phoneNumber')){
			//means that a phone number was added or edited.
			//first, remove all phone numbers
			$query = $em->createQuery('SELECT p FROM app\models\PhoneNumber p WHERE p.profile = :profile');
			$query->setParameter('profile', $prf);
			$results = $query->getResult();
			//print_r($results);
			
			
			if($results){
				$em->remove($results[0]);
				$em->flush();
				/*foreach($results as $num){
					$em->remove($num);
					$em->flush();
				}
				*/
			}
			
			//create new phone numbers - this should be a loop
			/*
			$ph = new PhoneNumber();
			$ph->setNumber($prColl->getItem('phoneNumber'));
			$ph->setProfile($prf);
			$em->persist($ph);
			$em->flush();

			$phones = new ArrayCollection();
			$phones->add($ph);
			$prf->setPhoneNumbers($phones);*/
		}
		/*
		if($prColl->getItem('officeHour')){
			//means that an office hour was added or edited.
			//first, remove all office hours
			$query = $this->em->createQuery('SELECT oh FROM app\models\OfficeHour oh WHERE oh.profile = :profile');
			$query->setParameter('profile', $prf);
			$results = $query->getResult();
			
			if($results){
				foreach($results as $hr){
					$this->em->remove($hr);
				}
				$this->em->flush();
			}
			//create new phone numbers - also should be looped
			$officeH = new OfficeHour();
			$officeH->setStartTime(new DateTime('now'));
			$endtime = new DateTime('now');
			$endtime->add(new DateInterval('PT1H'));
			$officeH->setEndTime($endtime);
			$officeH->setProfile($prf);
			$em->persist($officeH);
			$em->flush();	
			
			$hrs = new ArrayCollection();
			$hrs->add($officeH);
			$prf->setOfficeHours($hrs);	
		}
		*/
		//Upload stub
		//TODO:Upload
		
		//print_r($prf->getTitle());
		//print_r($prf->getBio());
		//$em->persist($prf);
		//$em->flush();
		
		//$this->redirect('/dashboard/profiles/show');
		
	}
	/*
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
	*/
	private function getProfileView(MembershipUser $user){
		
		$em = Connections::get('default')->getEntityManager();
		
		$model = new ProfileVM();
		
		$qry = $em->createQuery('SELECT i FROM app\models\Instructor i WHERE i.user = :usr');
		$qry->setParameter('usr', $user);
		$results = $qry->getResult();
		
		$model->instructor = $results[0];
		$model->user = $model->instructor->getUser();
		
		$query = $em->createQuery('SELECT p FROM app\models\Profile p WHERE p.instructor = :ins');
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