<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class Department
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
	 * @Column(type="string", nullable="false")
	 */
	private $name;
	
	/**
	 * @ManyToOne(targetEntity="Instructor")
	 */
	private $administrator;
	
	
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setSchool($school) { $this->school = $school; }
    public function getSchool() { return $this->school; }
	public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }
    public function setAdministrator($administrator) { $this->administrator = $administrator; }
    public function getAdministrator() {  return $this->administrator; }

}
