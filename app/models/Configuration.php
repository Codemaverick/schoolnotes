<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class Configuration
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @Column(type="string", nullable="false")
	 */
	private $accountId;
	 
	/**
	 * @Column(type="datetime", nullable="false")
	 */
	private $dateCreated;
	
	/**
	 * @OneToOne(targetEntity="School")	 
	 */
	 private $school;
	 
	
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setAccountId($acc) { $this->accountId = $acc; }
    public function getAccountId() { return $this->accountId; }
	public function setDateCreated($created) { $this->dateCreated = $created; }
    public function getDateCreated() { return $this->dateCreated; }
    public function setSchool($sch){ $this->school = $sch; }
    public function getSchool(){ return $this->school; }
    

}
