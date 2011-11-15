<?php
 
namespace app\models;

use app\models\Security\MembershipUser;
use \Doctrine\Common\Collections\ArrayCollection;
 
/**
 * @Entity
 */

class Subscriber extends MembershipUser
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @OneToOne(targetEntity="School")
	 */
	private $school;

	
	/** @ManyToMany(targetEntity="Subscription") */
	private $subscriptions;
	
	public function __construct() {
        $this->subscriptions = new \Doctrine\Common\Collections\ArrayCollection();
    } 
	
	public function getId() { return $this->Id; }
    public function setId($Id) { $this->Id = $Id; }
    public function getSchool() { return $this->school; }
    public function setSchool($school) { $this->school = $school; }
    public function setSubsriptions($subscriptions) { $this->subsriptions = $subscriptions; }
    public function getSubscriptions() { return $this->subscriptions; }
    

}
