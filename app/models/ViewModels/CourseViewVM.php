<?php

namespace app\models\ViewModels;

use \Doctrine\Common\Collections\ArrayCollection;
use \lithium\data\Connections;
use \lithium\action\Controller;
use notes\security\Sentinel;

class CourseViewVM
{
	public $course;
	public $coursesection;
	public $classnotes;
	public $homeworks;
	public $announcements;
	public $professor;
	public $profile;
	
	public function __construct(){
	
		$this->classnotes = new ArrayCollection();
		$this->homeworks = new ArrayCollection(); 
		$this->announcements = new ArrayCollection();
	}
	
	public static function load($username, $section_id){
		
		$model = new CourseViewVM();
		$em = Connections::get('default')->getEntityManager();
	
		$section = $em->getRepository('app\models\CourseSection');
		$notesContext = $em->getRepository('app\models\ClassNote');
		$hwContext = $em->getRepository('app\models\Homework');
		$annContext = $em->getRepository('app\models\Announcement');
		
		$model = Sentinel::loadInstructor($username, $model);
					
		$model->coursesection = $section->find($section_id);
		
		$model->course = $model->coursesection->getCourse();
		
		$query = $em->createQuery('SELECT n FROM app\models\ClassNote n WHERE n.courseSection = :sec');
		$query->setParameter('sec', $model->coursesection);
		$model->classnotes = $query->getResult();

		$query2 = $em->createQuery('SELECT h FROM app\models\Homework h WHERE h.courseSection = :sec');
		$query2->setParameter('sec', $model->coursesection);
		$model->homeworks = $query2->getResult();
		
		$query3 = $em->createQuery('SELECT a FROM app\models\Announcement a WHERE a.courseSection = :sec');
		$query3->setParameter('sec', $model->coursesection);
		$model->announcements =  $query3->getResult();
		
		$model->professor = $model->coursesection->getInstructor();
		return $model;
		
	}
	
	public static function loadNotesView($username, $section_id){
	
		$model = new CourseViewVM();
		$em = Connections::get('default')->getEntityManager();
		$section = $em->getRepository('app\models\CourseSection');
		$notesContext = $em->getRepository('app\models\ClassNote');
		$model = Sentinel::loadInstructor($username, $model);
					
		$model->coursesection = $section->find($section_id);
		
		$query = $em->createQuery('SELECT n FROM app\models\ClassNote n WHERE n.courseSection = :sec');
		$query->setParameter('sec', $model->coursesection);
		
		$model->course = $model->coursesection->getCourse();
		
		$model->classnotes = $query->getResult();
		$model->professor = $model->coursesection->getInstructor();
		
		return $model;
	}	
	
	public static function loadHWView($username, $section_id){
	
		$model = new CourseViewVM();
		$em = Connections::get('default')->getEntityManager();
		$section = $em->getRepository('app\models\CourseSection');
		$hwContext = $em->getRepository('app\models\Homework');
		$model = Sentinel::loadInstructor($username, $model);
					
		$model->coursesection = $section->find($section_id);
		
		$query = $em->createQuery('SELECT h FROM app\models\Homework h WHERE h.courseSection = :sec');
		$query->setParameter('sec', $model->coursesection);

		$model->course = $model->coursesection->getCourse();
		
		$model->homeworks = $query->getResult();
		$model->professor = $model->coursesection->getInstructor();
		
		return $model;
	}	
	
	public static function loadAnnoucementsView($username, $section_id){
	
		$model = new CourseViewVM();
		$em = Connections::get('default')->getEntityManager();
		$section = $em->getRepository('app\models\CourseSection');
		$hwContext = $em->getRepository('app\models\Homework');
		$model = Sentinel::loadInstructor($username, $model);
					
		$model->coursesection = $section->find($section_id);
		
		$query = $em->createQuery('SELECT a FROM app\models\Announcement a WHERE a.courseSection = :sec');
		$query->setParameter('sec', $model->coursesection);
		$model->announcements =  $query->getResult();
		
		$model->course = $model->coursesection->getCourse();
		
		$model->professor = $model->coursesection->getInstructor();
		
		return $model;
	}	

}


?>
