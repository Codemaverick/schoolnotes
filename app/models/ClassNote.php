<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class ClassNote
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
	 * @ManyToOne(targetEntity="CourseSection")
	 */
	private $courseSection;
	
	/**
	 * @OneToMany(targetEntity="Attachment", mappedBy="ClassNote")
	 */
	private $attachments;
	
	/**
	 * @ManyToOne(targetEntity="Semester")
	 */
	private $semester;
	
	/**
	* @Column(type="text", nullable="true")
	*/
	private $note;
	
	/**
	* @Column(type="string", nullable="true")
	*/
	private $name;
	
	/**
	* @ManyToOne(targetEntity="app\Models\Security\MembershipUser")
	*/
	private $createdBy;
	
	
	//private $status (active/archived); - do I need this?
	
	
	public function __construct() {
        $this->attachments = new \Doctrine\Common\Collections\ArrayCollection();
    } 
	
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setDateCreated($datecreated) { $this->dateCreated = $datecreated; }
    public function getDateCreated() { return $this->dateCreated; }
    public function setCourseSection($section) { $this->courseSection = $section; }
    public function getCourseSection() {  return $this->courseSection; }
	public function setAttachments($attachments) { $this->attachments = $attachments; }
    public function getAttachments() {  return $this->attachments; }
	public function setSemester($semester) { $this->semester = $semester; }
    public function getSemester() {  return $this->semester; }
    public function setNote($note) { $this->note = $note; }
    public function getNote() { return $this->note; }
    public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }
    public function getCreatedBy(){ return $this->createdBy; }
    public function setCreatedBy($value) { $this->createdBy = $value; }

}
