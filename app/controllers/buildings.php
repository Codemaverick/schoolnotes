<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\Building;	 

class Buildings extends Controller{

	private $dbContext;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\Building');
		
	}
	
	public function index(){
		
		$data['buildings'] = $this->dbContext->findAll();
		return $this->render($data);
		
	}
	
	public function create()
	{
		$query = $this->em->createQuery('SELECT s FROM models\School s WHERE s.id = :id');
		$query->setParameter('id', 1);
		$schools = $query->getResult();
		$data['school'] = $schools[0];
		
		return $this->render($data);
	}
	
	public function create_new(){
		$coll = new FormCollection($this->input->post('building', true));
		$s = $this->input->post('school', true);
		$Id = $s['id'];
		
		$bldg = $coll->createObject('Building');
		echo var_dump($bldg);
		
		$this->em->persist($bldg);
		$this->em->flush();
		/*
		//var_dump($school);
		$sc = $this->em->find('models\School', $Id);
		$dept->setSchool($sc);
		$this->em->persist($dept);
		$this->em->flush();
		*/
		redirect('/buildings/index');
		
	}
	
	public function show($Id)
	{
		$bldg = new Building();
		$bd = $this->em->find('models\Building', $Id);
		//echo var_dump($sc);
		
		if($bd != null){
			$bldg = $bd;
			return $this->render(array('building' => $bldg));
		}
	}
	
	public function edit($Id)
	{
		$building = new Building();
		$bd = $this->em->find('models\Building', $Id);
		//echo var_dump($sc);
		
		if($bd != null){
			$building = $bd;
			return $this->render(array('building' => $building));
		}
	}
	
	public function update()
	{
		$bldg = $this->input->post('building', true);
		$coll = new FormCollection($bldg);
		
		$Id = $bldg['id'];
		echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$bd = $this->em->find('models\Building', $Id);
			$building = $coll->updateObject('Building', $bd);
			//var_dump($school);
			
			$this->em->persist($building);
			$this->em->flush();
			redirect('/buildings/index');
		}else{
			return $this->edit($Id);
		}
		
	}
	
	public function delete($Id)
	{
		$building = new Building();
		$bd = $this->em->find('models\Building', $Id);
		//echo var_dump($sc);
		
		if($bd != null){
			$building = $bd;
			return $this->render(array('building' => $building));
		}
	}
	
	public function destroy()
	{
		$building = $this->input->post('building', true);
		$coll = new FormCollection($building);
		
		$Id = $building['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$bd = $this->em->find('models\Building', $Id);
			$building = $this->em->remove($bd);
			$this->em->flush();
		}
		
		redirect('/buildings/');
	}
	
	
}


?>