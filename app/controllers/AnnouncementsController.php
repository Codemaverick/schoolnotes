<?php  

namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;

use app\models\Announcement, app\models\CourseSection;
use app\models\Homework, app\models\Instructor;	
use app\models\ViewModels\DashboardVM;
use app\models\ViewModels\CourseVM;
use app\models\ViewModels\CourseViewVM;	

use notes\web\FormCollection;
use notes\security\Sentinel;
use \DateTime;


class AnnouncementsController extends Controller{

	private $dbContext;
	private $prof;
	
	public function ___construct(array $config = array())
	{
		parent::__construct($config);

		/*$this->dbContext = $this->em->getRepository('app\models\Announcement');
		$this->prof = $this->dbContext->find(1); //temp default professor
		$this->sContext = $this->em->getRepository('app\models\CourseSection');*/
		
	}
	
	public function index($courseId, $section){
		
		$em = Connections::get('default')->getEntityManager();
		$course = $em->getRepository('app\models\Course')->find($courseId);
		
		$username = $this->request->params['username'];
		$model = CourseViewVM::loadAnnouncementsView($username, $section);
		
		$data = array('model'=> $model);
		$this->set($data);
		$this->render(array('layout'=>'profiles'));
		
	}
	
	public function manage($section){
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){ $this->redirect('Accounts::login');}
		
		$username = $user->getUsername();
		$model = CourseViewVM::loadAnnouncementsView($username, $section);
		
		$data = array('model'=> $model);
		$this->set($data);
		$this->render(array('layout'=>'profiles'));
	}

	
	public function listAll(){
		$user = $this->request->params['user'];
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Announcement');
		$userContext = $em->getRepository('app\models\Security\MembershipUser');
		$classContext = $em->getRepository('app\models\CourseSection');
		//$instructor
		//ideally, should be as simple as this
		$query2 = $em->createQuery('SELECT s FROM app\models\Instructor s WHERE s.user = :usr');
		$query2->setParameter('usr', $user);
		$results = $query2->getResult();
		$instr = $results[0];
		
		$prof = $userContext->find($user->getId());
		$query = $em->createQuery('SELECT h FROM app\models\Announcement h WHERE h.createdBy = :usr');
		$query->setParameter('usr', $instr);
		$anns = $query->getResult();
		
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
		$data['announcements'] = $anns;
		$data['courses'] = $courses;
		
		$this->set($data);
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
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){ $this->redirect('Accounts::login');}
		
		$em = Connections::get('default')->getEntityManager();
		$course = $em->getRepository('app\models\Course')->find($courseId);
		$sContext = $em->getRepository('app\models\CourseSection');
		
		$coll = new FormCollection($this->request->data['announcement']);
		//var_dump($this->input->post('classnote', true));
		$ann = $coll->createObject('Announcement');
		//var_dump($note);
		$sec = $coll->getItem('section');
		$section = $sContext->find($sec);
		$ann->setCourseSection($section);
	
		//try catch block?
		$dateExp = $coll->getItem('dateExpires');
		if($dateExp){
			$ann->setDateExpires(new DateTime($dateExp));
		}else{
			$ann->setDateExpires(null);
		}
		
		$ann->setDatePosted(new DateTime("now"));
		$ann->setCreatedBy($user);		
		$em->persist($ann);
		$em->flush();
		$this->redirect('/dashboard/courseview/show/' . $section->getId());
	}
	
	public function show($id)
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Announcement');
		$sContext = $em->getRepository('app\models\CourseSection');
		
		$ann = new Announcement();
		$a = $dbContext->find($id);
		//echo var_dump($sc);
		if($a != null){
			$ann = $a;
			$section = $a->getCourseSection();
			$data = array();
			$username = $this->request->params['username'];
			$model = CourseViewVM::loadAnnouncementsView($username, $section->getId(), $id); //inefficient - loads all hws
			
			$data['model'] = $model;
			return $this->set($data);
		}//else throw 404
	
	}
	
	public function details($id){
		
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){ $this->redirect('Accounts::login');}
		
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Announcement');
		$sContext = $em->getRepository('app\models\CourseSection');
		
		$ann = new Announcement();
		$a = $dbContext->find($id);
		//echo var_dump($sc);
		if($a != null){
			$ann = $a;
			$section = $a->getCourseSection();
			$data = array();
			$username = $user->getUsername();
			$model = CourseViewVM::loadAnnouncementsView($username, $section->getId(), $id); //inefficient - loads all hws
			
			$data['model'] = $model;
			$this->set($data);
			$this->render(array('layout'=>'profiles'));
		
		}//else throw 404
	}
	
	//need to enforce security here. Should only be able to edit classnotes that belong to you
	public function edit($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$course = $em->getRepository('app\models\Course')->find($courseId);
		$sContext = $em->getRepository('app\models\CourseSection');
		$dbContext = $this->em->getRepository('app\models\Announcement');
		
		$ann = $this->getAnnouncement($Id);
		
		if($ann != null){
			$data = array();
			$data['ann'] = $ann;
			$section = $sContext->find($ann->getCourseSection()->getId());
			$data['section'] = $section;

			return $this->set($data);
		}else{
			//throw 404 redirect
		}
	}
	
	public function update()
	{
		$em = Connections::get('default')->getEntityManager();
		$course = $em->getRepository('app\models\Course')->find($courseId);
		$sContext = $em->getRepository('app\models\CourseSection');
		$dbContext = $this->em->getRepository('app\models\Announcement');
		
		$coll = new FormCollection($this->request->data['announcement']);
		//var_dump($this->input->post('classnote', true));
		//$nt = $coll->createObject('ClassNote');
		
		$Id = $coll->getItem('id');
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$ann = $dbContext->find($Id);
			$ann = $coll->updateObject('Announcement', $ann);
			//var_dump($school);
			$dateExp = $coll->getItem('dateExpires');
			if($dateExp){
				$ann->setDateExpires(new DateTime($dateExp));
			}else{
				$ann->setDateExpires(null);
			}
			
			$em->persist($ann);
			$em->flush();
			
			$sec = $coll->getItem('section');
			$section = $sContext->find($sec);
			redirect('/dashboard/courseview/show/' . $section->getId());
		}else{
			return self::edit($Id);
		}
		
	}
	
	public function delete($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$sContext = $em->getRepository('app\models\CourseSection');
		
		$ann = $this->getAnnouncement($Id);
		
		if($ann != null){
			$data = array();
			$data['ann'] = $ann;
			$section = $sContext->find($ann->getCourseSection()->getId());
			$data['section'] = $section;

			$this->set($data);
		}else{
			//throw 404 redirect
		}

	}
	
	public function destroy()
	{
		$em = Connections::get('default')->getEntityManager();
		$sContext = $em->getRepository('app\models\CourseSection');
		
		$annObj = $this->request->data['announcement'];
		$coll = new FormCollection($annObj);
		//var_dump($hwObj);
		
		$Id = $coll->getItem('id');
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$ann = $this->dbContext->find($Id);
			$ann = $this->em->remove($ann);
			$this->em->flush();
		}
		
		$sec = $coll->getItem('section');
		$section = $this->sContext->find($sec);
		redirect('/dashboard/courseview/show/' . $section->getId());
	}
	
	private function getAnnouncement($Id){
		
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $this->em->getRepository('app\models\Announcement');
		
		$anncmt = $dbContext->find($Id);
		
		if($anncmt != null){
			return $anncmt;
		}else{
			return null;
		}
	}
	
	
}


?>