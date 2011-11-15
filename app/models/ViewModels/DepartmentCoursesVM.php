<?php
 
namespace app\models\ViewModels;

use \Doctrine\Common\Collections\ArrayCollection;

class DepartmentCoursesVM
{
	public $department;
	public $instructors;
	public $school;
	public $courses;
	
	public function __construct($dep = null, $ins = null, $sch = null, $crs = null){
		$this->instructors = $ins ? $ins : new ArrayCollection();
		$this->courses = $crs ? $crs : new ArrayCollection();
		$this->school = $sch; 
		$this->department = $dep;
	}	
}

?>
