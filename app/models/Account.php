<?php
 
namespace app\models;
 

class Account
{
	
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @OneToOne(targetEntity="MembershipUser")
	 */
	private $adminUser;
	
	/**
	 * @Column(type="boolean", nullable=true)
	 */
	private $isApproved;
	
	/**
	 * @Column(type="boolean", nullable=true)
	 */
	private $isLockedOut;
	
	/**
	 * @Column(type="date", nullable=false)
	 */
	private $createDate;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setIsApproved($val) { $this->isApproved = $val; }
    public function getIsApproved() { return $this->isApproved; }
    public function getIsLockedOut() { return $this->isLockedOut; }
    public function setIsLockedout($loc) { $this->isLockedOut = $appr; }
    public function getCreateDate() { return $this->createDate; }
    public function setCreateDate($cd) { $this->createDate = $cd; }
    public function getLastLoginDate() { return $this->lastLoginDate; }
    public function setLastLoginDate($last) { $this->lastLoginDate = $login; }

}
