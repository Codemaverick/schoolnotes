<?php
 
namespace app\models;
 
use \Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 */

class Course
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	 
	/**
	 * @ManyToOne(targetEntity="School")
	 */
	private $school;
	/**
	 * @ManyToOne(targetEntity="Department")
	 */
	private $department;
	 
	/**
	 * @Column(type="string", nullable="false")
	 */
	private $name;
	
	/**
	 * @Column(type="string", nullable="true")
	 */
	private $description;
	
	/**
	 * @Column(type="string", unique="true")
	 */
	private $courseCode;
	
	/**
	 * @OneToMany(targetEntity="CourseSection", mappedBy="Course")
	 */
	private $section;
	
	public function __construct(){
		$this->section = new ArrayCollection();
	}
	
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
	public function setSchool($school) { $this->school = $school; }
    public function getSchool() { return $this->school; }
    public function setDepartment($department) { $this->department = $department; }
    public function getDepartment() { return $this->department; }
    public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }
    public function setDescription($description) { $this->description = $description; }
    public function getDescription() {  return $this->description; }
	public function setCourseCode($code) { $this->courseCode = $courseCode; }
    public function getCourseCode() {  return $this->courseCode; }
	public function setSection($section) { $this->section = $section; }
    public function getSection() {  return $this->section; }

}
