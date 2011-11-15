<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Index Page for this controller.
 *
 */
use models\Course;
use models\ViewModels\RegisterCourseVM;	
	 
class Home extends Controller{

	public function __construct(){
		parent::__construct();
		
		$this->dbContext = $this->em->getRepository('models\Course');
		$this->insContext = $this->em->getRepository('models\Instructor');
	}
	
	public function index(){
		
		//echo "Home Controller Rendered Successfully";
		$professors = $this->insContext->findAll();
		$courses = $this->dbContext->findAll();
		
		//print_r($_COOKIE);
		
		$data = array('instructors'=>$professors, 'courses'=>$courses);
		return $this->render($data);
		
	}
	
	public function create(){
	
		$data = array();
		$data['website'] = "www.artisan.is";
		$data['name'] = "Javabean Review";
		return $this->render($data);
	}

}


?>