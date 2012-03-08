<?php  

/**
 * Index Page for this controller.
 *
*/

namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;
 

use app\models\School, app\models\Department, app\models\Instructor;	
use app\models\ViewModels\DashboardVM;
use app\models\ViewModels\CourseVM;
use notes\security\Sentinel;

class DashboardController extends Controller{

	private $dbContext;
	private $prof;
	
	public function ___construct(array $config = array()){
		parent::__construct($config);
		
		$this->em = Connections::get('default')->getEntityManager();
		
		$sen = new Sentinel();
		$user = $sen->getLoggedInUser();
		if($user){
			$this->dbContext = $this->em->getRepository('app\models\Instructor');
			
			$query = $this->em->createQuery('SELECT s FROM app\models\Instructor s WHERE s.user = :usr');
			$query->setParameter('usr', $user);
			$results = $query->getResult();
			$this->prof = $results[0]; //temp default professor
		}else{
			redirect('/accounts/login');
		}
		
	}
	
	public function index(){
	
		$sen = new Sentinel();
		$em = Connections::get('default')->getEntityManager();
		
		$user = $sen->getLoggedInUser();
		if($user){
			
			$dashVM = new DashboardVM();
			$dashVM = DashboardVM::loadDefaultView($user, $dashVM);
		
			$data['model'] = $dashVM;
			$this->set($data);
			$this->render(array('layout'=>'dashboard'));
			
		}else{
			$this->redirect('Accounts::login');
		}

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