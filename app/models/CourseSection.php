<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class CourseSection
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ManyToOne(targetEntity="Course")
	 */
	private $course;
	 
	/**
	 * @Column(type="string", nullable="false")
	 */
	private $section;
	
	/**
	 * @ManyToOne(targetEntity="Instructor")
	 */
	 private $instructor;
	 
	 /**
	 * @ManyToOne(targetEntity="Semester")
	 */
	 private $semester;
	
	
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setCourse($course) { $this->course = $course; }
    public function getCourse() { return $this->course; }
	public function setSection($section) { $this->section = $section; }
    public function getSection() { return $this->section; }
    public function setInstructor($instructor){ $this->instructor = $instructor; }
    public function getInstructor(){ return $this->instructor; }
    public function setSemester($semester){ $this->semester = $semester; }
    public function getSemester(){ return $this->semester; }

}
