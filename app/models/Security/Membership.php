<?php

namespace app\models\Security;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 */
class Membership
{
	
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @Column(type="string",unique=true, nullable=false)
	 */
	private $userId; //should be GUID string
	
	/**
	 * @Column(type="string", nullable=false)
	 */
	private $password;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $passwordSalt;
	
	/**
	 * @Column(type="string",unique=true, nullable=false)
	 */
	private $email;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $passwordQuestion;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $passwordAnswer;
	
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
	
	/**
	 * @Column(type="date", nullable=true)
	 */
	private $lastLoginDate;
	
	/**
	 * @Column(type="integer",nullable=true)
	 */
	private $failedPasswordAttemptCount;
		
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $applicationId;
	
	public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getUserId() { return $this->userId; }
    public function setUserId($userId) { $this->userId = $userId; }
    public function getPassword() { return $this->password; }
    public function setPassword($pwd) { $this->password = $pwd; }
    public function getPasswordSalt() { return $this->passwordSalt; }
    public function setPasswordSalt($pwdSalt) { $this->passwordSalt = $pwdSalt; }
    public function setEmail($email) { $this->email = $email; }
    public function getEmail() {  return $this->email; }
    public function getPasswordQuestion() { return $this->passwordQuestion; }
    public function setPasswordQuestion($pwdQ) { $this->passwordQuestion = $pwdQ; }
    public function getPasswordAnswer() { return $this->passwordAnswer; }
    public function setPasswordAnswer($pwdAns) { $this->passwordAnswer = $pwdAns; }

	public function isApproved() { return $this->isApproved; }
    public function setIsApproved($appr) { $this->isApproved = $appr; }
    public function isLockedOut() { return $this->isLockedOut; }
    public function setLockedout($loc) { $this->isLockedOut = $appr; }
    public function getCreateDate() { return $this->createDate; }
    public function setCreateDate($cd) { $this->createDate = $cd; }
    public function getLastLoginDate() { return $this->lastLoginDate; }
    public function setLastLoginDate($last) { $this->lastLoginDate = $login; }
    
    public function getFailedPasswordAttemptCount() { return $this->failedPasswordAttemptCount; }
    public function setFailedPasswordAttemptCount($failed) { $this->failedPasswordAttemptCount = $failed; }
    public function getApplicationId() { return $this->applicationId; }
    public function setApplicationId($appId) { $this->application = $appId; }
}


?>