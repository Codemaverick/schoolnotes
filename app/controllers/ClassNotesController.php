<?php  

	/**
	 * Index Page for this controller.
	 *
	 */
namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;
	 
use app\models\ClassNote, models\Department, models\Instructor;	
use app\models\ViewModels\DashboardVM;
use app\models\ViewModels\CourseVM;
use notes\web\FormCollection;
use \DateTime;

class ClassNotesController extends Controller{

	private $dbContext;
	private $prof;
	
	public function ___construct(array $config = array()){
		parent::__construct($config);
		
		$this->em = Connections::get('default')->getEntityManager();
		
		$this->dbContext = $this->em->getRepository('app\models\ClassNote');
		$this->prof = $this->dbContext->find(1); //temp default professor
		$this->sContext = $this->em->getRepository('app\models\CourseSection');
		
	}
	
	public function index($courseId, $section){
		
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\ClassNote');
		
		$course = $em->getRepository('models\Course')->find($courseId);
		$section = $em->getRepository('models\CourseSection')->find($section);
		$notes = $this->dbContext->findAll(); //retrieve the id of the current semester
		
		$data['notes'] = $notes;
		$this->set($data);
		
	}
	
	public function listAll(){
		$user = $this->request->params['user'];
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\ClassNote');
		$userContext = $em->getRepository('app\models\Security\MembershipUser');
		//$instructor
		//ideally, should be as simple as this
		$prof = $userContext->find($user->getId());
		$query = $em->createQuery('SELECT n FROM app\models\ClassNote n WHERE n.createdBy = :usr');
		$query->setParameter('usr', $prof);
		$notes = $query->getResult();
		
		$query2 = $em->createQuery('SELECT s FROM app\models\Instructor s WHERE s.user = :usr');
		$query2->setParameter('usr', $user);
		$results = $query2->getResult();
			
		$dashVM = new DashboardVM();
		$dashVM->professor = $results[0];
		
		$data['model'] = $dashVM;
		$data['notes'] = $notes;
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
	
		$sen = new Sentinel();	
		$user = $sen->getLoggedInUser();
		
		if(!$user){
			$this->redirect('Accounts::login');
		}
	
		$em = Connections::get('default')->getEntityManager();
		$sContext = $em->getRepository('app\models\CourseSection');
		$coll = new FormCollection($this->request->data['classnote']);
		//var_dump($this->input->post('classnote', true));
		$note = $coll->createObject('ClassNote');
		//var_dump($note);
		$sec = $coll->getItem('section');
		$section = $sContext->find($sec);
		$note->setCourseSection($section);
		$note->setSemester($section->getSemester());
		$note->setDateCreated(new DateTime("now"));
		$note->setCreatedBy($user);
		//var_dump($note->getDateCreated());
		
		$em->persist($note);
		$em->flush();
		$this->redirect('/dashboard/courseview/show/' . $section->getId());
	}
	
	public function show($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\ClassNote');
		
		$note = new ClassNote();
		$nt = $dbContext->find($Id);
		//echo var_dump($sc);
		if($nt != null){
			$note = $nt;
			$data = array();
			$data['note'] = $note;			
			$data['course'] = $note->getCourseSection()->getCourse();
			$data['instructor'] = $note->getCourseSection()->getInstructor();
			//var_dump($section->getCourse());
			
			$this->set($data);
		}//else throw 404
	
	}
	
	//need to enforce security here. Should only be able to edit classnotes that belong to you
	public function edit($Id)
	{
		$note = $this->getClassNote($Id);
		
		if($note != null){
			$data = array();
			$data['note'] = $note;
			$section = $this->sContext->find($note->getCourseSection()->getId());
			$data['section'] = $section;

			return $this->render($data);
		}else{
			//throw 404 redirect
		}
	}
	
	public function update()
	{
		$coll = new FormCollection($this->input->post('classnote', true));
		//var_dump($this->input->post('classnote', true));
		//$nt = $coll->createObject('ClassNote');
		
		$Id = $coll->getItem('id');
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$nt = $this->dbContext->find($Id);
			$note = $coll->updateObject('ClassNote', $nt);
			//var_dump($school);
			
			$this->em->persist($note);
			$this->em->flush();
			
			$sec = $coll->getItem('section');
			$section = $this->sContext->find($sec);
			redirect('/dashboard/courseview/show/' . $section->getId());
		}else{
			return $this->edit($Id);
		}
		
	}
	
	public function delete($Id)
	{
		$note = $this->getClassNote($Id);
		
		if($note != null){
			$data = array();
			$data['note'] = $note;
			$section = $this->sContext->find($note->getCourseSection()->getId());
			$data['section'] = $section;

			return $this->render($data);
		}else{
			//throw 404 redirect
		}

	}
	
	public function destroy()
	{
		$noteObj = $this->input->post('classnote', true);
		$coll = new FormCollection($noteObj);
		var_dump($noteObj);
		
		$Id = $coll->getItem('id');
		echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$nt = $this->dbContext->find($Id);
			$note = $this->em->remove($nt);
			$this->em->flush();
		}
		
		$sec = $coll->getItem('section');
		$section = $this->sContext->find($sec);
		redirect('/dashboard/courseview/show/' . $section->getId());
	}
	
	private function getClassNote($Id){
		$note = $this->dbContext->find($Id);
		
		if($note != null){
			return $note;
		}else{
			return null;
		}
	}
	
	
}


?>