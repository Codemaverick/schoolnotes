<?php

namespace app\models\ViewModels;

use \Doctrine\Common\Collections\ArrayCollection;

class CourseViewVM
{
	public $course;
	public $coursesection;
	public $classnotes;
	public $homeworks;
	public $announcements;
	
	public function __construct(){
	
		$this->classnotes = new ArrayCollection();
		$this->homeworks = new ArrayCollection(); 
		$this->announcements = new ArrayCollection();
	}	
}


?>
