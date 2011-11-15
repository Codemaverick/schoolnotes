<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\School;	 

class Schools extends Controller{

	private $dbContext;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\School');
		
	}
	
	public function index(){
		
		$data['schools'] = $this->dbContext->findAll();
		return $this->render($data);
		
	}
	
	public function create()
	{
		
	}
	
	public function create_new(){
		$coll = new FormCollection($this->input->post('school', true));
		$school = $coll->createObject('School');
		//var_dump($school);
		
		$this->em->persist($school);
		$this->em->flush();
		redirect('/schools/index');
	}
	
	public function show($Id)
	{
		$school = new School();
		$sc = $this->em->find('models\School', $Id);
		//echo var_dump($sc);
		
		if($sc != null){
			$school = $sc;
			return $this->render(array('school' => $school));
		}
	}
	
	public function edit($Id)
	{
		$school = new School();
		$sc = $this->em->find('models\School', $Id);
		//echo var_dump($sc);
		
		if($sc != null){
			$school = $sc;
			return $this->render(array('school' => $school));
		}
	}
	
	public function update()
	{
		$schoolObj = $this->input->post('school', true);
		$coll = new FormCollection($schoolObj);
		
		$Id = $schoolObj['id'];
		echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$sc = $this->em->find('models\School', $Id);
			$school = $coll->updateObject('School', $sc);
			//var_dump($school);
			
			$this->em->persist($school);
			$this->em->flush();
			redirect('/schools/index');
		}else{
			return $this->edit($Id);
		}
		
	}
	
	public function delete($Id)
	{
		$school = new School();
		$sc = $this->em->find('models\School', $Id);
		//echo var_dump($sc);
		
		if($sc != null){
			$school = $sc;
			return $this->render(array('school' => $school));
		}
	}
	
	public function destroy()
	{
		$schoolObj = $this->input->post('school', true);
		$coll = new FormCollection($schoolObj);
		
		$Id = $schoolObj['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$sc = $this->em->find('models\School', $Id);
			$school = $this->em->remove($sc);
			$this->em->flush();
		}
		
		redirect('/schools/');
	}
	
	
}


?>