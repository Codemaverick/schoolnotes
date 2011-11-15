<?php
 
namespace app\models;

/**
 * @Entity
 */
 
class School
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	 
	/**
	 * @Column(type="string", length=32, unique=true, nullable=false)
	 */
	private $name;
	 
	/**
	 * @Column(type="string", nullable=false)
	 */
	private $address;
	
	/**
	 * @Column(type="string", nullable=false)
	 */
	private $city;
	
	/**
	 * @Column(type="string", length=64, nullable=false)
	 */
	private $state;
	
	/**
	 * @Column(type="string", length=64, nullable=false)
	 */
	private $postalCode;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $website;
	 
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }
    public function setAddress($address) { $this->address = $address; }
    public function getAddress() {  return $this->address; }
	public function setCity($city) { $this->city = $city; }
    public function getCity() {  return $this->city; }
	public function setState($state) { $this->state = $state; }
    public function getState() {  return $this->state; }
	public function setPostalCode($postalCode) { $this->postalCode = $postalCode; }
    public function getPostalCode() {  return $this->postalCode; }
	public function setWebsite($website) { $this->website = $website; }
    public function getWebsite() {  return $this->website; }




}
