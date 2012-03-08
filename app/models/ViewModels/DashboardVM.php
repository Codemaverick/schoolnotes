<?php
 
namespace app\models\ViewModels;

use \Doctrine\Common\Collections\ArrayCollection;
use \lithium\data\Connections;
use \lithium\action\Controller;
use notes\security\Sentinel;
use notes\utilities\AppUtilities;

class DashboardVM
{
	public $departments;
	public $professor;
	public $coursesections;
	public $profile;
	public $semester;
	
	public function __construct(array $dep = null, $prof = null, array $crs = null){
		$this->professor = $prof;
		$this->coursesections = $crs ? $crs : new ArrayCollection();
		$this->departments = $dep ? $dep : new ArrayCollection();
		$this->profile = null;
		$this->semester = null;
	}	
	
	public static function loadDefaultView($user){
		$em = Connections::get('default')->getEntityManager();	
		$model = new DashboardVM();
		$model = Sentinel::loadInstructor($user->getUsername(), $model);
		$model->semester = AppUtilities::getCurrentSemester();
		
		$query = $em->createQuery('SELECT s FROM app\models\CourseSection s WHERE s.instructor = :ins');
		$query->setParameter('ins', $model->professor);
		$sections = $query->getResult();
			
		foreach( $sections as $sec){
			$model->coursesections->add($sec);
		}
			
		return $model;
	}
}

?>
