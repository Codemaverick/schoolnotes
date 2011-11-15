<?php
 
namespace app\models\ViewModels;

use \Doctrine\Common\Collections\ArrayCollection;

class AdminVM
{
	public $school;
	public $departments;
	public $instructors;
	public $semesters;
	public $courses;
	
	
	public function __construct($ins = null, $sems = null, array $depts = null, array $crs = null){
		$this->instructors = $ins ? $ins : new ArrayCollection();
		$this->departments = $depts ? $depts : new ArrayCollection();
		$this->courses = $crs ? $crs : new ArrayCollection();
		$this->semesters = $sems ? $sems : new ArrayCollection();
	}	
}


?>
