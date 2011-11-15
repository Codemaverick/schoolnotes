<?php

namespace app\models\Security;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 */
class Role
{
	
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @Column(type="string", unique="true", nullable=false)
	 */
	private $roleName;
	
	/**
	 * @ManyToMany(targetEntity="MembershipUser", inversedBy="roles")
	 */
	private $users;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $description;
	
	public function __construct(){
		$this->users = new ArrayCollection();
	}
	
	public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
	public function getRoleName() { return $this->roleName; }
    public function setRoleName($name) { $this->roleName = $name; }
	public function getDescription() { return $this->description; }
	public function setDescription($desc) { $this->description = $desc; }
	public function getUsers() { return $this->users; }
	public function setUsers($users) { $this->users = $users; }

}


?>