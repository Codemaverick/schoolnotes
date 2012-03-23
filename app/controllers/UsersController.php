<?php  

/**
 * Index Page for this controller.
 *
*/
namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;
use notes\web\FormCollection;
use notes\security\Sentinel;
use notes\utilities\AppUtilities;
 

use app\models\School, app\models\Department, app\models\Instructor;	
use app\models\ViewModels\DashboardVM;
use app\models\ViewModels\CourseVM;


class UsersController extends Controller{

	private $dbContext;
	private $prof;
	private $em;
	
	public function ___construct(array $config = array()){
		parent::__construct($config);
				
		
	}
	
	public function index(){
		//$semID = $this->getSemester(); //retrieve the id of the current semester
		$username = $this->request->params['username'];
		$sen = new Sentinel();
		$results = $sen->findUsersByName($username);
		//echo var_dump($username);
	
		if($results && is_array($results)){
			$user = $results[0];
			$this->em = Connections::get('default')->getEntityManager();
			$this->dbContext = $this->em->getRepository('app\models\Instructor');
			$query = $this->em->createQuery('SELECT s FROM app\models\Instructor s WHERE s.user = :usr');
			$query->setParameter('usr', $user);
			$results = $query->getResult();
			$this->prof = $results[0]; //temp default professor
			
			$dashVM = new DashboardVM();
			$dashVM->professor = $this->prof;
			
			
			$query = $this->em->createQuery('SELECT s FROM app\models\CourseSection s WHERE s.instructor = :ins');
			$query->setParameter('ins', $this->prof);
			$sections = $query->getResult();
			
			foreach( $sections as $sec){
				$dashVM->coursesections->add($sec->getCourse());
			}
			
			$query2 = $this->em->createQuery('SELECT pr FROM app\models\Profile pr WHERE pr.instructor = :ins');
			$query2->setParameter('ins', $this->prof);
			$pResults = $query2->getResult();
			//$dashVM->courses = $courses;
			if($pResults){
				$dashVM->profile = $pResults[0];
			}
			
			$dashVM->semester = AppUtilities::getCurrentSemester();
			
			$data['model'] = $dashVM;
			$this->set($data);
			$this->render(array('layout'=>'profiles'));
		}
	}
	
	public function create()
	{
	
	}
	
	public function create_new(){
		$coll = new FormCollection($this->request->data['school']);
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
		$schoolObj = $this->request->data['school'];
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