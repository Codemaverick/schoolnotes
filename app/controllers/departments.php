<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
use models\Department;	
use models\ViewModels\DepartmentCoursesVM; 

class Departments extends Controller{

	private $dbContext;
	
	public function __construct()
	{
		parent::__construct();
		
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){
			redirect('/accounts/login');
		}
		
		$this->dbContext = $this->em->getRepository('models\Department');
		$this->userContext = $this->em->getRepository('models\Instructor');
		$this->configSettings = ApplicationSettings::getConfiguration();
	}
	
	public function index(){
		
		$data = array();
		$data['school'] = $this->configSettings->getSchool();
		$data['departments'] = $this->dbContext->findAll();
		return $this->render($data);
		
	}
	
	public function create()
	{
		$data['school'] = $this->configSettings->getSchool();
		
		//should be restricted to just the school 
		$instructors = array();
		$insCollection = $this->em->getRepository('models\Instructor')->findAll();
		
		//echo var_dump($insCollection);
		foreach($insCollection as $ins){
			$instructors[$ins->getId()] = $ins->getUser()->getFullName();
		}
		$data['instructors'] = 	$instructors;	
		return $this->render($data);
	}
	
	
	public function courses($id){
		$model = new DepartmentCoursesVM();
		
		$dep = $this->em->getRepository('models\Department')->find($id);
		$model->department = $dep; 
		
		$query = $this->em->createQuery('SELECT c FROM models\Course c WHERE c.department = :id');
		$query->setParameter('id', $dep);
		$model->courses = $query->getResult();
		$data['model'] = $model;
		
		return $this->render($data);
	}
	
	
	public function create_new(){
		$deptItems = $this->input->post('department', true);
		//echo var_dump($deptItems);
		$coll = new FormCollection($deptItems);
		$s = $this->input->post('school', true);
		$Id = $s['id'];
		
		$dept = $coll->createObject('Department');
		//echo var_dump($dept);
		
		//$this->em->persist($dept);
		//$this->em->flush();
		
		//var_dump($school);
		$sc = $this->em->getRepository('models\School')->find($Id);
		$dept->setSchool($sc);
		
		$admin = $this->em->getRepository('models\Instructor')->find($deptItems['administrator']);
		$dept->setAdministrator($admin);
		
		$this->em->persist($dept);
		$this->em->flush();
		
		redirect('/departments/index');
		
	}
	
	public function show($Id)
	{
		$dept = new Department();
		$dp = $this->em->find('models\Department', $Id);
		//$admin = $dp->getAdministrator()->toArray();
		
		if($dp != null){
			$dept = $dp;
			return $this->render(array('department' => $dept));
		}
	}
	
	public function edit($Id)
	{
		$dept = new Department();
		$dp = $this->em->find('models\Department', $Id);
		//echo var_dump($sc);
		
		//should be restricted to just the school 
		$instructors = array();
		$insCollection = $this->em->getRepository('models\Instructor')->findAll();
		
		//echo var_dump($insCollection);
		foreach($insCollection as $ins){
			$instructors[$ins->getId()] = $ins->getUser()->getFullName();
		}
		$data['instructors'] = 	$instructors;	
		
		if($dp != null){
			$dept = $dp;
			$data['department'] = $dept;
		}
		return $this->render($data);
	}
	
	public function update()
	{
		$deptObj = $this->input->post('department', true);
		$coll = new FormCollection($deptObj);
		
		$Id = $deptObj['id'];
		echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$dp = $this->em->find('models\Department', $Id);
			$dept = $coll->updateObject('Department', $dp);
			//var_dump($school);
			
			//var_dump($school);
			$school = $this->configSettings->getSchool();
			$dept->setSchool($school);
			
			$admin = $this->userContext->find($deptObj['administrator']);
			$dept->setAdministrator($admin);
			
			$this->em->persist($dept);
			$this->em->flush();
			redirect('/departments/index');
		}else{
			return $this->edit($Id);
		}
				
	}
	
	public function delete($Id)
	{
		$dept = new Department();
		$dp = $this->em->find('models\Department', $Id);
		//echo var_dump($sc);
		
		if($dp != null){
			$dept = $dp;
			return $this->render(array('department' => $dept));
		}
	}
	
	public function destroy()
	{
		$deptObj = $this->input->post('department', true);
		$coll = new FormCollection($deptObj);
		
		$Id = $deptObj['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$dp = $this->em->find('models\Department', $Id);
			$dept = $this->em->remove($dp);
			$this->em->flush();
		}
		
		redirect('/departments');
	}
	
	
}


?>