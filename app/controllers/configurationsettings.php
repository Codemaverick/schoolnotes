<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\School;
use models\Configuration;	 

class ConfigurationSettings extends Controller{

	private $dbContext;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\Configuration');
		$this->schoolContext = $this->em->getRepository('models\School');

		
	}
	
	public function index(){
		
		$results = $this->dbContext->findAll();
		
		if(!$results){
			redirect('/configurationsettings/create');
		}
		
		$cfgSettings = $results[0];
		$data = array();
		$data['config'] = $cfgSettings;
		$data['school'] = $cfgSettings->getSchool();
		return $this->render($data);
		
	}
	
	public function create()
	{
		
	}
	
	public function create_new(){
		//$conf = new FormCollection($this->input->post('configuration', true));
		$coll = new FormCollection($this->input->post('school', true));
		$school = $coll->createObject('School');
		//$config = $conf->createObject('Configuration');
		//var_dump($school);
		
		$this->em->persist($school);
		$this->em->flush();	 
		
		$config = new Configuration();
		$uqId = uniqid();
		$config->setAccountId($uqId);
		$config->setSchool($school);
		$config->setDateCreated(new DateTime('now'));
		
		$this->em->persist($config);
		$this->em->flush();
		
		redirect('/configurationsettings/index');
	}
	
	
	public function edit()
	{
		$settings = $this->dbContext->findAll();
		
		if(!$settings){
			redirect('/configurationsettings/create');
		}
		$data = array();
		$config = $settings[0];
		$data['school'] = $config->getSchool();
		return $this->render($data);

	}
	
	public function update()
	{
		$results = $this->dbContext->findAll(); //should only ever be 1
		$config = $results[0];
		$sch = $config->getSchool();
				
		//$conf = new FormCollection($this->input->post('configuration', true));
		$coll = new FormCollection($this->input->post('school', true));
		$school = $this->schoolContext->find($sch->getId());
		$school = $coll->updateObject('School', $school);
		//$config = $conf->updateObject('Configuration', $config);
		//var_dump($school);
		
		$this->em->persist($school);
		//$this->em->persist($config);
		$this->em->flush();
		
		redirect('/configurationsettings/index');		
	}
		
	
}


?>