<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class Announcement
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
	private $datePosted;
	
	/**
	 * @Column(type="date", nullable="true")
	 */
	private $dateExpires;
	 
	/**
	 * @ManyToOne(targetEntity="CourseSection")
	 */
	private $coursesection;
	
	/**
	 * @Column(type="string", nullable="true")
	 */
	private $title;
	
	/**
	 * @Column(type="string", nullable="true")
	 */
	private $text;
	
	/**
	 * @ManyToOne(targetEntity="app\Models\Security\MembershipUser")
	 */
	private $createdBy;
	
	
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setDatePosted($datePosted) { $this->datePosted = $datePosted; }
    public function getDatePosted() { return $this->datePosted; }
    public function setDateExpires($dateExp) { $this->dateExpires = $dateExp; }
    public function getDateExpires() { return $this->dateExpires; }
    
    public function setCourseSection($cs) { $this->coursesection = $cs; }
    public function getCourseSection() {  return $this->coursesection; }
	
	public function setTitle($title) { $this->title = $title; }
    public function getTitle() {  return $this->title; }
    public function setText($txt) { $this->text = $txt; }
    public function getText() {  return $this->text; }
    public function getCreatedBy(){ return $this->createdBy; }
    public function setCreatedBy($value) { $this->createdBy = $value;}


}
