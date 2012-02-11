<?php
 
namespace app\models\ViewModels;

use \Doctrine\Common\Collections\ArrayCollection;

class DashboardVM
{
	public $departments;
	public $professor;
	public $courses;
	public $profile;
	public $semester;
	
	public function __construct(array $dep = null, $prof = null, array $crs = null){
		$this->professor = $prof;
		$this->courses = $crs ? $crs : new ArrayCollection();
		$this->departments = $dep ? $dep : new ArrayCollection();
		$this->profile = null;
		$this->semester = null;
	}	
}

?>
