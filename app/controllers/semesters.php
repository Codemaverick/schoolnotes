<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\Semester;

class Semesters extends Controller{

	private $dbContext;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\Semester');
		
	}
	
	public function index(){
		$data = array();
		$data['semesters'] = $this->dbContext->findAll();
		return $this->render($data);
		
	}
	
	/* Create a course. Department Id parameter required    */
	public function create()
	{
		$typesCtxt = $this->em->getRepository('models\SemesterType')->findAll();
		$types = array();
		foreach($typesCtxt as $t){
			$types[$t->getId()] = $t->getType();
		}
		$data = array();
		$data['types'] = $types;		
		return $this->render($data);
	}
	
	public function create_new(){
		$formItems = $this->input->post('semester', true);
		$coll = new FormCollection($formItems);
		$semester = $coll->createObject('Semester');
		$semester->setStartDate(new DateTime($semester->getStartDate()));
		$semester->setEndDate(new DateTime($semester->getEndDate()));		
				
		$semester->setCourses = null;
		$typeId = $formItems['type'];
		
		$smType = $this->em->getRepository('models\SemesterType')->find($typeId);
		$semester->setSemesterType($smType);
		
		//echo var_dump($semester);
		
		$this->em->persist($semester);
		$this->em->flush();
		redirect('/semesters/');
		
	}
	
	public function show($Id)
	{
		$semester = new Semester();
		$sms = $this->em->find('models\Semester', $Id);
		//echo var_dump($sc);
		
		if($sms != null){
			$semester = $sms;
			return $this->render(array('semester' => $semester));
		}
	}
	
	public function edit($Id)
	{
		$semester = $this->em->getRepository('models\Semester')->find($Id);
		$data = array();
		$data['semester'] = $semester;
		
		$typesCtxt = $this->em->getRepository('models\SemesterType')->findAll();
		$types = array();
		foreach($typesCtxt as $t){
			$types[$t->getId()] = $t->getType();
		}
		$data['types'] = $types;		
		
		return $this->render($data);
	}
	
	public function update()
	{
		$formItems = $this->input->post('semester', true);
		$coll = new FormCollection($formItems);
		
		$Id = $formItems['id'];
		$sms = $this->dbContext->find($Id);
		
		if($sms){
			$sms->setStartDate(new DateTime($formItems['startDate']));
			$sms->setEndDate(new DateTime($formItems['endDate']));
			
			$typeId = $formItems['type'];
		
			$smType = $this->em->getRepository('models\SemesterType')->find($typeId);
			$sms->setSemesterType($smType);
			
			$this->em->persist($sms);
			$this->em->flush();
			redirect('/semesters/');
		}else{
			return $this->edit($Id);
		}
	}
	
	public function delete($Id)
	{
		$semester = new Semester();
		$sms = $this->em->find('models\Semester', $Id);
		//echo var_dump($sc);
		
		if($sms != null){
			$semester = $sms;
			return $this->render(array('semester' => $semester));
		}
	}
	
	public function destroy()
	{
		$semesterObj = $this->input->post('semester', true);
		$coll = new FormCollection($semesterObj);
		
		$Id = $semesterObj['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$sms = $this->em->find('models\Semester', $Id);
			$semester = $this->em->remove($sms);
			$this->em->flush();
		}
		
		redirect('/semesters/');
	}
	
	
	
}


?>