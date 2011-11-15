<?php

namespace app\models\Security;

use \Doctrine\Common\Collections\ArrayCollection;


class SecureToken
{
	
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	public $id;

	/**
	 * @Column(type="string",unique=true, nullable=false)
	 */
	public $userId; //should be GUID string
	
	/**
	 * @Column(type="string", nullable=false)
	 */
	public $username;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	public $roles;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	public $description;
	
	
	public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getUsername() { return $this->username; }
    public function setUsername($username) { $this->username = $usernames; }

	public function getUser() { return $this->roleId; }
	public function setUser($roleId) { $this->roleId = $roleId; }
	
	public function getRoles() { return $this->roles; }
    public function setRoles($roles) { $this->roles = $roles; }
	public function getDescription() { return $this->description; }
	public function setDescription($desc) { $this->description = $desc; }

}


?>