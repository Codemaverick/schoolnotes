<?php
 
namespace app\models\ViewModels;

use \Doctrine\Common\Collections\ArrayCollection;

class RegisterCourseVM
{
	public $department;
	public $instructors;
	public $school;
	public $course;
	
	public function __construct($sch = null, $ins = null, $dep = null, $crs = null){
		$this->department = $dep;
		$this->instructors = $ins ? $ins : new ArrayCollection();
		$this->course = $crs;
		$this->school = $sch; 
	}	
}

?>
