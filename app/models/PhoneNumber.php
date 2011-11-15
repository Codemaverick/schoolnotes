<?php
 
namespace app\models;
 
/**
 * @Entity
 */
class PhoneNumber
{ 
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	 
	/**
	 * @ManyToOne(targetEntity="Profile", inversedBy="phoneNumber")
	 */
	private $profile;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $type;
	 
	/**
	 * @Column(type="string", nullable=false)
	 */
	private $number;
	 
 
    public function getId() { return $this->id; }
    public function setId($id) { $this->Id = $id; } 
    public function setProfile($profile) { $this->profile = $profile; }
    public function getProfile() {  return $this->profile; }
    public function setType($numType) { $this->type = $numType; }
    public function getType() { return $this->type; }
    public function setNumber($number) { $this->number = $number; }
    public function getNumber() {  return $this->number; }

}
