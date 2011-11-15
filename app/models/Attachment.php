<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class Attachment
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
	 * @ManyToOne(targetEntity="Course", inversedBy="Attachment")
	 */
	private $course;
	
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $fileType;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $file;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $description;
	 
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setDateCreated($datecreated) { $this->datecreated = $datecreated; }
    public function getDateCreated() { return $this->datecreated; }
    public function setCourse($course) { $this->course = $course; }
    public function getCourse() {  return $this->course; }
	public function setFile($file) 
	{ 
		$this->file = $file;
		//this function should also set the file type
	
	}
    public function getFile() {  return $this->file; }
	public function setDescription($description) { $this->description = $description; }
    public function getDescription() {  return $this->description; }
	public function getFileType(){ return $this->fileType; }

}
