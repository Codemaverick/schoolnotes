<?php
 
namespace app\models;
 
use \Doctrine\Common\Collections\ArrayCollection;
use \app\models\Security\Role;
use \app\models\Security\MembershipUser;
/**
 * @Entity
 */

class Instructor
{
	
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	
	/**
	 * @OneToOne(targetEntity="app\models\Security\MembershipUser")
	 */
	private $user;
	
	/*
	*@OneToOne(targetEntity="School")
	*/
	private $school;
	 
	/**
	 * @ManyToMany(targetEntity="Department")
	 */
	private $department;
	 
	/**
	 * @Column(type="string", length=64, nullable=true)
	 */
	private $office;
	
	/**
	 * @OneToOne(targetEntity="Building")
	 */
	private $building;
	
	/**
	 * @OneToMany(targetEntity="CourseSection", mappedBy="instructor")
	 */
	private $courses;
	
	/**
	 * @OneToMany(targetEntity="app\models\Security\Role", mappedBy="roles")
	 */
	private $roles;
	
	public function __construct(){
		$this->courses = new ArrayCollection();
		$this->department = new ArrayCollection();
	}
	
	public function getId() { return $this->id; }
    public function setId($id) { $this->Id = $id; } 
    public function getUser() { return $this->user; }
    public function setUser($user) { $this->user = $user; } 
    public function setSchool($school) { $this->school = $school; }
    public function getSchool() { return $this->school; }
    public function setDepartments($department) { $this->department = $department; }
    public function getDepartments() {  return $this->department; }
    public function getDepartment() { return $this->department->count() > 0 ? $this->department->get(0) : null; }
    public function addDepartment($dept){ $this->department->add($dept); }
	public function setOffice($office){ $this->office = $office; }
	public function getOffice(){ return $this->office; }
	public function setBuilding($building){ $this->building = $building; }
	public function getBuilding(){ return $this->building; }
	public function setCourses($courses){ $this->courses = $courses; }
	public function getCourses(){ return $this->courses; }
	public function getRoles(){ return $this->roles; }
    public function setRoles($roles){ $this->roles = $roles; }

}
