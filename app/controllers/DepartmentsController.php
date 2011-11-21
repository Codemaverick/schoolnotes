<?php  

namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;

use app\models\Department;	
use app\models\ViewModels\DepartmentCoursesVM; 

use notes\utilities\ApplicationSettings;

use notes\web\FormCollection;
use notes\security\Sentinel;
use \DateTime;

class DepartmentsController extends Controller{

	private $dbContext;
	
	public function ___construct(array $config = array())
	{
		parent::__construct($config);
		
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){
			redirect('/accounts/login');
		}
		
		$this->dbContext = $this->em->getRepository('app\models\Department');
		$this->userContext = $this->em->getRepository('app\models\Instructor');
		$this->configSettings = ApplicationSettings::getConfiguration();
	}
	
	public function index(){
		
		$em = Connections::get('default')->getEntityManager();
		$configSettings = ApplicationSettings::getConfiguration();
		
		$dbContext = $em->getRepository('app\models\Department');
		$user = Sentinel::getAuthenticatedUser();
		if(!$user){
			$this->redirect('/accounts/login');
		}
		
		$data = array();
		$data['school'] = $configSettings->getSchool();
		$data['departments'] = $dbContext->findAll();
		
		$this->set($data);
		
	}
	
	public function create()
	{
		$em = Connections::get('default')->getEntityManager();
		$configSettings = ApplicationSettings::getConfiguration();
		
		$data['school'] = $configSettings->getSchool();
		
		//should be restricted to just the school 
		$instructors = array();
		$insCollection = $em->getRepository('app\models\Instructor')->findAll();
		
		//echo var_dump($insCollection);
		foreach($insCollection as $ins){
			$instructors[$ins->getId()] = $ins->getUser()->getFullName();
		}
		$data['instructors'] = 	$instructors;	
		$this->set($data);
	}
	
	
	public function courses($id){
		$em = Connections::get('default')->getEntityManager();
		$model = new DepartmentCoursesVM();
		
		$dep = $em->getRepository('app\models\Department')->find($id);
		$model->department = $dep; 
		
		$query = $em->createQuery('SELECT c FROM app\models\Course c WHERE c.department = :id');
		$query->setParameter('id', $dep);
		$model->courses = $query->getResult();
		$data['model'] = $model;
		
		$this->set($data);
	}
	
	
	public function create_new(){
		$em = Connections::get('default')->getEntityManager();
		$configSettings = ApplicationSettings::getConfiguration();
		
		$deptItems = $this->request->data['department'];
		//echo var_dump($deptItems);
		$coll = new FormCollection($deptItems);
		$s = $this->request->data['school'];
		$Id = $s['id'];
		
		$dept = $coll->createObject('Department');
		//echo var_dump($dept);
		
		//var_dump($school);
		$sc = $em->getRepository('app\models\School')->find($Id);
		$dept->setSchool($sc);
		
		$admin = $em->getRepository('app\models\Instructor')->find($deptItems['administrator']);
		$dept->setAdministrator($admin);
		
		$em->persist($dept);
		$em->flush();
		
		$this->redirect('Departments::index');
		
	}
	
	public function show($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$configSettings = ApplicationSettings::getConfiguration();
		
		$dept = new Department();
		$dp = $em->find('app\models\Department', $Id);
		//$admin = $dp->getAdministrator()->toArray();
		
		if($dp != null){
			$dept = $dp;
			$this->set(array('department' => $dept));
		}
	}
	
	public function edit($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$configSettings = ApplicationSettings::getConfiguration();
		
		$dept = new Department();
		$dp = $em->find('app\models\Department', $Id);
		//echo var_dump($sc);
		
		//should be restricted to just the school 
		$instructors = array();
		$insCollection = $em->getRepository('app\models\Instructor')->findAll();
		
		//echo var_dump($insCollection);
		foreach($insCollection as $ins){
			$instructors[$ins->getId()] = $ins->getUser()->getFullName();
		}
		$data['instructors'] = 	$instructors;	
		
		if($dp != null){
			$dept = $dp;
			$data['department'] = $dept;
		}
		$this->set($data);
	}
	
	public function update()
	{
		$em = Connections::get('default')->getEntityManager();
		$configSettings = ApplicationSettings::getConfiguration();
		$userContext = $em->getRepository('app\models\Instructor');
		
		$deptObj = $this->request->data['department'];
		$coll = new FormCollection($deptObj);
		
		$Id = $deptObj['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$dp = $em->find('app\models\Department', $Id);
			$dept = $coll->updateObject('Department', $dp);
			//var_dump($school);
			
			//var_dump($school);
			$school = $configSettings->getSchool();
			$dept->setSchool($school);
			
			$admin = $userContext->find($deptObj['administrator']);
			$dept->setAdministrator($admin);
			
			$em->persist($dept);
			$em->flush();
			
			$this->redirect('Departments::index');
		}else{
			return $this->edit($Id);
		}
				
	}
	
	public function delete($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$configSettings = ApplicationSettings::getConfiguration();
		$userContext = $em->getRepository('app\models\Instructor');
		
		$dept = new Department();
		$dp = $em->find('app\models\Department', $Id);
		//echo var_dump($sc);
		
		if($dp != null){
			$dept = $dp;
			$this->set(array('department' => $dept));
		}
	}
	
	public function destroy()
	{
		$em = Connections::get('default')->getEntityManager();
		$configSettings = ApplicationSettings::getConfiguration();
		$userContext = $em->getRepository('app\models\Instructor');
		
		$deptObj = $this->request->data['department'];
		$coll = new FormCollection($deptObj);
		
		$Id = $deptObj['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$dp = $em->find('models\Department', $Id);
			$dept = $em->remove($dp);
			$em->flush();
		}
		
		$this->redirect('/departments');
	}
	
	
}


?>