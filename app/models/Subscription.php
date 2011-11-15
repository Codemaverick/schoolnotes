<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class Subscription
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @OneToOne(targetEntity="School")
	 */
	private $school;
	 
	/**
	 * @OneToOne(targetEntity="Course")
	 */
	private $course;
	
	/**
	 * @Column(type="boolean", nullable=true)
	 */
	private $expires;
	 
	 
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setSchool($school) { $this->school = $school; }
    public function getSchool() { return $this->school; }
    public function setCourse($course) { $this->course = $course; }
    public function getCourse() {  return $this->course; }
	public function setExpires($expires) { $this->expires = $expires; }
    public function getExpires() {  return $this->expires; }

}
