<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class Semester
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	 
	/**
	 * @Column(type="date")
	 */
	private $startDate;

	/**
	 * @Column(type="date")
	 */
	private $endDate;
	
	/**
	 * @ManyToMany(targetEntity="Course")
	 */
	private $courses;
	
	/**
	 * @ManyToOne(targetEntity="SemesterType")
	 * @JoinColumn(name="semester_id", referencedColumnName="id")
	 */
	public $semesterType;
	
	public function __construct() {
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
    } 
	 
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setStartDate($startDate) { $this->startDate = $startDate; }
    public function getStartDate() { return $this->startDate; }
	public function setEndDate($endDate) { $this->endDate = $endDate; }
    public function getEndDate() { return $this->endDate; }
    public function setCourses($courses) { $this->courses = $courses; }
    public function getCourses() {  return $this->courses; }
    public function setSemesterType($type) { $this->semesterType = $type; }
    public function getSemesterType() {  return $this->semesterType; }
    
	
	public function getName(){
		if($this->semesterType && $this->startDate){
			$type = $this->semesterType->getType();
			$year = $this->startDate->format('Y');
			return $type . " " . $year;
		}else{
			return "";
		}
	}

}
