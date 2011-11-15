<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\ClassNote, models\Department, models\Instructor;	
use models\ViewModels\DashboardVM;
use models\ViewModels\CourseVM;

class ClassNotes extends Controller{

	private $dbContext;
	private $prof;
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\ClassNote');
		$this->prof = $this->dbContext->find(1); //temp default professor
		$this->sContext = $this->em->getRepository('models\CourseSection');
		
	}
	
	public function index($courseId, $section){
		
		$course = $this->em->getRepository('models\Course')->find($courseId);
		$section = $this->em->getRepository('models\CourseSection')->find($section);
		$notes = $this->dbContext->findAll(); //retrieve the id of the current semester
		
		$data['notes'] = $notes;
		return $this->render($data);
		
	}
	
	public function create($id)
	{
		$section = $this->sContext->find($id);
		$data = array();
		$data['section'] = $section;
		
		return $this->render($data);
	}
	
	public function create_new(){
		$coll = new FormCollection($this->input->post('classnote', true));
		//var_dump($this->input->post('classnote', true));
		$note = $coll->createObject('ClassNote');
		//var_dump($note);
		$sec = $coll->getItem('section');
		$section = $this->sContext->find($sec);
		$note->setCourseSection($section);
		$note->setSemester($section->getSemester());
		$note->setDateCreated(new DateTime("now"));
		
		var_dump($note->getDateCreated());
		
		$this->em->persist($note);
		$this->em->flush();
		redirect('/dashboard/courseview/show/' . $section->getId());
	}
	
	public function show($Id)
	{
		$note = new ClassNote();
		$nt = $this->dbContext->find($Id);
		//echo var_dump($sc);
		if($nt != null){
			$note = $nt;
			$data = array();
			$data['note'] = $note;			
			$data['course'] = $note->getCourseSection()->getCourse();
			//var_dump($section->getCourse());
			
			return $this->render($data);
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