<?php
 
namespace app\models\Security;

use \Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 */
class MembershipUser
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
	private $username;
	 
	/**
	 * @Column(type="string", length=64, nullable=false)
	 */
	private $password;
	
	/**
	 * @Column(type="string", nullable=false)
	 */
	private $firstname;
	 
	/**
	 * @Column(type="string", nullable=false)
	 */
	private $lastname;
	
	/**
	 * @Column(type="string", length=64, nullable=false)
	 */
	private $email;
	 
	/**
	 * @ManyToMany(targetEntity="Role", mappedBy="users")
	*/
	private $roles;
	
	public function __construct(){
		$this->roles = new ArrayCollection();
	}
 
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setUsername($username) { $this->username = $username; }
    public function getUsername() { return $this->username; }
    public function setPassword($password) { $this->password = $password; }
    public function getPassword() {  return $this->password; }
    public function setFirstname($firstname) { $this->firstname = $firstname; }
    public function getFirstname() { return $this->firstname; }
    public function setLastname($lastname) { $this->lastname = $lastname; }
    public function getLastname() {  return $this->lastname; }
	public function setEmail($email) { $this->email = $email; }
    public function getEmail() {  return $this->email; }
    public function getFullName(){ return $this->firstname . " " . $this->lastname; }
    public function getRoles(){ return $this->roles; }
    public function setRoles($roles){ $this->roles = $roles; }
    
}

?>
