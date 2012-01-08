<?php  
	/**
	 * Index Page for this controller.
	 *
	 */
namespace app\controllers;

use \lithium\data\Connections;
use \lithium\action\Controller;
use notes\web\FormCollection;
use \DateTime;

use app\models\Semester;

class SemestersController extends Controller{

	private $dbContext;
	
	public function ___construct(array $config = array()){
		parent::__construct($config);
		
		$this->em = Connections::get('default')->getEntityManager();
		$this->dbContext = $this->em->getRepository('app\models\Semester');
		
	}
	
	public function index(){
	
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Semester');
		$data = array();
		$data['semesters'] = $dbContext->findAll();
		
		$this->set($data);
		
	}
	
	/* Create a course. Department Id parameter required    */
	public function create()
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Semester');
		
		$typesCtxt = $em->getRepository('app\models\SemesterType')->findAll();
		
		$types = array();
		foreach($typesCtxt as $t){
			$types[$t->getId()] = $t->getType();
		}
		
		$data = array();
		$data['types'] = $types;		
		$this->set($data);
	}
	
	public function create_new(){
	
		$formItems = $this->request->data['semester'];
		$coll = new FormCollection($formItems);
		$semester = $coll->createObject('Semester');
		$semester->setStartDate(new DateTime($semester->getStartDate()));
		$semester->setEndDate(new DateTime($semester->getEndDate()));		
				
		$semester->setCourses = null;
		$typeId = $formItems['type'];
		
		$smType = $em->getRepository('app\models\SemesterType')->find($typeId);
		$semester->setSemesterType($smType);
		
		//echo var_dump($semester);
		
		$em->persist($semester);
		$em->flush();
		$this->redirect('Semesters::index');
		
	}
	
	public function show($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Semester');
		
		$semester = new Semester();
		$sms = $em->find('app\models\Semester', $Id);
		//echo var_dump($sc);
		
		if($sms != null){
			$semester = $sms;
			$this->set(array('semester' => $semester));
		}
	}
	
	public function edit($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Semester');
		
		$semester = $em->getRepository('app\models\Semester')->find($Id);
		$data = array();
		$data['semester'] = $semester;
		
		$typesCtxt = $em->getRepository('app\models\SemesterType')->findAll();
		$types = array();
		foreach($typesCtxt as $t){
			$types[$t->getId()] = $t->getType();
		}
		$data['types'] = $types;		
		
		$this->set($data);
	}
	
	public function update()
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Semester');
		
		$formItems = $this->request->data['semester'];
		$coll = new FormCollection($formItems);
		
		$Id = $formItems['id'];
		$sms = $dbContext->find($Id);
		
		if($sms){
			$sms->setStartDate(new DateTime($formItems['startDate']));
			$sms->setEndDate(new DateTime($formItems['endDate']));
			
			$typeId = $formItems['type'];
		
			$smType = $em->getRepository('app\models\SemesterType')->find($typeId);
			$sms->setSemesterType($smType);
			
			$em->persist($sms);
			$em->flush();
			$this->redirect('/semesters/');
		}else{
			return self::edit($Id);
		}
	}
	
	public function delete($Id)
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Semester');
		
		$semester = new Semester();
		$sms = $em->find('app\models\Semester', $Id);
		//echo var_dump($sc);
		
		if($sms != null){
			$semester = $sms;
			$this->set(array('semester' => $semester));
		}
	}
	
	public function destroy()
	{
		$em = Connections::get('default')->getEntityManager();
		$dbContext = $em->getRepository('app\models\Semester');
		
		$semesterObj = $this->request->data['semester'];
		$coll = new FormCollection($semesterObj);
		
		$Id = $semesterObj['id'];
		//echo "Id of updated object is " . $Id;
		
		if($Id != null){
			$sms = $em->find('models\Semester', $Id);
			$semester = $em->remove($sms);
			$em->flush();
		}
		
		$this->redirect('/semesters/');
	}
	
	
	
}


?>