<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class Building
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id; 
	
	/**
	 * @OneToOne(targetEntity="School", cascade={"persist"})
	 */
	private $school;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $name;
	 
	/**
	 * @Column(type="string",nullable=false)
	 */
	private $address;
	 
	/**
	 * @Column(type="string", nullable=false)
	 */
	private $city;
	
	/**
	 * @Column(type="string", nullable=false)
	 */
	private $state;
	
	/**
	 * @Column(type="string", length=32, nullable=false)
	 */
	private $postalCode;

	 
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setSchool($school) { $this->school = $school; }
    public function getSchool() { return $this->school; }
	public function setName($name) { $this->name = $name; }
    public function getName() {  return $this->name; }
    public function setAddress($address) { $this->address = $address; }
    public function getAddress() {  return $this->address; }
    public function setCity($city) { $this->city = $city; }
    public function getCity() {  return $this->city; }
	public function setState($state) { $this->state = $state; }
    public function getState() {  return $this->state; }
	public function setPostCode($postalCode) { $this->postalCode = $postalCode; }
    public function getPostalCode() {  return $this->postalCode; }

}
