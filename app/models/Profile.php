<?php
 
namespace app\models;
 
use \Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 */

class Profile
{
	
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	* @OneToOne(targetEntity="Instructor")
	*/
	private $instructor;
	 
	/**
	 * @Column(type="string", nullable="true")
	 */
	private $title;
	 
	/**
	 * @Column(type="text", nullable=true)
	 */
	private $bio;
	
	/**
	 * @Column(type="string", nullable="true")
	 */
	private $image;
	
	/**
	 * @OneToMany(targetEntity="PhoneNumber", mappedBy="profile")
	 */
	private $phoneNumber;
	
	/**
	 * @OneToMany(targetEntity="OfficeHour", mappedBy="profile")
	 */
	private $officeHour;
	
	
	public function __construct(){
		$this->phoneNumber = new ArrayCollection();
		$this->officeHour = new ArrayCollection();
	}
	
	public function getId() { return $this->id; }
    public function setId($id) { $this->Id = $id; } 
    public function setInstructor($inst) { $this->instructor = $inst; }
    public function getInstructor() { return $this->instructor; }
    public function setTitle($title) { $this->title = $title; }
    public function getTitle() {  return $this->title; }
	public function setBio($bio){ $this->bio = $bio; }
	public function getBio(){ return $this->bio; }
	public function setImage($img){ $this->image = $img; }
	public function getImage(){ return $this->image; }
	public function setOfficeHours($hours){ $this->officeHour = $hours; }
	public function getOfficeHours(){ return $this->officeHour; }
	public function addOfficeHour($hour){ $this->officeHour->add($hour); }
	
	public function getPhoneNumbers(){ return $this->phoneNumber; }
	public function setPhoneNumbers($numbers){ $this->phoneNumber = $numbers; }
	public function addPhoneNumber($number){ $this->phoneNumber->add($number); }

}
