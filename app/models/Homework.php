<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class Homework
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
	private $dateCreated;
	
	/**
	 * @Column(type="date")
	 */
	private $dateDue;
	 
	/**
	 * @ManyToOne(targetEntity="CourseSection")
	 */
	private $courseSection;
	
	/**
	 * @OneToMany(targetEntity="Attachment", mappedBy="ClassNote")
	 */
	private $attachments;
	
	/**
	 * @Column(type="string", nullable="true")
	 */
	private $name;
	
	/**
	 * @Column(type="string", nullable="true")
	 */
	private $text;
	
	/**
	 * @ManyToOne(targetEntity="app\Models\Security\MembershipUser")
	 */
	private $createdBy;
	
	
	
	public function __construct() {
        $this->attachments = new \Doctrine\Common\Collections\ArrayCollection();
    } 
	
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setDateCreated($datecreated) { $this->dateCreated = $datecreated; }
    public function getDateCreated() { return $this->dateCreated; }
    public function setDateDue($datedue) { $this->dateDue = $datedue; }
    public function getDateDue() { return $this->dateDue->format('Y-m-d'); }
    
    public function setCourseSection($cs) { $this->coursesection = $cs; }
    public function getCourseSection() {  return $this->courseSection; }
	public function setAttachments($attachments) { $this->attachments = $attachments; }
    public function getAttachments() {  return $this->attachments; }
	
	public function setName($name) { $this->name = $name; }
    public function getName() {  return $this->name; }
    public function setText($txt) { $this->text = $txt; }
    public function getText() {  return $this->text; }
    public function getCreatedBy(){ return $this->createdBy; }
    public function setCreatedBy($value) { $this->createdBy = $value; }


}
