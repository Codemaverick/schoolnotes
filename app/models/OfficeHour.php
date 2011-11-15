<?php
 
namespace app\models;
 
/**
 * @Entity
 */
class OfficeHour
{ 
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	 
	/**
	 * @ManyToOne(targetEntity="Profile", inversedBy="officeHour")
	 */
	private $profile;
	
	/**
	 * @Column(type="time", nullable=false)
	 */
	private $startTime;
	 
	/**
	 * @Column(type="time", nullable=false)
	 */
	private $endTime;
	 
 
    public function getId() { return $this->id; }
    public function setId($id) { $this->Id = $id; } 
    public function setProfile($profile) { $this->profile = $profile; }
    public function getProfile() {  return $this->profile; }
    public function setStartTime($startTime) { $this->startTime = $startTime; }
    public function getStartTime() { return $this->startTime; }
    public function setEndTime($endTime) { $this->endTime = $endTime; }
    public function getEndTime() {  return $this->endTime; }

}
