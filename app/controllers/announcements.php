<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\Announcement, models\CourseSection, models\Instructor;	
use models\ViewModels\DashboardVM;
use models\ViewModels\CourseVM;

class Announcements extends Controller{

	private $dbContext;
	private $prof;
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\Announcement');
		$this->prof = $this->dbContext->find(1); //temp default professor
		$this->sContext = $this->em->getRepository('models\CourseSection');
		
	}
	
	public function index($courseId, $section){
		
		$course = $this->em->getRepository('models\Course')->find($courseId);
		$section = $this->sContext->find($section);
		
		$query = $this->em->createQuery('SELECT s FROM models\Announcement s WHERE s.coursesection = :sec');
		$query->setParameter('sec', $section->getId());
		$anncmt = $query->getResult();
		
		//s$anncmt = $this->dbContext->findBy(array('coursesection'=>$section)); //retrieve the id of the current semester
		
		$data['announcements'] = $anncmt;
		$data['section'] = $section;
		$data['course'] = $course;
		
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
		$coll = new FormCollection($this->input->post('announcement', true));
		//var_dump($this->input->post('classnote', true));
		$ann = $coll->createObject('Announcement');
		//var_dump($note);
		$sec = $coll->getItem('section');
		$section = $this->sContext->find($sec);
		$ann->setCourseSection($section);
	
		//try catch block?
		$dateExp = $coll->getItem('dateExpires');
		if($dateExp){
			$ann->setDateExpires(new DateTime($dateExp));
		}else{
			$ann->setDateExpires(null);
		}
		
		$ann->setDatePosted(new DateTime("now"));
				
		$this->em->persist($ann);
		$this->em->flush();
		redirect('/dashboard/courseview/show/' . $section->getId());
	}
	
	public function show($Id)
	{
		$homework = new Homework();
		$hw = $this->dbContext->find($Id);
		//echo var_dump($sc);
		if($hw != null){
			$homework = $hw;
			$data = array();
			$data['homework'] = $homework;
			$data['section'] = $homework->getCourseSection();			
			$data['course'] = $homework->getCourseSection()->getCourse();
			//var_dump($section->getCourse());
			
			return $this->render($data);
		}//else throw 404
	
	}
	
	//need to enforce security here. Should only be able to edit classnotes that belong to you
	public function edit($Id)
	{
		$ann = $this->getAnnouncement($Id);
		
		if($ann != null){
			$data = array();
			$data['ann'] = $ann;
			$section = $this->sContext->find($ann->getCourseSection()->getId());
			$data['section'] = $section;

			return $this->render($data);
		}else{
			//throw 404 redirect
		}
	}
	
	public function update()
	{
		$coll = new FormCollection($this->input->post('announcement', true));
		//var_dump($this->input->post('classnote', true));
		//$nt = $coll->createObject('ClassNote');
		
		$Id = $coll->getItem('id');
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$ann = $this->dbContext->find($Id);
			$ann = $coll->updateObject('Announcement', $ann);
			//var_dump($school);
			$dateExp = $coll->getItem('dateExpires');
			if($dateExp){
				$ann->setDateExpires(new DateTime($dateExp));
			}else{
				$ann->setDateExpires(null);
			}
			
			$this->em->persist($ann);
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
		$ann = $this->getAnnouncement($Id);
		
		if($ann != null){
			$data = array();
			$data['ann'] = $ann;
			$section = $this->sContext->find($ann->getCourseSection()->getId());
			$data['section'] = $section;

			return $this->render($data);
		}else{
			//throw 404 redirect
		}

	}
	
	public function destroy()
	{
		$annObj = $this->input->post('announcement', true);
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
		$anncmt = $this->dbContext->find($Id);
		
		if($anncmt != null){
			return $anncmt;
		}else{
			return null;
		}
	}
	
	
}


?>