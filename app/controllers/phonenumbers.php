<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\PhoneNumber;	
use models\ViewModels\DashboardVM;
use models\ViewModels\CourseVM;

class PhoneNumbers extends Controller{

	private $dbContext;
	private $prof;
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\PhoneNumber');
		$this->pContext = $this->em->getRepository('models\Profile');
		
	}
	
	public function index(){
		
		$numbers = $this->dbContext->findAll();
		
		$data['numbers'] = $numbers;
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
		$coll = new FormCollection($this->input->post('homework', true));
		//var_dump($this->input->post('classnote', true));
		$hw = $coll->createObject('Homework');
		//var_dump($note);
		$sec = $coll->getItem('section');
		$section = $this->sContext->find($sec);
		$hw->setCourseSection($section);
	
		//try catch block?
		$hw->setDateDue(new DateTime($coll->getItem(dateDue)));
		$hw->setDateCreated(new DateTime("now"));
		
		//var_dump($note->getDateCreated());
		
		$this->em->persist($hw);
		$this->em->flush();
		redirect('/dashboard/courseview/show/' . $section->getId());
	}
	
	public function show($Id)
	{
		$phone = new PhoneNumber();
		$ph = $this->dbContext->find($Id);
		//echo var_dump($sc);
		if($ph != null){
			$phone = $ph;
			$data = array();
			$data['phone'] = $phone;
						
			return $this->render($data);
		}//else throw 404
	
	}
	
	//need to enforce security here. Should only be able to edit classnotes that belong to you
	public function edit($Id)
	{
		$hw = $this->getHomework($Id);
		
		if($hw != null){
			$data = array();
			$data['homework'] = $hw;
			$section = $this->sContext->find($hw->getCourseSection()->getId());
			$data['section'] = $section;

			return $this->render($data);
		}else{
			//throw 404 redirect
		}
	}
	
	public function update()
	{
		$coll = new FormCollection($this->input->post('homework', true));
		//var_dump($this->input->post('classnote', true));
		//$nt = $coll->createObject('ClassNote');
		
		$Id = $coll->getItem('id');
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$hw = $this->dbContext->find($Id);
			$homework = $coll->updateObject('Homework', $hw);
			//var_dump($school);
			
			$hw->setDateDue(new DateTime($coll->getItem('dateDue')));
			$this->em->persist($homework);
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
		$homework = $this->getHomework($Id);
		
		if($homework != null){
			$data = array();
			$data['homework'] = $homework;
			$section = $this->sContext->find($homework->getCourseSection()->getId());
			$data['section'] = $section;

			return $this->render($data);
		}else{
			//throw 404 redirect
		}

	}
	
	public function destroy()
	{
		$hwObj = $this->input->post('homework', true);
		$coll = new FormCollection($hwObj);
		//var_dump($hwObj);
		
		$Id = $coll->getItem('id');
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$hw = $this->dbContext->find($Id);
			$homework = $this->em->remove($hw);
			$this->em->flush();
		}
		
		$sec = $coll->getItem('section');
		$section = $this->sContext->find($sec);
		redirect('/dashboard/courseview/show/' . $section->getId());
	}
	
	private function getHomework($Id){
		$hw = $this->dbContext->find($Id);
		
		if($hw != null){
			return $hw;
		}else{
			return null;
		}
	}
	
	
}


?>