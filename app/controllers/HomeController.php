<?php
/**
 * Index Page for this controller.
 *
 */

namespace app\controllers;


use \lithium\data\Connections;
 
use app\models\Course;
use app\models\ViewModels\RegisterCourseVM;	
	 
class HomeController extends \lithium\action\Controller{

	public function ___construct(array $config = array()){
		parent::__construct($config);
		$this->em = Connections::get('default')->getEntityManager();
		$this->dbContext = $this->em->getRepository('app\models\Course');
		$this->insContext = $this->em->getRepository('app\models\Instructor');
		
	}
	
	public function index(){
		
		//echo "Home Controller Rendered Successfully";
		$professors = $this->insContext->findAll();
		$courses = $this->dbContext->findAll();
		
		//print_r($_COOKIE);
		
		$data = array('instructors'=>$professors, 'courses'=>$courses);
		$this->set($data);
		
	}
	
	public function create(){
	
		$data = array();
		$data['website'] = "www.artisan.is";
		$data['name'] = "Javabean Review";
		return $this->render($data);
	}

}


?>